<?php

//basic stuff
echo'<link rel="stylesheet" href="styles.css">';
include 'db_connect.php';
session_start();

//gets the lists for the users
$sql = "SELECT * FROM list WHERE userid = ?";
$stat = $conn->prepare($sql);
$stat->bindParam(1,$_SESSION['userid']);
$stat -> execute();

//loops through the users lists to get the different elements
while($row = $stat->fetch(PDO::FETCH_ASSOC)) {

    $sql = "SELECT * FROM list_element WHERE listid = ?";
    $stat_element = $conn->prepare($sql);
    $stat_element->bindParam(1,$row['listid']);
    $stat_element -> execute();
    echo '<h1>' . $row['name'] . '</h1>';

    //outputs the elements
    while($row_element = $stat_element->fetch(PDO::FETCH_ASSOC)) {

    echo $row_element['name'].'<br>';
    }
}

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
