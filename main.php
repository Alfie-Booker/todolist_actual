<?php

//basic stuff
echo'<link rel="stylesheet" href="styles.css">';
include 'db_connect.php';
session_start();

//gets list information
$sql = "SELECT * FROM list WHERE userid = ?";
$stat = $conn->prepare($sql);
$stat->bindParam(1,$_SESSION['userid']);
$stat -> execute();
$result = $stat->fetch(PDO::FETCH_ASSOC);

while($row = $stat->fetch(PDO::FETCH_ASSOC)) {

    $sql = "SELECT * FROM list_element WHERE listid = ?";
    $stat_element = $conn->prepare($sql);
    $stat_element->bindParam(1,$row['listid']);
    $stat_element -> execute();
    $result_element = $stat_element->fetch(PDO::FETCH_ASSOC);

    echo $row['name'].'<br>';

    $rowCount = $stat_element->rowCount();
    echo "Number of rows returned: " . $rowCount . "<br>";
    while($row_element = $stat_element->fetch(PDO::FETCH_ASSOC)) {
        echo 'funny';;
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
