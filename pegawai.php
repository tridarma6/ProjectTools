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

    $id_pegawai    = 0;
    $nama_pegawai  = "";
    $email         = "";
    $alamat        = "";
    $nomor_telepon = "";

    $query = "SELECT * FROM tb_transaksi";
    $result = $connection->query($query);

    foreach($result as $row){
        $id_pegawai    = $row['id_pegawai'];
        $nama_pegawai  = $row['nama_pegawai'];
        $email         = $row['email'];
        $alamat        = $row['alamat'];
        $nomor_telepon = $row['nomor_telepon'];

    }

?>