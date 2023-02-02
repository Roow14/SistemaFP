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
$id_escola = $_GET['id_escola'];

$NumeroTel = $_POST['NumeroTel'];
$Tipo = $_POST['Tipo'];
$NotaTel = $_POST['NotaTel'];

$NumeroCel = $_POST['NumeroCel'];
$NotaCel = $_POST['NotaCel'];

$EmailEscola = $_POST['EmailEscola'];
$NotaEmail = $_POST['NotaEmail'];

// e-mail
if (empty($_POST['EmailEscola'])) {
} else {
	// inserir
	$sql = "INSERT INTO email_escola (id_escola, EmailEscola) VALUES ('$id_escola', '$EmailEscola')";
	if ($conn->query($sql) === TRUE) {
	} else {
	}

	// buscar xxx
	$sql = "SELECT * FROM email_escola ORDER BY id_email_escola DESC LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$id_email_escola = $row['id_email_escola'];
	    }
	} else {
	}


	if (empty($_POST['NotaEmail'])) {
	} else {
		// atualizar
		$sql = "UPDATE email_escola SET NotaEmail = '$NotaEmail' WHERE id_email_escola = '$id_email_escola' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}
}

// telefone
if (empty($_POST['NumeroTel'])) {
} else {
	// inserir
	$sql = "INSERT INTO telefone_escola (id_escola, NumeroTel, ClasseTel) VALUES ('$id_escola', '$NumeroTel', 1)";
	if ($conn->query($sql) === TRUE) {
	} else {
	}

	// buscar xxx
	$sql = "SELECT * FROM telefone_escola ORDER BY id_telefone_escola DESC LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$id_telefone_escola = $row['id_telefone_escola'];
	    }
	} else {
	}

	if (empty($_POST['Tipo'])) {
	} else {
		// atualizar
		$sql = "UPDATE telefone_escola SET Tipo = '$Tipo' WHERE id_telefone_escola = '$id_telefone_escola' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}

	if (empty($_POST['NotaTel'])) {
	} else {
		// atualizar
		$sql = "UPDATE telefone_escola SET NotaTel = '$NotaTel' WHERE id_telefone_escola = '$id_telefone_escola' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}
}

// celular
if (empty($_POST['NumeroCel'])) {
} else {
	// inserir
	$sql = "INSERT INTO telefone_escola (id_escola, NumeroTel, ClasseTel) VALUES ('$id_escola', '$NumeroCel', 2)";
	if ($conn->query($sql) === TRUE) {
	} else {
	}

	// buscar xxx
	$sql = "SELECT * FROM telefone_escola ORDER BY id_telefone_escola DESC LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$id_telefone_escola = $row['id_telefone_escola'];
	    }
	} else {
	}

	if (empty($_POST['NotaCel'])) {
	} else {
		// atualizar
		$sql = "UPDATE telefone_escola SET NotaTel = '$NotaCel' WHERE id_telefone_escola = '$id_telefone_escola' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}
}

// voltar
header("Location: cadastrar-telefone-email-escola.php?id_escola=$id_escola");
exit;
?>
