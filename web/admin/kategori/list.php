<?php
require_once '../auth.php';
require_once '../../config/database.php';

$result = $conn->query("SELECT * FROM category ORDER BY id ASC");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Data Kategori</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #F9F5EB;
            color: #333333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .page-header {
            margin-bottom: 40px;
            border-bottom: 2px solid #000000;
            padding-bottom: 20px;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #000000;
            margin-bottom: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .add-button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #000000;
            color: #ffffff;
            text-decoration: none;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.875rem;
            transition: background-color 0.2s ease;
            border: 2px solid #000000;
        }

        .add-button:hover {
            background-color: #F9F5EB;
            color: #000000;
            text-decoration: none;
        }

        .categories-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #E4DCCF;
            margin-bottom: 40px;
            border: 1px solid #e6e6e6;
        }

        .categories-table th {
            background-color: #E4DCCF;
            padding: 16px 12px;
            text-align: left;
            font-weight: bold;
            color: #000000;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.875rem;
            border-bottom: 2px solid #000000;
            border-right: 1px solid #e6e6e6;
        }

        .categories-table th:last-child {
            border-right: none;
        }

        .categories-table td {
            padding: 16px 12px;
            border-bottom: 1px solid #e6e6e6;
            border-right: 1px solid #e6e6e6;
            vertical-align: top;
        }

        .categories-table td:last-child {
            border-right: none;
        }

        .categories-table tr:hover {
            background-color: #F9F5EB;
        }

        .category-id {
            font-weight: bold;
            color: #666666;
            width: 80px;
            text-align: center;
        }

        .category-name {
            font-weight: 600;
            color: #000000;
            max-width: 250px;
            word-wrap: break-word;
            line-height: 1.4;
        }

        .category-description {
            color: #666666;
            max-width: 400px;
            word-wrap: break-word;
            line-height: 1.5;
        }

        .actions {
            white-space: nowrap;
        }

        .action-link {
            color: #000000;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 8px 12px;
            border: 1px solid #000000;
            display: inline-block;
            margin-right: 8px;
            margin-bottom: 4px;
            transition: all 0.2s ease;
        }

        .action-link:hover {
            background-color: #000000;
            color: #ffffff;
            text-decoration: none;
        }

        .action-link.delete:hover {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .navigation {
            padding: 24px 0;
            border-top: 2px solid #000000;
            margin-top: 32px;
        }

        .back-link {
            display: inline-block;
            color: #000000;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 24px;
            border: 2px solid #000000;
            transition: all 0.2s ease;
        }

        .back-link:hover {
            background-color: #000000;
            color: #ffffff;
            text-decoration: none;
        }

        .back-link::before {
            content: "← ";
            margin-right: 8px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666666;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            color: #333333;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .empty-state p {
            font-size: 1rem;
            margin-bottom: 24px;
        }
    </style>
</head>

<body>
    <div class="container">
        <header class="page-header">
            <h1 class="page-title">Data Kategori</h1>
            <a href="create.php" class="add-button">Tambah Kategori</a>
        </header>

        <?php if ($result && $result->num_rows > 0): ?>
            <table class="categories-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="category-id"><?= htmlspecialchars($row['id']) ?></td>
                            <td class="category-name"><?= htmlspecialchars($row['name']) ?></td>
                            <td class="category-description">
                                <?= htmlspecialchars($row['description']) ?: '<em>Tidak ada deskripsi</em>' ?>
                            </td>
                            <td class="actions">
                                <a href="edit.php?id=<?= $row['id'] ?>" class="action-link">Edit</a>
                                <a href="delete.php?id=<?= $row['id'] ?>" 
                                   class="action-link delete" 
                                   onclick="return confirm('Yakin ingin menghapus kategori ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <h3>Belum Ada Kategori</h3>
                <p>Mulai dengan menambahkan kategori pertama untuk mengorganisir artikel Anda.</p>
                <a href="create.php" class="add-button">Tambah Kategori Pertama</a>
            </div>
        <?php endif; ?>

        <nav class="navigation">
            <a href="../index.php" class="back-link">Kembali ke Dashboard</a>
        </nav>
    </div>
</body>

</html>