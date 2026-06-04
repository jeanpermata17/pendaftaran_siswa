<?php
include '../koneksi.php';

// ==================================================
// AMBIL DATA TERAKHIR UNTUK AUTO-INCREMENT AMAN
// ==================================================
$query_reg = mysqli_query($conn, "SELECT no_pendaftar FROM tabel_pendaftar ORDER BY id DESC LIMIT 1");

if ($query_reg && mysqli_num_rows($query_reg) > 0) {
    $row_reg = mysqli_fetch_array($query_reg);
    $last_reg = $row_reg['no_pendaftar']; 
    
    if (strpos($last_reg, '-') !== false) {
        $nomor_saja = (int) substr($last_reg, strpos($last_reg, '-') + 1);
    } else {
        $nomor_saja = (int) $last_reg;
    }
    
    $nomor_baru = $nomor_saja + 1; 
} else {
    $nomor_baru = 99231; 
}

// Sinkronisasi ID Sistem dan No Pendaftaran dengan angka urutan yang sama
$format_id_baru          = "ID-2026" . sprintf("%02d", ($nomor_baru % 100)); 
$format_pendaftaran_baru = "REG-" . $nomor_baru;

$error = '';

if(isset($_POST['simpan'])){
    $no_pendaftar    = mysqli_real_escape_string($conn, $_POST['no_pendaftar']);
    $nama_lengkap    = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $jenis_kelamin   = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $asal_sekolah    = mysqli_real_escape_string($conn, $_POST['asal_sekolah']);
    $jurusan_pilihan = mysqli_real_escape_string($conn, $_POST['jurusan_pilihan']);
    $no_tlepon       = mysqli_real_escape_string($conn, $_POST['no_tlepon']);

    $query_insert = "INSERT INTO tabel_pendaftar 
                    (no_pendaftar, nama_lengkap, jenis_kelamin, asal_sekolah, jurusan_pilihan, no_tlepon) 
                    VALUES 
                    ('$no_pendaftar', '$nama_lengkap', '$jenis_kelamin', '$asal_sekolah', '$jurusan_pilihan', '$no_tlepon')";

    if(mysqli_query($conn, $query_insert)){
        header("Location: data_df.php");
        exit;
    } else {
        $error = "Gagal menyimpan data ke database: " . mysqli_error($conn);
    }
}
?>
 
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Pendaftaran</title>
    
    <style>
        /* Menggunakan font modern bawaan Google Fonts */
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
            color: #0b1a30; /* Biru dongker/hitam pekat */
            text-align: center;
            font-size: 28px;
            margin: 0 0 5px 0;
            font-weight: 800;
        }

        .subtitle {
            text-align: center;
            color: #7b8a9c; /* Abu-abu kebiruan */
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
            border: 1px solid #d1d5db; /* Border abu-abu */
            border-radius: 8px;
            font-size: 14px;
            color: #374151;
            background-color: #f3f4f6; /* Latar input abu-abu muda */
            outline: none;
            transition: all 0.3s ease;
            box-sizing: border-box;
            font-family: inherit;
        }

        .form-group input:focus, 
        .form-group select:focus {
            border-color: #0d845e; /* Border hijau saat aktif */
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(13, 132, 94, 0.15);
        }

        .form-group input[readonly] {
            background-color: #e5e7eb;
            color: #6b7280;
            cursor: not-allowed;
        }

        /* Tombol Simpan (Hijau) */
        .btn-simpan {
            width: 100%;
            background-color: #0d845e; /* Hijau tua */
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
            background-color: #e5e8ec; /* Abu-abu muda */
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

        /* Separator "atau" */
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

        /* Link Footer */
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
        <h2>Data user baru</h2>
        <p class="subtitle">Isi form berikut untuk membuat data SPMB</p>

        <?php if(!empty($error)): ?>
            <div style="color: #b91c1c; background-color: #fef2f2; padding: 12px; border: 1px solid #f87171; margin-bottom: 20px; border-radius: 6px; font-size: 14px;">
                <?= $error; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">

            <div class="form-row">
                <div class="form-group">
                    <label>ID Sistem (Otomatis)</label>
                    <input type="text" name="id" value="<?= $format_id_baru; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>No. SPMB (Otomatis)</label>
                    <input type="text" name="no_pendaftar" value="<?= $format_pendaftaran_baru; ?>" readonly>
                </div>
            </div>

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" placeholder="Masukkan nama lengkap" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Asal Sekolah</label>
                    <input type="text" name="asal_sekolah" placeholder="Nama SMA/SMK/MA Asal" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Jurusan Pilihan</label>
                    <select name="jurusan_pilihan" required>
                        <option value="">-- Pilih Jurusan --</option>
                        <option value="Rekayasa Perangkat Lunak">Rekayasa Perangkat Lunak (RPL)</option>
                        <option value="Tata Busana">Tata Busana (TB)</option>
                        <option value="Teknik Sepeda Motor">Teknik Sepeda Motor (TSM)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>No. Telepon / WhatsApp</label>
                    <input type="text" name="no_tlepon" placeholder="081234567890" required>
                </div>
            </div>

            <button type="submit" name="simpan" class="btn-simpan">
                💾 Simpan
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