<?php

    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "ionio_website";
    $conn = "";

    try{
        $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    }catch(mysqli_sql_exception){
        echo "Could not connect!";
    }

    if ($conn){
        echo "<script>";
        echo "console.log('Connection with server has been established');";
        echo "</script>";
    }
?>