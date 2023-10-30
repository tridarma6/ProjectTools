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

    $id_camera            = 0;
    $nama_camera          = "";
    $harga_sewa_harian    = 0;
    $deskripsi            = "";

    $query = "SELECT * FROM tb_camera";
    $result = $connection->query($query);

    foreach($result as $row){
        $id_camera            = $row['id_camera'];
        $nama_camera          = $row['nama_camera'];
        $harga_sewa_harian    = $row['harga_sewa_harian'];
        $deskripsi            = $row['deskripsi'];

        echo "<br>".$id_camera." ".$nama_camera." ".$harga_sewa_harian." ".$deskripsi."<br>";
        echo "<br>".$id_camera." ".$nama_camera." ".$harga_sewa_harian." ".$deskripsi."<br>";
    }
?>