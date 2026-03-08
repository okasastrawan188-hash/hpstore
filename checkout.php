<?php
session_start();

require "autoload.php";

use App\Models\Transaksi;
use App\Models\Produk;

/* ============================
   PROTEKSI
============================ */
if(empty($_SESSION['keranjang'])){
    header("Location: produk.php");
    exit;
}

$transaksiModel = new Transaksi();
$produkModel     = new Produk();

$total = 0;

/* ============================
   HITUNG TOTAL
============================ */
foreach($_SESSION['keranjang'] as $id => $jumlah){

    $data = $produkModel->getById($id);
    if(!$data) continue;

    $subtotal = $data['harga'] * $jumlah;
    $total += $subtotal;
}

/* ============================
   BUAT TRANSAKSI
============================ */
$id_transaksi = $transaksiModel->buatTransaksi(
    $_SESSION['user_id'],
    $total
);

/* ============================
   SIMPAN DETAIL + UPDATE STOK
============================ */
foreach($_SESSION['keranjang'] as $id => $jumlah){

    $data = $produkModel->getById($id);
    if(!$data) continue;

    $transaksiModel->simpanDetail(
        $id_transaksi,
        $id,
        $jumlah,
        $data['harga']
    );

    // Kurangi stok
    $produkModel->update(
        $id,
        $data['nama'],
        $data['harga'],
        $data['stok'] - $jumlah
    );
}

/* ============================
   KOSONGKAN KERANJANG
============================ */
unset($_SESSION['keranjang']);
?>

<!DOCTYPE html>
<html>
<head>
<title>Checkout Berhasil</title>

<style>

/* ================= BODY ================= */
body{
    margin:0;
    font-family:Arial, sans-serif;
    background:#f4f6fb;
}

/* ================= CONTAINER ================= */
.container{
    width:90%;
    max-width:600px;
    margin:80px auto;
}

/* ================= CARD ================= */
.card{
    background:white;
    padding:40px;
    border-radius:20px;
    box-shadow:0 15px 40px rgba(0,0,0,0.08);
    text-align:center;
    animation:fadeIn 0.6s ease;
}

/* Animasi */
@keyframes fadeIn{
    from{
        opacity:0;
        transform:translateY(20px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* ================= TEXT ================= */
.card h2{
    color:#1e3c72;
    margin-bottom:20px;
}

.card p{
    font-size:18px;
    margin:10px 0;
}

/* ================= BUTTON ================= */
.btn{
    display:inline-block;
    margin-top:20px;
    text-decoration:none;
    background:#1e3c72;
    color:white;
    padding:12px 25px;
    border-radius:10px;
    font-weight:bold;
    transition:0.3s;
}

.btn:hover{
    background:#00c6ff;
    transform:scale(1.05);
}

</style>

</head>
<body>

<div class="container">

<div class="card">

<h2>✅ Checkout Berhasil</h2>

<p>🎉 Pesanan kamu sudah berhasil dibuat!</p>

<p><b>ID Transaksi :</b> <?php echo $id_transaksi; ?></p>

<p><b>Total Pembayaran :</b> 
Rp <?php echo number_format($total); ?>
</p>

<a href="produk.php" class="btn">
🛍 Kembali Belanja
</a>

</div>

</div>

</body>
</html>