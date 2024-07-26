<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$bd = "usuarios";
$port = 3225;

$conn = new mysqli($host, $usuario, $senha, $bd, $port);

if ($conn->connect_errno) {
    die("Falha na concexão" . $conn->conect_errno . ")" . $conn->connect_error);
}


?>