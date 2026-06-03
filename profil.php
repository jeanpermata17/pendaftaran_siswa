<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Sekolah | SMK Riyadhul Ulum</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            color: #000000; /* Teks utama hitam pekat */
            min-height: 100vh;
        }

        /* NAVBAR STYLES */
        .navbar {
            background-color: #14532d; /* Hijau Tua */
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
            padding: 12px 0; /* Padding vertikal yang seimbang */
        }

        .nav-logo {
            color: #ffffff; /* Teks Putih */
            font-size: 1.3rem;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px; /* Jarak antara logo dan teks */
        }

        /* Merapikan tampilan logo sekolah */
        .nav-logo img {
            height: 45px; /* Tinggi logo pas dengan ukuran navbar */
            width: auto;
            display: block;
            object-fit: contain;
            border-radius: 4px;
            /* Trik CSS untuk menyamarkan background hitam/gelap pada gambar agar menyatu dengan hijau */
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
            color: #14532d; /* Teks berubah hijau tua saat aktif */
            background-color: #ffffff; /* Background menjadi putih saat aktif */
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
            background: #14532d; /* Hijau Tua Polos pekat sesuai request */
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
            font-style: italic;
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
            border-top: 4px solid #14532d; /* Garis atas hijau tua */
            text-align: center;
        }

        .stat-card h3 {
            font-size: 1.2rem;
            color: #14532d;
            margin-bottom: 10px;
        }

        .stat-card p {
            font-size: 0.95rem;
            color: #333333;
        }

        /* CONTENT STYLES */
        .profile-section h2 {
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
            margin-bottom: 20px;
        }

        .vision-mission-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-top: 15px;
        }

        .vm-box {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            border-left: 4px solid #14532d; /* Border samping hijau tua */
        }

        .vm-box h4 {
            color: #14532d;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        .vm-box ul {
            padding-left: 20px;
        }

        .vm-box li {
            margin-bottom: 8px;
            color: #333333;
        }

        /* TABLE JURUSAN STYLE */
        .table-responsive {
            overflow-x: auto;
            border-radius: 8px;
            margin-top: 15px;
            border: 1px solid #e2e8f0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }

        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
            font-size: 0.95rem;
            color: #000000;
        }

        th {
            background-color: #14532d; /* Header tabel hijau tua */
            color: #ffffff; /* Tulisan header tabel putih */
            font-weight: 600;
        }

        tr:hover {
            background-color: #f0fdf4;
        }

        /* FOOTER INFO */
        .footer-info {
            text-align: center;
            padding: 20px 0;
            color: #333333;
            font-size: 0.9rem;
            margin-top: 40px;
            border-top: 1px solid #cbd5e1;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .nav-container {
                flex-direction: column;
                gap: 15px;
            }
            .nav-menu {
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
                gap: 10px;
            }
            .dashboard-container {
                margin-top: 190px;
            }
            .welcome-section h1 {
                font-size: 1.6rem;
            }
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
                <li><a href="index.php"><i class="fa-solid fa-chart-pie"></i> Dashboard</a></li>
                <li><a href="profil.php" class="active"><i class="fa-solid fa-user-plus"></i> Profil</a></li>
                <li><a href="index.php" class="btn-logout">Keluar</a></li>
            </ul>
        </div>
    </nav>

    <div class="dashboard-container">
        
        <header class="welcome-section">
            <h1>SMK Riyadhul Ulum Ujung Batu</h1>
            <p>"Selamat datang di halaman SMK riyadhul ulum Sekolah unggulan berbasis 29 karakter, teknologi, dan prestasi.SMK RU adalah lembaga pendidikan kejuruan yang berkomitmen mengembangkan potensi peserta didik melalui pendidikan berbasis karakter, teknologi, dan nilai-nilai keislaman."</p>
        </header>

        <div class="stats-grid">
            <div class="card stat-card">
                <h3><i class="fa-solid fa-book-open-reader"></i> Imtaq & Iptek</h3>
                <p>Mengintegrasikan pendidikan karakter Islami dengan penguasaan teknologi modern masa kini.</p>
            </div>
            <div class="card stat-card">
                <h3><i class="fa-solid fa-briefcase"></i> Siap Kerja</h3>
                <p>Kurikulum kejuruan yang dirancang adaptif serta selaras dengan kebutuhan dunia industri nyata.</p>
            </div>
            <div class="card stat-card">
                <h3><i class="fa-solid fa-school"></i> Fasilitas Nyaman</h3>
                <p>Dukungan ruang laboratorium komputer praktek dan lingkungan belajar yang kondusif.</p>
            </div>
        </div>

        <main class="card profile-section">
            <h2><i class="fa-solid fa-address-card"></i> Sekilas Tentang Sekolah</h2>
            <hr>
            <p style="color: #333333; line-height: 1.7; margin-bottom: 20px;">
                SMK Riyadhul Ulum Ujung Batu berkomitmen penuh dalam melahirkan insan didik yang kompeten dan siap pakai di bursa kerja. Melalui perpaduan disiplin tinggi dan bimbingan nilai keagamaan yang kuat, kami menempa para siswa agar siap menghadapi tantangan global sekaligus menjadi pribadi yang berintegritas dan amanah.
            </p>

            <div class="vision-mission-grid">
                <div class="vm-box">
                    <h4><i class="fa-solid fa-eye"></i> Visi Sekolah</h4>
                    <p style="color: #000000;">Menjadi pusat pendidikan kejuruan unggulan pilihan masyarakat yang mampu mencetak lulusan mandiri, berjiwa wirausaha, profesional, dan tetap teguh pada koridor akhlakul karimah.</p>
                </div>
                <div class="vm-box">
                    <h4><i class="fa-solid fa-bullseye"></i> Misi Utama</h4>
                    <ul>
                        <li>Menyelenggarakan pembelajaran berbasis kompetensi kerja dan budi pekerti.</li>
                        <li>Mengembangkan bakat siswa secara optimal lewat praktek kerja nyata.</li>
                        <li>Membangun kemitraan strategis dengan institusi usaha demi penyerapan alumni.</li>
                    </ul>
                </div>
            </div>
        </main>

        <section class="card profile-section">
            <h2><i class="fa-solid fa-layer-group"></i> Program / Kompetensi Keahlian</h2>
            <hr>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Kompetensi Keahlian</th>
                            <th>Fokus Pembelajaran</th>
                            <th>Prospek Karir Utama</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Rekayasa Perangkat Lunak (RPL)</strong></td>
                            <td>perangkat lunak, pemrograman (coding), dan analisis sistem.</td>
                            <td>bekerja secara remote di perusahaan global, menjadi freelancer, atau bahkan membangun startup teknologi.</td>
                        </tr>
                        <tr>
                            <td><strong>Tata Busana (TB)</strong></td>
                            <td>keterampilan desain, menjahit, dan produksi pakaian.</td>
                            <td>perancang busana.</td>
                        </tr>
                        <tr>
                            <td><strong>Teknik Sepeda Motor (TSM)</strong></td>
                            <td>Menekankan pada keterampilan teknis sepeda motor secara utuh, mulai dari mesin, sasis, kelistrikan, hingga perbaikan sistem injeksi.</td>
                            <td>teknisi profesional di dealer resmi, spesialis kendaraan listrik, hingga wirausahawan bengkel mandiri.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <footer class="footer-info">
            <p>&copy; <?php echo date('Y'); ?> SMK Riyadhul Ulum Ujung Batu. All Rights Reserved.</p>
        </footer>
    </div>

</body>
</html>