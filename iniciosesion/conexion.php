<?php
    $host = "localhost:3307";
    $user = "root";
    $pass = "";

    $db = "iniciosesionbd";
    $conexion = mysqli_connect($host,$user,$pass,$db);

    if(!$conexion){
        die("❌ Error de conexión: " . mysqli_connect_error());

    }

?>