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

    // $id_transaksi           = 0;
    // $id_customer            = 0;
    // $id_pegawai             = 0;
    // $tanggal_pemesanan      = "";
    // $tanggal_mulai_sewa     = "";
    // $tanggal_akhir_sewa     = "";
    // $total_harga            = 0;
    $error                  = "";
    $sukses                 = "";

    if(isset($_GET['op'])){
        $op = $_GET['op'];
    }else{
        $op = "";
    }

    if($op == 'delete'){
        $id_transaksi         = $_GET['id_transaksi'];
        $sql                  = "DELETE FROM tb_transaksi WHERE id_transaksi = '$id_transaksi'";
        $q1                   = mysqli_query($connection,$sql);
        if ($connection->query($sql) === TRUE) {
            $sukses = "Data berhasil dihapus";
        } else {
            $error = "Data gagal dihapus";
        }
    }

    if ($op == 'edit') {
        // Validasi id_det_transaksi dan pastikan itu adalah bilangan bulat positif
        $id_transaksi = isset($_GET['id_transaksi']) ? intval($_GET['id_transaksi']) : 0;

        if ($id_transaksi <= 0) {
            // Handle invalid or missing id_det_transaksi parameter
            echo "Invalid or missing id_transaksi parameter.";
        } else {
            // Lakukan koneksi ke database (pastikan variabel $connection sudah terdefinisi)
            $sql1           = " UPDATE tb_det_transaksi
                                JOIN tb_transaksi ON tb_det_transaksi.`id_transaksi` = tb_transaksi.`id_transaksi`
                                SET tb_det_transaksi.`jumlah_hari_sewa` = DATEDIFF(tb_transaksi.`tanggal_akhir_sewa`, tb_transaksi.`tanggal_mulai_sewa`)"; 

            $sql2           = " UPDATE tb_det_transaksi
                                JOIN tb_camera ON tb_det_transaksi.`id_camera` = tb_camera.`id_camera`
                                SET tb_det_transaksi.`harga_sewa` = tb_camera.`harga_sewa_harian` * tb_det_transaksi.`jumlah_hari_sewa`";

            $sql3           = " UPDATE tb_transaksi
                                SET total_harga = (
                                SELECT SUM(harga_sewa)
                                FROM tb_det_transaksi
                                WHERE tb_det_transaksi.`id_transaksi` = tb_transaksi.`id_transaksi`
                                );";
            
            $sql4           = " SELECT * FROM tb_transaksi WHERE id_transaksi = '$id_transaksi'";
            $q1 = mysqli_query($connection, $sql1);
            $q2 = mysqli_query($connection, $sql2);
            $q3 = mysqli_query($connection, $sql3);
            $q4 = mysqli_query($connection, $sql4);


            // Periksa apakah ada kesalahan eksekusi SQL
            if (!$q1 && !$q2 && !$q3 && !$q4) {
                echo "Error: " . mysqli_error($connection);
                // Handle the SQL error appropriately
            } else {
                // Periksa apakah ada hasil dari query
                if (mysqli_num_rows($q4) > 0) {
                    // Ambil data dari hasil query
                    $row = mysqli_fetch_array($q4);
                    $id_customer          = $row['id_customer'];
                    $id_pegawai           = $row['id_pegawai'];
                    $tanggal_pemesanan    = $row['tanggal_pemesanan'];
                    $tanggal_mulai_sewa   = $row['tanggal_mulai_sewa'];
                    $tanggal_akhir_sewa   = $row['tanggal_akhir_sewa'];
                    $total_harga          = $row['total_harga'];

                    // Lakukan operasi lainnya dengan data yang telah diambil
                } else {
                    // Handle the case when no matching record is found
                    echo "No matching record found for id_det_transaksi: $id_transaksi";
                }
            }
        }
        // $id_transaksi         = $_GET['id_transaksi'];
        // $sql1                 = "SELECT * FROM tb_transaksi WHERE id = '$id_transaksi'";
        // $q1                   = mysqli_query($connection, $sql1);
        // $row                  = mysqli_fetch_array($q1);
        // $id_transaksi         = $row['id_transaksi'];
        

    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_customer            = $_POST['id_customer'];
        $id_pegawai             = $_POST['id_pegawai'];
        $tanggal_pemesanan      = $_POST['tanggal_pemesanan'];
        $tanggal_mulai_sewa     = $_POST['tanggal_mulai_sewa'];
        $tanggal_akhir_sewa     = $_POST['tanggal_akhir_sewa'];
        
        if($op == 'edit'){
            $sql            = " UPDATE tb_transaksi 
                                SET id_customer = '$id_customer', id_pegawai = '$id_pegawai', tanggal_pemesanan = '$tanggal_pemesanan', tanggal_mulai_sewa = '$tanggal_mulai_sewa', tanggal_akhir_sewa = '$tanggal_akhir_sewa' 
                                WHERE id_transaksi = '$id_transaksi';";

            $sql2           = " UPDATE tb_det_transaksi
                                JOIN tb_camera ON tb_det_transaksi.`id_camera` = tb_camera.`id_camera`
                                SET tb_det_transaksi.`harga_sewa` = tb_camera.`harga_sewa_harian` * tb_det_transaksi.`jumlah_hari_sewa`";

            $sql3           = " UPDATE tb_transaksi
                                SET total_harga = (
                                SELECT SUM(harga_sewa)
                                FROM tb_det_transaksi
                                WHERE tb_det_transaksi.`id_transaksi` = tb_transaksi.`id_transaksi`
                                );";
            $q1 = $connection->query($sql);
            $q2 = $connection->query($sql2);
            $q3 = $connection->query($sql3);
            if (!$q1 && !$q2 && !$q3) {
                $error      = "Data baru gagal di-update";
            } else {
                // Periksa apakah ada hasil dari query
                if (mysqli_num_rows($q4) > 0) {
                    // Ambil data dari hasil query
                    $row = mysqli_fetch_array($q4);
                    $id_customer          = $row['id_customer'];
                    $id_pegawai           = $row['id_pegawai'];
                    $tanggal_pemesanan    = $row['tanggal_pemesanan'];
                    $tanggal_mulai_sewa   = $row['tanggal_mulai_sewa'];
                    $tanggal_akhir_sewa   = $row['tanggal_akhir_sewa'];
                    $total_harga          = $row['total_harga'];

                    // Lakukan operasi lainnya dengan data yang telah diambil
                } else {
                    // Handle the case when no matching record is found
                    echo "No matching record found for id_det_transaksi: $id_transaksi";
                }
                $sukses     = "Data baru berhasil di-update";
            }
        }else{
            $sql            = " INSERT INTO tb_transaksi (id_customer, id_pegawai, tanggal_pemesanan, tanggal_mulai_sewa, tanggal_akhir_sewa) 
                                VALUES ('$id_customer', '$id_pegawai', '$tanggal_pemesanan', '$tanggal_mulai_sewa', '$tanggal_akhir_sewa');";

            $sql2           = " UPDATE tb_det_transaksi
                                JOIN tb_camera ON tb_det_transaksi.`id_camera` = tb_camera.`id_camera`
                                SET tb_det_transaksi.`harga_sewa` = tb_camera.`harga_sewa_harian` * tb_det_transaksi.`jumlah_hari_sewa`";

            $sql3           = " UPDATE tb_transaksi
                                SET total_harga = (
                                SELECT SUM(harga_sewa)
                                FROM tb_det_transaksi
                                WHERE tb_det_transaksi.`id_transaksi` = tb_transaksi.`id_transaksi`
                                );";
            $q1 = $connection->query($sql);
            $q2 = $connection->query($sql2);
            $q3 = $connection->query($sql3);
            if (!$q1 && !$q2 && !$q3) {
                $error      = "Data baru gagal ditambahkan";
            } else {
                 // Periksa apakah ada hasil dari query
                if (mysqli_num_rows($q4) > 0) {
                    // Ambil data dari hasil query
                    $row = mysqli_fetch_array($q4);
                    $id_customer          = $row['id_customer'];
                    $id_pegawai           = $row['id_pegawai'];
                    $tanggal_pemesanan    = $row['tanggal_pemesanan'];
                    $tanggal_mulai_sewa   = $row['tanggal_mulai_sewa'];
                    $tanggal_akhir_sewa   = $row['tanggal_akhir_sewa'];
                    $total_harga          = $row['total_harga'];

                    // Lakukan operasi lainnya dengan data yang telah diambil
                } else {
                    // Handle the case when no matching record is found
                    echo "No matching record found for id_det_transaksi: $id_transaksi";
                }
                $sukses     = "Data baru berhasil ditambahkan";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRANSAKSI</title>
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
        <span class="fs-2 text-white">TRANSAKSI</span>
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
                        <a href="transaksi.php">Back</a>
                    </div>
                <?php
                    
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                        <a href="transaksi.php">Back</a>
                    </div>
                <?php
                    
                }
                ?>
                <form action="" method="post">
                    <div class="mb-3 row">
                        <label for="id_customer" class="col-sm-2 col-form-label">ID Customer</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="id_customer" name="id_customer" value="<?php echo $id_customer ?>" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="id_pegawai" class="col-sm-2 col-form-label">ID Pegawai</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="id_pegawai" name="id_pegawai" value="<?php echo $id_pegawai ?>" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tanggal_pemesanan" class="col-sm-2 col-form-label">Tanggal Pemesanan</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="tanggal_pemesanan" name="tanggal_pemesanan" value="<?php echo $tanggal_pemesanan ?>" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tanggal_mulai_sewa" class="col-sm-2 col-form-label">Mulai Sewa</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="tanggal_mulai_sewa" name="tanggal_mulai_sewa" value="<?php echo $tanggal_mulai_sewa ?>" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tanggal_akhir_sewa" class="col-sm-2 col-form-label">Akhir Sewa</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="tanggal_akhir_sewa" name="tanggal_akhir_sewa" value="<?php echo $tanggal_akhir_sewa ?>" required>
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
                DATA TRANSAKSI
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID Transaksi</th>
                            <th scope="col">ID Customer</th>
                            <th scope="col">ID Pegawai</th>
                            <th scope="col">Tanggal Pemesanan</th>
                            <th scope="col">Mulai Sewa</th>
                            <th scope="col">Akhir Sewa</th>
                            <th scope="col">Total Harga</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php 
                            $sql2   = "SELECT * FROM tb_transaksi";
                            $result = $connection->query($sql2);
                            if($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    $id_transaksi         = $row['id_transaksi'];
                                    $id_customer          = $row['id_customer'];
                                    $id_pegawai           = $row['id_pegawai'];
                                    $tanggal_pemesanan    = $row['tanggal_pemesanan'];
                                    $tanggal_mulai_sewa   = $row['tanggal_mulai_sewa'];
                                    $tanggal_akhir_sewa   = $row['tanggal_akhir_sewa'];
                                    $total_harga          = $row['total_harga'];
                                    ?>
                                    <tr>
                                        <td scope="row"><?php echo $id_transaksi ?></td>
                                        <td scope="row"><a href="customer.php"><?php echo $id_customer ?></a></td>
                                        <td scope="row"><a  href="pegawai.php"><?php echo $id_pegawai ?></a></td>
                                        <td scope="row"><?php echo $tanggal_pemesanan ?></td>
                                        <td scope="row"><?php echo $tanggal_mulai_sewa ?></td>
                                        <td scope="row"><?php echo $tanggal_akhir_sewa ?></td>
                                        <td scope="row"><?php echo "Rp ".$total_harga ?></td>
                                        <td scope="row">
                                            <a href="transaksi.php?op=edit&id_transaksi=<?php echo $id_transaksi ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                            <a href="transaksi.php?op=delete&id_transaksi=<?php echo $id_transaksi?>" onclick="return confirm('Apakah anda yakin ingin menghapus data?')"><button type="button" class="btn btn-danger">Delete</button></a>
                                            <a href="transaksi.php"><button type="button" class="btn btn-primary">R</button></a>
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