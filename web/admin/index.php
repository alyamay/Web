<?php
require_once 'auth.php';
require_once '../config/database.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #F9F5EB;
            color: #222222;
            line-height: 1.4;
        }

        .main-container {
            max-width: 1024px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .dashboard-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .dashboard-header {
            margin-bottom: 48px;
            padding-bottom: 24px;
            border-bottom: 3px solid #000000;
        }

        .dashboard-title {
            font-size: 3rem;
            font-weight: bold;
            color: #000000;
            line-height: 1.1;
            margin-bottom: 8px;
            letter-spacing: -0.02em;
        }

        .dashboard-subtitle {
            font-size: 1.125rem;
            color: #002B5B;
            font-weight: normal;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.875rem;
        }

        .menu-list {
            list-style: none;
            margin-bottom: 48px;
        }

        .menu-item {
            border-bottom: 1px solid #e6e6e6;
        }

        .menu-item:last-child {
            border-bottom: none;
        }

        .menu-link {
            display: block;
            padding: 24px 0;
            text-decoration: none;
            color: #000000;
            transition: all 0.2s ease;
            position: relative;
        }

        .menu-link:hover {
            background-color: #E4DCCF;
            text-decoration: none;
            color: #000000;
            padding-left: 16px;
        }

        .menu-link:hover::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background-color: #000000;
        }

        .menu-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #000000;
            margin-bottom: 8px;
            line-height: 1.2;
        }

        .menu-description {
            font-size: 1rem;
            color: #666666;
            line-height: 1.4;
            max-width: 600px;
        }

        .logout-section {
            border-top: 2px solid #000000;
            padding-top: 32px;
            margin-top: 48px;
        }

        .logout-link {
            display: inline-block;
            background-color: #000000;
            color: #ffffff;
            text-decoration: none;
            padding: 16px 32px;
            font-weight: bold;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.2s ease;
            border: 2px solid #000000;
        }

        .logout-link:hover {
            background-color: #ffffff;
            color: #000000;
            text-decoration: none;
        }

        .welcome-message {
            background-color: #f8f8f8;
            padding: 20px;
            margin-bottom: 32px;
            border-left: 4px solid #000000;
        }

        .welcome-text {
            font-size: 1rem;
            color: #333333;
            margin: 0;
            line-height: 1.5;
        }

        .section-divider {
            height: 2px;
            background-color: #e6e6e6;
            margin: 32px 0;
        }

        h1, h2, h3 {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            font-weight: bold;
        }

        p {
            font-family: 'Helvetica Neue', Arial, sans-serif;
        }

        .menu-link:focus,
        .logout-link:focus {
            outline: 2px solid #000000;
            outline-offset: 2px;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="dashboard-container">
            <header class="dashboard-header">
                <h1 class="dashboard-title">DASHBOARD ADMIN</h1>
                <p class="dashboard-subtitle">Panel Kontrol Administrasi</p>
            </header>

            <div class="welcome-message">
                <p class="welcome-text">
                    Selamat datang kembali. Gunakan menu di bawah ini untuk mengelola konten website Anda.
                </p>
            </div>

            <nav>
                <ul class="menu-list">
                    <li class="menu-item">
                        <a href="artikel/list.php" class="menu-link">
                            <h2 class="menu-title">Kelola Artikel</h2>
                            <p class="menu-description">
                                Tambah, edit, dan hapus artikel. Kelola konten utama website Anda dengan mudah dan efisien.
                            </p>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="kategori/list.php" class="menu-link">
                            <h2 class="menu-title">Kelola Kategori</h2>
                            <p class="menu-description">
                                Atur kategori untuk mengorganisasi artikel dan memudahkan navigasi pengunjung website.
                            </p>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="penulis/list.php" class="menu-link">
                            <h2 class="menu-title">Kelola Penulis</h2>
                            <p class="menu-description">
                                Tambah dan kelola profil penulis yang berkontribusi dalam pembuatan konten website.
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="logout-section">
                <a href="logout.php" class="logout-link">Keluar</a>
            </div>
        </div>
    </div>
</body>
</html>