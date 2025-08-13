<?php
    session_start();
    require("config.php");

    if(!isset($_SESSION["login_info"])){
        header("location:index.php");
        exit();
    }

    $logged_in_user_id = $_SESSION["login_info"]["id"];
    $reminders = [];
    $sql_all = "SELECT NAME, DOB FROM users WHERE account_id = ?";
    $stmt_all = $con->prepare($sql_all);
    $stmt_all->bind_param("i", $logged_in_user_id);
    $stmt_all->execute();
    $res_all = $stmt_all->get_result();
    while ($row = $res_all->fetch_assoc()) {
        $reminders[] = $row;
    }
    $upcoming_birthdays = [];
    $today = new DateTime('today');
    foreach ($reminders as $reminder) {
        $dob = new DateTime($reminder['DOB']);
        $next_birthday = new DateTime(date('Y') . '-' . $dob->format('m-d'));
        if ($next_birthday < $today) {
            $next_birthday->modify('+1 year');
        }
        $interval = $today->diff($next_birthday);
        $days_left = $interval->days;
        $upcoming_birthdays[] = [
            'name' => $reminder['NAME'],
            'birthday_date' => $dob->format('F jS'),
            'days_left' => $days_left
        ];
    }
    usort($upcoming_birthdays, function($a, $b) {
        return $a['days_left'] <=> $b['days_left'];
    });
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Dashboard - Birthday Buddy</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.css" >
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="style.css?v=1.0">
    </head>
    <body>
        <?php include "navbar.php"; ?>

        <div class='container-fluid'>
            
            <div class="page-header text-center mb-5">
                <h2>Welcome, <?php echo htmlspecialchars($_SESSION["login_info"]["ANAME"]); ?>!</h2>
                <p>Here are your upcoming birthday reminders.</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <?php
                        if (isset($notifications) && !empty($notifications)) {
                            foreach($notifications as $notification_card){
                                echo $notification_card; 
                            }
                        }
                    ?>
                </div>
            </div>
            
            <div class="row">
                <div class='col-12'>
                    <div class="row justify-content-center px-md-4 mt-5">
                        <?php if (empty($upcoming_birthdays)): ?>
                            <div class="col-12 text-center text-white">
                                <h4>You haven't added any reminders yet.</h4>
                            </div>
                        <?php else: ?>
                            <?php foreach ($upcoming_birthdays as $bday): ?>
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="card shadow-sm bday-card h-100">
                                        <div class="card-body text-center d-flex flex-column">
                                            <h5 class="card-title"><?php echo htmlspecialchars($bday['name']); ?></h5>
                                            <p class="card-text text-muted"><?php echo $bday['birthday_date']; ?></p>
                                            <div class="mt-auto pt-3">
                                                <?php
                                                    if ($bday['days_left'] == 0) {
                                                        echo "<div class='badge badge-success p-2 w-100'>🎉 Today!</div>";
                                                    } else if ($bday['days_left'] == 1) {
                                                        echo "<h4>1</h4> <div class='text-muted small'>DAY LEFT</div>";
                                                    } else {
                                                        echo "<h4>{$bday['days_left']}</h4> <div class='text-muted small'>DAYS LEFT</div>";
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="notifications.js"></script>

    </body>
</html>
    </body>
</html>
