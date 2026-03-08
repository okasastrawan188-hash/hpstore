<?php

session_start();
require "../autoload.php";

use App\Models\Transaksi;

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit;
}

$transaksiModel = new Transaksi();

$mulai = $_GET['mulai'] ?? '';
$akhir = $_GET['akhir'] ?? '';

$query = "SELECT * FROM transaksi WHERE 1";

if($mulai && $akhir){
    $query .= " AND tanggal BETWEEN '$mulai' AND '$akhir'";
}

$result = $transaksiModel->getByUser(1); // sementara

?>

<h2>Laporan Transaksi</h2>

<form method="GET">
    Mulai: <input type="date" name="mulai">
    Sampai: <input type="date" name="akhir">
    <button type="submit">Filter</button>
</form>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Tanggal</th>
    <th>Total</th>
    <th>Status</th>
</tr>

<?php
$all = $transaksiModel->getByUser($_SESSION['user_id']);

while($row = $all->fetch_assoc()){
?>

<tr>
    <td><?= $row['id']; ?></td>
    <td><?= $row['tanggal']; ?></td>
    <td>Rp <?= number_format($row['total']); ?></td>
    <td><?= $row['status']; ?></td>
</tr>

<?php } ?>

</table>