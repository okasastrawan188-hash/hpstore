<?php

session_start();
require "../autoload.php";

use App\Models\Transaksi;

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit;
}

$transaksiModel = new Transaksi();

// Update status
if(isset($_POST['update_status'])){
    $transaksiModel->updateStatus($_POST['id'], $_POST['status']);
}

$data = $transaksiModel->getByUser($_SESSION['user_id']);
?>

<h2>Kelola Transaksi</h2>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Total</th>
    <th>Status</th>
    <th>Ubah Status</th>
</tr>

<?php
$query = $transaksiModel->getByUser($_SESSION['user_id']);

while($row = $query->fetch_assoc()){
?>

<tr>
    <td><?= $row['id']; ?></td>
    <td>Rp <?= number_format($row['total']); ?></td>
    <td><?= $row['status']; ?></td>

    <td>
        <form method="POST">
            <input type="hidden" name="id" value="<?= $row['id']; ?>">

            <select name="status">
                <option>Pending</option>
                <option>Diproses</option>
                <option>Dikirim</option>
                <option>Selesai</option>
            </select>

            <button type="submit" name="update_status">
                Update
            </button>
        </form>
    </td>

</tr>

<?php } ?>

</table>