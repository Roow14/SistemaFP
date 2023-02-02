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
$Categoria = $_POST['Categoria'];

// input múlitplo
// exames
foreach ($_POST['Categoria'] as $Item => $Valor) {
	echo $Item.' > '.$Valor.'<br>';

	// verificar se a categoria está cadastrada
	$sql = "SELECT * FROM categoria_paciente WHERE id_categoria = '$Valor' AND id_paciente = '$id_paciente' ";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	    	// está cadastrada
	    }
	} else {
		// inserir
		$sql = "INSERT INTO categoria_paciente (id_categoria, id_paciente) VALUES ('$Valor', '$id_paciente')";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}
}

unset($_SESSION['AtivarAlteracaoCategoria']);

// voltar
header("Location: categoria-paciente.php?id_paciente=$id_paciente");
exit;
