<?php
//basic stuff
echo'<link rel="stylesheet" href="styles.css">';
include 'db_connect.php';
session_start();

//gets data from html post
$name = $_POST['name'];
$time = time();

$sql = "INSERT INTO list (userid, name, time) VALUES (?,?,?)";
$stat = $conn->prepare($sql);
$stat->bindParam(1, $_SESSION['userid']);
$stat->bindParam(2, $name);
$stat->bindParam(3, $time);
$stat->execute();

echo "new list created";
header("refresh:1; url=main.php");
?>