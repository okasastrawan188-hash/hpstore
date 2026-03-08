<?php

session_start();

require "../autoload.php";

use App\Models\Produk;

// =============================
// PROTEKSI ADMIN
// =============================
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit;
}

$produkModel = new Produk();

if(isset($_GET['id'])){

    $id = $_GET['id'];

    $produkModel->hapus($id);

    echo "<script>
            alert('Produk berhasil dihapus!');
            window.location='data_produk.php';
          </script>";
    exit;
}

?>