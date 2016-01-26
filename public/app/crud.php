<?php
include_once 'db.php';

if(!isset($_GET['edit']) && !isset($_GET['del']) && !isset($_POST['save']))
{

    $SQL = $MySQLiconn->query("SELECT * FROM users");

    $data =[];
    while($row = $SQL->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
}

if(isset($_POST['save']))
{

    $fn = $MySQLiconn->real_escape_string($_POST['fname']);
    $ln = $MySQLiconn->real_escape_string($_POST['password']);

    $SQL = $MySQLiconn->query("INSERT INTO users(fname,password) VALUES('$fn','$ln')");

    if(!$SQL)
    {
        echo $MySQLiconn->error;
    }else{
        echo 'data inserted';
    }
}
/* code for data insert */


/* code for data delete */
if(isset($_GET['del']))
{
    $SQL = $MySQLiconn->query("DELETE FROM users WHERE id=".$_GET['del']);
    echo "User Deleted";
}
/* code for data delete */



/* code for data update */
if(isset($_GET['edit']))
{
    $SQL = $MySQLiconn->query("SELECT * FROM users WHERE id=".$_GET['edit']);
    $getROW = $SQL->fetch_array();
}

if(isset($_POST['update']))
{
    $SQL = $MySQLiconn->query("UPDATE data SET fname='".$_POST['fname']."', password='".$_POST['password']."' WHERE id=".$_GET['edit']);
    if($SQL){
        echo "User updated";
    }
}
/* code for data update */

?>