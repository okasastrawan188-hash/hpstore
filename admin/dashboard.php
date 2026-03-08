<?php
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit;
}

require "../autoload.php";
use App\Core\Database;

/* ===============================
   KONEKSI DATABASE
================================*/
$database = new Database();
$db = $database->getConnection();

/* ===============================
   AMBIL DATA GRAFIK
================================*/
$result = $db->query("
    SELECT MONTH(tanggal) as bulan,
           SUM(total) as total_bulanan
    FROM transaksi
    GROUP BY MONTH(tanggal)
    ORDER BY MONTH(tanggal)
");

$bulan = [];
$total = [];

if($result){
    while($row = $result->fetch_assoc()){
        $bulan[] = "Bulan ".$row['bulan'];
        $total[] = (int)$row['total_bulanan'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard Admin</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

body{
    margin:0;
    font-family:Arial, sans-serif;
    background: linear-gradient(135deg,#1e3c72,#2a5298,#00c6ff);
    background-attachment: fixed;
}

/* ================= PROFILE ================= */

.profile-box{
    position:absolute;
    top:20px;
    left:20px;
    background:rgba(255,255,255,0.2);
    backdrop-filter:blur(10px);
    padding:12px 18px;
    border-radius:12px;
    color:white;
    font-size:14px;
    font-weight:bold;
}

/* ================= HEADER ================= */

.header{
    color:white;
    text-align:center;
    padding:30px;
    font-size:24px;
    font-weight:bold;
}

/* ================= CARD ================= */

.container{
    width:90%;
    margin:40px auto;
    display:flex;
    gap:25px;
    flex-wrap:wrap;
    justify-content:center;
}

.card{
    background:rgba(255,255,255,0.2);
    backdrop-filter:blur(15px);
    padding:30px;
    width:250px;
    text-align:center;
    border-radius:16px;
    color:white;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-8px);
    background:rgba(255,255,255,0.3);
}

.card a{
    text-decoration:none;
    background:white;
    color:#1e3c72;
    padding:10px 15px;
    border-radius:8px;
    display:inline-block;
    margin-top:15px;
    font-weight:bold;
    transition:0.3s;
}

.card a:hover{
    background:#00c6ff;
    color:white;
}

/* ================= GRAFIK ================= */

.grafik-box{
    width:90%;
    margin:50px auto;
    background:white;
    padding:30px;
    border-radius:16px;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}

.grafik-box h3{
    text-align:center;
    margin-bottom:20px;
}

/* ================= LOGOUT ================= */

.logout{
    text-align:center;
    margin-bottom:40px;
}

.logout a{
    text-decoration:none;
    background:#ff4b5c;
    color:white;
    padding:12px 25px;
    border-radius:8px;
    font-weight:bold;
}

.logout a:hover{
    background:#c70039;
}

</style>
</head>
<body>

<!-- ================= PROFILE ADMIN ================= -->
<div class="profile-box">
👑 Admin :
<?php echo $_SESSION['nama'] ?? 'Admin'; ?>
</div>

<div class="header">
Dashboard Admin
</div>

<!-- ================= CARD MENU ================= -->

<div class="container">

<div class="card">
<h3>Produk</h3>
<p>Kelola data produk</p>
<a href="tambah_produk.php">Tambah</a>
<br>
<a href="data_produk.php">Lihat</a>
</div>

<div class="card">
<h3>Transaksi</h3>
<p>Kelola transaksi & status</p>
<a href="transaksi.php">Data</a>
</div>

<div class="card">
<h3>Laporan</h3>
<p>Export laporan PDF</p>
<a href="export_pdf.php">Export</a>
</div>

</div>

<!-- ================= GRAFIK ================= -->

<div class="grafik-box">
<h3>📊 Grafik Total Transaksi Per Bulan</h3>

<canvas id="chartTransaksi"></canvas>
</div>

<script>

const bulan = <?= json_encode($bulan); ?>;
const total = <?= json_encode($total); ?>;

const ctx = document.getElementById('chartTransaksi');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: bulan.length ? bulan : ["Belum Ada Data"],
        datasets: [{
            label: 'Total Transaksi',
            data: total.length ? total : [0],
            backgroundColor: '#1e3c72',
            borderRadius: 8
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

</script>

<div class="logout">
<a href="../logout.php">Logout</a>
</div>

</body>
</html>