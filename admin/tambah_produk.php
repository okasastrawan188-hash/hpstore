<?php
session_start();
require "../autoload.php";

use App\Models\Produk;

// ===============================
// PROTEKSI ADMIN
// ===============================
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit;
}

$produkModel = new Produk();

// ===============================
// PROSES SIMPAN
// ===============================
if(isset($_POST['simpan'])){

    $nama  = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok  = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];

    $gambar = $_FILES['gambar']['name'];
    $tmp    = $_FILES['gambar']['tmp_name'];

    $namaBaru = time() . "_" . $gambar;

    move_uploaded_file($tmp, "../uploads/" . $namaBaru);

    $produkModel->tambah($nama, $harga, $stok, $namaBaru);

    echo "<script>
            alert('Produk berhasil ditambahkan!');
            window.location='data_produk.php';
          </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Tambah Produk</title>

<style>

body{
    margin:0;
    font-family:Arial, sans-serif;
    background: linear-gradient(135deg,#1e3c72,#2a5298,#00c6ff);
}

/* CARD FORM */
.container{
    width:100%;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.card{
    background:white;
    padding:40px;
    width:400px;
    border-radius:16px;
    box-shadow:0 15px 30px rgba(0,0,0,0.2);
}

.card h2{
    text-align:center;
    margin-bottom:20px;
}

/* INPUT */
.card input,
.card textarea{
    width:100%;
    padding:10px;
    margin-bottom:15px;
    border-radius:8px;
    border:1px solid #ccc;
    font-size:14px;
}

.card input:focus,
.card textarea:focus{
    border:1px solid #1e3c72;
    outline:none;
}

/* BUTTON */
.btn{
    width:100%;
    padding:12px;
    background:#1e3c72;
    color:white;
    border:none;
    border-radius:8px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

.btn:hover{
    background:#00c6ff;
}

/* BACK */
.back{
    text-align:center;
    margin-top:15px;
}

.back a{
    text-decoration:none;
    color:#1e3c72;
    font-weight:bold;
}

.back a:hover{
    color:#00c6ff;
}

</style>

</head>
<body>

<div class="container">

<div class="card">

<h2>➕ Tambah Produk</h2>

<form method="POST" enctype="multipart/form-data">

<input type="text" name="nama" placeholder="Nama Produk" required>

<input type="number" name="harga" placeholder="Harga" required>

<input type="number" name="stok" placeholder="Stok" required>

<textarea name="deskripsi" placeholder="Deskripsi"></textarea>

<input type="file" name="gambar" required>

<button type="submit" name="simpan" class="btn">
Simpan Produk
</button>

</form>

<div class="back">
<a href="dashboard.php">← Kembali</a>
</div>

</div>

</div>

</body>
</html>