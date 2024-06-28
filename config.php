<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "web_teo";
$conn = mysqli_connect($host, $username, $password, $database);

if(!$conn){
    echo "ERROR";
}