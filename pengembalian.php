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
    $id_transaksi           = "";
    $id_pengembalian        = "";
    $tanggal_pengembalian   = "";
    $denda                  = "";
    $error                  = "";
    $sukses                 = "";
    $show                   = "";

    if(isset($_GET['op'])){
        $op = $_GET['op'];
    }else{
        $op = "";
    }

    if($op == 'delete'){
        $id_pengembalian         = $_GET['id_pengembalian'];
        $sql                     = "DELETE FROM tb_pengembalian WHERE id_pengembalian = '$id_pengembalian'";
        $q1                      = mysqli_query($connection, $sql);
        if(!$q1) {
            $error = "Data gagal dihapus";
        } else {
            $sukses = "Data berhasil dihapus";
        }
    }

    if($op == 'show'){
        $id_pengembalian         = $_GET['id_pengembalian'];
        $sql                     = "SELECT * FROM tb_pengembalian
                                    WHERE $id_pengembalian = '$id_pengembalian';";
        $q1                      = mysqli_query($connection, $sql);
        if($q1){
            if (mysqli_num_rows($q1) > 0) {
                // Ambil data dari hasil query
                $row = mysqli_fetch_array($q1);
                $id_pengembalian       = $row['id_pengembalian'];
                $id_transaksi          = $row['id_transaksi'];
                $tanggal_pengembalian  = $row['tanggal_pengembalian'];
                
                // Lakukan operasi lainnya dengan data yang telah diambil
            } else {
                // Handle the case when no matching record is found
                echo "No matching record found for id_pengembalian: $id_pengembalian";
            }
            $show          = "show";               
        }else{
            $show          = "dontshow";
        }
    }
    if ($op == 'edit') {
                
        // Validasi id_pengembalian dan pastikan itu adalah bilangan bulat positif
        $id_pengembalian = isset($_GET['id_pengembalian']) ? intval($_GET['id_pengembalian']) : 0;

        if ($id_pengembalian <= 0) {
            // Handle invalid or missing id_pengembalian parameter
            echo "Invalid or missing id_pengembalian parameter.";
        } else {
            // Lakukan koneksi ke database (pastikan variabel $connection sudah terdefinisi)

            $sql            = "UPDATE tb_pengembalian
                                JOIN tb_transaksi ON tb_transaksi.id_transaksi = tb_pengembalian.id_transaksi
                                SET tb_pengembalian.denda = DATEDIFF(tb_pengembalian.tanggal_pengembalian, tb_transaksi.tanggal_akhir_sewa) * 20000
                                WHERE id_pengembalian = '$id_pengembalian'";
            $sql4           = " SELECT * FROM tb_pengembalian WHERE id_pengembalian = '$id_pengembalian'";

            $q = mysqli_query($connection, $sql);
            $q4 = mysqli_query($connection, $sql4);
            // Periksa apakah ada kesalahan eksekusi SQL
            if (!$q4 && !$q) {
                echo "Error: " . mysqli_error($connection);
                // Handle the SQL error appropriately
            } else {
                // Periksa apakah ada hasil dari query
                if (mysqli_num_rows($q4) > 0) {
                    // Ambil data dari hasil query
                    $row                  = mysqli_fetch_array($q4);
                    $id_transaksi         = $row['id_transaksi'];
                    $tanggal_pengembalian = $row['tanggal_pengembalian'];
                    // Lakukan operasi lainnya dengan data yang telah diambil
                } else {
                    // Handle the case when no matching record is found
                    echo "No matching record found for id_pengembalian: $id_pengembalian";
                }
            }
        }


    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_transaksi           = $_POST['id_transaksi'];
        $tanggal_pengembalian   = $_POST['tanggal_pengembalian'];
        
        if($op == 'edit'){
            $sql            = " UPDATE tb_pengembalian
                                SET id_transaksi = '$id_transaksi', tanggal_pengembalian = '$tanggal_pengembalian', denda = '$denda' 
                                WHERE id_pengembalian = '$id_pengembalian'";
            $sql2            = "UPDATE tb_pengembalian
                                JOIN tb_transaksi ON tb_transaksi.id_transaksi = tb_pengembalian.id_transaksi
                                SET tb_pengembalian.denda = DATEDIFF(tb_pengembalian.tanggal_pengembalian, tb_transaksi.tanggal_akhir_sewa) * 20000
                                WHERE id_pengembalian = '$id_pengembalian'";
            $q1             = $connection->query($sql);
            $q2           = $connection->query($sql2);
            if ($q1 && $q2) {
                $sukses     = "Data baru berhasil di-update";
            } else {
                $error      = "Data baru gagal di-update";
            }
        }else{
            $sql            = "INSERT INTO tb_pengembalian (id_transaksi, tanggal_pengembalian, denda) 
                                VALUES ('$id_transaksi', '$tanggal_pengembalian', '$denda')";
            $sql2            = "UPDATE tb_pengembalian
                                JOIN tb_transaksi ON tb_transaksi.id_transaksi = tb_pengembalian.id_transaksi
                                SET tb_pengembalian.denda = DATEDIFF(tb_pengembalian.tanggal_pengembalian, tb_transaksi.tanggal_akhir_sewa) * 20000
                                WHERE id_pengembalian = '$id_pengembalian'";
            $q1             = $connection->query($sql);
            $q2           = $connection->query($sql2);
            if ($$q1 && $q2) {
                $sukses     = "Data baru berhasil ditambahkan";
            } else {
                $error      = "Data baru gagal ditambahkan";
            }
        }
    }
    $sql_transaksi = "SELECT id_transaksi FROM tb_transaksi";
    $result_transaksi = $connection->query($sql_transaksi);

    // Simpan data id_transaksi dalam array
    $nama_transaksi_options = array();
    if ($result_transaksi->num_rows > 0) {
        while ($row = $result_transaksi->fetch_assoc()) {
            $nama_transaksi_options[] = $row['id_transaksi'];
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
        <span class="fs-2 text-white">PENGEMBALIAN</span>
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
    <?php 
    if($show == "show"){
    ?>

    <div class="mx-auto">
        <div class="card">
            <div class="card-header">
                SHOW DATA
            </div>
            <div class="card-body">
                <div class="mb-3 row">
                    <label for="id_pengembalian" class="col-sm-2 col-form-label">ID Pengembalian</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="id_pengembalian" name="id_pengembalian" value="<?php echo $id_pengembalian ?>" readonly>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="id_transaksi" class="col-sm-2 col-form-label">ID Transaksi</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="id_transaksi" name="id_transaksi" value="<?php echo $id_transaksi ?>" readonly>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="tanggal_pengembalian" class="col-sm-2 col-form-label">Tanggal Pengembalian</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tanggal_pengembalian" name="tanggal_pengembalian" value="<?php echo $tanggal_pengembalian ?>" readonly>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="denda" class="col-sm-2 col-form-label">Denda</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="denda" name="denda" value="<?php echo $denda ?>" readonly>
                    </div>
                </div>
                <div class="mb-3 row">
                    <a href="det_transaksi.php"><button type="button" class="btn btn-primary">Back</button></a>
                </div>
            </div>
        </div>
    </div>

    <?php
    }
    ?>
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
                        <a href="pengembalian.php">Back</a>
                    </div>
                <?php
                    
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                        <a href="pengembalian.php">Back</a>
                    </div>
                <?php
                    
                }
                ?>
                <form action="" method="post">
                    
                    <div class="mb-3 row">
                        <label for="id_transaksi" class="col-sm-2 col-form-label">ID Transaksi</label>
                        <div class="col-sm-10">
                            <select name="id_transaksi" id="id_transaksi" class="form-control">
                                <option value="">--Pilih ID Transaksi--</option>
                                <?php
                                    foreach($nama_transaksi_options as $option){
                                        $selected = ($id_transaksi == $option)? "selected" : "";
                                        echo "<option value=\"$option\" $selected>$option</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tanggal_pengembalian" class="col-sm-2 col-form-label">Tanggal Pengembalian</label>
                        <div class="col-sm-10">
                            <input type="date" name="tanggal_pengembalian" id="tanggal_pengembalian" value="<?php echo $tanggal_pengembalian ?>" required>
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
                DATA PENGEMBALIAN
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID Pengembalian</th>
                            <th scope="col">ID Transaksi</th>
                            <th scope="col">Tanggal Pengembalian</th>
                            <th scope="col">Denda</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php 
                            $sql2   = "SELECT * FROM tb_pengembalian";
                            $result = $connection->query($sql2);
                            if($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    $id_pengembalian         = $row['id_pengembalian'];
                                    $id_transaksi            = $row['id_transaksi'];
                                    $tanggal_pengembalian    = $row['tanggal_pengembalian'];
                                    $denda                   = $row['denda'];

                                    ?>
                                    <tr>
                                        <td scope="row"><?php echo $id_pengembalian ?></td>
                                        <td scope="row"><?php echo $id_transaksi ?></td>
                                        <td scope="row"><?php echo $tanggal_pengembalian ?></td>
                                        <td scope="row"><?php echo $denda ?></td>
                                        <td scope="row">
                                            <a href="pengembalian.php?op=edit&id_pengembalian=<?php echo $id_pengembalian ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                            <a href="pengembalian.php?op=delete&id_pengembalian=<?php echo $id_pengembalian?>&id_pengembalian=<?php echo $id_pengembalian?>" onclick="return confirm('Apakah anda yakin ingin menghapus data?')"><button type="button" class="btn btn-danger">Delete</button></a>
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