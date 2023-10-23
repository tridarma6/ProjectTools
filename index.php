<?php

    $host       = "127.0.0.1:3308";
    $username   = "root";
    $password   = "";
    $db         = "toolti";
    
    $connection = new mysqli($host, $username, $password, $db);
    if($connection->connect_error){
        die("Koneksi gagal").$connection->connect_error;
    }else{
        echo "Koneksi Berhasil";
    }
?>