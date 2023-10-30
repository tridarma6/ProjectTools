<?php

    $host       = "127.0.0.1:3306";
    $username   = "root";
    $password   = "";
    $db         = "db_camera";

    $connection = new mysqli($host, $username, $password, $db);
    if($connection->connect_error){
        die("Koneksi gagal").$connection->connect_error;
    }else{
        echo "Koneksi Berhasil";
    }

    $id_transaksi           = 0;
    $id_customer            = 0;
    $id_pegawai             = 0;
    $tanggal_pemesanan      = "";
    $tanggal_mulai_sewa     = "";
    $tanggal_akhir_sewa     = "";
    $total_harga            = 0;

    $query = "SELECT * FROM tb_transaksi";
    $result = $connection->query($query);

    foreach($result as $row){
        $id_transaksi           = $row['id_transaksi'];
        $id_customer            = $row['id_customer'];
        $id_pegawai             = $row['id_pegawai'];
        $tanggal_pemesanan      = $row['tanggal_pemesanan'];
        $tanggal_mulai_sewa     = $row['tanggal_mulai_sewa'];
        $tanggal_akhir_sewa     = $row['tanggal_akhir_sewa'];
        $total_harga            = $row['total_harga'];
    }

?>