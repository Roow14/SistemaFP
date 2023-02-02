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
$id_midia = $_GET['id_midia'];

// buscar xxx
$sql = "SELECT * FROM midia_ajuda WHERE id_midia = '$id_midia'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$ArquivoMidia = $row['ArquivoMidia'];
		$Arquivo = '../../vault/ajuda/'.$ArquivoMidia;
		unlink($Arquivo);
    }
} else {
}

// apagar
$sql = "DELETE FROM midia_ajuda WHERE id_midia = '$id_midia'";
if ($conn->query($sql) === TRUE) {
} else {
}

unset($_SESSION['AtivarRemocaoAvaliacao']);
unset($_SESSION['ApagarArquivoAvaliacao']);

// voltar
header("Location: listar-avaliacoes.php");
exit;
