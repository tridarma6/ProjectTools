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

    $error                  = "";
    $sukses                 = "";
    $nama_customer          = "";
    $email                  = "";
    $alamat                 = "";
    $nomor_telepon          = "";

    if(isset($_GET['op'])){
        $op = $_GET['op'];
    }else{
        $op = "";
    }

    if($op == 'delete'){
        $id_customer          = $_GET['id_customer'];
        $sql                  = "DELETE FROM tb_customer WHERE id_customer = '$id_customer'";
        $q1                   = mysqli_query($connection,$sql);
        if ($connection->query($sql) === TRUE) {
            $sukses = "Data berhasil dihapus";
        } else {
            $error = "Data gagal dihapus";
        }
    }

    if ($op == 'edit') {
                
        // Validasi id_customer dan pastikan itu adalah bilangan bulat positif
        $id_customer = isset($_GET['id_customer']) ? intval($_GET['id_customer']) : 0;

        if ($id_customer <= 0) {
            // Handle invalid or missing id_customer parameter
            echo "Invalid or missing id_customer parameter.";
        } else {
            // Lakukan koneksi ke database (pastikan variabel $connection sudah terdefinisi)


            $sql4           = " SELECT * FROM tb_customer WHERE id_customer = '$id_customer'";
            $q4 = mysqli_query($connection, $sql4);

            // Periksa apakah ada kesalahan eksekusi SQL
            if (!$q4) {
                echo "Error: " . mysqli_error($connection);
                // Handle the SQL error appropriately
            } else {
                // Periksa apakah ada hasil dari query
                if (mysqli_num_rows($q4) > 0) {
                    // Ambil data dari hasil query
                    $row = mysqli_fetch_array($q4);
                    $id_customer = $row['id_customer'];
                    $nama_customer = $row['nama_customer'];
                    $email = $row['email'];
                    $alamat = $row['alamat'];
                    $nomor_telepon = $row['nomor_telepon'];

                    // Lakukan operasi lainnya dengan data yang telah diambil
                } else {
                    // Handle the case when no matching record is found
                    echo "No matching record found for id_customer: $id_customer";
                }
            }
        }


    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama_customer         = $_POST['nama_customer'];
        $email                 = $_POST['email'];
        $alamat                = $_POST['alamat'];
        $nomor_telepon         = $_POST['nomor_telepon'];
        
        if($op == 'edit'){
            $sql            = " UPDATE tb_customer 
                                SET nama_customer = '$nama_customer', email = '$email', alamat = '$alamat', nomor_telepon = '$nomor_telepon';
                                WHERE id_customer = '$id_customer'";

            if ($connection->query($sql) === TRUE) {
                $sukses     = "Data baru berhasil di-update";
            } else {
                $error      = "Data baru gagal di-update";
            }
        }else{
            $sql            = "INSERT INTO tb_customer (nama_customer, email, alamat, nomor_telepon)
                                VALUES ('$nama_customer', '$email', '$alamat', '$nomor_telepon')";
            if ($connection->query($sql) === TRUE) {
                $sukses     = "Data baru berhasil ditambahkan";
            } else {
                $error      = "Data baru gagal ditambahkan";
            }
        }
    }

    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUSTOMER</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">
    <style>
        body {
            background-image: url('img/bg-cam2.jpg');
            background-size: cover;
            font-family: 'Lora', serif;
        }
        .header{
            position: fixed;
            width: 100%;
            top: 0;
            background-image: url('img/bg-cam2.jpg');
            background-size: cover;
            padding: 15px; 
            z-index: 1000;
        }
        .nav{
            padding-right: 15px;
        }
        .mx-auto{
            width: 1100px;   
        }
        .card{
            margin-top:10px;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
            background-color: black;
            color: white;
        }
        
        form {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
        }
        
        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="header d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom fs-5">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
        <span class="fs-2 text-white">CUSTOMER</span>
        </a>
    
        <ul class="nav nav-pills align-items-center">
            <li class="nav-item dropdown">
                <a class="nav-link active bg-black dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Tables Data
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item text-black" href="camera.php">Table Camera</a></li>
                    <li><a class="dropdown-item text-black" href="customer.php">Table Customer</a></li>
                    <li><a class="dropdown-item text-black" href="det_transaksi.php">Table Detail Transaksi</a></li>
                    <li><a class="dropdown-item text-black" href="pegawai.php">Table Pegawai</a></li>
                    <li><a class="dropdown-item text-black" href="pengembalian.php">Table Pengembalian</a></li>
                    <li><a class="dropdown-item text-black" href="transaksi.php">Table Transaksi</a></li>
                </ul>
            </li>
        </ul>
        
    </div>
    <br><br><br><br>
    
    <div class="mx-auto">
        <div class="card">
            <div class="card-header">
                CREATE / EDIT DATA
            </div>
            <div class="card-body">
            <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                        <a href="customer.php">Back</a>
                    </div>
                <?php
                    
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                        <a href="customer.php">Back</a>
                    </div>
                <?php
                    
                }
                ?>
                <form action="" method="post">
                    
                    <div class="mb-3 row">
                        <label for="nama_customer" class="col-sm-2 col-form-label">Nama Customer</label>
                        <div class="col-sm-10">
                            <input type="text" name="nama_customer" id="nama_customer" value="<?php echo $nama_customer ?>" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" name="email" id="email" value="<?php echo $email ?>" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" name="alamat" id="alamat" value="<?php echo $alamat ?>" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nomor_telepon" class="col-sm-2 col-form-label">Nomor Telepon</label>
                        <div class="col-sm-10">
                            <input type="text" name="nomor_telepon" id="nomor_telepon" value="<?php echo $nomor_telepon ?>" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" value="Simpan Data" name="simpan" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header text-white bg-secondary">
                DATA CUSTOMER
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID Customer</th>
                            <th scope="col">Nama Customer</th>
                            <th scope="col">Email</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Nomor Telepon</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php 
                            $sql2   = "SELECT * FROM tb_customer";
                            $result = $connection->query($sql2);
                            if($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    $id_customer            = $row['id_customer'];
                                    $nama_customer          = $row['nama_customer'];
                                    $email                  = $row['email'];
                                    $alamat                 = $row['alamat'];
                                    $nomor_telepon          = $row['nomor_telepon'];
                                    ?>
                                    <tr>
                                        <td scope="row"><?php echo $id_customer ?></td>
                                        <td scope="row"><?php echo $nama_customer ?></td>
                                        <td scope="row"><?php echo $email ?></td>
                                        <td scope="row"><?php echo $alamat ?></td>
                                        <td scope="row"><?php echo $nomor_telepon ?></td>
                                        <td scope="row">
                                            <a href="customer.php?op=edit&id_customer=<?php echo $id_customer ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                            <a href="customer.php?op=delete&id_customer=<?php echo $id_customer?>&id_customer=<?php echo $id_customer?>" onclick="return confirm('Apakah anda yakin ingin menghapus data?')"><button type="button" class="btn btn-danger">Delete</button></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>