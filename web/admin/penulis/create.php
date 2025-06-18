<?php
require_once '../auth.php';
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nickname = $_POST['nickname'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO author (nickname, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nickname, $email, $password);
    $stmt->execute();

    header("Location: list.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tambah Penulis</title>
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

        .edit-form {
            background-color: #E4DCCF;
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
            background-color: #F9F5EB;
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
            background-color: #000;
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

        .password-strength {
            margin-top: 4px;
            font-size: 0.75rem;
        }

        .password-strength.weak {
            color: #cc0000;
        }

        .password-strength.medium {
            color: #ff9900;
        }

        .password-strength.strong {
            color: #009900;
        }
    </style>
</head>

<body>
    <div class="admin-container">
        <header class="admin-header">
            <h1 class="admin-title">Tambah Penulis</h1>
        </header>

        <form method="POST" class="create-form">
            <div class="form-group">
                <label class="form-label" for="nickname">Nama Penulis <span class="required">*</span></label>
                <input type="text" id="nickname" name="nickname" class="form-input" maxlength="100" required placeholder="Masukkan nama penulis">
                <div class="form-help">Nama yang akan ditampilkan sebagai penulis artikel</div>
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email <span class="required">*</span></label>
                <input type="email" id="email" name="email" class="form-input" maxlength="255" required placeholder="contoh@email.com">
                <div class="form-help">Email akan digunakan untuk login ke sistem</div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password <span class="required">*</span></label>
                <input type="password" id="password" name="password" class="form-input" minlength="6" required placeholder="Masukkan password">
                <div class="form-help">Password minimal 6 karakter untuk keamanan yang lebih baik</div>
                <div id="password-strength" class="password-strength" style="display: none;"></div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">Simpan Penulis</button>
                <a href="list.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>

        <a href="list.php" class="back-link">Kembali ke Daftar Penulis</a>
    </div>

    <script>
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthDiv = document.getElementById('password-strength');

            if (password.length === 0) {
                strengthDiv.style.display = 'none';
                return;
            }

            strengthDiv.style.display = 'block';

            let strength = 0;
            if (password.length >= 6) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;

            strengthDiv.className = 'password-strength';

            if (strength < 2) {
                strengthDiv.classList.add('weak');
                strengthDiv.textContent = 'Password lemah';
            } else if (strength < 4) {
                strengthDiv.classList.add('medium');
                strengthDiv.textContent = 'Password sedang';
            } else {
                strengthDiv.classList.add('strong');
                strengthDiv.textContent = 'Password kuat';
            }
        });

        document.querySelector('form').addEventListener('submit', function(e) {
            const nickname = document.getElementById('nickname').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;

            if (!nickname) {
                e.preventDefault();
                alert('Nama penulis harus diisi!');
                document.getElementById('nickname').focus();
                return false;
            }

            if (!email) {
                e.preventDefault();
                alert('Email harus diisi!');
                document.getElementById('email').focus();
                return false;
            }

            if (password.length < 6) {
                e.preventDefault();
                alert('Password minimal 6 karakter!');
                document.getElementById('password').focus();
                return false;
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('nickname').focus();
        });
    </script>
</body>

</html>