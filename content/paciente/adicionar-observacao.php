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
$id_paciente = $_GET['id_paciente'];
$Observacao = $_POST['Observacao'];

// inserir
$sql = "INSERT INTO diagnostico_observacao (id_paciente, Observacao) VALUES ('$id_paciente', '$Observacao')";
if ($conn->query($sql) === TRUE) {
} else {
}

unset($_SESSION['AtivarObservacao']);

// voltar
header("Location: diagnostico-paciente.php?id_paciente=$id_paciente");
exit;
?>
