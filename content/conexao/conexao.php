<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}
    
//conexão com banco
$servername = "localhost"; $username = "root"; $password = ""; $dbname = "fisiofor_agenda";
// $servername = "localhost"; $username = "fisiofor_agenda"; $password = "JZ7Vmz8^pGKH"; $dbname = "fisiofor_agenda";


//Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
//Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>