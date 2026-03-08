<?php
session_start();

/* ✅ PROTEKSI LOGIN */
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

require "autoload.php";

use App\Core\Database;

/* ==============================
   KONEKSI DATABASE
============================== */
$database = new Database();
$conn = $database->getConnection();

/* ========================
   TAMBAH PRODUK
======================== */
if(isset($_GET['id'])){
    $id = $_GET['id'];

    if(!isset($_SESSION['keranjang'])){
        $_SESSION['keranjang'] = [];
    }

    $_SESSION['keranjang'][$id] = 
        ($_SESSION['keranjang'][$id] ?? 0) + 1;

    header("Location: keranjang.php");
    exit;
}

/* ========================
   KURANGI JUMLAH
======================== */
if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];

    if(isset($_SESSION['keranjang'][$id])){
        $_SESSION['keranjang'][$id]--;

        if($_SESSION['keranjang'][$id] <= 0){
            unset($_SESSION['keranjang'][$id]);
        }
    }

    header("Location: keranjang.php");
    exit;
}

/* ========================
   HAPUS SEMUA PRODUK
======================== */
if(isset($_GET['hapus_semua'])){
    $id = $_GET['hapus_semua'];
    unset($_SESSION['keranjang'][$id]);

    header("Location: keranjang.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Keranjang Belanja</title>

<style>

/* ================= BODY ================= */
body{
    margin:0;
    font-family:Arial, sans-serif;
    background:#f4f6fb;
    color:#333;
}

/* ================= TITLE ================= */
h2{
    text-align:center;
    margin-top:40px;
}

/* ================= CONTAINER ================= */
.container{
    width:90%;
    margin:40px auto;
    display:flex;
    flex-direction:column;
    gap:20px;
}

/* ================= CARD ================= */
.card{
    background:white;
    padding:20px;
    border-radius:16px;
    box-shadow:0 8px 20px rgba(0,0,0,0.05);
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

/* ================= INFO ================= */
.info h3{
    margin:0;
    color:#1e3c72;
}

.info p{
    margin:5px 0;
}

/* ================= BUTTON ================= */
.btn{
    text-decoration:none;
    padding:8px 15px;
    border-radius:8px;
    font-size:13px;
    font-weight:bold;
    color:white;
    background:#1e3c72;
    margin:5px;
    transition:0.3s;
}

.btn:hover{
    background:#00c6ff;
}

/* ================= TOTAL ================= */
.total{
    text-align:center;
    font-size:20px;
    font-weight:bold;
    margin-top:20px;
}

/* ================= EMPTY ================= */
.empty{
    text-align:center;
    color:#888;
    font-size:18px;
}

</style>

</head>
<body>

<h2>🛒 Keranjang Belanja</h2>

<div class="container">

<?php
$total = 0;

if(!empty($_SESSION['keranjang'])){

foreach($_SESSION['keranjang'] as $id => $jumlah){

    $query = mysqli_query($conn, "SELECT * FROM produk WHERE id='$id'");
    $data = mysqli_fetch_assoc($query);

    if(!$data) continue;

    $subtotal = $data['harga'] * $jumlah;
    $total += $subtotal;
?>

<div class="card">

    <div class="info">
        <h3><?php echo $data['nama']; ?></h3>
        <p>Harga: Rp <?php echo number_format($data['harga']); ?></p>
        <p>Jumlah: <?php echo $jumlah; ?></p>
        <p><b>Subtotal: Rp <?php echo number_format($subtotal); ?></b></p>
    </div>

    <div>
        <a href="keranjang.php?hapus=<?php echo $id; ?>" class="btn">
            - 1
        </a>

        <a href="keranjang.php?id=<?php echo $id; ?>" class="btn">
            + 1
        </a>

        <a href="keranjang.php?hapus_semua=<?php echo $id; ?>" 
           class="btn" 
           style="background:red;"
           onclick="return confirm('Hapus semua produk ini?')">
            Hapus
        </a>
    </div>

</div>

<?php
}
} else {
    echo "<p class='empty'>Keranjang masih kosong 🛍</p>";
}
?>

</div>

<div class="total">
Total: Rp <?php echo number_format($total); ?>
</div>

<?php if(!empty($_SESSION['keranjang'])){ ?>
<div style="text-align:center; margin-top:20px;">
    <a href="checkout.php" class="btn">
        ✅ Checkout Sekarang
    </a>
</div>
<?php } ?>

<div style="text-align:center; margin-top:20px;">
    <a href="produk.php" class="btn" style="background:#555;">
        ⬅ Kembali Belanja
    </a>
</div>

</body>
</html>