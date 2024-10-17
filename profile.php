<?php

//basic stuff
echo'<link rel="stylesheet" href="styles.css">';
include 'db_connect.php';
session_start();

$username = $_SESSION["username"];

//gets personal details other than password
$sql = "SELECT userid,username,fname,lname,email,time FROM user WHERE username = ?";
$stat = $conn->prepare($sql);
$stat->bindParam(1,$username);
$stat -> execute();
$result = $stat->fetch(PDO::FETCH_ASSOC);


//outputs the personal details
foreach ($result as $key=>$value) {
    echo $key." : ".$value."<br>";
}

//gets the last login time that isnt the one they just did
$act = 'log';
$sql = "SELECT time FROM audit WHERE userid = ? AND action = ? ORDER BY time DESC LIMIT 1 OFFSET 1";
$stat = $conn->prepare($sql);
$stat->bindParam(1,$_SESSION['userid']);
$stat->bindParam(2,$act);
$stat -> execute();
$result = $stat->fetch(PDO::FETCH_ASSOC);
echo "Last Login: ".date('Y-m-d H:i:s',$result['time'])."<br>";

//tells them how many times they did each action
$actions = array("log","spc","apc");

foreach ($actions as $action){
    $sql = "SELECT COUNT(*) AS count FROM audit WHERE userid = ? AND action = ?";
    $stat = $conn->prepare($sql);
    $stat->bindParam(1,$_SESSION['userid']);
    $stat->bindParam(2,$action);
    $stat -> execute();
    $result = $stat->fetch(PDO::FETCH_ASSOC);
    echo "Action: ".$action."   Times done: ".$result["count"]."<br>";
}


?>
<!-- buttons for changing details -->
<form action="update.html">
    <input type="submit" value="change details">
</form>

<form action="password_change.html">
    <input type="submit" value="change password">
</form>

<form action="main.php">
    <input type="submit" value="main">
</form>