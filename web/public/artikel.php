<?php
require_once '../config/database.php';
require_once '../includes/header.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM article WHERE id = ? AND status = 'published'");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) die("Artikel tidak ditemukan");

$authors = [];
$auth = $conn->query("SELECT a.nickname FROM article_author aa JOIN author a ON aa.author_id = a.id WHERE aa.article_id = $id");
while ($a = $auth->fetch_assoc()) $authors[] = $a['nickname'];

$categories = [];
$cat = $conn->query("SELECT c.name FROM article_category ac JOIN category c ON ac.category_id = c.id WHERE ac.article_id = $id");
while ($c = $cat->fetch_assoc()) $categories[] = $c['name'];
?>

<style>
    .article-container {
        max-width: 800px;
        margin: 0 auto;
        background-color: #ffffff;
        padding: 0;
    }

    .article-header {
        margin-bottom: 32px;
    }

    .article-title {
        font-size: 2.5rem;
        font-weight: bold;
        color: #000000;
        line-height: 1.2;
        margin-bottom: 16px;
        word-wrap: break-word;
    }

    .article-meta {
        font-size: 0.875rem;
        color: #666666;
        margin-bottom: 24px;
        border-bottom: 1px solid #e6e6e6;
        padding-bottom: 16px;
    }

    .meta-item {
        display: inline-block;
        margin-right: 20px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
    }

    .meta-item:last-child {
        margin-right: 0;
    }

    .article-image {
        width: 100%;
        height: auto;
        max-height: 400px;
        object-fit: cover;
        margin-bottom: 24px;
        border: 1px solid #e6e6e6;
    }

    .article-content {
        font-size: 1.125rem;
        line-height: 1.7;
        color: #333333;
        margin-bottom: 32px;
    }

    .article-content p {
        margin-bottom: 20px;
    }

    .article-content h2 {
        font-size: 1.5rem;
        font-weight: bold;
        color: #000000;
        margin: 32px 0 16px 0;
    }

    .article-content h3 {
        font-size: 1.25rem;
        font-weight: bold;
        color: #000000;
        margin: 24px 0 12px 0;
    }

    .article-content ul,
    .article-content ol {
        margin: 16px 0;
        padding-left: 24px;
    }

    .article-content li {
        margin-bottom: 8px;
    }

    .article-content blockquote {
        border-left: 4px solid #0066cc;
        padding-left: 16px;
        margin: 24px 0;
        font-style: italic;
        color: #555555;
    }

    .article-navigation {
        padding: 24px 0;
        border-top: 1px solid #e6e6e6;
        margin-top: 32px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        color: #0066cc;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: color 0.2s ease;
    }

    .back-link:hover {
        color: #004499;
        text-decoration: none;
    }

    .back-link::before {
        content: "←";
        margin-right: 8px;
        font-size: 1rem;
    }

    .main-container {
        display: flex;
        max-width: 1200px;
        margin: 0 auto;
        gap: 32px;
        padding: 20px;
    }

    .main-content {
        flex: 2;
    }

    .sidebar-container {
        flex: 1;
        min-width: 300px;
    }
</style>

<div class="main-container">
    <div class="main-content">
        <article class="article-container">
            <header class="article-header">
                <h1 class="article-title"><?= htmlspecialchars($data['title']) ?></h1>

                <div class="article-meta">
                    <span class="meta-item">
                        <strong>Diterbitkan:</strong> <?= date('d F Y', strtotime($data['created_at'])) ?>
                    </span>
                    <?php if (!empty($authors)): ?>
                        <span class="meta-item">
                            <strong>Penulis:</strong> <?= implode(', ', $authors) ?>
                        </span>
                    <?php endif; ?>
                    <?php if (!empty($categories)): ?>
                        <span class="meta-item">
                            <strong>Kategori:</strong> <?= implode(', ', $categories) ?>
                        </span>
                    <?php endif; ?>
                </div>
            </header>

            <?php if ($data['picture']): ?>
                <img src="../assets/images/<?= htmlspecialchars($data['picture']) ?>"
                    alt="<?= htmlspecialchars($data['title']) ?>"
                    class="article-image">
            <?php endif; ?>

            <div class="article-content">
                <?= $data['content'] ?>
            </div>

            <nav class="article-navigation">
                <a href="index.php" class="back-link">Kembali ke Beranda</a>
            </nav>
        </article>
    </div>

    <div class="sidebar-container">
        <?php require_once '../includes/sidebar.php'; ?>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>