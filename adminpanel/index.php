<?php
    require "session.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Login</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <style>
            .body {
            margin: 0;
            padding: 0;
            background: #90caf9 ;
            background-image: url('img/bg-cam1.jpg');
            background-size: cover;
            height: 100vh;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: sans-serif;
            align-items: center;
            }
            .login {
            position: fixed;
            top: 50%;
            left: 43%;
            transform: translate(-30%, -50%);
            background: rgba(4, 29, 23, 0.5);
            padding: 50px;
            box-shadow: 0px 0px 25px 10px black;
            border-radius: 15px;
            justify-content: center;
            align-items: center;
            }
            .avatar {
            font-size: 30px ;
            background: #E59866;
            width: 50px;
            height: 50px;
            line-height: 50px;
            position: fixed;
            left: 50%;
            top: 0;
            transform: translate(-50%, -50%);
            text-align: center;
            border-radius: 50%;
            }
            .login h2 {
            text-align: center;
            color: black;
            font-weight: bolder;
            font-size: 30px;
            font-family: sans-serif;
            letter-spacing: 3px;
            padding-top: 0;
            margin-top: -20px;

            }
            .box-login {
            display: flex;
            justify-content:flex-start;
            margin: 10px;
            border-bottom: 2px solid white;
            padding: 8px 0;
            }
            .box-login i {
            font-size: 23px;
            color: black;
            padding: 5px 0;
            }
            .box-login input::placeholder {
            color: white;
            }
            .nav{
                margin: 0 90px;
            }
            .box-login a li{
                margin: 0 90px;
            }
            .nav-item{
                transform: scale(1.2);
            }
    </style>
</head>
<body>
    
        <div class="login justify-content-center">

            <div class="avatar">
                <i class="fa fa-user"></i>
            </div>

            <h2>Admin Section</h2>

            <div class="box-login">
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

        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>