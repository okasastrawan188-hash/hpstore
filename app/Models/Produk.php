<?php

namespace App\Models;

use App\Core\BaseModel;
use App\Core\ModelInterface;

class Produk extends BaseModel implements ModelInterface
{

    // ==========================
    // AMBIL SEMUA PRODUK
    // ==========================
    public function getAll()
    {
        return $this->db->query("SELECT * FROM produk");
    }

    // ==========================
    // AMBIL PRODUK BERDASARKAN ID
    // ==========================
    public function getById($id)
    {
        $id = intval($id);
        $query = $this->db->query("SELECT * FROM produk WHERE id=$id");
        return $query->fetch_assoc();
    }

    // ==========================
    // TAMBAH PRODUK
    // ==========================
    public function tambah($nama, $harga, $stok, $gambar)
    {
        $nama  = $this->db->real_escape_string($nama);
        $harga = intval($harga);
        $stok  = intval($stok);

        return $this->db->query("
            INSERT INTO produk (nama, harga, stok, gambar)
            VALUES ('$nama', '$harga', '$stok', '$gambar')
        ");
    }

    // ==========================
    // UPDATE PRODUK
    // ==========================
    public function update($id, $nama, $harga, $stok)
    {
        $id    = intval($id);
        $nama  = $this->db->real_escape_string($nama);
        $harga = intval($harga);
        $stok  = intval($stok);

        return $this->db->query("
            UPDATE produk
            SET nama='$nama',
                harga='$harga',
                stok='$stok'
            WHERE id=$id
        ");
    }

    // ==========================
    // HAPUS PRODUK
    // ==========================
    public function hapus($id)
    {
        $id = intval($id);
        return $this->db->query("DELETE FROM produk WHERE id=$id");
    }
}