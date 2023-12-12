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
            .box-login input {
            padding: 5px 5px;
            background: none;
            border: none;
            outline: none;
            color: white;
            font-size: 18px;
            }
            .box-login select{
                padding: 5px 100px;
                margin: 0 10px;
                color: white;
                background-color: black;
            }
            .box-login input::placeholder {
            color: white;
            }
            .btn-login
            .box-login input:hover{
            background: rgba(10, 10, 10,s 0.5);
            }
            .btn-login {
            margin-left: 10px;
            margin-bottom: 20px;
            background: none;
            border: 1px solid white;
            width: 92.5%;
            padding: 10px;
            color: white;
            font-size: 18px;
            letter-spacing: 3px;
            cursor: pointer;
            }
            .btn-login:hover{
            background: rgba(12, 30, 15, 0.5);
            }
            .bottom {
            margin-left: 10px;
            margin-right: 10px;
            display: flex;
            justify-content: space-between;
            }
            .bottom a {
            color: white;
            font-size: 15px;
            text-decoration: none;
            }
            .bottom a:hover {
            text-decoration: underline;
            }
    </style>
</head>
<body>
    
        <div class="login justify-content-center">

            <div class="avatar">
                <i class="fa fa-user"></i>
            </div>

            <h2>Login Form</h2>

            <div class="box-login">
                <i class="fas fa-envelope-open-text"></i>
                <select id="userRole">
                    <option value="admin">Admin</option>
                    <option value="customer">Customer</option>
                </select>
            </div>

            <button type="button" name="login" class="btn-login" onclick="redirectToRole()">Login</button>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function redirectToRole() {
            var selectedRole = document.getElementById("userRole").value;
            if (selectedRole === "admin") {
                window.location.href = "admin.php"; 
            } else if (selectedRole === "customer") {
                window.location.href = "client.php"; 
            }
        }
    </script>
</body>
</html>