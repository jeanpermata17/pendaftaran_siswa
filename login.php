<?php
include 'koneksi.php';
session_start();

$error = '';
$nama = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = trim($_POST['nama'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($nama == '' || $password == '') {
        $error = "Semua field wajib diisi.";
    } else {
        $stmt = mysqli_prepare($conn, "SELECT * FROM tabel_user WHERE nama = ?");
        mysqli_stmt_bind_param($stmt, "s", $nama);
        mysqli_stmt_execute($stmt);
        
        $result = mysqli_stmt_get_result($stmt);
        $user   = mysqli_fetch_assoc($result);

        if ($user) {
            // PERBAIKAN DI SINI: Menggunakan perbandingan langsung (===) 
            // agar bisa membaca password teks biasa yang ada di database Anda.
            if ($password === $user['password']) {
                $_SESSION['user'] = $user['nama'];
                $_SESSION['id']   = $user['id'];
                
                header("Location: user/data_user.php");
                exit;
            } else {
                $error = "Password salah.";
            }
        } else {
            $error = "Nama tidak ditemukan.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tema Emerald</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #064e3b, #111827);
            padding: 20px;
        }

        .card {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        .card .icon {
            text-align: center;
            font-size: 55px;
            margin-bottom: 12px;
        }

        .card h2 {
            text-align: center;
            color: #111827;
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .card p.subtitle {
            text-align: center;
            color: #4b5563;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #1f2937;
            font-size: 14px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper span {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            color: #6b7280;
        }

        input {
            width: 100%;
            padding: 14px 14px 14px 42px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            outline: none;
            font-size: 14px;
            transition: all 0.3s ease;
            color: #111827;
            background-color: #f9fafb;
        }

        input:focus {
            border-color: #059669;
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.15);
        }

        .btn {
            width: 100%;
            padding: 14px;
            border: none;
            background: linear-gradient(135deg, #059669, #065f46);
            color: #ffffff;
            font-size: 16px;
            font-weight: bold;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(5, 150, 105, 0.4);
            background: linear-gradient(135deg, #047857, #022c22);
        }

        .btn:active {
            transform: translateY(0);
        }

        .error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fca5a5;
            padding: 12px 14px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .divider {
            text-align: center;
            margin: 22px 0;
            color: #9ca3af;
            font-size: 13px;
            position: relative;
        }

        .divider::before,
        .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 35%;
            height: 1px;
            background: #e5e7eb;
        }

        .divider::before { left: 0; }
        .divider::after  { right: 0; }

        .register-link {
            display: block;
            text-align: center;
            font-size: 14px;
            color: #4b5563;
        }

        .register-link a {
            color: #059669;
            text-decoration: none;
            font-weight: 700;
        }

        .register-link a:hover {
            text-decoration: underline;
            color: #047857;
        }
    </style>
</head>
<body>
    <div class="card">

        <div class="icon">🎓</div>
        <h2>Selamat Datang</h2>
        <p class="subtitle">Silakan login untuk melanjutkan</p>

        <?php if ($error != ''): ?>
            <div class="error">
                ⚠️ <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" autocomplete="off">
            <div class="form-group">
                <label for="nama">Nama Pengguna</label>
                <div class="input-wrapper">
                    <span>👤</span>
                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        placeholder="Masukkan nama Anda"
                        value="<?php echo htmlspecialchars($nama); ?>"
                        required
                    >
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <span>🔒</span>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password Anda"
                        required
                    >
                </div>
            </div>

            <button type="submit" class="btn">🚀 Masuk Aplikasi</button>
        </form>

        <div class="divider">atau</div>

        <p class="register-link">
            Belum punya akun? <a href="user/tambah_user.php">Daftar di sini</a>
        </p>

    </div>
</body>
</html>