<?php
session_start();
require("config.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Register - Birthday Buddy</title>
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
            .register-container {
                min-height: 100vh;
            }
            .register-card {
                border-radius: 1rem;
                border: none;
            }
            .register-card .card-title {
                font-weight: 700;
                font-size: 1.5rem;
            }
            .register-icon {
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
            <div class="row d-flex justify-content-center align-items-center register-container">
                <div class="col-md-7 col-lg-5">
                    <div class="card shadow-lg register-card">
                        <div class="card-body p-4 p-md-5">

                            <div class="text-center">
                                <i class="fa fa-user-plus register-icon mb-3"></i>
                                <h3 class="card-title mb-4">Create Account</h3>
                            </div>

                            <?php
                                if(isset($_POST["register"])){
                                    $uname = $_POST["uname"];
                                    $upass = $_POST["upass"];
                                    $cpass = $_POST["cpass"];

                                    if ($upass !== $cpass) {
                                        echo "<div class='alert alert-danger'>Passwords do not match.</div>";
                                    } else {
                                        $check_sql = "SELECT id FROM accounts WHERE username = ?";
                                        $check_stmt = $con->prepare($check_sql);
                                        $check_stmt->bind_param("s", $uname);
                                        $check_stmt->execute();
                                        $check_result = $check_stmt->get_result();

                                        if($check_result->num_rows > 0){
                                            echo "<div class='alert alert-danger'>Username already exists.</div>";
                                        } else {
                                            $hashed_password = password_hash($upass, PASSWORD_DEFAULT);

                                            $insert_sql = "INSERT INTO accounts (username, password) VALUES (?, ?)";
                                            $insert_stmt = $con->prepare($insert_sql);
                                            $insert_stmt->bind_param("ss", $uname, $hashed_password);

                                            if($insert_stmt->execute()){
                                                echo "<div class='alert alert-success'>Account created! You can now <a href='index.php'>login</a>.</div>";
                                            } else {
                                                echo "<div class='alert alert-danger'>Failed to create account.</div>";
                                            }
                                        }
                                    }
                                }
                            ?>
                            <form action='register.php' method='post'>
                                <div class="form-group mb-4">
                                    <label for="uname">User Name</label>
                                    <input type="text" id="uname" class="form-control form-control-lg" name='uname' required>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="upass">Password</label>
                                    <input type="password" id="upass" class="form-control form-control-lg" name='upass' required>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="cpass">Confirm Password</label>
                                    <input type="password" id="cpass" class="form-control form-control-lg" name='cpass' required>
                                </div>
                                <div class="form-group">
                                    <button type='submit' name='register' class='btn btn-primary btn-lg btn-block'>Create Account</button>
                                </div>
                                <div class="text-center mt-4">
                                    <p class="text-muted">Already have an account? <a href="index.php">Login here</a>.</p>
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
