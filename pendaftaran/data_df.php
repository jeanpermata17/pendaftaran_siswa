<?php 
include '../koneksi.php'; 
session_start(); 

// =========================================================================
// LOGIKA PHP: MENDUKUNG AJAX (AGAR TETAP DI DASHBOARD & KIRIM BALIK JSON)
// =========================================================================
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id_user          = mysqli_real_escape_string($conn, $_POST['id']);
    $no_pendaftar     = mysqli_real_escape_string($conn, $_POST['no_pendaftar']);
    $nama_lengkap     = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $jenis_kelamin    = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $asal_sekolah     = mysqli_real_escape_string($conn, $_POST['asal_sekolah']);
    $jurusan_pilihan  = mysqli_real_escape_string($conn, $_POST['jurusan_pilihan']);
    $no_tlepon        = mysqli_real_escape_string($conn, $_POST['no_telepon']);

    $query_insert = "INSERT INTO tabel_pendaftar (no_pendaftar, nama_lengkap, jenis_kelamin, asal_sekolah, jurusan_pilihan, no_tlepon) 
                     VALUES ('$no_pendaftar', '$nama_lengkap', '$jenis_kelamin', '$asal_sekolah', '$jurusan_pilihan', '$no_tlepon')";

    // Jika diakses menggunakan Fetch API / AJAX JavaScript
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' || isset($_POST['id'])) {
        header('Content-Type: application/json');
        if (mysqli_query($conn, $query_insert)) {
            echo json_encode(['status' => 'success', 'message' => 'Pendaftaran Berhasil Disimpan!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
        }
        exit;
    }

    // fallback jika submit manual tanpa AJAX
    if (mysqli_query($conn, $query_insert)) {
        echo "<script>
                alert('Pendaftaran Berhasil Disimpan!');
                window.location.href = 'data_df.php';
              </script>";
        exit;
    } else {
        echo "<script>alert('Gagal menyimpan data: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pendaftaran | SMK Riyadhul Ulum</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background-color: #f4fbf7; /* Latar belakang abu-hijau super lembut */
    color: #0f172a; /* Teks utama gelap pekat modern */
    min-height: 100vh;
}

/* 1. NAVBAR / HEADER ATAS */
.navbar {
    background-color: #053b21; /* Hijau Tua Pekat sesuai gambar */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
}

.nav-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 90%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 14px 0;
}

.nav-container h3, .welcome-text {
    color: #ffffff;
    font-size: 1.15rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* Tombol Menu Kanan Navbar (Data Daftar / Kembali) */
.btn-nav-menu {
    background-color: rgba(255, 255, 255, 0.15);
    color: #ffffff !important;
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 500;
    padding: 8px 16px;
    border-radius: 6px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-right: 10px;
}

.btn-nav-menu:hover {
    background-color: rgba(255, 255, 255, 0.25);
}

/* Tombol Logout Merah */
.logout-btn {
    background-color: #b91c1c; /* Merah pekat sesuai gambar */
    color: #ffffff !important;
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 600;
    padding: 8px 16px;
    border-radius: 6px;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.logout-btn:hover {
    background-color: #991b1b;
}


/* 2. LAYOUT UTAMA & JUDUL HALAMAN */
.container {
    width: 92%;
    max-width: 1150px;
    margin: 100px auto 40px; 
}

.container h1, .title-section {
    font-size: 1.6rem;
    color: #053b21;
    font-weight: 700;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}


/* 3. TOMBOL AKSI UTAMA (Tambah Data Baru) */
.btn-tambah {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    background-color: #006b42; /* Hijau tombol tambah data */
    color: #ffffff;
    padding: 10px 18px;
    font-size: 0.9rem;
    font-weight: 600;
    border-radius: 8px;
    margin-bottom: 20px;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 6px rgba(0, 107, 66, 0.15);
}

.btn-tambah:hover {
    background-color: #005433;
    transform: translateY(-1px);
}


/* 4. SEKSI CARD (Pembungkus Form / Tabel) */
.card-table {
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05); /* Bayangan lembut melayang */
    border: 1px solid #e2e8f0;
    overflow-x: auto;
}


/* 5. STYLE TABEL (Data User / Data Pendaftar) */
table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
    font-size: 0.88rem;
}

/* Judul baris tabel menggunakan warna gelap pekat */
thead tr {
    background-color: #0d1527; 
    color: #ffffff;
}

th {
    padding: 14px 16px;
    font-weight: 600;
    letter-spacing: 0.3px;
    white-space: nowrap;
}

td {
    padding: 14px 16px;
    color: #1e293b;
    border-bottom: 1px solid #f1f5f9;
    white-space: nowrap;
}

tbody tr:last-child td {
    border-bottom: none;
}

tbody tr:hover {
    background-color: #f8fafc;
}

/* Nomor Urut Badge Bulat/Kotak Manis */
.no-badge {
    background-color: #e2e8f0;
    color: #475569;
    padding: 3px 8px;
    border-radius: 4px;
    font-weight: 600;
    font-size: 0.75rem;
}


/* 6. INPUT DAN ELEMENT FORMULIR */
.form-row {
    display: flex;
    gap: 20px;
    margin-bottom: 18px;
}

.form-group {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 6px;
}

label {
    font-size: 0.85rem;
    font-weight: 600;
    color: #475569;
}

/* Tampilan kolom input teks dan select */
input[type="text"], input[type="tel"], input[type="password"], select {
    width: 100%;
    padding: 11px 14px;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    font-size: 0.9rem;
    background-color: #ffffff;
    color: #0f172a;
    outline: none;
    transition: all 0.2s ease;
}

input:focus, select:focus {
    border-color: #006b42;
    box-shadow: 0 0 0 3px rgba(0, 107, 66, 0.1);
}

/* Input yang tidak bisa diedit (Read Only / Otomatis) */
input[readonly] {
    background-color: #f1f5f9;
    color: #64748b;
    cursor: not-allowed;
    border-color: #e2e8f0;
}


/* 7. TOMBOL AKSI TABEL (Edit & Hapus Mini) */
.btn-edit, .btn-hapus {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    text-decoration: none;
    font-size: 0.78rem;
    font-weight: 600;
    padding: 6px 14px;
    border-radius: 6px;
    transition: all 0.2s ease;
    margin-right: 4px;
    cursor: pointer;
}

.btn-edit {
    background-color: #f1f5f9;
    color: #006b42;
    border: 1px solid #cbd5e1;
}

.btn-edit:hover {
    background-color: #006b42;
    color: #ffffff;
    border-color: #006b42;
}

.btn-hapus {
    background-color: #fff1f2;
    color: #b91c1c;
    border: 1px solid #ffe4e6;
}

.btn-hapus:hover {
    background-color: #b91c1c;
    color: #ffffff;
    border-color: #b91c1c;
}


/* 8. RESPONSIVE SCRIPT LAYOUT */
@media (max-width: 768px) {
    .nav-container {
        flex-direction: column;
        gap: 12px;
        text-align: center;
    }
    .container {
        margin-top: 140px;
    }
    .form-row {
        flex-direction: column;
        gap: 15px;
    }
}
</style>
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <h3><i class="fa-solid fa-folder-open"></i> Data Pendaftaran Siswa</h3>
            <a href="../user/data_user.php" class="logout-btn"><i class="fa-solid fa-arrow-left"></i> Return</a>
        </div>
    </nav>

    <div class="container">
        <h1><i class="fa-solid fa-users"></i> Data Calon Siswa Baru</h1>

        <a href="tambah_df.php" class="btn-tambah"><i class="fa-solid fa-plus"></i> Tambah Data</a>

        <div class="card-table">
            <table>
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>No. Pendaftar</th>
                        <th>Nama Lengkap</th>
                        <th>Jenis Kelamin</th>
                        <th>Asal Sekolah</th>
                        <th>Jurusan Pilihan</th>
                        <th>No. Telepon</th>
                        <th style="text-align: center; width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $data = mysqli_query($conn, "SELECT * FROM tabel_pendaftar");
                        $no = 1; 
                        
                        while($item = mysqli_fetch_array($data)) {
                    ?>
                    <tr>
                        <td><span class="no-badge"><?= $no++; ?></span></td>
                        <td><?= htmlspecialchars($item['no_pendaftar']); ?></td>
                        <td class="wrap-text" style="font-weight: 600; color: #000000;"><?= htmlspecialchars($item['nama_lengkap']); ?></td>
                        <td><?= htmlspecialchars($item['jenis_kelamin']); ?></td>
                        <td class="wrap-text"><?= htmlspecialchars($item['asal_sekolah']); ?></td>
                        <td class="wrap-text"><i class="fa-solid fa-graduation-cap"></i> <?= htmlspecialchars($item['jurusan_pilihan']); ?></td>
                        <td><?= htmlspecialchars($item['no_tlepon']); ?></td>
                        <td style="text-align: center;">
                            <a href="edit_df.php?id=<?= $item['id']; ?>" class="btn-edit"><i class="fa-solid fa-pen"></i> Edit</a>
                            <a href="hapus_df.php?id=<?= $item['id']; ?>" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus data siswa ini?')"><i class="fa-solid fa-trash"></i> Hapus</a>
                        </td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>