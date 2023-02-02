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
$id_atividade_titulo = $_GET['id_atividade_titulo'];
$id_treino_paciente = $_GET['id_treino_paciente'];
$id_paciente = $_GET['id_paciente'];
$id_atividade = $_POST['id_atividade'];

// inserir
$sql = "INSERT INTO prog_atividade_paciente (id_treino_paciente, id_atividade_titulo, id_atividade) VALUES ('$id_treino_paciente', '$id_atividade_titulo', '$id_atividade')";
if ($conn->query($sql) === TRUE) {
} else {
}
echo $sql;
// voltar
header("Location: treino.php?id_paciente=$id_paciente&id_treino_paciente=$id_treino_paciente");
exit;
?>
 