<?php
$pass = "1234"; // contraseña original
$hash = password_hash($pass, PASSWORD_DEFAULT);
echo $hash;
?>