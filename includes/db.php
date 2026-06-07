<?php
$host = "localhost";
$user = "root";
$pass = "root";
$db   = "ponchateaqui";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro na ligação à base de dados: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");