<?php

print_r($_POST);
if(isset($_POST['artist']) && isset($_POST['title']) ){
    $conn = mysqli_connect('localhost', 'root', '', 'zf2');
    $title = mysqli_real_escape_string($conn, $_POST['title']);

    $artist = mysqli_real_escape_string($conn, $_POST['artist']);

    $result = mysqli_query($conn, "insert into album(title, artist) VALUES('$title', '$artist')");
    if($result){
        echo json_encode(array('title' => $title, 'artist' => $artist, 'id' => mysqli_insert_id($conn)));
    }else{
        echo json_encode(array('error' => 'Album not inserted'));
    }
}
