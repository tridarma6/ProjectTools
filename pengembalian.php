<?php

    $host       = "127.0.0.1:3308";
    $username   = "root";
    $password   = "";
    $db         = "db_camera";

    $connection = new mysqli($host, $username, $password, $db);
    if($connection->connect_error){
        die("Koneksi gagal").$connection->connect_error;
    }else{
        echo "Koneksi Berhasil";
    }

    $id_pengembalian            = 0;
    $id_transaksi               = 0;
    $tanggal_pengembalian       = "";
    $denda                      = 0;

    $query = "SELECT * FROM tb_pengembalian";
    $result = $connection->query($query);

    foreach($result as $row){
        $id_pengembalian            = $row['id_pengembalian'];
        $id_transaksi               = $row['id_transaksi'];
        $tanggal_pengembalian       = $row['tanggal_pengembalian'];
        $denda                      = $row['denda'];
    }

?>