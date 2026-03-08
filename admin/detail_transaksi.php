<?php
session_start();
require "../autoload.php";

use App\Models\Transaksi;

// ================= PROTEKSI ADMIN =================
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit;
}

// ================= CEK ID =================
if(!isset($_GET['id'])){
    header("Location: transaksi.php");
    exit;
}

$transaksi_id = intval($_GET['id']);

$transaksiModel = new Transaksi();
$details = $transaksiModel->getDetail($transaksi_id);

$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
<title>Detail Transaksi</title>

<style>

body{
    margin:0;
    font-family:Arial, sans-serif;
    background: linear-gradient(135deg,#1e3c72,#2a5298,#00c6ff);
}

/* CONTAINER */
.container{
    width:90%;
    margin:40px auto;
}

/* HEADER */
.header{
    text-align:center;
    color:white;
    margin-bottom:30px;
}

/* CARD TABLE */
.table-box{
    background:white;
    padding:20px;
    border-radius:16px;
    box-shadow:0 10px 30px rgba(0,0,0,0.2);
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#1e3c72;
    color:white;
    padding:12px;
}

table td{
    padding:10px;
    text-align:center;
    border-bottom:1px solid #ddd;
}

table tr:hover{
    background:#f2f2f2;
}

/* BUTTON */
.btn{
    text-decoration:none;
    background:#1e3c72;
    color:white;
    padding:8px 15px;
    border-radius:6px;
    transition:0.3s;
}

.btn:hover{
    background:#00c6ff;
}

/* BACK */
.back{
    text-align:center;
    margin-top:20px;
}

.back a{
    text-decoration:none;
    background:red;
    color:white;
    padding:10px 20px;
    border-radius:8px;
}

.back a:hover{
    background:darkred;
}

</style>

</head>
<body>

<div class="container">

<div class="header">
<h2>📦 Detail Transaksi #<?php echo $transaksi_id; ?></h2>
</div>

<div class="table-box">

<?php if(empty($details)){ ?>

<p style="text-align:center; color:red;">
⚠ Tidak ada detail transaksi.
</p>

<?php } else { ?>

<table>

<tr>
<th>No</th>
<th>Nama Produk</th>
<th>Harga</th>
<th>Jumlah</th>
<th>Subtotal</th>
</tr>

<?php
$no = 1;
foreach($details as $item){

    $subtotal = $item['harga'] * $item['jumlah'];
    $total += $subtotal;
?>

<tr>
<td><?php echo $no++; ?></td>
<td><?php echo $item['nama']; ?></td>
<td>Rp <?php echo number_format($item['harga']); ?></td>
<td><?php echo $item['jumlah']; ?></td>
<td>Rp <?php echo number_format($subtotal); ?></td>
</tr>

<?php } ?>

<tr style="font-weight:bold;">
<td colspan="4" align="right">Total</td>
<td>Rp <?php echo number_format($total); ?></td>
</tr>

</table>

<?php } ?>

</div>

<div class="back">
<a href="transaksi.php">⬅ Kembali</a>
</div>

</div>

</body>
</html>