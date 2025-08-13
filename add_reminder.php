<?php
    session_start();
    require("config.php");

    if(!isset($_SESSION["login_info"])){
        header("location:index.php");
        exit();
    }
    $logged_in_user_id = $_SESSION["login_info"]["id"];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Add Reminder - Birthday Buddy</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.css" >
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="style.css?v=1.0">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    </head>
    <body>
        <?php include "navbar.php"; ?>

        <div class='container-fluid py-5'>
            <div class='row justify-content-center'>
                <div class='col-lg-4 col-md-6'>
                    <div class="content-card">
                        <?php
                            if(isset($_POST["reg"])){
                                $name = $_POST["name"];
                                $dob = date("Y-m-d",strtotime($_POST["dob"]));

                                $sql = "INSERT INTO users (account_id, NAME, DOB, WISH_YEAR) VALUES (?, ?, ?, '-')";
                                $stmt = $con->prepare($sql);
                                $stmt->bind_param("iss", $logged_in_user_id, $name, $dob);

                                if($stmt->execute()){
                                    echo"<div class='alert alert-success'>Added Successfully!</div>";
                                }else{
                                    echo"<div class='alert alert-danger'>Failed, please try again.</div>";
                                }
                            }
                        ?>
                        <form action='add_reminder.php' method='post' autocomplete='off'>
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name='name' required>
                            </div>
                            <div class="form-group">
                                <label>Date of Birth</label>
                                <input type="text" class="form-control datepicker" name='dob' placeholder="dd-mm-yyyy" required>
                            </div>
                            <button type='submit' name='reg' class='btn btn-primary btn-block mt-4'>Add Reminder</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class='row justify-content-center mt-5 pt-3'>
                <div class='col-lg-10 col-md-12'>
                    <div class="content-card">
                        <div class="table-responsive">
                            <table class='table reminder-table mb-0'>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>DOB</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sql = "SELECT * FROM users WHERE account_id = ? ORDER BY ID DESC";
                                        $stmt = $con->prepare($sql);
                                        $stmt->bind_param("i", $logged_in_user_id);
                                        $stmt->execute();
                                        $res = $stmt->get_result();

                                        if($res->num_rows > 0){
                                            $i = 0;
                                            while($row = $res->fetch_assoc()){
                                                $i++;
                                                echo "
                                                <tr>
                                                    <td><b>{$i}</b></td>
                                                    <td>".htmlspecialchars($row["NAME"])."</td>
                                                    <td>".date("d-m-Y",strtotime($row["DOB"]))."</td>
                                                    <td class='text-right'><a href='delete_reminder.php?id={$row["ID"]}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this reminder?\")'>Delete</a></td>
                                                </tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='4' class='text-center text-muted pt-4 pb-4'>You haven't added any reminders yet.</td></tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function(){
                $(".datepicker").datepicker({
                dateFormat:"dd-mm-yy",
                changeMonth: true,
                changeYear: true,
                yearRange: '1940:2050',
                });
            });
        </script>
    </body>
</html>
