<?php

require "autoload.php";

use App\Models\User;

if(isset($_POST['register'])){

    $userModel = new User();

    $hasil = $userModel->register(
        $_POST['nama'],
        $_POST['email'],
        $_POST['password']
    );

    if($hasil){
        echo "<script>
                alert('Register berhasil!');
                window.location='login.php';
              </script>";
    } else {
        echo "<script>alert('Register gagal!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register Customer</title>

<style>

/* ================= BODY ================= */
body{
    margin:0;
    font-family:Arial, sans-serif;
    background:#f4f6fb; /* 🔥 sama seperti login */
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

/* ================= CARD ================= */
.register-box{
    background:white;
    padding:40px;
    width:360px;
    border-radius:20px;
    box-shadow:0 15px 35px rgba(0,0,0,0.08);
    text-align:center;
    animation:fadeIn 0.6s ease;
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

/* ================= TITLE ================= */
.register-box h2{
    color:#1e3c72;
    margin-bottom:25px;
}

/* ================= INPUT ================= */
.register-box input{
    width:100%;
    padding:12px;
    margin:10px 0;
    border-radius:12px;
    border:1px solid #ddd;
    font-size:14px;
    transition:0.3s;
}

.register-box input:focus{
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
.register-box a{
    text-decoration:none;
    color:#1e3c72;
    font-weight:bold;
}

.register-box a:hover{
    color:#00c6ff;
}

</style>

</head>
<body>

<div class="register-box">

<h2>📝 Register Customer</h2>

<form method="POST">

<input type="text" name="nama" placeholder="Masukkan Nama" required>

<input type="email" name="email" placeholder="Masukkan Email" required>

<input type="password" name="password" placeholder="Masukkan Password" required>

<button type="submit" name="register" class="btn">
Daftar
</button>

</form>

<br>
<p>Sudah punya akun?</p>
<a href="login.php">Login Sekarang</a>

</div>

</body>
</html>