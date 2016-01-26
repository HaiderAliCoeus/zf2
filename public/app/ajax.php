<?php

$conn = mysqli_connect('localhost', 'root', '', 'zf2');
$result = mysqli_query($conn, 'select * from album');
$numRows = mysqli_num_rows($result);
$data = array();/*
foreach(mysqli_fetch_assoc($result) as $row){
    $data[] = $row;
}*/
for($i = 0; $i< $numRows; $i++){
    $data[] = mysqli_fetch_assoc($result);
}


echo json_encode($data);