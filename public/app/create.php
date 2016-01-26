<?php
include_once 'db.php';

$fn = $MySQLiconn->real_escape_string($_POST['fname']);
$ln = $MySQLiconn->real_escape_string($_POST['password']);

$SQL = $MySQLiconn->query("INSERT INTO users(fname,password) VALUES('$fn','$ln')");

if(!$SQL)
{
    echo 0;
}else{
    echo 1;
}