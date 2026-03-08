<?php
session_start();
require "autoload.php";

use App\Models\User;

$error = "";

if(isset($_POST['login'])){

    $userModel = new User();
    $data = $userModel->login($_POST['email'], $_POST['password']);

    if($data){

        $_SESSION['user_id'] = $data['id'];
        $_SESSION['nama']    = $data['nama'];
        $_SESSION['role']    = $data['role'];

        session_regenerate_id(true);

        if($data['role'] == 'admin'){
            header("Location: admin/dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit;

    } else {
        $error = "Email atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login Customer</title>

<style>

/* ================= BODY ================= */
body{
    margin:0;
    font-family:Arial, sans-serif;
    background: #f4f6fb;  /* 🔥 warna soft customer */
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

/* ================= CARD LOGIN ================= */
.login-box{
    background:white;
    width:360px;
    padding:40px;
    border-radius:20px;
    box-shadow:0 15px 35px rgba(0,0,0,0.08);
    text-align:center;
    animation:fadeIn 0.6s ease;
}

/* Animasi masuk */
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

/* ================= TITLE ================= */
.login-box h2{
    color:#1e3c72;
    margin-bottom:25px;
}

/* ================= INPUT ================= */
.login-box input{
    width:100%;
    padding:12px;
    margin:10px 0;
    border-radius:12px;
    border:1px solid #ddd;
    font-size:14px;
    transition:0.3s;
}

.login-box input:focus{
    border-color:#00c6ff;
    outline:none;
    box-shadow:0 0 8px rgba(0,198,255,0.3);
}

/* ================= BUTTON ================= */
.btn{
    width:100%;
    padding:12px;
    border:none;
    border-radius:12px;
    background:linear-gradient(135deg,#1e3c72,#00c6ff);
    color:white;
    font-size:15px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

.btn:hover{
    transform:scale(1.05);
}

/* ================= LINK ================= */
.login-box a{
    text-decoration:none;
    color:#1e3c72;
    font-weight:bold;
}

.login-box a:hover{
    color:#00c6ff;
}

/* ERROR */
.error{
    color:red;
    margin-bottom:10px;
    font-size:14px;
}

</style>

</head>
<body>

<div class="login-box">

<h2>👋 Login Customer</h2>

<?php if($error != ""){ ?>
<p class="error"><?php echo $error; ?></p>
<?php } ?>

<form method="POST">

<input type="email" name="email" placeholder="Masukkan Email" required>

<input type="password" name="password" placeholder="Masukkan Password" required>

<button type="submit" name="login" class="btn">
Masuk
</button>

</form>

<br>
<p>Belum punya akun?</p>
<a href="register.php">Daftar Sekarang</a>

</div>

</body>
</html>