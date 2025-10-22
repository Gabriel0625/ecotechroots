<?php
$host = 'localhost';
$user = 'root';
$pass = 'root';
$db   = 'ecotechroots';
$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno) {
    error_log("Erro conexão MySQL: " . $mysqli->connect_error);
    die("Erro na conexão com o banco.");
}
$mysqli->set_charset("utf8mb4");
?>
