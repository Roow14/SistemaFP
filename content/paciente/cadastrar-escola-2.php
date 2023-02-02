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
$NomeEscola = $_POST['NomeEscola'];
$Endereco = $_POST['Endereco'];	
$Numero = $_POST['Numero'];	
$Complemento = $_POST['Complemento'];	
$Cep = $_POST['Cep'];	
$Bairro = $_POST['Bairro'];	
$Cidade = $_POST['Cidade'];	
$Estado = $_POST['Estado'];
$Observacao = $_POST['Observacao'];

// inserir
$sql = "INSERT INTO escola (NomeEscola) VALUES ('$NomeEscola')";
if ($conn->query($sql) === TRUE) {
} else {
}

// buscar xxx
$sql = "SELECT * FROM escola ORDER BY id_escola DESC LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_escola = $row['id_escola'];
    }
} else {
}

if (empty($_POST['Observacao'])) {
} else {
	// atualizar
	$sql = "UPDATE escola SET Observacao = '$Observacao' WHERE id_escola = '$id_escola' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// inserir
$sql = "INSERT INTO escola_paciente (id_escola) VALUES ('$id_escola')";
if ($conn->query($sql) === TRUE) {
} else {
}

if (empty($_POST['Endereco'])) {
} else {
	// atualizar
	$sql = "UPDATE endereco_escola SET Endereco = '$Endereco' WHERE id_escola = '$id_escola' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
	// inserir
	$sql = "INSERT INTO endereco_escola (Endereco, id_escola) VALUES ('$Endereco', '$id_escola')";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
	// buscar xxx
	$sql = "SELECT * FROM endereco_escola ORDER BY id_endereco_escola DESC LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$id_endereco_escola = $row['id_endereco_escola'];
	    }
	} else {
	}
	if (empty($_POST['Numero'])) {
		// atualizar
		$sql = "UPDATE endereco_escola SET Numero = NULL WHERE id_endereco_escola = '$id_endereco_escola' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	} else {
		// atualizar
		$sql = "UPDATE endereco_escola SET Numero = '$Numero' WHERE id_endereco_escola = '$id_endereco_escola' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}

	if (empty($_POST['Complemento'])) {
		// atualizar
		$sql = "UPDATE endereco_escola SET Complemento = NULL WHERE id_endereco_escola = '$id_endereco_escola' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	} else {
		// atualizar
		$sql = "UPDATE endereco_escola SET Complemento = '$Complemento' WHERE id_endereco_escola = '$id_endereco_escola' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}

	if (empty($_POST['Cep'])) {
		// atualizar
		$sql = "UPDATE endereco_escola SET Cep = NULL WHERE id_endereco_escola = '$id_endereco_escola' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	} else {
		// atualizar
		$sql = "UPDATE endereco_escola SET Cep = '$Cep' WHERE id_endereco_escola = '$id_endereco_escola' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}

	if (empty($_POST['Bairro'])) {
		// atualizar
		$sql = "UPDATE endereco_escola SET Bairro = NULL WHERE id_endereco_escola = '$id_endereco_escola' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	} else {
		// atualizar
		$sql = "UPDATE endereco_escola SET Bairro = '$Bairro' WHERE id_endereco_escola = '$id_endereco_escola' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}

	if (empty($_POST['Cidade'])) {
		// atualizar
		$sql = "UPDATE endereco_escola SET Cidade = NULL WHERE id_endereco_escola = '$id_endereco_escola' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	} else {
		// atualizar
		$sql = "UPDATE endereco_escola SET Cidade = '$Cidade' WHERE id_endereco_escola = '$id_endereco_escola' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}

	if (empty($_POST['Estado'])) {
		// atualizar
		$sql = "UPDATE endereco_escola SET Estado = NULL WHERE id_endereco_escola = '$id_endereco_escola' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	} else {
		// atualizar
		$sql = "UPDATE endereco_escola SET Estado = '$Estado' WHERE id_endereco_escola = '$id_endereco_escola' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}
}

unset($_SESSION['AtivarCadastroEscola']);

// voltar
header("Location: escola.php?id_escola=$id_escola.php");
exit;
?>
