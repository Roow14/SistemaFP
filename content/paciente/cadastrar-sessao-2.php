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
$SessaoInicial = $_POST['SessaoInicial'];
$HorasInicial = $_POST['HorasInicial'];
$id_categoria = $_POST['id_categoria'];

// inserir
$sql = "INSERT INTO sessao_paciente (id_paciente, id_categoria, SessaoInicial, HorasInicial) VALUES ('$id_paciente', '$id_categoria', '$SessaoInicial', '$HorasInicial')";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: listar-sessoes.php?id_paciente=$id_paciente&id_sessao=$id_sessao");
exit;
?>
