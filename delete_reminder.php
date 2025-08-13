<?php 
	session_start();
	require("config.php");
	
	if(!isset($_SESSION["login_info"])){
		header("location:index.php");
		exit(); 
	}
	
	$logged_in_user_id = $_SESSION["login_info"]["id"];
	$reminder_id_to_delete = $_GET["id"];

	$sql="DELETE FROM users WHERE ID = ? AND account_id = ?";
	$stmt = $con->prepare($sql);
	$stmt->bind_param("ii", $reminder_id_to_delete, $logged_in_user_id);
	
	if($stmt->execute()){
		header("location:add_reminder.php");
		exit(); 
	} else {
		header("location:add_reminder.php?error=deletefailed");
		exit();
	}
?>