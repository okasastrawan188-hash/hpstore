<?php
session_start();
require "../autoload.php";

use App\Models\Transaksi;

/* =========================
   PROTEKSI ADMIN
========================= */
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit;
}

if(isset($_GET['id']) && isset($_GET['status'])){

    $id = $_GET['id'];
    $status = $_GET['status'];

    $model = new Transaksi();
    $model->updateStatus($id, $status);

    header("Location: transaksi.php");
    exit;
}
?>