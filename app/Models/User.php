<?php

namespace App\Models;

use App\Core\BaseModel;

class User extends BaseModel
{

    public function login($email, $password)
    {
        $email = $this->db->real_escape_string($email);
        $password = md5($password);

        $query = $this->db->query("
            SELECT * FROM users
            WHERE email='$email'
            AND password='$password'
        ");

        return $query->fetch_assoc();
    }

    public function register($nama, $email, $password)
    {
        $nama = $this->db->real_escape_string($nama);
        $email = $this->db->real_escape_string($email);
        $password = md5($password);

        return $this->db->query("
            INSERT INTO users (nama,email,password,role)
            VALUES ('$nama','$email','$password','customer')
        ");
    }

}