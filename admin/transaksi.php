<?php
session_start();
require "../autoload.php";

use App\Models\Transaksi;

// =============================
// PROTEKSI ADMIN
// =============================
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit;
}

$transaksiModel = new Transaksi();
$transaksis = $transaksiModel->getAll();
?>

<!DOCTYPE html>
<html>
<head>
<title>Data Transaksi</title>

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

/* TABLE BOX */
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
    padding:6px 12px;
    border-radius:6px;
    font-size:13px;
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
<h2>📦 Data Transaksi</h2>
</div>

<div class="table-box">

<?php if(empty($transaksis)){ ?>

<p style="text-align:center; color:red;">
⚠ Belum ada transaksi
</p>

<?php } else { ?>

<table>

<tr>
<th>No</th>
<th>ID</th>
<th>Nama Pembeli</th>
<th>Tanggal</th>
<th>Total</th>
<th>Status</th>
<th>Aksi</th>
</tr>

<?php
$no = 1;
foreach($transaksis as $data){
?>

<tr>
<td><?php echo $no++; ?></td>
<td><?php echo $data['id']; ?></td>

<td>
<?php echo $data['nama'] ?? 'Tidak Diketahui'; ?>
</td>

<td><?php echo $data['tanggal']; ?></td>

<td>
Rp <?php echo number_format($data['total']); ?>
</td>

<td>

<?php if($data['status'] == 'pending'){ ?>

<a href="update_status.php?id=<?php echo $data['id']; ?>&status=diproses"
   style="background:orange; color:white; padding:6px 10px; border-radius:6px; text-decoration:none;">
   Pending ➜ Klik Ubah
</a>

<?php } else { ?>

<a href="update_status.php?id=<?php echo $data['id']; ?>&status=selesai"
   style="background:green; color:white; padding:6px 10px; border-radius:6px; text-decoration:none;">
   <?php echo ucfirst($data['status']); ?>
</a>

<?php } ?>

</td>

<td>
<a href="detail_transaksi.php?id=<?php echo $data['id']; ?>" 
class="btn">
Detail
</a>
</td>

</tr>

<?php } ?>

</table>

<?php } ?>

</div>

<div class="back">
<a href="dashboard.php">⬅ Kembali</a>
</div>

</div>

</body>
</html>