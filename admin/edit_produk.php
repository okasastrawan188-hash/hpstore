<?php
session_start();

require "../autoload.php";

use App\Models\Produk;

/* =============================
   PROTEKSI ADMIN
============================= */
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit;
}

$produkModel = new Produk();

$id = $_GET['id'];
$data = $produkModel->getById($id);

/* =============================
   PROSES UPDATE
============================= */
if(isset($_POST['update'])){

    $nama  = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok  = $_POST['stok'];

    $produkModel->update($id, $nama, $harga, $stok);

    echo "<script>
            alert('Produk berhasil diupdate!');
            window.location='data_produk.php';
          </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Produk</title>

<style>

/* ================= BODY ================= */
body{
    margin:0;
    font-family:Arial, sans-serif;
    background: linear-gradient(135deg,#1e3c72,#2a5298,#00c6ff);
}

/* ================= CONTAINER ================= */
.container{
    width:400px;
    margin:80px auto;
}

/* ================= CARD ================= */
.card{
    background:white;
    padding:30px;
    border-radius:16px;
    box-shadow:0 15px 35px rgba(0,0,0,0.2);
    text-align:center;
    animation:fadeIn 0.5s ease;
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

/* ================= INPUT ================= */
.card input{
    width:100%;
    padding:12px;
    margin:10px 0;
    border-radius:8px;
    border:1px solid #ddd;
    transition:0.3s;
}

.card input:focus{
    border-color:#1e3c72;
    outline:none;
    box-shadow:0 0 8px rgba(30,60,114,0.3);
}

/* ================= BUTTON ================= */
.btn{
    width:100%;
    padding:12px;
    border:none;
    border-radius:8px;
    background:#1e3c72;
    color:white;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

.btn:hover{
    background:#00c6ff;
    transform:scale(1.05);
}

/* BACK BUTTON */
.back{
    display:inline-block;
    margin-top:15px;
    text-decoration:none;
    color:#1e3c72;
    font-weight:bold;
}

.back:hover{
    color:#00c6ff;
}

</style>

</head>
<body>

<div class="container">

<div class="card">

<h2>✏ Edit Produk</h2>

<form method="POST">

<input type="text" name="nama"
value="<?= htmlspecialchars($data['nama']); ?>"
required>

<input type="number" name="harga"
value="<?= $data['harga']; ?>"
required>

<input type="number" name="stok"
value="<?= $data['stok']; ?>"
required>

<button type="submit" name="update" class="btn">
Update Produk
</button>

</form>

<a href="data_produk.php" class="back">
⬅ Kembali
</a>

</div>

</div>

</body>
</html>