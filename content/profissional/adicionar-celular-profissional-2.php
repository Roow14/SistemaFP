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
$id_profissional = $_GET['id_profissional'];
$ClasseTel = 2;
$NumeroTel = $_POST['NumeroTel'];
$NotaTel = $_POST['NotaTel'];

if (empty($_POST['NumeroTel'])) {
} else {
	// inserir
	$sql = "INSERT INTO telefone_profissional (id_profissional, NumeroTel, ClasseTel) VALUES ('$id_profissional', '$NumeroTel', '$ClasseTel')";
	if ($conn->query($sql) === TRUE) {
	} else {
	}

	// buscar xxx
	$sql = "SELECT * FROM telefone_profissional ORDER BY Timestamp DESC LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$id_telefone_profissional = $row['id_telefone_profissional'];
	    }
	} else {
	}

	if (empty($_POST['NotaTel'])) {
	} else {
		// atualizar
		$sql = "UPDATE telefone_profissional SET NotaTel = '$NotaTel' WHERE id_telefone_profissional = '$id_telefone_profissional' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}
}

// voltar
header("Location: profissional.php?id_profissional=$id_profissional");
exit;
?>
