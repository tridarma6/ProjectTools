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
    $nama_camera            = "";
    $deskripsi              = "";
    $error                  = "";
    $sukses                 = "";

    if(isset($_GET['op'])){
        $op = $_GET['op'];
    }else{
        $op = "";
    }

    if($op == 'delete'){
        $id_camera            = $_GET['id_camera'];
        $nama_camera          = $_GET['nama_camera'];
        $deskripsi            = $_GET['deskripsi'];
        $sql                  = "DELETE FROM tb_camera WHERE id_camera = '$id_camera'";

        $q1                   = mysqli_query($connection,$sql);
        if ($connection->query($sql) === TRUE) {
            $sukses = "Data berhasil dihapus";
        } else {
            $error = "Data gagal dihapus";
        }
    }

    if ($op == 'edit') {
                
        // Validasi id_camera dan pastikan itu adalah bilangan bulat positif
        $id_camera = isset($_GET['id_camera']) ? intval($_GET['id_camera']) : 0;

        if ($id_camera <= 0) {
            // Handle invalid or missing id_camera parameter
            echo "Invalid or missing id_camera parameter.";
        } else {
            // Lakukan koneksi ke database (pastikan variabel $connection sudah terdefinisi)


            $sql4           = " SELECT * FROM tb_camera WHERE id_camera = '$id_camera'";

            $q4 = mysqli_query($connection, $sql4);

            // Periksa apakah ada kesalahan eksekusi SQL
            if (!$q4) {
                echo "Error: " . mysqli_error($connection);
                // Handle the SQL error appropriately
            } else {
                // Periksa apakah ada hasil dari query
                if (mysqli_num_rows($q4) > 0) {
                    // Ambil data dari hasil query
                    $row               = mysqli_fetch_array($q4);
                    $nama_camera       = $row['nama_camera'];
                    $harga_sewa_harian = $row['harga_sewa_harian'];
                    $deskripsi         = $row['deskripsi'];

                    // Lakukan operasi lainnya dengan data yang telah diambil
                } else {
                    // Handle the case when no matching record is found
                    echo "No matching record found for id_det_transaksi: $id_camera";
                }
            }
        }


    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama_camera          = $_POST['nama_camera'];
        $harga_sewa_harian    = $_POST['harga_sewa_harian'];
        $deskripsi            = $_POST['deskripsi'];
        
        if($op == 'edit'){
            $sql            = " UPDATE tb_camera
                                SET nama_camera = '$nama_camera', harga_sewa_harian = '$harga_sewa_harian', deskripsi = '$deskripsi' 
                                WHERE id_camera = '$id_camera'";

            if ($connection->query($sql) === TRUE) {
                $sukses     = "Data baru berhasil di-update";
            } else {
                $error      = "Data baru gagal di-update";
            }
        }else{
            $sql            = "INSERT INTO tb_camera (nama_camera, harga_sewa_harian, deskripsi) 
                                VALUES ('$nama_camera', '$harga_sewa_harian', '$deskripsi')";

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
    <title>CAMERA</title>
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
        <span class="fs-2 text-white">CAMERA</span>
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
                        <a href="camera.php">Back</a>
                    </div>
                <?php
                    
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                        <a href="camera.php">Back</a>
                    </div>
                <?php
                    
                }
                ?>
                <form action="" method="post">
                    
                    <div class="mb-3 row">
                        <label for="nama_camera" class="col-sm-2 col-form-label">Nama Camera</label>
                        <div class="col-sm-10">
                            <input type="text" name="nama_camera" id="nama_camera" value="<?php echo $nama_camera ?>" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="harga_sewa_harian" class="col-sm-2 col-form-label">Harga Sewa Harian</label>
                        <div class="col-sm-10">
                            <input type="number" name="harga_sewa_harian" id="harga_sewa_harian" value="<?php echo $harga_sewa_harian ?>" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                        <div class="col-sm-10">
                            <input type="text" name="deskripsi" id="deskripsi" value="<?php echo $deskripsi ?>" required>
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
                DATA CAMERA
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID Camera</th>
                            <th scope="col">Nama Camera</th>
                            <th scope="col">Harga Sewa Harian</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php 
                            $sql2   = "SELECT * FROM tb_camera";
                            $result = $connection->query($sql2);
                            if($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    $id_camera     = $row['id_camera'];
                                    $nama_camera         = $row['nama_camera'];
                                    $harga_sewa_harian            = $row['harga_sewa_harian'];
                                    $deskripsi     = $row['deskripsi'];

                                    ?>
                                    <tr>
                                        <td scope="row"><?php echo $id_camera ?></td>
                                        <td scope="row"><?php echo $nama_camera ?></td>
                                        <td scope="row"><?php echo $harga_sewa_harian ?></td>
                                        <td scope="row"><?php echo $deskripsi ?></td>
                                        <td scope="row">
                                            <a href="camera.php?op=edit&id_camera=<?php echo $id_camera ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                            <a href="camera.php?op=delete&id_camera=<?php echo $id_camera?>&id_camera=<?php echo $id_camera?>" onclick="return confirm('Apakah anda yakin ingin menghapus data?')"><button type="button" class="btn btn-danger">Delete</button></a>
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