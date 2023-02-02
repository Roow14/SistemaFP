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
$id_medico = $_GET['id_medico'];
$NomeMedico = $_POST['NomeMedico'];
$Crm = $_POST['Crm'];
$Anotacao = $_POST['Anotacao'];
$EmailMedico = $_POST['EmailMedico'];
$Telefone = $_POST['Telefone'];
$Celular = $_POST['Celular'];

// atualizar
$sql = "UPDATE medico SET NomeMedico = '$NomeMedico' WHERE id_medico = '$id_medico' ";
if ($conn->query($sql) === TRUE) {
} else {
}

// atualizar
$sql = "UPDATE medico SET Crm = '$Crm' WHERE id_medico = '$id_medico' ";
if ($conn->query($sql) === TRUE) {
} else {
}

// atualizar
$sql = "UPDATE medico SET Anotacao = '$Anotacao' WHERE id_medico = '$id_medico' ";
if ($conn->query($sql) === TRUE) {
} else {
}

// email
if (empty($_POST['EmailMedico'])) {
	// verificar se está cadastrado
	$sql = "SELECT * FROM email_medico WHERE id_medico = '$id_medico' AND Status = 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$id_email_medico = $row['id_email_medico'];
			// apagar
			$sqlA = "DELETE FROM email_medico WHERE id_email_medico = '$id_email_medico'";
			if ($conn->query($sqlA) === TRUE) {
				echo 'email foi removido com sucesso';
			} else {
			}
	    }
	} else {
		echo 'não existe email';
	}
} else {
	// buscar
	$sql = "SELECT * FROM email_medico WHERE id_medico = '$id_medico' AND Status = 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$id_email_medico = $row['id_email_medico'];
			// atualizar
			$sqlA = "UPDATE email_medico SET EmailMedico = '$EmailMedico' WHERE id_email_medico = '$id_email_medico'";
			if ($conn->query($sqlA) === TRUE) {
				echo 'email cadastrado com sucesso';
			} else {
				echo 'erro ao cadastrar email '.$sql;
			}
	    }
	} else {
		// inserir
		$sqlA = "INSERT INTO email_medico (EmailMedico, id_medico, Status) VALUES ('$EmailMedico', '$id_medico', 1)";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
	}
}

// telefone
if (empty($_POST['Telefone'])) {
	// verificar se está cadastrado
	$sql = "SELECT * FROM telefone_medico WHERE Telefone = '$Telefone' AND Tipo = 1 AND Status = 1 AND id_medico = '$id_medico'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$id_telefone_medico = $row['id_telefone_medico'];
			// apagar
			$sqlA = "DELETE FROM telefone_medico WHERE id_telefone_medico = '$id_telefone_medico'";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
	    }
	} else {
	}
} else {
	// verificar se está cadastrado
	$sql = "SELECT * FROM telefone_medico WHERE Telefone = '$Telefone' AND Tipo = 1 AND Status = 1 AND id_medico = '$id_medico'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$id_telefone_medico = $row['id_telefone_medico'];
			// atualizar
			$sqlA = "UPDATE telefone_medico SET Telefone = '$Telefone', Tipo = 1 WHERE id_telefone_medico = '$id_telefone_medico'";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
	    }
	} else {
		// inserir
		$sqlA = "INSERT INTO telefone_medico (Telefone, id_medico, Tipo, Status) VALUES ('$Telefone', '$id_medico', 1, 1)";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
	}
}

// celular
if (empty($_POST['Celular'])) {
	// verificar se está cadastrado
	$sql = "SELECT * FROM telefone_medico WHERE Telefone = '$Celular' AND Tipo = 3 AND Status = 1 AND id_medico = '$id_medico'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$id_telefone_medico = $row['id_telefone_medico'];
			// apagar
			$sqlA = "DELETE FROM telefone_medico WHERE id_telefone_medico = '$id_telefone_medico'";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
	    }
	} else {
	}
} else {
	// verificar se está cadastrado
	$sql = "SELECT * FROM telefone_medico WHERE Telefone = '$Celular' AND Tipo = 3 AND Status = 1 AND id_medico = '$id_medico'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$id_telefone_medico = $row['id_telefone_medico'];
			// atualizar
			$sqlA = "UPDATE telefone_medico SET Telefone = '$Celular' WHERE id_telefone_medico = '$id_telefone_medico'";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
	    }
	} else {
		// inserir
		$sqlA = "INSERT INTO telefone_medico (Telefone, id_medico, Tipo, Status) VALUES ('$Celular', '$id_medico', 3, 1)";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
	}
}

// voltar
header("Location: alterar-medico.php?id_medico=$id_medico");
exit;
?>