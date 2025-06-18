<?php
require_once '../auth.php';
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO category (name, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $desc);
    $stmt->execute();

    header("Location: list.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Kategori</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
            background-color: #E4DCCF;
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
            background-color: #E4DCCF;
            color: #000000;
            font-size: 1rem;
            font-family: inherit;
            min-height: 120px;
            resize: vertical;
            transition: border-color 0.2s ease;
            box-sizing: border-box;
        }

        .form-textarea:focus {
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
            background-color: #F9F5EB;
            color: #000000;
        }

        .btn-secondary {
            background-color: #F9F5EB;
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

        @media (max-width: 768px) {
            .admin-container {
                padding: 16px;
            }

            .admin-title {
                font-size: 1.875rem;
            }

            .create-form {
                padding: 24px;
            }

            .form-actions {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }

            .btn {
                text-align: center;
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="admin-container">
        <header class="admin-header">
            <h1 class="admin-title">Tambah Kategori</h1>
        </header>

        <form method="POST" class="create-form">
            <div class="form-group">
                <label class="form-label" for="name">Nama Kategori <span class="required">*</span></label>
                <input type="text" id="name" name="name" class="form-input" maxlength="255" required placeholder="Masukkan nama kategori">
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Deskripsi</label>
                <textarea id="description" name="description" class="form-textarea" placeholder="Masukkan deskripsi kategori (opsional)"></textarea>
                <div class="form-help">Deskripsi akan membantu mengorganisir dan menjelaskan kategori ini</div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">Simpan Kategori</button>
                <a href="list.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>

        <a href="list.php" class="back-link">Kembali ke Daftar Kategori</a>
    </div>
</body>
</html>