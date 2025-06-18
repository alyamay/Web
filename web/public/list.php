<?php
require_once 'auth.php';
require_once '../config/database.php';

$user_id = $_SESSION['author_id'];

// Query yang benar untuk mengambil artikel berdasarkan user yang login
// Menggunakan JOIN dengan tabel article_author
$sql = "SELECT a.* FROM article a 
        INNER JOIN article_author aa ON a.id = aa.article_id 
        WHERE aa.author_id = ? 
        ORDER BY a.date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Data Artikel</title>
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
            background-color: #ffffff;
            color: #000000;
            text-decoration: none;
        }

        .articles-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #E4DCCF;
            margin-bottom: 40px;
            border: 1px solid #e6e6e6;
        }

        .articles-table th {
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

        .articles-table th:last-child {
            border-right: none;
        }

        .articles-table td {
            padding: 16px 12px;
            border-bottom: 1px solid #e6e6e6;
            border-right: 1px solid #e6e6e6;
            vertical-align: top;
        }

        .articles-table td:last-child {
            border-right: none;
        }

        .articles-table tr:hover {
            background-color: #F9F5EB;
        }

        .article-number {
            font-weight: bold;
            color: #666666;
            width: 60px;
            text-align: center;
        }

        .article-title {
            font-weight: 600;
            color: #000000;
            max-width: 300px;
            word-wrap: break-word;
            line-height: 1.4;
        }

        .article-image {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border: 1px solid #e6e6e6;
            display: block;
        }

        .no-image {
            width: 80px;
            height: 60px;
            background-color: #f5f5f5;
            border: 1px solid #e6e6e6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            color: #999999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .article-date {
            font-size: 0.875rem;
            color: #666666;
            white-space: nowrap;
        }

        .article-status {
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 4px 8px;
            border: 1px solid;
            display: inline-block;
            min-width: 80px;
            text-align: center;
        }

        .status-published {
            color: #000000;
            border-color: #000000;
            background-color: transparent;
        }

        .status-draft {
            color: #666666;
            border-color: #666666;
            background-color: transparent;
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
            padding: 40px 20px;
            color: #666666;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="container">
        <header class="page-header">
            <h1 class="page-title">AlyNews's Creator</h1>
            <a href="artikel/create.php" class="add-button">Tambah Artikel</a>
        </header>

        <table class="articles-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Gambar</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php $no = 1; ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="article-number"><?= $no++ ?></td>
                            <td class="article-title"><?= htmlspecialchars($row['title']) ?></td>
                            <td>
                                <?php if ($row['picture']): ?>
                                    <img src="../assets/images/<?= htmlspecialchars($row['picture']) ?>"
                                        alt="<?= htmlspecialchars($row['title']) ?>"
                                        class="article-image">
                                <?php else: ?>
                                    <div class="no-image">Tidak ada</div>
                                <?php endif; ?>
                            </td>
                            <td class="article-date"><?= date('d M Y', strtotime($row['date'])) ?></td>
                            <td>
                                <span class="article-status status-<?= $row['status'] === 'published' ? 'published' : 'draft' ?>">
                                    <?= $row['status'] === 'published' ? 'Terbit' : 'Draft' ?>
                                </span>
                            </td>
                            <td class="actions">
                                <a href="artikel/edit.php?id=<?= $row['id'] ?>" class="action-link">Edit</a>
                            <a href="artikel/delete.php?id=<?= $row['id'] ?>"
                                class="action-link delete"
                                onclick="return confirm('Yakin ingin menghapus artikel ini?')">Hapus</a>
                            </td>
                            
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="empty-state">Belum ada artikel yang Anda buat.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <nav class="navigation">
            <a href="logout.php" class="back-link">Logout</a>
        </nav>
    </div>
</body>

</html>