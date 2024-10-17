<?php

// basic starting stuff
include 'db_connect.php';
echo'<link rel="stylesheet" href="styles.css">';

$username = $_POST['username'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];
$fname = $_POST['fname'];
$lname = $_POST['sname'];
$email = $_POST['email'];
$date = date("Y-m-d");


//checks that the new username is unique
$sql = "SELECT username FROM user WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bindParam(1,$username);
$stmt -> execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

//if it isn't unique then it redirects to new page
if ($username == $result['username']) {
    echo "Username already in use try again";
    header("refresh:1; url=index.html");
}

//if passwords dont match then it redirects to login page
elseif ($password != $cpassword) {
    echo "Passwords don't match";
    header("refresh:1; url=index.html");
}

// tries to put new data into the database, if there is an error it will output
else {
    try
{
    $hpassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO user (username, password, fname, lname, email, time) VALUES (?,?,?,?,?,?)";

    $stat = $conn->prepare($sql);

    $stat->bindParam(1, $username);
    $stat->bindParam(2, $hpassword);
    $stat->bindParam(3, $fname);
    $stat->bindParam(4, $lname);
    $stat->bindParam(5, $email);
    $stat->bindParam(6, $date);
    $stat->execute();

    header("refresh:1; url=login.html");
    echo "sucessfully registered";
}
catch (PDOException $e)
{
    echo "error: " . $e->getMessage();
}}

?>