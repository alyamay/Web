<?php
require_once '../auth.php';
require_once '../../config/database.php';

$user_id = $_SESSION['author_id'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = $_POST['title'];
    $date    = $_POST['date'];
    $content = $_POST['content'];
    $status  = $_POST['status'];
    $slug    = strtolower(str_replace(' ', '-', $title));
    $picture = null;
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['picture']['tmp_name'], '../../assets/images/' . $filename);
        $picture = $filename;
    }

    $stmt = $conn->prepare("INSERT INTO article (title, slug, date, content, status, picture) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $title, $slug, $date, $content, $status, $picture);
    $stmt->execute();

    $article_id = $conn->insert_id;

    $stmt = $conn->prepare("INSERT INTO article_author (article_id, author_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $article_id, $user_id);
    $stmt->execute();

    if (!empty($_POST['category_ids'])) {
        foreach ($_POST['category_ids'] as $cat_id) {
            $stmt = $conn->prepare("INSERT INTO article_category (article_id, category_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $article_id, $cat_id);
            $stmt->execute();
        }
    }

    header("Location: ../list.php");
    exit;
}

$categories = $conn->query("SELECT * FROM category");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tambah Artikel</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #E4DCCF;
            color: #000000;
            line-height: 1.6;
        }

        .admin-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #F9F5EB;
        }

        .admin-header {
            margin-bottom: 32px;
            padding-bottom: 16px;
            border-bottom: 2px solid #000000;
        }

        .admin-title {
            font-size: 2.25rem;
            font-weight: bold;
            color: #000000;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .create-form {
            background-color: #F9F5EB;
            border: 1px solid #e6e6e6;
            padding: 32px;
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-weight: bold;
            color: #000000;
            margin-bottom: 8px;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e6e6e6;
            background-color: #ffffff;
            color: #000000;
            font-size: 1rem;
            font-family: inherit;
            transition: border-color 0.2s ease;
            box-sizing: border-box;
        }

        .form-input:focus {
            outline: none;
            border-color: #000000;
        }

        .form-textarea {
            width: 100%;
            padding: 16px;
            border: 2px solid #e6e6e6;
            background-color: #ffffff;
            color: #000000;
            font-size: 1rem;
            font-family: inherit;
            min-height: 200px;
            resize: vertical;
            transition: border-color 0.2s ease;
            box-sizing: border-box;
        }

        .form-textarea:focus {
            outline: none;
            border-color: #000000;
        }

        .form-textarea-hidden {
            display: none;
        }

        .editor-toolbar {
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 8px 12px;
            background-color: #f8f8f8;
            border: 2px solid #e6e6e6;
            border-bottom: 1px solid #e6e6e6;
            margin-bottom: 0;
        }

        .editor-btn {
            padding: 6px 10px;
            background-color: #ffffff;
            border: 1px solid #cccccc;
            color: #000000;
            font-size: 0.875rem;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.2s ease;
            min-width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .editor-btn:hover {
            background-color: #f0f0f0;
            border-color: #999999;
        }

        .editor-btn:active,
        .editor-btn.active {
            background-color: #000000;
            color: #ffffff;
            border-color: #000000;
        }

        .editor-separator {
            width: 1px;
            height: 24px;
            background-color: #cccccc;
            margin: 0 8px;
        }

        .form-editor {
            width: 100%;
            min-height: 200px;
            padding: 16px;
            border: 2px solid #002B5B;
            border-top: none;
            background-color: #E4DCCF;
            color: #000000;
            font-size: 1rem;
            font-family: inherit;
            line-height: 1.6;
            transition: border-color 0.2s ease;
            box-sizing: border-box;
            overflow-y: auto;
        }

        .form-editor:focus {
            outline: none;
            border-color: #000000;
        }

        .form-editor[placeholder]:empty::before {
            content: attr(placeholder);
            color: #999999;
            font-style: italic;
        }

        .form-editor h2 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #000000;
            margin: 16px 0 8px 0;
        }

        .form-editor h3 {
            font-size: 1.25rem;
            font-weight: bold;
            color: #000000;
            margin: 12px 0 6px 0;
        }

        .form-editor ul,
        .form-editor ol {
            margin: 8px 0;
            padding-left: 24px;
        }

        .form-editor li {
            margin-bottom: 4px;
        }

        .form-editor p {
            margin: 8px 0;
        }

        .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e6e6e6;
            background-color: #ffffff;
            color: #000000;
            font-size: 1rem;
            font-family: inherit;
            transition: border-color 0.2s ease;
            box-sizing: border-box;
        }

        .form-select:focus {
            outline: none;
            border-color: #000000;
        }

        .form-select[multiple] {
            min-height: 120px;
        }

        .form-file {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e6e6e6;
            background-color: #ffffff;
            color: #000000;
            font-size: 1rem;
            font-family: inherit;
            transition: border-color 0.2s ease;
            box-sizing: border-box;
        }

        .form-file:focus {
            outline: none;
            border-color: #000000;
        }

        .form-actions {
            padding-top: 24px;
            border-top: 1px solid #e6e6e6;
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .btn {
            display: inline-block;
            padding: 14px 28px;
            background-color: #000000;
            color: #ffffff;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 2px solid #000000;
            transition: all 0.2s ease;
            cursor: pointer;
            font-family: inherit;
        }

        .btn:hover {
            background-color: #ffffff;
            color: #000000;
        }

        .btn-secondary {
            background-color: #ffffff;
            color: #000000;
            border: 2px solid #666666;
        }

        .btn-secondary:hover {
            background-color: #666666;
            color: #ffffff;
            border-color: #666666;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            color: #000000;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 16px 0;
            border-top: 1px solid #e6e6e6;
            margin-top: 24px;
            transition: color 0.2s ease;
        }

        .back-link:hover {
            color: #666666;
            text-decoration: none;
        }

        .back-link::before {
            content: "←";
            margin-right: 8px;
            font-size: 1rem;
        }

        .form-help {
            font-size: 0.75rem;
            color: #666666;
            margin-top: 4px;
            font-style: italic;
        }

        .required {
            color: #cc0000;
        }
    </style>
</head>

<body>
    <div class="admin-container">
        <header class="admin-header">
            <h1 class="admin-title">Tambah Artikel</h1>
        </header>

        <form method="POST" enctype="multipart/form-data" class="create-form">
            <div class="form-group">
                <label class="form-label" for="title">Judul <span class="required">*</span></label>
                <input type="text" id="title" name="title" class="form-input" maxlength="255" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="picture">Upload Gambar</label>
                <input type="file" id="picture" name="picture" class="form-file" accept="image/*">
                <div class="form-help">Format yang didukung: JPG, PNG, GIF (Maksimal 5MB)</div>
            </div>

            <div class="form-group">
                <label class="form-label" for="date">Tanggal <span class="required">*</span></label>
                <input type="date" id="date" name="date" class="form-input" value="<?= date('Y-m-d') ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="content">Isi Artikel <span class="required">*</span></label>
                <div class="editor-toolbar">
                    <button type="button" class="editor-btn" onclick="formatText('bold')" title="Bold">
                        <strong>B</strong>
                    </button>
                    <button type="button" class="editor-btn" onclick="formatText('italic')" title="Italic">
                        <em>I</em>
                    </button>
                    <button type="button" class="editor-btn" onclick="formatText('underline')" title="Underline">
                        <u>U</u>
                    </button>
                    <span class="editor-separator"></span>
                    <button type="button" class="editor-btn" onclick="formatText('insertUnorderedList')" title="Bullet List">
                        • List
                    </button>
                    <button type="button" class="editor-btn" onclick="formatText('insertOrderedList')" title="Numbered List">
                        1. List
                    </button>
                    <span class="editor-separator"></span>
                    <button type="button" class="editor-btn" onclick="formatText('formatBlock', 'h2')" title="Heading 2">
                        H2
                    </button>
                    <button type="button" class="editor-btn" onclick="formatText('formatBlock', 'h3')" title="Heading 3">
                        H3
                    </button>
                </div>
                <div id="editor" class="form-editor" contenteditable="true" placeholder="Tulis isi artikel di sini..."></div>
                <textarea id="content" name="content" class="form-textarea-hidden" required></textarea>
            </div>

            <div class="form-group">
                <input type="hidden" name="author_ids[]" value="<?= $user_id ?>">
            </div>

            <div class="form-group">
                <label class="form-label" for="category_ids">Pilih Kategori <span class="required">*</span></label>
                <select id="category_ids" name="category_ids[]" class="form-select" multiple required>
                    <?php while ($c = $categories->fetch_assoc()): ?>
                        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                    <?php endwhile; ?>
                </select>
                <div class="form-help">Tahan Ctrl (Windows) atau Cmd (Mac) untuk memilih beberapa kategori</div>
            </div>

            <div class="form-group">
                <label class="form-label" for="status">Status</label>
                <select id="status" name="status" class="form-select">
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">Simpan Artikel</button>
                <a href="../list.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>

        <a href="../list.php" class="back-link">Kembali ke Daftar Artikel</a>
    </div>

    <script>
        function formatText(command, value = null) {
            document.execCommand(command, false, value);
            document.getElementById('editor').focus();
            updateHiddenTextarea();
        }

        function updateHiddenTextarea() {
            const editor = document.getElementById('editor');
            const hiddenTextarea = document.getElementById('content');
            hiddenTextarea.value = editor.innerHTML;
        }

        document.getElementById('editor').addEventListener('input', updateHiddenTextarea);

        document.querySelector('form').addEventListener('submit', function(e) {
            updateHiddenTextarea();

            const content = document.getElementById('content').value.trim();
            if (!content || content === '') {
                e.preventDefault();
                alert('Isi artikel tidak boleh kosong!');
                document.getElementById('editor').focus();
                return false;
            }
        });

        document.getElementById('editor').addEventListener('paste', function(e) {
            e.preventDefault();
            const text = (e.originalEvent || e).clipboardData.getData('text/plain');
            document.execCommand('insertText', false, text);
            updateHiddenTextarea();
        });

        document.addEventListener('DOMContentLoaded', function() {
            const editor = document.getElementById('editor');
            editor.focus();

            editor.addEventListener('keydown', function(e) {
                if (e.ctrlKey || e.metaKey) {
                    switch (e.key) {
                        case 'b':
                            e.preventDefault();
                            formatText('bold');
                            break;
                        case 'i':
                            e.preventDefault();
                            formatText('italic');
                            break;
                        case 'u':
                            e.preventDefault();
                            formatText('underline');
                            break;
                    }
                }
            });
        });
    </script>
</body>

</html>