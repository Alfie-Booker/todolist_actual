<?php

//basic stuff
echo'<link rel="stylesheet" href="styles.css">';
include 'db_connect.php';
session_start();

//gets data from post
$password_in = $_POST['password'];
$new_password = $_POST['new_password'];
$new_password2 = $_POST['new_password2'];
$count = 0;

//gets the data for the username
$sql = "SELECT * FROM user WHERE username = ?";
$stat = $conn->prepare($sql);
$stat->bindParam(1,$_SESSION['username']);
$stat -> execute();
$result = $stat->fetch(PDO::FETCH_ASSOC);

//declares password as the hashed one from the db
if($result){
    $password = $result['password'];}

//makes sure that the password matches
if (password_verify($password_in,$password)) {

    //makes sure the passwords match up and if they do it changes the password to a new hashed one
    if ($new_password == $new_password2) {
        echo "pass match <br>";
        $new_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE user SET password = ? WHERE username = ?";
        $stat = $conn->prepare($sql);
        $stat->bindParam(1,$new_password);
        $stat->bindParam(2,$_SESSION['username']);
        $stat->execute();

    }
    else{ $count = $count + 1;}
}else{$count = $count + 1; }

//if they havent changed the password correctely it adds attempted changed password to the audit log and same for successful
if($count>0){
    $act = "apc";
}else{
    $act = "spc";
}
$logtime = time();

//inserts the action time and username into the audit log
$sql = "INSERT INTO audit (userid, action, time) VALUES (?,?,?)";
$stat = $conn->prepare($sql);
$stat->bindParam(1, $_SESSION['userid']);
$stat->bindParam(2, $act);
$stat->bindParam(3, $logtime);
$stat->execute();
header("refresh:1; url=profile.php");
?>