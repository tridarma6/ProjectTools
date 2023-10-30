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

    $id_det_transaksi       = 0;
    $id_transaksi           = 0;
    $id_camera              = 0;
    $jumlah_hari_sewa       = 0;
    $harga_sewa             = 0;

    $query = "SELECT * FROM tb_det_transaksi";
    $result = $connection->query($query);

    foreach($result as $row){
        $id_det_transaksi       =  $row['id_det_transaksi'];
        $id_transaksi           =  $row['id_transaksi'];
        $id_camera              =  $row['id_camera'];
        $jumlah_hari_sewa       =  $row['jumlah_hari_sewa'];
        $harga_sewa             =  $row['harga_sewa'];
    }

?>