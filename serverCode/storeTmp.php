<?php
$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASENAME);
date_default_timezone_set ( "Asia/Tehran" );
$temp = $_GET["temp"];
$dateHour=date('h');


$quarySelect = "SELECT * FROM temp ORDER BY ID DESC LIMIT 1";
$result=mysqli_query($conn, $quarySelect);
$row = $result->fetch_assoc();


$quary = "UPDATE currenttemp SET temp=".$temp." WHERE id=1";
mysqli_query($conn, $quary);


if($result&&$row['date']!=$dateHour){
    $quary = "insert into temp (temp,date) VALUES (".$temp.",".$dateHour.")";
    mysqli_query($conn, $quary);
}

