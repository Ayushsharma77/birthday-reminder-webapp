<?php
    session_start();
    require("config.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login - Birthday Buddy</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.css" >
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="style.css?v=1.0">

        <style>
            body {
                font-family: 'Poppins', sans-serif;
                background: #6a11cb;
                background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 0.9), rgba(37, 117, 252, 0.9));
                background: linear-gradient(to right, rgba(106, 17, 203, 0.9), rgba(37, 117, 252, 0.9));
            }
            .login-container {
                min-height: 100vh;
            }
            .login-card {
                border-radius: 1rem;
                border: none;
            }
            .login-card .card-title {
                font-weight: 700;
                font-size: 1.5rem;
            }
            .login-icon {
                font-size: 5rem;
                color: #007bff;
            }
            .form-control:focus {
                box-shadow: none;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row d-flex justify-content-center align-items-center login-container">
                <div class="col-md-7 col-lg-5">
                    <div class="card shadow-lg login-card">
                        <div class="card-body p-4 p-md-5">

                            <div class="text-center">
                                <i class="fa fa-birthday-cake login-icon mb-3"></i>
                                <h3 class="card-title mb-4">Member Login</h3>
                            </div>

                            <?php
                                if(isset($_POST["login"])){
                                    $uname = $_POST["uname"];
                                    $upass = $_POST["upass"];

                                    $sql = "SELECT * FROM accounts WHERE username = ?";
                                    $stmt = $con->prepare($sql);
                                    $stmt->bind_param("s", $uname);
                                    $stmt->execute();
                                    $res = $stmt->get_result();

                                    if($res->num_rows > 0){
                                        $row = $res->fetch_assoc();
                                        if(password_verify($upass, $row["password"])){
                                            $_SESSION["login_info"] = [
                                                "id" => $row["id"],
                                                "ANAME" => $row["username"]
                                            ];
                                            header('location:home.php');
                                            exit();
                                        } else {
                                            echo"<div class='alert alert-danger'>Invalid Username or Password.</div>";
                                        }
                                    }else{
                                        echo"<div class='alert alert-danger'>Account does not exist. Please create one</div>";
                                    }
                                }
                            ?>
                            <form action='index.php' method='post'>
                                <div class="form-group mb-4">
                                    <label for="uname">User Name</label>
                                    <input type="text" id="uname" class="form-control form-control-lg" name='uname' required>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="upass">Password</label>
                                    <input type="password" id="upass" class="form-control form-control-lg" name='upass' required>
                                </div>
                                <div class="form-group">
                                    <button type='submit' name='login' class='btn btn-primary btn-lg btn-block'>Login</button>
                                </div>
                                <div class="text-center mt-4">
                                    <p class="text-muted">Don't have an account? <a href="register.php">Create one now!</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    </body>
</html>
