<?php

//basic stuff
echo'<link rel="stylesheet" href="styles.css">';
include 'db_connect.php';
session_start();

//gets data from html post
$username = $_POST['username'];
$fname = $_POST['fname'];
$sname = $_POST['sname'];
$email = $_POST['email'];

$sql = "SELECT username,userid FROM user WHERE username = ?";
$stat = $conn->prepare($sql);
$stat->bindParam(1,$username);
$stat -> execute();
$result = $stat->fetch(PDO::FETCH_ASSOC);
if ($result['username'] == '' and $result['userid'] != $_SESSION["userid"]) {

    //updates the database with the new data
    $sql = $conn -> prepare("UPDATE user SET username=?,fname=?, lname=?, email=? WHERE username=?");
    $sql ->bindParam(1, $username);
    $sql -> bindParam(2, $fname);
    $sql -> bindParam(3, $sname);
    $sql -> bindParam(4, $email);
    $sql -> bindParam(5, $_SESSION['username']);
    $sql -> execute();

    //adds to the log table that the data has been updated
    $act = "upd";
    $logtime = time();

    $sql = "INSERT INTO audit (userid, action, time) VALUES (?,?,?)";
    $stat = $conn->prepare($sql);
    $stat->bindParam(1, $_SESSION['userid']);
    $stat->bindParam(2, $act);
    $stat->bindParam(3, $logtime);
    $stat->execute();
    $_SESSION['username'] = $username;
    header("refresh:1; url=profile.php");
}


?>