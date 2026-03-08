<?php
namespace App\Core;

use mysqli;

class Database
{
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db   = "hpstore";

    protected $conn;

    public function __construct()
    {
        $this->conn = new mysqli(
            $this->host,
            $this->user,
            $this->pass,
            $this->db
        );

        if ($this->conn->connect_error) {
            die("Koneksi database gagal");
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
}