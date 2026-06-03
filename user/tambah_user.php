<?php
include '../koneksi.php';

$nama  = '';
$password = ''; // Ditambahkan agar tidak ada undefined variable saat kosong
$error = '';
$success = '';

if (isset($_POST['simpan'])) {

    $nama     = trim($_POST['nama'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($nama == '' || $password == '') {

        $error = "Semua field wajib diisi.";

    } else { // ⬅️ SUDAH DIPERBAIKI: Menambahkan 'else' yang hilang

        // SIMPAN DATA
        // ⬅️ SUDAH DIPERBAIKI: Menghapus koma ekstra di VALUES (?, ?)
        $stmt = mysqli_prepare($conn, "INSERT INTO tabel_user (nama, `password`) VALUES (?, ?)");

        // ⬅️ SUDAH DIPERBAIKI: Mengubah "sss" menjadi "ss" karena hanya ada 2 parameter
        mysqli_stmt_bind_param($stmt, "ss", $nama, $password);

        if (mysqli_stmt_execute($stmt)) {

            $success = "✅ Data berhasil disimpan!";

            // KOSONGKAN INPUT
            $nama  = '';
            $password = '';

        } else {

            $error = "❌ Data gagal disimpan.";

        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data</title>
    <style>
    /* RESET */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background: linear-gradient(
        90deg,
        #014d40 0%,
        #005f56 35%,
        #003b49 100%
    );
    padding:20px;
}

/* CARD */
.card{
    width:100%;
    max-width:400px; /* sebelumnya 600px */
    background:#ffffff;
    border-radius:18px;
    padding:25px;
    box-shadow:0 10px 25px rgba(0,0,0,0.20);
}

.icon{
    text-align:center;
    font-size:40px; /* sebelumnya 55px */
    margin-bottom:10px;
}

.card h2{
    text-align:center;
    font-size:28px; /* sebelumnya 42px */
    color:#0f172a;
    margin-bottom:5px;
}

.subtitle{
    text-align:center;
    color:#64748b;
    font-size:14px; /* sebelumnya 20px */
    margin-bottom:25px;
}

.form-group{
    margin-bottom:15px;
}

.form-group label{
    display:block;
    margin-bottom:6px;
    font-size:14px;
    font-weight:600;
}

.input-wrapper{
    display:flex;
    align-items:center;
    background:#f3f4f6;
    border:2px solid #d1d5db;
    border-radius:12px;
    padding:0 12px;
}

.input-wrapper span{
    font-size:16px;
    margin-right:8px;
}

.input-wrapper input{
    width:100%;
    border:none;
    outline:none;
    background:transparent;
    padding:12px 0;
    font-size:14px;
}

.btn{
    width:100%;
    border:none;
    border-radius:12px;
    padding:12px;
    margin-top:10px;
    background:linear-gradient(
        90deg,
        #059669,
        #047857
    );
    color:white;
    font-size:16px;
    font-weight:bold;
    cursor:pointer;
}

.btn-kembali{
    display:block;
    text-align:center;
    text-decoration:none;
    margin-top:10px;
    padding:10px;
    border-radius:12px;
    background:#e5e7eb;
    color:#334155;
    font-weight:600;
    font-size:14px;
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

.login-link{
    text-align:center;
    color:#475569;
    font-size:13px;
}
.login-link a{
    color:#059669;
    font-weight:bold;
    text-decoration:none;
}

.login-link a:hover{
    text-decoration:underline;
}
</style>
</head>
<body>

<div class="card">

    <div class="icon">📝</div>

    <h2>Data user</h2>

    <p class="subtitle">
        Isi form berikut untuk membuat user anda
    </p>

    <!-- ERROR -->
    <?php if ($error != ''): ?>

        <div class="error">
            ⚠️ <?php echo htmlspecialchars($error); ?>
        </div>

    <?php endif; ?>

    <!-- SUCCESS -->
    <?php if ($success != ''): ?>

        <div class="success">
            <?php echo $success; ?>
        </div>

    <?php endif; ?>

    <form method="POST" autocomplete="off">

        <!-- NAMA -->
        <div class="form-group">

            <label for="nama">Nama</label>

            <div class="input-wrapper">

                <span>👤</span>

                <input
                    type="text"
                    id="nama"
                    name="nama"
                    placeholder="Masukkan nama"
                    value="<?php echo htmlspecialchars($nama); ?>"
                >

            </div>

        </div>

        <!-- PASSWORD -->
        <div class="form-group">

            <label for="password">Password</label>

            <div class="input-wrapper">

                <span>🔒</span>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                >

            </div>

        </div>

        <!-- BUTTON -->
        <button type="submit" name="simpan" class="btn">
            💾 Simpan
        </button>

        <!-- TOMBOL KEMBALI -->
        <a href="data_user.php" class="btn-kembali">
            ⬅ Kembali ke Halaman Utama
        </a>

    </form>

    <div class="divider">atau</div>

    <p class="login-link">
        Sudah punya akun?
        <a href="tambah_user.php">Login di sini</a>
    </p>

</div>

</body>
</html>