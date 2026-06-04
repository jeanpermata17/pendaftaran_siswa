<?php
include 'koneksi.php'; // Pastikan file koneksi.php kamu sudah benar

// ==================================================
// AMBIL DATA TERAKHIR UNTUK AUTO-INCREMENT AMAN
// ==================================================
$query_reg = mysqli_query($conn, "SELECT no_pendaftar FROM tabel_pendaftar ORDER BY id DESC LIMIT 1");

if ($query_reg && mysqli_num_rows($query_reg) > 0) {
    $row_reg = mysqli_fetch_array($query_reg);
    $last_reg = $row_reg['no_pendaftar']; // Mengambil REG terakhir, misal: REG-99231 atau REG-3545
    
    // Ambil angka setelah tanda "-" jika ada format REG-XXXX
    if (strpos($last_reg, '-') !== false) {
        $nomor_saja = (int) substr($last_reg, strpos($last_reg, '-') + 1);
    } else {
        $nomor_saja = (int) $last_reg;
    }
    
    $nomor_baru = $nomor_saja + 1; 
} else {
    // Nilai default awal jika tabel di database benar-benar kosong
    $nomor_baru = 99231; 
}

// Sinkronisasi ID Sistem dan No Pendaftaran dengan angka urutan yang sama
$format_id_baru          = "ID-2026" . sprintf("%02d", ($nomor_baru % 100)); // Menyesuaikan format ID-202605
$format_pendaftaran_baru = "REG-" . $nomor_baru;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard SPMB | SMK Riyadhul Ulum</title>
    <link class="sub-css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* ==========================================
           TEMA WARNA KONSISTEN: HIJAU TUA, PUTIH, & HITAM
           ========================================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f0fdf4; 
            color: #000000;
            min-height: 100vh;
        }

        /* NAVBAR STYLES */
        .navbar {
            background-color: #14532d; 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
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
            padding: 12px 0;
        }

        .nav-logo {
            color: #ffffff; 
            font-size: 1.3rem;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-logo img {
            height: 45px;
            width: auto;
            display: block;
            object-fit: contain;
            border-radius: 4px;
            mix-blend-mode: lighten; 
        }

        .nav-menu {
            display: flex;
            align-items: center;
            list-style: none;
            gap: 20px;
        }

        .nav-menu a {
            color: #ffffff;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            padding: 8px 15px;
            border-radius: 5px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            opacity: 0.85;
        }

        .nav-menu a:hover, .nav-menu a.active {
            color: #14532d; 
            background-color: #ffffff; 
            opacity: 1;
        }

        .nav-menu .btn-logout {
            background-color: #ffffff;
            color: #14532d !important;
            font-weight: 600;
        }

        .nav-menu .btn-logout:hover {
            background-color: transparent;
            color: #ffffff !important;
            border: 1px solid #ffffff;
        }

        /* LAYOUT CONTAINER */
        .dashboard-container {
            width: 90%;
            max-width: 1100px;
            margin: 100px auto 40px; 
        }

        /* WELCOME/HERO SECTION STYLE */
        .welcome-section {
            background: #14532d; 
            color: #ffffff;
            padding: 40px 30px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            text-align: center;
        }

        .welcome-section h1 {
            font-size: 2.2rem;
            margin-bottom: 8px;
            color: #ffffff;
        }

        .welcome-section p {
            color: #ffffff;
            opacity: 0.9;
            font-size: 1.1rem;
        }

        /* CARDS & GRIDS STYLE */
        .card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            margin-bottom: 30px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            text-align: center;
            transition: transform 0.2s ease;
        }
        .stat-card:hover {
            transform: translateY(-3px);
        }

        .stat-card.blue { border-top: 4px solid #16a34a; }   
        .stat-card.green { border-top: 4px solid #14532d; }  
        .stat-card.orange { border-top: 4px solid #475569; } 

        .stat-card h3 {
            font-size: 1.1rem;
            color: #475569;
            margin-bottom: 10px;
        }

        .stat-number-text {
            font-size: 1.6rem;
            font-weight: 700;
            color: #14532d;
        }

        /* FORM COMPONENT STYLES */
        .form-section h2 {
            font-size: 1.5rem;
            color: #14532d;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        hr {
            border: 0;
            height: 1px;
            background-color: #e2e8f0;
            margin-bottom: 25px;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 20px;
        }

        .form-row .form-group {
            margin-bottom: 0;
        }

        label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #475569;
        }

        input[type="text"], input[type="tel"], select {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 0.95rem;
            background-color: #ffffff;
            color: #000000;
            outline: none;
            transition: border-color 0.2s;
        }

        input:focus, select:focus {
            border-color: #14532d;
        }

        .btn-submit {
            background-color: #14532d;
            color: #ffffff;
            border: none;
            padding: 14px 24px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.2s;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background-color: #0f3f22;
        }

        @media (max-width: 768px) {
            .nav-container { flex-direction: column; gap: 15px; }
            .nav-menu { width: 100%; justify-content: center; flex-wrap: wrap; gap: 10px; }
            .dashboard-container { margin-top: 190px; }
            .form-row { flex-direction: column; gap: 20px; }
            .welcome-section h1 { font-size: 1.6rem; }
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <a href="#" class="nav-logo">
                <img src="logo-smk.jpg" alt="Logo SMK Riyadhul Ulum"> 
                SMK Riyadhul Ulum
            </a>
            <ul class="nav-menu">
                <li><a href="dashbord.php" class="active"><i class="fa-solid fa-chart-pie"></i> Dashboard</a></li>
                <li><a href="profil.php"><i class="fa-solid fa-user-plus"></i> Profil</a></li>
                <li><a href="index.php" class="btn-logout">Keluar</a></li>
            </ul>
        </div>
    </nav>

    <div class="dashboard-container">
        
        <header class="welcome-section">
            <h1>Selamat Datang di Portal SPMB</h1>
            <p>Silakan lengkapi formulir pendaftaran di bawah ini dengan data yang valid.</p>
        </header>

        <div class="stats-grid">
            <div class="card stat-card blue">
                <h3>ID SPMB Anda</h3>
                <p id="cardIdUser" class="stat-number-text"><?= $format_id_baru; ?></p>
            </div>
            <div class="card stat-card green">
                <h3>No. SPMB</h3>
                <p id="cardNoPendaftar" class="stat-number-text"><?= $format_pendaftaran_baru; ?></p>
            </div>
            <div class="card stat-card orange">
                <h3>Status Akun</h3>
                <p id="statusAkun" class="stat-number-text" style="font-size: 1.3rem; margin-top: 5px;">Belum Mengisi Data</p>
            </div>
        </div>

        <main class="card form-section">
            <h2><i class="fa-solid fa-pen-to-square"></i> Formulir SPMB Baru</h2>
            <hr>
            
            <form id="formPendaftaran" action="pendaftaran/data_df.php" method="POST">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="id">ID Sistem (Otomatis)</label>
                        <input type="text" id="id" name="id" value="<?= $format_id_baru; ?>" readonly style="background-color: #f1f2f6; cursor: not-allowed; border-color: #cbd5e1;">
                    </div>
                    <div class="form-group">
                        <label for="no_pendaftar">No. SPMB (Otomatis)</label>
                        <input type="text" id="no_pendaftar" name="no_pendaftar" value="<?= $format_pendaftaran_baru; ?>" readonly style="background-color: #f1f2f6; cursor: not-allowed; border-color: #cbd5e1;">
                    </div>
                </div>

                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan nama lengkap sesuai ijazah" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="asal_sekolah">Asal Sekolah</label>
                        <input type="text" id="asal_sekolah" name="asal_sekolah" placeholder="Nama SMA/SMK/MA Asal" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="jurusan_pilihan">Jurusan Pilihan</label>
                        <select id="jurusan_pilihan" name="jurusan_pilihan" required>
                            <option value="" disabled selected>-- Pilih Jurusan --</option>
                            <option value="Rekayasa Perangkat Lunak">Rekayasa perangkat lunak(RPL)</option>
                            <option value="Tata Busana">Tata busana(TB)</option>
                            <option value="Teknik Sepeda Motor">Teknik sepeda motor(TSM)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="no_telepon">No. Telepon / WhatsApp</label>
                        <input type="tel" id="no_telepon" name="no_telepon" placeholder="Contoh: 081234567890" required>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Simpan & Kirim Pendaftaran</button>
            </form>
        </main>
    </div>

    <script>
    document.getElementById('formPendaftaran').addEventListener('submit', function(event) {
        event.preventDefault(); 

        const formData = new FormData(this);
        const actionUrl = this.getAttribute('action');

        fetch(actionUrl, {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success') {
                alert('Berhasil Terkirim! Data pendaftaran Anda telah disimpan.');
                
                const statusEl = document.getElementById('statusAkun');
                statusEl.innerText = 'Sudah Terhubung';
                statusEl.style.color = '#16a34a'; 
                
                if (data.next_id && data.next_reg) {
                    document.getElementById('cardIdUser').innerText = data.next_id;
                    document.getElementById('cardNoPendaftar').innerText = data.next_reg;
                }
                
                this.reset();
                
                if (data.next_id && data.next_reg) {
                    document.getElementById('id').value = data.next_id;
                    document.getElementById('no_pendaftar').value = data.next_reg;
                }
            } else {
                alert('Gagal menyimpan data: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat berkomunikasi dengan server.');
        });
    });
    </script>
</body>
</html>