<?php
include '../koneksi.php';

$error   = '';
$success = '';
$user    = [];

// Ambil data berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM tabel_user WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $user   = mysqli_fetch_assoc($result);

    if (!$user) {
        header("Location: data_user.php");
        exit;
    }
} else {
    header("Location: data_user.php");
    exit;
}

// Proses Update
if (isset($_POST['update'])) {

    $nama     = trim($_POST['nama'] ?? '');
    $password = $_POST['password'] ?? '';
    $id       = $_POST['id'];

    if ($nama == '' || $password == '') {

        $error = "Semua field wajib diisi.";

    } else {

        $stmt = mysqli_prepare(
            $conn,
            "UPDATE tabel_user SET nama = ?, `password` = ? WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ssi",
            $nama,
            $password,
            $id
        );

        if (mysqli_stmt_execute($stmt)) {

            $stmt2 = mysqli_prepare(
                $conn,
                "SELECT * FROM tabel_user WHERE id = ?"
            );

            mysqli_stmt_bind_param($stmt2, "i", $id);
            mysqli_stmt_execute($stmt2);

            $result2 = mysqli_stmt_get_result($stmt2);
            $user    = mysqli_fetch_assoc($result2);

            $success = "Data berhasil diperbarui.";

        } else {

            $error = "Data gagal diperbarui.";

        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Data User</title>

<style>
/* RESET */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(135deg,#005f56,#00796b);
    padding:20px;
}

/* CARD */
.card{
    width:100%;
    max-width:380px;
    background:#fff;
    border-radius:25px;
    padding:28px;
    box-shadow:0 15px 35px rgba(0,0,0,.15);
}

/* ICON */
.icon{
    text-align:center;
    font-size:45px;
    margin-bottom:8px;
}

/* JUDUL */
.card h2{
    text-align:center;
    color:#0f172a;
    font-size:28px;
    margin-bottom:5px;
}

.subtitle{
    text-align:center;
    color:#64748b;
    font-size:14px;
    margin-bottom:25px;
}

/* ALERT */
.error,
.success{
    padding:12px;
    border-radius:10px;
    font-size:14px;
    margin-bottom:15px;
}

.error{
    background:#fee2e2;
    color:#dc2626;
}

.success{
    background:#dcfce7;
    color:#15803d;
}

/* FORM */
.form-group{
    margin-bottom:15px;
}

.form-group label{
    display:block;
    margin-bottom:6px;
    font-size:14px;
    font-weight:600;
    color:#334155;
}

.input-wrapper{
    display:flex;
    align-items:center;
    background:#f8fafc;
    border:2px solid #e2e8f0;
    border-radius:14px;
    padding:0 12px;
    transition:.3s;
}

.input-wrapper:focus-within{
    border-color:#059669;
    box-shadow:0 0 0 3px rgba(5,150,105,.15);
}

.input-wrapper span{
    font-size:18px;
    margin-right:8px;
}

.input-wrapper input{
    width:100%;
    border:none;
    outline:none;
    background:none;
    padding:12px 0;
    font-size:14px;
}

/* BUTTON UPDATE */
.btn-update{
    width:100%;
    border:none;
    border-radius:14px;
    padding:13px;
    background:linear-gradient(135deg,#059669,#047857);
    color:white;
    font-size:15px;
    font-weight:600;
    cursor:pointer;
    transition:.3s;
}

.btn-update:hover{
    transform:translateY(-2px);
    box-shadow:0 8px 20px rgba(5,150,105,.3);
}

/* PEMBATAS */
.divider{
    display:flex;
    align-items:center;
    margin:18px 0;
    color:#94a3b8;
    font-size:13px;
}

.divider::before,
.divider::after{
    content:'';
    flex:1;
    border-bottom:1px solid #e2e8f0;
}

.divider::before{
    margin-right:10px;
}

.divider::after{
    margin-left:10px;
}

/* BUTTON KEMBALI */
.btn-back{
    display:block;
    text-align:center;
    text-decoration:none;
    padding:12px;
    border-radius:14px;
    background:#f1f5f9;
    color:#334155;
    font-size:14px;
    font-weight:600;
    transition:.3s;
}

.btn-back:hover{
    background:#e2e8f0;
}
</style>
</head>
<body>

<div class="card">

    <div class="icon">✏️</div>

    <h2>Edit Data</h2>

    <p class="subtitle">
        Perbarui data akun Anda
    </p>

    <?php if($error != ''): ?>
        <div class="error">
            ⚠️ <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <?php if($success != ''): ?>
        <div class="success">
            ✅ <?php echo htmlspecialchars($success); ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <input
            type="hidden"
            name="id"
            value="<?php echo $user['id']; ?>"
        >

        <!-- Nama -->
        <div class="form-group">
            <label>Nama</label>

            <div class="input-wrapper">
                <span>👤</span>

                <input
                    type="text"
                    name="nama"
                    value="<?php echo htmlspecialchars($user['nama']); ?>"
                    placeholder="Masukkan nama"
                >
            </div>
        </div>

        <!-- Password -->
        <div class="form-group">
            <label>Password</label>

            <div class="input-wrapper">
                <span>🔒</span>

                <input
                    type="password"
                    name="password"
                    value="<?php echo htmlspecialchars($user['password']); ?>"
                    placeholder="Masukkan password"
                >
            </div>
        </div>

        <button type="submit" name="update" class="btn-update">
            💾 Update Data
        </button>

    </form>

    <div class="divider">atau</div>

    <a href="data_user.php" class="btn-back">
        ← Kembali ke Halaman Utama
    </a>

</div>

</body>
</html>