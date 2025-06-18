<?php
require_once '../config/database.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    if ($password !== $confirm) {
        $error = "Konfirmasi password tidak sama.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM admin WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Username sudah terdaftar.";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            $insert = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
            $insert->bind_param("ss", $username, $hashed);

            if ($insert->execute()) {
                $success = "Registrasi berhasil. Silakan login.";
            } else {
                $error = "Gagal registrasi.";
            }

            $insert->close();
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Admin</title>
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

        .register-container {
            max-width: 400px;
            width: 100%;
            padding: 40px;
            margin: 20px;
        }

        .register-header {
            text-align: center;
            margin-bottom: 48px;
            padding-bottom: 24px;
            border-bottom: 3px solid #000000;
        }

        .register-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #000000;
            line-height: 1.1;
            margin-bottom: 8px;
            letter-spacing: -0.02em;
        }

        .register-subtitle {
            font-size: 0.875rem;
            color: #666666;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .success-message {
            background-color: #f8f8f8;
            color: #2e7d32;
            padding: 16px;
            margin-bottom: 24px;
            border-left: 4px solid #2e7d32;
            font-weight: 500;
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

        .register-button {
            width: 100%;
            background-color: #000000;
            color: #E4DCCF;
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

        .register-button:hover {
            background-color: #F9F5EB;
            color: #000000;
        }

        .register-button:focus {
            outline: 2px solid #000000;
            outline-offset: 2px;
        }

        .login-section {
            border-top: 2px solid #E4DCCF;
            padding-top: 24px;
            text-align: center;
        }

        .login-text {
            font-size: 1rem;
            color: #666666;
            margin-bottom: 16px;
        }

        .login-link {
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

        .login-link:hover {
            background-color: #000000;
            color: #ffffff;
            text-decoration: none;
        }

        .login-link:focus {
            outline: 2px solid #000000;
            outline-offset: 2px;
        }

        .success-section {
            text-align: center;
        }

        .success-link {
            display: inline-block;
            background-color: #000000;
            color: #ffffff;
            border: 2px solid #000000;
            padding: 16px 32px;
            font-size: 0.875rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: none;
            transition: all 0.2s ease;
            margin-top: 16px;
        }

        .success-link:hover {
            background-color: #ffffff;
            color: #000000;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .register-container {
                padding: 24px;
                margin: 16px;
            }

            .register-title {
                font-size: 2rem;
            }

            .form-input,
            .register-button {
                padding: 14px;
            }
        }

        @media (max-width: 480px) {
            .register-container {
                padding: 20px;
            }

            .register-title {
                font-size: 1.75rem;
            }
        }
    </style>
</head>

<body>
    <div class="register-container">
        <header class="register-header">
            <h1 class="register-title">Registrasi Admin</h1>
            <p class="register-subtitle">Buat Akun Baru</p>
        </header>

        <?php if ($success): ?>
            <div class="success-message">
                <?php echo htmlspecialchars($success); ?>
            </div>
            <div class="success-section">
                <a href="login.php" class="success-link">Login Sekarang</a>
            </div>
        <?php else: ?>
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
                        autocomplete="username"
                        value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password:</label>
                    <input type="password"
                        id="password"
                        name="password"
                        class="form-input"
                        required
                        autocomplete="new-password">
                </div>

                <div class="form-group">
                    <label class="form-label" for="confirm">Ulangi Password:</label>
                    <input type="password"
                        id="confirm"
                        name="confirm"
                        class="form-input"
                        required
                        autocomplete="new-password">
                </div>

                <button type="submit" class="register-button">Daftar</button>
            </form>

            <div class="login-section">
                <p class="login-text">Sudah memiliki akun?</p>
                <a href="login.php" class="login-link">Login di Sini</a>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>