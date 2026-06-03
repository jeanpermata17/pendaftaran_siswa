<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang | SMK Riyadlul 'Ulum</title>
    <style>
        /* 1. IMPORT FONTS & RESET STYLE */
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* 2. BASE LAYOUT & BACKGROUND */
        body {
            /* Ditambahkan linear-gradient (overlay hitam transparan 60%) agar teks putih mudah dibaca */
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                        url('https://ppdb.riyul.com/imeg/1.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #ffffff;
            overflow: hidden;
            padding: 20px;
        }

        /* 3. CONTENCT CONTAINER */
        .welcome-container {
            text-align: center;
            max-width: 800px;
            padding: 40px 20px;
            animation: softFadeIn 1.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* 4. TYPOGRAPHY */
        .tagline {
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: #27ae60; /* Hijau yang lebih teduh & gelap */
            margin-bottom: 24px;
        }

        h1 {
            font-size: 4rem;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -1.5px;
            margin-bottom: 48px;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.6);
            text-transform: capitalize;
        }

        /* 5. BUTTONS & INTERACTION */
        .btn-enter {
            display: inline-block;
            background-color: #27ae60; /* Hijau utama yang lebih gelap */
            color: #ffffff; 
            text-decoration: none;
            padding: 18px 48px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            box-shadow: 0 4px 25px rgba(39, 174, 96, 0.3);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .btn-enter:hover {
            background-color: #1e8449; /* Hijau saat di-hover (lebih gelap lagi) */
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(39, 174, 96, 0.5);
        }

        .btn-enter:active {
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(39, 174, 96, 0.4);
        }

        /* 6. ANIMATIONS */
        @keyframes softFadeIn {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* 7. RESPONSIVE DESIGN (MOBILE FRIENDLY) */
        @media (max-width: 768px) {
            h1 {
                font-size: 2.6rem;
                letter-spacing: -0.5px;
                margin-bottom: 36px;
            }
            .tagline {
                font-size: 0.85rem;
                letter-spacing: 3px;
                margin-bottom: 16px;
            }
            .btn-enter {
                padding: 16px 38px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>

    <div class="welcome-container">
        <div class="tagline">Website Pendaftaran</div>
        <h1>Selamat Datang di SMK Riyadlul 'Ulum</h1>
        <a href="dashbord.php" class="btn-enter">Klik di Sini untuk Masuk</a>
    </div>

</body>
</html>