<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// input
$id_periodo = $_GET['id_periodo'];
$NomePeriodo = $_POST['NomePeriodo'];
$Periodo = $_POST['Periodo'];

// atualizar
$sql = "UPDATE periodo SET NomePeriodo = '$NomePeriodo', Periodo = '$Periodo' WHERE id_periodo = '$id_periodo' ";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: configurar-periodo.php");
exit;
?>
