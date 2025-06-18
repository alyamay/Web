<?php
require_once '../config/database.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlyNews - Header & Footer Design</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #E4DCCF;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #222;
            line-height: 1.5;
        }

        .main-header {
            background-color: #F9F5EB;
            border-bottom: 1px solid #002B5B;
            padding: 0;
        }

        .navbar-brand {
            font-size: 1.75rem;
            font-weight: bold;
            color: #000000 !important;
            text-decoration: none;
            letter-spacing: -0.02em;
            padding: 16px 0;
        }

        .navbar-brand:hover {
            color: #000000 !important;
            text-decoration: none;
        }

        .navbar {
            padding: 0;
        }

        .navbar-nav .nav-link {
            color: #000000 !important;
            font-weight: 400;
            font-size: 0.875rem;
            padding: 16px 20px !important;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
            border-radius: 0;
            transition: background-color 0.2s ease;
        }

        .navbar-nav .nav-link:hover {
            background-color: #f5f5f5;
            color: #000000 !important;
        }

        .navbar-nav .nav-link.active {
            background-color: #000000;
            color: #ffffff !important;
        }

        .sidebar {
            background-color: #F9F5EB;
            border: 1px solid #e6e6e6;
            padding: 24px;
            margin-bottom: 32px;
            height: fit-content;
            position: sticky;
            top: 32px;
        }

        .sidebar h3 {
            color: #000000;
            font-size: 1rem;
            font-weight: bold;
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e6e6e6;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sidebar form {
            margin-bottom: 32px;
        }

        .sidebar input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #F9F5EB;
            border-radius: 0;
            margin-bottom: 12px;
            font-size: 0.875rem;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #E4DCCF;
        }

        .sidebar input[type="text"]:focus {
            outline: none;
            border-color: #000000;
            box-shadow: none;
        }

        .sidebar input[type="text"]::placeholder {
            color: #999999;
        }

        .sidebar button {
            width: 100%;
            padding: 12px;
            background-color: #000000;
            color: #ffffff;
            border: 1px solid #000000;
            border-radius: 0;
            font-weight: 500;
            font-size: 0.875rem;
            cursor: pointer;
            transition: background-color 0.2s ease;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sidebar button:hover {
            background-color: #333333;
            border-color: #333333;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin-bottom: 32px;
        }

        .sidebar li {
            margin-bottom: 0;
            border-bottom: 1px solid #f5f5f5;
        }

        .sidebar li:last-child {
            border-bottom: none;
        }

        .sidebar li a {
            display: block;
            padding: 12px 0;
            color: #000000;
            text-decoration: none;
            font-weight: 400;
            font-size: 0.875rem;
            transition: color 0.2s ease;
        }

        .sidebar li a:hover {
            color: #0066cc;
            text-decoration: underline;
        }

        .sidebar p {
            color: #666666;
            line-height: 1.6;
            margin-bottom: 0;
            font-size: 0.875rem;
            padding: 16px;
            background-color: #E4DCCF;
            border: 1px solid #e6e6e6;
        }

        .main-container {
            display: flex;
            gap: 32px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px 16px;
        }

        .main-content {
            flex: 2;
        }

        .sidebar-container {
            flex: 1;
            max-width: 300px;
        }

        .main-footer {
            background-color: #F9F5EB;
            border-top: 1px solid #002B5B;
            margin-top: 48px;
            padding: 32px 0;
        }

        .footer-content {
            text-align: center;
            color: #666666;
            font-size: 0.75rem;
        }

        .footer-content p {
            margin: 0;
            padding: 16px 0;
            border: none;
            border-radius: 0;
            background-color: transparent;
        }

        .content-area {
            min-height: 60vh;
            padding: 48px 0;
        }

        .demo-card {
            background: #ffffff;
            border: 1px solid #e6e6e6;
            padding: 32px;
            text-align: center;
        }

        .demo-card h2 {
            color: #000000;
            margin-bottom: 16px;
            font-weight: bold;
        }

        .demo-card p {
            color: #666666;
            line-height: 1.6;
        }

        .related-articles {
            margin-top: 15px;
        }

        .related-article-item {
            display: flex;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .related-article-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .related-article-image {
            flex: 0 0 80px;
            margin-right: 12px;
        }

        .related-article-image img {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }

        .related-article-content {
            flex: 1;
        }

        .related-article-content h4 {
            margin: 0 0 5px 0;
            font-size: 14px;
            line-height: 1.3;
        }

        .related-article-content h4 a {
            color: #333;
            text-decoration: none;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .related-article-content h4 a:hover {
            color: #002B5B;
        }

    </style>
</head>

<body>
    <header class="main-header">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid px-0">
                    <a class="navbar-brand" href="/">AlyNews</a>

                    <div class="navbar-nav ms-auto">
                        <a class="nav-link active" href="../public/index.php">Beranda</a>
                        <a class="nav-link" href="../public/login.php">Start Writing</a>
                    </div>
                </div>
            </nav>
        </div>
    </header>