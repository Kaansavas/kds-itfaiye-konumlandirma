<?php
    $server = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'itfaiye';
    $con=mysqli_connect($server,$username,$password,$database);
    $con->set_charset("utf8");

    if(mysqli_connect_errno()) {
        echo "connection error" . mysqli_connect_error();
        }
    ?>