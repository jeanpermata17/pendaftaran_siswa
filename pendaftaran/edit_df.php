<?php
include '../koneksi.php';

// 1. Memastikan ada ID data yang dikirim lewat URL (contoh: edit.php?id=5)
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: data_df.php");
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

// 2. Ambil data lama dari database berdasarkan ID untuk ditampilkan di form
$query_select = mysqli_query($conn, "SELECT * FROM tabel_pendaftar WHERE id = '$id'");

// Jika data tidak ditemukan di database, kembalikan ke halaman utama
if (mysqli_num_rows($query_select) == 0) {
    header("Location: data_df.php");
    exit;
}

$data = mysqli_fetch_array($query_select);
$error = '';

// 3. Proses ketika tombol name="update" diklik
if (isset($_POST['update'])) {

    // Ambil data dari form dan amankan input
    $nama_lengkap    = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $jenis_kelamin   = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $asal_sekolah    = mysqli_real_escape_string($conn, $_POST['asal_sekolah']);
    $jurusan_pilihan = mysqli_real_escape_string($conn, $_POST['jurusan_pilihan']);
    $no_tlepon       = mysqli_real_escape_string($conn, $_POST['no_tlepon']);

    // Jalankan query UPDATE
    $query_update = "UPDATE tabel_pendaftar SET 
                    nama_lengkap    = '$nama_lengkap', 
                    jenis_kelamin   = '$jenis_kelamin', 
                    asal_sekolah    = '$asal_sekolah', 
                    jurusan_pilihan = '$jurusan_pilihan', 
                    no_tlepon       = '$no_tlepon' 
                    WHERE id        = '$id'";

    if (mysqli_query($conn, $query_update)) {
        // Jika berhasil, redirect kembali ke data_df.php
        header("Location: data_df.php");
        exit;
    } else {
        // Jika gagal, tampilkan pesan error
        $error = "Gagal memperbarui data: " . mysqli_error($conn);
    }
}
?>
 
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pendaftaran</title>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap');

        body {
            font-family: 'Nunito', sans-serif;
            background-color: #0c564f; /* Tema latar hijau tua (teal) */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 40px 20px;
        }

        .card.form-section {
            background: #ffffff;
            width: 100%;
            max-width: 500px;
            padding: 40px 35px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .icon-header {
            text-align: center;
            font-size: 40px;
            margin-bottom: 10px;
        }

        h2 {
            color: #0b1a30;
            text-align: center;
            font-size: 28px;
            margin: 0 0 5px 0;
            font-weight: 800;
        }

        .subtitle {
            text-align: center;
            color: #7b8a9c;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .form-row {
            display: flex;
            gap: 15px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            color: #111827;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .form-group input, 
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            color: #374151;
            background-color: #f3f4f6;
            outline: none;
            transition: all 0.3s ease;
            box-sizing: border-box;
            font-family: inherit;
        }

        .form-group input:focus, 
        .form-group select:focus {
            border-color: #0d845e;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(13, 132, 94, 0.15);
        }

        .form-group input[readonly] {
            background-color: #e5e7eb;
            color: #6b7280;
            cursor: not-allowed;
        }

        /* Tombol Perbarui (Hijau) */
        .btn-simpan {
            width: 100%;
            background-color: #0d845e;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 10px;
            font-family: inherit;
        }

        .btn-simpan:hover {
            background-color: #0a6b4c;
        }

        /* Tombol Kembali (Abu-abu) */
        .btn-kembali {
            display: block;
            width: 100%;
            background-color: #e5e8ec;
            color: #374151;
            text-align: center;
            text-decoration: none;
            padding: 14px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 700;
            margin-top: 15px;
            transition: background 0.3s;
            box-sizing: border-box;
        }

        .btn-kembali:hover {
            background-color: #d1d5db;
        }

        .separator {
            display: flex;
            align-items: center;
            text-align: center;
            color: #9ca3af;
            font-size: 13px;
            margin: 25px 0;
        }

        .separator::before,
        .separator::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #f3f4f6;
        }

        .separator::before { margin-right: 1em; }
        .separator::after { margin-left: 1em; }

        .footer-link {
            text-align: center;
            font-size: 14px;
            color: #6b7280;
        }

        .footer-link a {
            color: #0d845e;
            font-weight: 700;
            text-decoration: none;
        }

        .footer-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <main class="card form-section">

        <div class="icon-header">📝</div>
        <h2>Edit Data User</h2>
        <p class="subtitle">Perbarui form berikut untuk mengubah data SPMB</p>

        <?php if(!empty($error)): ?>
            <div style="color: #b91c1c; background-color: #fef2f2; padding: 12px; border: 1px solid #f87171; margin-bottom: 20px; border-radius: 6px; font-size: 14px;">
                <?= $error; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">

            <div class="form-row">
                <div class="form-group">
                    <label>ID Sistem</label>
                    <input type="text" name="id" value="ID-2026<?= sprintf('%02d', ($data['id'] % 100)); ?>" readonly>
                </div>
                <div class="form-group">
                    <label>No. SPMB</label>
                    <input type="text" name="no_pendaftar" value="<?= $data['no_pendaftar']; ?>" readonly>
                </div>
            </div>

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="<?= $data['nama_lengkap']; ?>" placeholder="Masukkan nama lengkap" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki" <?= ($data['jenis_kelamin'] == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                        <option value="Perempuan" <?= ($data['jenis_kelamin'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Asal Sekolah</label>
                    <input type="text" name="asal_sekolah" value="<?= $data['asal_sekolah']; ?>" placeholder="Nama SMA/SMK/MA Asal" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Jurusan Pilihan</label>
                    <select name="jurusan_pilihan" required>
                        <option value="">-- Pilih Jurusan --</option>
                        <option value="Rekayasa Perangkat Lunak" <?= ($data['jurusan_pilihan'] == 'Rekayasa Perangkat Lunak') ? 'selected' : ''; ?>>Rekayasa Perangkat Lunak (RPL)</option>
                        <option value="Tata Busana" <?= ($data['jurusan_pilihan'] == 'Tata Busana') ? 'selected' : ''; ?>>Tata Busana (TB)</option>
                        <option value="Teknik Sepeda Motor" <?= ($data['jurusan_pilihan'] == 'Teknik Sepeda Motor') ? 'selected' : ''; ?>>Teknik Sepeda Motor (TSM)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>No. Telepon / WhatsApp</label>
                    <input type="text" name="no_tlepon" value="<?= $data['no_tlepon']; ?>" placeholder="081234567890" required>
                </div>
            </div>

            <button type="submit" name="update" class="btn-simpan">
                💾 Perbarui Data
            </button>
            
            <a href="data_df.php" class="btn-kembali">
                &larr; Kembali ke Data Tamu
            </a>

            <div class="separator">atau</div>

            <div class="footer-link">
                Sudah punya akun? <a href="#">Login di sini</a>
            </div>

        </form>
    </main>

</body>
</html>