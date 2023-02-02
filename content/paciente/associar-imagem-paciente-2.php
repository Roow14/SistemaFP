<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}
    
include "../conexao/conexao.php";

// input
$id_midia_paciente = $_GET['id_midia_paciente'];
$id_paciente = $_GET['id_paciente'];

// atualizar dados
$sql = "UPDATE midia_paciente SET id_paciente = '$id_paciente' WHERE id_midia_paciente = '$id_midia_paciente' ";
if ($conn->query($sql) === TRUE) {
} else {
}

// fechar e voltar
header("Location: midia-paciente.php?id_midia_paciente=$id_midia_paciente");
exit;
?>