<?php
session_start();
require "../autoload.php";

use App\Models\Produk;

// =========================
// PROTEKSI ADMIN
// =========================
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit;
}

$produkModel = new Produk();
$produk = $produkModel->getAll();
?>

<!DOCTYPE html>
<html>
<head>
<title>Data Produk</title>

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

/* BUTTON */
.btn{
    text-decoration:none;
    background:#1e3c72;
    color:white;
    padding:8px 15px;
    border-radius:6px;
    font-size:14px;
    transition:0.3s;
}

.btn:hover{
    background:#00c6ff;
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

/* ACTION BUTTON */
.action-btn{
    padding:6px 10px;
    border-radius:6px;
    text-decoration:none;
    color:white;
    font-size:13px;
}

.edit{
    background:#28a745;
}

.delete{
    background:#dc3545;
}

/* FOTO */
.product-img{
    width:70px;
    height:70px;
    object-fit:cover;
    border-radius:10px;
    box-shadow:0 3px 6px rgba(0,0,0,0.2);
}

</style>

</head>
<body>

<div class="container">

<div class="header">
<h2>📦 Data Produk</h2>

<br>

<a href="tambah_produk.php" class="btn">
➕ Tambah Produk
</a>

</div>

<?php if(empty($produk)){ ?>

<p style="color:white; text-align:center;">
⚠ Belum ada produk
</p>

<?php } else { ?>

<div class="table-box">

<table>

<tr>
<th>No</th>
<th>Foto</th>
<th>Nama</th>
<th>Harga</th>
<th>Stok</th>
<th>Aksi</th>
</tr>

<?php
$no = 1;
foreach($produk as $data){
?>

<tr>
<td><?php echo $no++; ?></td>

<!-- FOTO -->
<td>
<?php
if(!empty($data['gambar']) && file_exists("../uploads/".$data['gambar'])){
?>
<img src="../uploads/<?php echo $data['gambar']; ?>" 
class="product-img">
<?php } else { ?>
<span style="color:red;">Tidak Ada Foto</span>
<?php } ?>
</td>

<td><?php echo $data['nama']; ?></td>

<td>Rp <?php echo number_format($data['harga']); ?></td>

<td><?php echo $data['stok']; ?></td>

<td>

<a href="edit_produk.php?id=<?php echo $data['id']; ?>" 
class="action-btn edit">
Edit
</a>

<a href="hapus_produk.php?id=<?php echo $data['id']; ?>" 
onclick="return confirm('Yakin hapus produk?')" 
class="action-btn delete">
Hapus
</a>

</td>
</tr>

<?php } ?>

</table>

</div>

<?php } ?>

<br>

<div style="text-align:center;">
<a href="dashboard.php" class="btn">⬅ Kembali</a>
</div>

</div>

</body>
</html>