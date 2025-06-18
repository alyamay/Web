<?php
require_once '../auth.php';
require_once '../../config/database.php';

$result = $conn->query("SELECT * FROM author ORDER BY id ASC");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Data Penulis</title>
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
            border-bottom: 2px solid #002B5B;
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

        .authors-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #E4DCCF;
            margin-bottom: 40px;
            border: 1px solid #e6e6e6;
        }

        .authors-table th {
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

        .authors-table th:last-child {
            border-right: none;
        }

        .authors-table td {
            padding: 16px 12px;
            border-bottom: 1px solid #e6e6e6;
            border-right: 1px solid #e6e6e6;
            vertical-align: top;
        }

        .authors-table td:last-child {
            border-right: none;
        }

        .authors-table tr:hover {
            background-color: #F9F5EB;
        }

        .author-id {
            font-weight: bold;
            color: #666666;
            width: 80px;
            text-align: center;
        }

        .author-name {
            font-weight: 600;
            color: #000000;
            max-width: 250px;
            word-wrap: break-word;
            line-height: 1.4;
        }

        .author-email {
            color: #666666;
            max-width: 300px;
            word-wrap: break-word;
            line-height: 1.4;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
        }

        .author-email:hover {
            color: #000000;
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

        .stats-info {
            background-color: #f8f8f8;
            padding: 16px 20px;
            margin-bottom: 24px;
            border-left: 4px solid #000000;
        }

        .stats-info p {
            margin: 0;
            color: #666666;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stats-number {
            font-weight: bold;
            color: #000000;
            font-size: 1.125rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <header class="page-header">
            <h1 class="page-title">Data Penulis</h1>
            <a href="create.php" class="add-button">Tambah Penulis</a>
        </header>

        <?php if ($result && $result->num_rows > 0): ?>
            <div class="stats-info">
                <p>Total Penulis: <span class="stats-number"><?= $result->num_rows ?></span></p>
            </div>

            <table class="authors-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="author-id"><?= htmlspecialchars($row['id']) ?></td>
                            <td class="author-name"><?= htmlspecialchars($row['nickname']) ?></td>
                            <td class="author-email">
                                <a href="mailto:<?= htmlspecialchars($row['email']) ?>" style="color: inherit; text-decoration: none;">
                                    <?= htmlspecialchars($row['email']) ?>
                                </a>
                            </td>
                            <td class="actions">
                                <a href="edit.php?id=<?= $row['id'] ?>" class="action-link">Edit</a>
                                <a href="delete.php?id=<?= $row['id'] ?>"
                                    class="action-link delete"
                                    onclick="return confirm('Yakin ingin menghapus penulis ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <h3>Belum Ada Penulis</h3>
                <p>Mulai dengan menambahkan penulis pertama untuk dapat membuat artikel.</p>
                <a href="create.php" class="add-button">Tambah Penulis Pertama</a>
            </div>
        <?php endif; ?>

        <nav class="navigation">
            <a href="../index.php" class="back-link">Kembali ke Dashboard</a>
        </nav>
    </div>
</body>

</html>