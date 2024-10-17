<?php

//basic stuff
echo'<link rel="stylesheet" href="styles.css">';
include 'db_connect.php';
session_start();

//gets personal details other than password
$sql = "SELECT * FROM list WHERE userid = ?";
$stat = $conn->prepare($sql);
$stat->bindParam(1,$_SESSION['userid']);
$stat -> execute();
$result = $stat->fetch(PDO::FETCH_ASSOC);



?>
<form action="profile.php">
    <input type="submit" value="Profile">
</form>

<form action="list.html">
    <input type="submit" value="New list">
</form>

<form action="list_element.html">
    <input type="submit" value="New task">
</form>
