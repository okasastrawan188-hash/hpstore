<?php
session_start();
require "autoload.php";
?>

<!DOCTYPE html>
<html>
<head>
<title>HP Store - Home</title>

<style>

/* =========================
   BODY BACKGROUND GAMBAR HP
========================= */
body{
    margin:0;
    font-family:Arial, sans-serif;

    /* BACKGROUND GAMBAR + OVERLAY */
    background:
        linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)),
        url("https://images.unsplash.com/photo-1511707171634-5f897ff02aa9");

    background-size:cover;
    background-position:center;
    background-attachment:fixed;
    color:white;
}

/* ================= NAVBAR ================= */
.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:20px 8%;
    background:rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
}

.logo{
    font-size:22px;
    font-weight:bold;
    color:#ff6b6b;
}

.menu a{
    text-decoration:none;
    margin-left:20px;
    color:white;
    font-weight:500;
    transition:0.3s;
}

.menu a:hover{
    color:#ff6b6b;
}

/* ================= HERO ================= */
.hero{
    text-align:center;
    padding:150px 20px;
}

.hero h1{
    font-size:50px;
    margin-bottom:15px;
}

.hero p{
    font-size:20px;
    margin-bottom:35px;
    opacity:0.9;
}

/* BUTTON */
.btn{
    text-decoration:none;
    background:#ff6b6b;
    color:white;
    padding:14px 30px;
    border-radius:30px;
    font-weight:bold;
    transition:0.3s;
    box-shadow:0 8px 20px rgba(255,107,107,0.5);
}

.btn:hover{
    background:#ff4757;
    transform:translateY(-3px);
}

/* ================= FEATURE CARD ================= */
.features{
    display:flex;
    justify-content:center;
    gap:30px;
    flex-wrap:wrap;
    padding:50px 8%;
}

.card{
    background:rgba(255,255,255,0.15);
    backdrop-filter: blur(10px);
    padding:30px;
    width:250px;
    border-radius:16px;
    text-align:center;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-8px);
    background:rgba(255,255,255,0.25);
}

.card h3{
    color:#ff6b6b;
}

.card p{
    font-size:14px;
    opacity:0.9;
}

/* FOOTER */
.footer{
    text-align:center;
    padding:30px;
    margin-top:40px;
    background:rgba(0,0,0,0.4);
    backdrop-filter: blur(10px);
    color:#ddd;
}

</style>

</head>
<body>

<!-- ================= NAVBAR ================= -->
<div class="navbar">
    <div class="logo">🛍 HP Store</div>

    <div class="menu">
        <a href="index.php">Home</a>
        <a href="produk.php">Produk</a>

        <?php if(isset($_SESSION['user_id'])){ ?>
            <a href="logout.php">Logout</a>
        <?php } else { ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php } ?>
    </div>
</div>

<!-- ================= HERO SECTION ================= -->
<div class="hero">
    <h1>Belanja HP Impian Kamu 🚀</h1>
    <p>Harga terbaik • Produk original • Pengiriman cepat</p>

    <?php if(!isset($_SESSION['user_id'])){ ?>
        <a href="register.php" class="btn">
            Mulai Belanja
        </a>
    <?php } else { ?>
        <a href="produk.php" class="btn">
            Lihat Produk
        </a>
    <?php } ?>
</div>

<!-- ================= FEATURE SECTION ================= -->
<div class="features">

    <div class="card">
        <h3>🔥 Promo</h3>
        <p>Diskon setiap minggu untuk produk pilihan</p>
    </div>

    <div class="card">
        <h3>🚚 Pengiriman</h3>
        <p>Pengiriman cepat ke seluruh Indonesia</p>
    </div>

    <div class="card">
        <h3>⭐ Terpercaya</h3>
        <p>Ribuan pelanggan sudah berbelanja</p>
    </div>

</div>

<div class="footer">
    © 2026 HP Store - All Rights Reserved
</div>

</body>
</html>