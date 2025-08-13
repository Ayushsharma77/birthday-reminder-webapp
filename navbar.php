<?php
    if(session_status() == PHP_SESSION_NONE){ session_start(); }

    function number_suffix($number){
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number%100) <= 13)){ return $number. 'th'; }
        else{ return $number.$ends[$number % 10]; }
    }
    
    $notifications=[];
    if(isset($_SESSION["login_info"])){
        $logged_in_user_id = $_SESSION["login_info"]["id"];
        $current_month_day=date("m-d");
        $sql="SELECT * FROM users WHERE DATE_FORMAT(DOB, '%m-%d') = ? AND account_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $current_month_day, $logged_in_user_id);
        $stmt->execute();
        $res=$stmt->get_result();
        if($res->num_rows>0){
            while($row=$res->fetch_assoc()){
                $dob = new DateTime($row["DOB"]);
                $today = new DateTime('today');
                $age = $today->diff($dob)->y;
                $birthday_number = $age;
                $name = htmlspecialchars($row["NAME"]);
                
                if ($age > 0) {
                    $birthday_suffix = number_suffix($age);
                    $notifications[] = "
                        <div class='today-notification-card'>
                            <h5 class='card-title'>🎉 It's {$name}'s {$birthday_suffix} Birthday Today! 🎉</h5>
                        </div>";
                } else {
                     $notifications[] = "
                        <div class='today-notification-card'>
                            <h5 class='card-title'>🎉 It's {$name}'s Birthday Today! 🎉</h5>
                        </div>";
                }
            }
        }
    }
?>
<nav class="navbar navbar-expand-lg navbar-dark main-navbar">
    <a class="navbar-brand d-flex align-items-center" href="home.php">
        <img src="birthday-cake.png" height="40" alt="Birthday Buddy Logo">
        <span class="navbar-brand-text">Birthday Buddy</span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="home.php"><span class='fa fa-home'></span> Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="add_reminder.php"><span class='fa fa-plus'></span> Add Reminder</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>
