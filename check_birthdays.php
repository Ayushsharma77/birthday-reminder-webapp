<?php
session_start();
require("config.php");

if (!isset($_SESSION["login_info"]["id"])) {
    echo json_encode([]); 
    exit();
}

$logged_in_user_id = $_SESSION["login_info"]["id"];
$current_month_day = date("m-d");

$birthday_names = [];

$sql = "SELECT NAME FROM users WHERE DATE_FORMAT(DOB, '%m-%d') = ? AND account_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("si", $current_month_day, $logged_in_user_id);

if ($stmt->execute()) {
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $birthday_names[] = htmlspecialchars($row['NAME']);
    }
}

header('Content-Type: application/json');
echo json_encode($birthday_names);
?>
