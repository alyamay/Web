<?php
session_start();
require_once '../config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['admin_id'] = $id;
            header("Location: index.php");
            exit;
        } else {
            $error = "Password salah.";
        }
    } else {
        $error = "Username tidak ditemukan.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            max-width: 400px;
            width: 100%;
            padding: 40px;
            margin: 20px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 48px;
            padding-bottom: 24px;
            border-bottom: 3px solid #000000;
        }

        .login-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #000000;
            line-height: 1.1;
            margin-bottom: 8px;
            letter-spacing: -0.02em;
        }

        .login-subtitle {
            font-size: 0.875rem;
            color: #666666;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .error-message {
            background-color: #f8f8f8;
            color: #d32f2f;
            padding: 16px;
            margin-bottom: 24px;
            border-left: 4px solid #d32f2f;
            font-weight: 500;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 1rem;
            font-weight: bold;
            color: #000000;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.875rem;
        }

        .form-input {
            width: 100%;
            padding: 16px;
            border: 2px solid #e6e6e6;
            background-color: #ffffff;
            font-size: 1rem;
            color: #222222;
            transition: border-color 0.2s ease;
            font-family: 'Helvetica Neue', Arial, sans-serif;
        }

        .form-input:focus {
            outline: none;
            border-color: #000000;
        }

        .form-input:hover {
            border-color: #cccccc;
        }

        .login-button {
            width: 100%;
            background-color: #000000;
            color: #F9F5EB;
            border: 2px solid #000000;
            padding: 16px;
            font-size: 0.875rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            margin-bottom: 24px;
        }

        .login-button:hover {
            background-color: #E4DCCF;
            color: #000000;
        }

        .login-button:focus {
            outline: 2px solid #000000;
            outline-offset: 2px;
        }

        .register-section {
            border-top: 2px solid #E4DCCF;
            padding-top: 24px;
            text-align: center;
        }

        .register-text {
            font-size: 1rem;
            color: #666666;
            margin-bottom: 16px;
        }

        .register-link {
            display: inline-block;
            background-color: #ffffff;
            color: #000000;
            border: 2px solid #000000;
            padding: 12px 24px;
            font-size: 0.875rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .register-link:hover {
            background-color: #000000;
            color: #ffffff;
            text-decoration: none;
        }

        .register-link:focus {
            outline: 2px solid #000000;
            outline-offset: 2px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <header class="login-header">
            <h1 class="login-title">Login Admin</h1>
            <p class="login-subtitle">Panel Administrasi</p>
        </header>

        <?php if ($error): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label class="form-label" for="username">Username:</label>
                <input type="text" 
                       id="username" 
                       name="username" 
                       class="form-input" 
                       required 
                       autocomplete="username">
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password:</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       class="form-input" 
                       required 
                       autocomplete="current-password">
            </div>

            <button type="submit" class="login-button">Login</button>
        </form>

        <div class="register-section">
            <p class="register-text">Belum memiliki akun?</p>
            <a href="registrasi.php" class="register-link">Daftar Sekarang</a>
        </div>
    </div>
</body>
</html>