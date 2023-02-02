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
$id_midia_avaliacao = $_GET['id_midia_avaliacao'];
$ArquivoMidia = $_GET['ArquivoMidia'];

// buscar xxx
$sql = "SELECT * FROM midia_avaliacao WHERE id_midia_avaliacao = '$id_midia_avaliacao'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$ArquivoMidia = $row['ArquivoMidia'];
		$Arquivo = '../../vault/avaliacao/'.$ArquivoMidia;
		unlink($Arquivo);
    }
} else {
}

// apagar
$sql = "DELETE FROM midia_avaliacao WHERE id_midia_avaliacao = '$id_midia_avaliacao'";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: listar-avaliacoes.php?id_paciente=$id_paciente");
exit;
