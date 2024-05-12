<?php
    require '../config/db_connect.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["uname"];
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];

        $email = $_POST["email"];
        $password = md5($_POST["password"]);
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);
        $data = mysqli_fetch_assoc($result);
        if($data){
            echo "<script>alert('Email Already Exists')</script>";
            return;
        }
        $sql = "INSERT INTO users(FirstName,LastName,Email,Username,password) VALUES ('$fname','$lname','$email','$name','$password')";
        $result = $conn->query($sql);
        header("Location: http://localhost/car-dealership/index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <?php include("../templates/header.php");?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Register</h2>
                <form action="/car-dealership/pages/register.php" method="post" class="text-center">
                    <div class="form-group" style="margin: 20px;">
                        <input type="text" class="form-control" placeholder="Username" id="uname" name="uname" required>
                    </div>
                    <div class="form-group" style="margin: 20px;">
                        <input type="text" class="form-control" placeholder="First Name" id="fname" name="fname" required>
                    </div>
                    <div class="form-group" style="margin: 20px;">
                        <input type="text" class="form-control" placeholder="Last Name" id="lname" name="lname" required>
                    </div>
                    <div class="form-group" style="margin: 20px;">
                        <input type="email" class="form-control" id="email" placeholder="Email" name="email" required>
                    </div>
                    <div class="form-group" style="margin: 20px;">
                        <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
                    </div>
                    <div class="form-group" style="margin: 20px;">
                        <button type="submit" class="btn btn-primary">Signup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>