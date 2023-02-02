<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// input
$Valor = $_POST['Valor'];
$Variavel = 'ItensPorPagina';
$id_usuario = $_SESSION['UsuarioID'];
$Origem = $_GET['Origem'];

// buscar xxx
$sql = "SELECT * FROM configuracao WHERE Variavel = '$Variavel' AND id_usuario = '$id_usuario'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_configuracao = $row['id_configuracao'];
		// atualizar
		$sqlA = "UPDATE configuracao SET Valor = '$Valor' WHERE id_configuracao = '$id_configuracao' ";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
    }
} else {
	// não tem
	// inserir
	$sqlA = "INSERT INTO configuracao (Variavel, Valor, id_usuario) VALUES ('$Variavel', '$Valor', '$id_usuario')";
	if ($conn->query($sqlA) === TRUE) {
	} else {
	}
}


// voltar
if (empty($_GET['Origem'])) {
	header("Location: configuracao.php");
} else {
	header("Location: $Origem");
}
exit;
?>
