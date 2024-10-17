<?php
//basic stuff
echo'<link rel="stylesheet" href="styles.css">';
include 'db_connect.php';
session_start();

//gets data from html post
$name = $_POST['name'];
$time = time();
$listid = $_POST['list'];

$sql = "INSERT INTO list_element (listid,name, time) VALUES (?,?,?)";
$stat = $conn->prepare($sql);
$stat->bindParam(1, $listid);
$stat->bindParam(2, $name);
$stat->bindParam(3, $time);
$stat->execute();

echo "new list element created";
header("refresh:1; url=main.php");
?>