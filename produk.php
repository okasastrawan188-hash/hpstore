<?php
session_start();
require "autoload.php";

use App\Models\Produk;

/* ===============================
   PROTEKSI LOGIN
================================*/
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$produkModel = new Produk();
$dataProduk  = $produkModel->getAll();
?>

<!DOCTYPE html>
<html>
<head>
<title>Produk - HP Store</title>

<style>

/* =============================
   BODY STYLE (NYAMBUNG HOME)
============================= */
body{
    margin:0;
    font-family:Arial, sans-serif;

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
    padding:20px 8%;
    background:rgba(255,255,255,0.1);
    backdrop-filter:blur(10px);
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.navbar a{
    color:white;
    text-decoration:none;
    margin-left:20px;
    font-weight:bold;
    transition:0.3s;
}

.navbar a:hover{
    color:#ff6b6b;
}

/* ================= TITLE ================= */
h2{
    text-align:center;
    margin-top:50px;
    font-size:32px;
}

/* ================= GRID ================= */
.container{
    width:90%;
    margin:40px auto;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:30px;
}

/* ================= CARD ================= */
.card{
    background:rgba(255,255,255,0.15);
    backdrop-filter:blur(10px);
    padding:20px;
    border-radius:16px;
    text-align:center;
    box-shadow:0 10px 25px rgba(0,0,0,0.3);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-8px);
    background:rgba(255,255,255,0.25);
}

/* ===== Gambar Lebih Presisi & Center ===== */
.card .img-box{
    width:100%;
    height:220px;
    background:white;
    border-radius:14px;
    display:flex;
    justify-content:center;
    align-items:center;
    overflow:hidden;
}

.card .img-box img{
    max-width:100%;
    max-height:100%;
    object-fit:contain;
    cursor:pointer;
    transition:0.3s;
}

.card .img-box img:hover{
    transform:scale(1.05);
}

/* ================= TEXT ================= */
.card h3{
    margin:15px 0 10px;
    color:white;              /* ✔ tidak merah lagi */
    font-size:18px;
    font-weight:bold;
}

.card p{
    margin:5px 0;
}

/* ================= BUTTON ================= */
.card a{
    display:inline-block;
    margin-top:15px;
    text-decoration:none;
    background:#ff6b6b;
    color:white;
    padding:10px 20px;
    border-radius:25px;
    font-weight:bold;
    transition:0.3s;
}

.card a:hover{
    background:#ff4757;
    transform:scale(1.05);
}

/* ================= LIGHTBOX ================= */
#lightbox{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.85);
    justify-content:center;
    align-items:center;
    z-index:999;
}

#lightbox img{
    max-width:80%;
    max-height:80%;
    border-radius:15px;
    animation:zoomIn 0.3s ease;
}

@keyframes zoomIn{
    from{
        transform:scale(0.5);
        opacity:0;
    }
    to{
        transform:scale(1);
        opacity:1;
    }
}

</style>

</head>
<body>

<!-- ================= NAVBAR ================= -->
<div class="navbar">
    <div><b>🛍 HP Store</b></div>

    <div>
        <a href="index.php">Home</a>
        <a href="produk.php">Produk</a>
        <a href="keranjang.php">Keranjang</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<h2>🔥 Produk Terbaru</h2>

<div class="container">

<?php
if($dataProduk){
while($data = $dataProduk->fetch_assoc()){

    $gambar = (!empty($data['gambar']))
        ? "uploads/".$data['gambar']
        : "https://via.placeholder.com/400x300";
?>

<div class="card">

    <!-- Gambar Bisa Diklik -->
    <div class="img-box">
    <img src="<?php echo $gambar; ?>" 
         class="product-img">
</div>

    <h3><?php echo htmlspecialchars($data['nama']); ?></h3>

    <p>💰 Rp <?php echo number_format($data['harga']); ?></p>

    <p>📦 Stok: <?php echo $data['stok']; ?></p>

    <?php if($data['stok'] > 0){ ?>
        <a href="keranjang.php?id=<?php echo $data['id']; ?>">
            ➕ Tambah ke Keranjang
        </a>
    <?php } else { ?>
        <p style="color:red;font-weight:bold;">
            ❌ Stok Habis
        </p>
    <?php } ?>

</div>

<?php
}
}
?>

</div>

<!-- ================= LIGHTBOX POPUP ================= -->
<div id="lightbox">
    <img id="lightbox-img">
</div>

<script>

/* ===== BUKA GAMBAR FULL ===== */
document.querySelectorAll(".product-img").forEach(img => {

    img.addEventListener("click", function(){
        document.getElementById("lightbox").style.display = "flex";
        document.getElementById("lightbox-img").src = this.src;
    });

});

/* ===== TUTUP KETIKA KLIK AREA HITAM ===== */
document.getElementById("lightbox").addEventListener("click", function(){
    this.style.display = "none";
});

</script>

</body>
</html>