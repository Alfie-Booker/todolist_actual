<?php

//basic stuff and starts the session and sets the session time
echo'<link rel="stylesheet" href="styles.css">';
include 'db_connect.php';
session_set_cookie_params(1800);
session_start();

$username = $_POST['username'];
$password_in = $_POST['password'];

$sql = "SELECT * FROM user WHERE username = ?";

$stat = $conn->prepare($sql);

$stat->bindParam(1,$username);
$stat -> execute();
$result = $stat->fetch(PDO::FETCH_ASSOC);

if($result){

    //sets the session variables
    $_SESSION["ssnlogin"] = true;
    $_SESSION["username"] = $username;
    $_SESSION["userid"] = $result["userid"];
    $password= $result['password'];

    //checks that the password is correct and logs the action
    if (password_verify($password_in,$password)) {

        $act = "log";
        $logtime = time();

        $sql = "INSERT INTO audit (userid, action, time) VALUES (?,?,?)";
        $stat = $conn->prepare($sql);

        $stat->bindParam(1, $_SESSION['userid']);
        $stat->bindParam(2, $act);
        $stat->bindParam(3, $logtime);
        $stat->execute();

        header("refresh:1; url=main.php");
        echo "You have logged in";

    }else{echo 'incorrect login details';}
}

?>
