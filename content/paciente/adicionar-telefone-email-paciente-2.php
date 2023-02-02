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

$NumeroTel = $_POST['NumeroTel'];
$Tipo = $_POST['Tipo'];
$NotaTel = $_POST['NotaTel']; 

$NumeroCel = $_POST['NumeroCel'];
$NotaCel = $_POST['NotaCel'];

$EmailPaciente = $_POST['EmailPaciente'];
$NotaEmail = $_POST['NotaEmail'];

// e-mail
if (empty($_POST['EmailPaciente'])) {
} else {
	// inserir
	$sql = "INSERT INTO email_paciente (id_paciente, EmailPaciente) VALUES ('$id_paciente', '$EmailPaciente')";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
	

	// buscar xxx
	$sql = "SELECT * FROM email_paciente ORDER BY id_email_paciente DESC LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$id_email_paciente = $row['id_email_paciente'];
	    }
	} else {
	}

	

	if (empty($_POST['NotaEmail'])) {
	} else {
		// atualizar
		$sql = "UPDATE email_paciente SET NotaEmail = '$NotaEmail' WHERE id_email_paciente = '$id_email_paciente' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}
	
}

// telefone
if (empty($_POST['NumeroTel'])) {
} else {
	// inserir
	$sql = "INSERT INTO telefone_paciente (id_paciente, NumeroTel, ClasseTel) VALUES ('$id_paciente', '$NumeroTel', 1)";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
	

	// buscar xxx
	$sql = "SELECT * FROM telefone_paciente ORDER BY id_telefone_paciente DESC LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$id_telefone_paciente = $row['id_telefone_paciente'];
	    }
	} else {
	}

	if (empty($_POST['Tipo'])) {
	} else {
		// atualizar
		$sql = "UPDATE telefone_paciente SET Tipo = '$Tipo' WHERE id_telefone_paciente = '$id_telefone_paciente' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}
	

	if (empty($_POST['NotaTel'])) {
	} else {
		// atualizar
		$sql = "UPDATE telefone_paciente SET NotaTel = '$NotaTel' WHERE id_telefone_paciente = '$id_telefone_paciente' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}
	
}

// celular
if (empty($_POST['NumeroCel'])) {
} else {
	// inserir
	$sql = "INSERT INTO telefone_paciente (id_paciente, NumeroTel, ClasseTel) VALUES ('$id_paciente', '$NumeroCel', 2)";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
	

	// buscar xxx
	$sql = "SELECT * FROM telefone_paciente ORDER BY id_telefone_paciente DESC LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$id_telefone_paciente = $row['id_telefone_paciente'];
	    }
	} else {
	}

	if (empty($_POST['NotaCel'])) {
	} else {
		// atualizar
		$sql = "UPDATE telefone_paciente SET NotaTel = '$NotaCel' WHERE id_telefone_paciente = '$id_telefone_paciente' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}
	
}

// voltar
header("Location: cadastrar-alterar-telefone-email-paciente.php?id_paciente=$id_paciente");
exit;
?>
