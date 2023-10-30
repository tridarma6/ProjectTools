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

    $id_customer   = 0;
    $nama_customer = "";
    $alamat        = "";
    $email         = "";
    $nomor_telepon = "";

    $query = "SELECT * FROM tb_transaksi";
    $result = $connection->query($query);

    foreach($result as $row){
        $id_customer   = $row['id_customer'];
        $nama_customer = $row['nama_customer'];
        $alamat        = $row['alamat'];
        $email         = $row['email'];
        $nomor_telepon = $row['nomor_telepon'];
        
    }

?>