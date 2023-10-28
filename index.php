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

    $id_customer    = 0;
    $name           = "";
    $alamat         = "";

    $query = "SELECT * FROM customer";
    $result = $connection->query($query);

    foreach($result as $row){
        $id_customer = $row['id_customer'];
        $name        = $row['name'];
        $alamat      = $row['alamat'];
        echo "<br>".$id_customer." ".$name." ".$alamat;
        echo "Testing";
    }

?>