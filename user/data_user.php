<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

include '../koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data user</title>
    <style>
        /* RESET STYLES */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f3f4f6; /* Abu-abu sangat muda untuk kontras dashboard */
            color: #111827; /* Hitam pekat untuk teks utama */
            min-height: 100vh;
        }

        /* NAVBAR STYLES */
        .navbar {
            background: linear-gradient(135deg, #064e3b, #022c22); /* Gradasi Hijau Tua */
            color: #ffffff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar h3 {
            font-size: 18px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .navbar .right {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .navbar a {
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .navbar .data-uang {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.15);
        }

        .navbar .data-uang:hover {
            background-color: rgba(255, 255, 255, 0.3);
        }

        .navbar .logout-btn {
            color: #ffffff;
            background-color: #b91c1c; /* Aksen merah khusus logout agar kontras */
        }

        .navbar .logout-btn:hover {
            background-color: #991b1b;
            transform: translateY(-1px);
        }

        /* MAIN CONTAINER */
        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .container h1 {
            font-size: 28px;
            color: #111827; /* Hitam */
            margin-bottom: 25px;
            font-weight: 700;
        }

        /* TOMBOL TAMBAH DATA (HIJAU TUA) */
        .btn-tambah {
            display: inline-block;
            text-decoration: none;
            background: linear-gradient(135deg, #059669, #065f46);
            color: #ffffff;
            padding: 12px 20px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 10px;
            margin-bottom: 25px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.2);
        }

        .btn-tambah:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(5, 150, 105, 0.3);
            background: linear-gradient(135deg, #047857, #022c22);
        }

        /* TABLE CARD MANAJEMEN */
        .card-table {
            background: #ffffff; /* Putih Bersih */
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            overflow: hidden; /* Agar sudut tabel melengkung rapi */
            border: 1px solid #e5e7eb;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 15px;
        }

        /* HEADER TABEL (HITAM SELEKTIF ATAU HIJAU PEKAT) */
        thead tr {
            background-color: #111827; /* Hitam Pekat Elegan */
            color: #ffffff;
        }

        th {
            padding: 16px 20px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        td {
            padding: 16px 20px;
            color: #374151; /* Abu-abu gelap */
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
        }

        /* Efek baris tabel saat dilewati mouse */
        tbody tr:hover {
            background-color: #f0fdf4; /* Hijau sangat muda lembut */
        }

        /* BADGE UNTUK NOMOR */
        .no-badge {
            background-color: #e5e7eb;
            color: #1f2937;
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
        }

        /* TOMBOL AKSI (EDIT & HAPUS) */
        .btn-edit, .btn-hapus {
            display: inline-block;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            padding: 8px 14px;
            border-radius: 8px;
            transition: all 0.2s ease;
            margin-right: 5px;
        }

        .btn-edit {
            background-color: #f3f4f6;
            color: #059669; /* Teks Hijau */
            border: 1px solid #d1d5db;
        }

        .btn-edit:hover {
            background-color: #059669;
            color: #ffffff;
            border-color: #059669;
        }

        .btn-hapus {
            background-color: #fff5f5;
            color: #dc2626; /* Teks Merah */
            border: 1px solid #fee2e2;
        }

        .btn-hapus:hover {
            background-color: #dc2626;
            color: #ffffff;
            border-color: #dc2626;
        }

        /* KONDISI DATA KOSONG */
        .empty-row td {
            text-align: center;
            padding: 40px;
            color: #6b7280;
            font-style: italic;
            background-color: #fafafa;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <h3>👋 Welcome, <?= htmlspecialchars($_SESSION['user']); ?></h3>
        <div class="right">
            <a href="../pendaftaran/data_df.php" class="data-uang">📈 Data SPMB</a>
            <a href="../logout.php" class="logout-btn">🚪 Logout</a>
        </div>
    </div>

    <div class="container">
        <h1>📋 Data User Anda</h1>
        <a href="tambah_user.php" class="btn-tambah">+ Tambah Data Baru</a>

        <div class="card-table">
            <table>
                <thead>
                    <tr>
                        <th style="width: 80px;">No</th>
                        <th>Nama</th>
                        <th>Password</th>
                        <th style="width: 220px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $data = mysqli_query($conn, "SELECT * FROM tabel_user");
                    $no   = 1; 
                    
                    if (mysqli_num_rows($data) > 0):
                        while ($item = mysqli_fetch_array($data)):
                    ?>
                    <tr>
                        <td><span class="no-badge"><?= $no++; ?></span></td>
                        <td style="font-weight: 600; color: #111827;"><?= htmlspecialchars($item['nama']); ?></td>
                        <td style="font-family: 'Courier New', Courier, monospace; color: #6b7280;"><?= htmlspecialchars($item['password']); ?></td>
                        <td>
                            <a href="edit_user.php?id=<?= $item['id']; ?>" class="btn-edit">✏️ Edit</a>
                            <a href="hapus_user.php?id=<?= $item['id']; ?>" class="btn-hapus"
                               onclick="return confirm('Yakin ingin menghapus data ini?')">🗑️ Hapus</a>
                        </td>
                    </tr>
                    <?php
                        endwhile;
                    else:
                    ?>
                    <tr class="empty-row">
                        <td colspan="4">😔 Belum ada data yang tersedia di database.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>