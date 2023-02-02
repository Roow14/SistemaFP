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
$EmailProfissional = $_POST['EmailProfissional'];
$NotaEmail = $_POST['NotaEmail'];

if (empty($_POST['EmailProfissional'])) {
} else {
	// inserir
	$sql = "INSERT INTO email_profissional (id_profissional, EmailProfissional) VALUES ('$id_profissional', '$EmailProfissional')";
	if ($conn->query($sql) === TRUE) {
	} else {
	}

	// buscar xxx
	$sql = "SELECT * FROM email_profissional ORDER BY Timestamp DESC LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$id_email_profissional = $row['id_email_profissional'];
	    }
	} else {
	}

	if (empty($_POST['NotaEmail'])) {
	} else {
		// atualizar
		$sql = "UPDATE email_profissional SET NotaEmail = '$NotaEmail' WHERE id_email_profissional = '$id_email_profissional' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}	
}

// voltar
header("Location: profissional.php?id_profissional=$id_profissional");
exit;
?>
