<?php

namespace App\Models;

use App\Core\BaseModel;

class Transaksi extends BaseModel
{

    public function buatTransaksi($user_id, $total)
    {
        $user_id = intval($user_id);
        $total   = intval($total);

        $this->db->query("
            INSERT INTO transaksi (user_id, total)
            VALUES ($user_id, $total)
        ");

        return $this->db->insert_id;
    }

    public function simpanDetail($transaksi_id, $produk_id, $jumlah, $harga)
    {
        $transaksi_id = intval($transaksi_id);
        $produk_id    = intval($produk_id);
        $jumlah       = intval($jumlah);
        $harga        = intval($harga);

        $this->db->query("
            INSERT INTO detail_transaksi
            (transaksi_id, produk_id, jumlah, harga)
            VALUES
            ($transaksi_id, $produk_id, $jumlah, $harga)
        ");
    }

    public function getByUser($user_id)
    {
        $user_id = intval($user_id);

        return $this->db->query("
            SELECT * FROM transaksi
            WHERE user_id = $user_id
            ORDER BY id DESC
        ");
    }

    public function getDetail($transaksi_id)
    {
        $transaksi_id = intval($transaksi_id);

        return $this->db->query("
            SELECT d.*, p.nama
            FROM detail_transaksi d
            JOIN produk p ON d.produk_id = p.id
            WHERE d.transaksi_id = $transaksi_id
        ");
    }

    public function updateStatus($id, $status)
    {
        $id = intval($id);
        $status = $this->db->real_escape_string($status);

        $this->db->query("
            UPDATE transaksi
            SET status = '$status'
            WHERE id = $id
        ");
    }

    public function hapus($transaksi_id)
    {
        $transaksi_id = intval($transaksi_id);

        $this->db->query("
            DELETE FROM detail_transaksi
            WHERE transaksi_id = $transaksi_id
        ");

        $this->db->query("
            DELETE FROM transaksi
            WHERE id = $transaksi_id
        ");
    }

    public function getAll()
    {
        $query = $this->db->query("
            SELECT t.*, u.nama
            FROM transaksi t
            LEFT JOIN users u ON t.user_id = u.id
            ORDER BY t.id DESC
        ");

        $data = [];

        while($row = $query->fetch_assoc()){
            $data[] = $row;
        }

        return $data;
    }

}