<?php
session_start();

/*
==================================================
PROTEKSI ADMIN
==================================================
*/
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit;
}

/*
==================================================
LOAD FILE
==================================================
*/
require __DIR__ . "/../dompdf/autoload.inc.php";
require __DIR__ . "/../autoload.php";

use Dompdf\Dompdf;
use App\Models\Transaksi;

$transaksiModel = new Transaksi();

/* ==================================================
   JIKA BELUM PILIH FILTER → TAMPILKAN FORM
================================================== */
if(!isset($_POST['filter'])){

?>

<!DOCTYPE html>
<html>
<head>
<title>Pilih Filter Laporan</title>

<style>
body{
    font-family:Arial;
    background:#f4f6fb;
    text-align:center;
    padding-top:100px;
}

.box{
    background:white;
    width:350px;
    margin:auto;
    padding:30px;
    border-radius:16px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

select, button{
    width:100%;
    padding:12px;
    margin-top:15px;
    border-radius:8px;
    border:1px solid #ddd;
}

button{
    background:#1e3c72;
    color:white;
    font-weight:bold;
    cursor:pointer;
}

button:hover{
    background:#00c6ff;
}

</style>

</head>
<body>

<div class="box">

<h3>📊 Pilih Periode Laporan</h3>

<form method="POST">
    <select name="periode" required>
        <option value="">-- Pilih --</option>
        <option value="hari">Hari Ini</option>
        <option value="minggu">Minggu Ini</option>
        <option value="bulan">Bulan Ini</option>
        <option value="tahun">Tahun Ini</option>
    </select>

    <button type="submit" name="filter">
        Generate PDF
    </button>
</form>

</div>

</body>
</html>

<?php
exit;
}

/*
==================================================
AMBIL DATA SESUAI FILTER
==================================================
*/

$periode = $_POST['periode'];

$query = "SELECT t.*, u.nama 
          FROM transaksi t
          LEFT JOIN users u ON t.user_id = u.id
          WHERE 1=1 ";

if($periode == "hari"){
    $query .= " AND DATE(t.tanggal) = CURDATE()";
}
elseif($periode == "minggu"){
    $query .= " AND YEARWEEK(t.tanggal, 1) = YEARWEEK(CURDATE(), 1)";
}
elseif($periode == "bulan"){
    $query .= " AND MONTH(t.tanggal) = MONTH(CURDATE())
                AND YEAR(t.tanggal) = YEAR(CURDATE())";
}
elseif($periode == "tahun"){
    $query .= " AND YEAR(t.tanggal) = YEAR(CURDATE())";
}

$db = (new \App\Core\Database())->getConnection();
$result = $db->query($query);

$totalPendapatan = 0;

/*
==================================================
BUAT HTML PDF
==================================================
*/

$html = "
<h2 style='text-align:center;'>LAPORAN TRANSAKSI</h2>
<p style='text-align:center;'>Periode: <b>$periode</b></p>

<table border='1' width='100%' cellpadding='8' cellspacing='0'>
<tr style='background:#ddd;'>
<th>ID</th>
<th>Nama Pembeli</th>
<th>Tanggal</th>
<th>Total</th>
<th>Status</th>
</tr>
";

while($row = $result->fetch_assoc()){

$totalPendapatan += $row['total'];

$nama = $row['nama'] ?? '-';
$status = !empty($row['status']) ? $row['status'] : 'pending';

$html .= "
<tr>
<td>{$row['id']}</td>
<td>{$nama}</td>
<td>{$row['tanggal']}</td>
<td>Rp ".number_format($row['total'])."</td>
<td>{$status}</td>
</tr>
";
}

$html .= "
</table>

<br>
<h3>Total Pendapatan: Rp ".number_format($totalPendapatan)."</h3>
";

/*
==================================================
GENERATE PDF
==================================================
*/

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper("A4","portrait");
$dompdf->render();
$dompdf->stream("laporan_".$periode.".pdf",[
    "Attachment"=>false
]);

exit;