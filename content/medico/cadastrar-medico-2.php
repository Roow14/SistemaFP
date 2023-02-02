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
$NomeMedico = $_POST['NomeMedico'];
$Crm = $_POST['Crm'];
$Telefone = $_POST['Telefone'];
$Celular = $_POST['Celular'];
$EmailMedico = $_POST['EmailMedico'];
$Anotacao = $_POST['Anotacao'];

// verificar se o médico está cadastrado no sistema
$sql = "SELECT * FROM medico WHERE NomeMedico = '$NomeMedico'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$_SESSION['ErroMedicoExistente'] = 'sim';
		// voltar
		header("Location: cadastrar-medico.php");
		exit;
    }
} else {
}

// inserir
$sql = "INSERT INTO medico (NomeMedico) VALUES ('$NomeMedico')";
if ($conn->query($sql) === TRUE) {
	echo $sql;
	echo '<br>';
} else {
	echo 'Erro: '.$sql;
	echo '<br>';
}

// buscar recém criado
$sql = "SELECT * FROM medico ORDER BY Timestamp DESC LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_medico = $row['id_medico'];
		echo $sql;
		echo '<br>';
    }
} else {
	echo 'Erro: '.$sql;
	echo '<br>';
}

// atualizar
if (empty($_POST['Crm'])) {
} else {
	$sql = "UPDATE medico SET Crm = '$Crm' WHERE id_medico = '$id_medico' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// atualizar
if (empty($_POST['Anotacao'])) {
} else {
	$sql = "UPDATE medico SET Anotacao = '$Anotacao' WHERE id_medico = '$id_medico' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// email
if (empty($_POST['EmailMedico'])) {
} else {
	// inserir
	$sql = "INSERT INTO email_medico (EmailMedico, id_medico, Status) VALUES ('$EmailMedico', '$id_medico', 1)";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// telefone
if (empty($_POST['Telefone'])) {
} else {
	// inserir
	$sql = "INSERT INTO telefone_medico (Telefone, id_medico, Tipo, Status) VALUES ('$Telefone', '$id_medico', 1, 1)";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// celular
if (empty($_POST['Celular'])) {
} else {
	// inserir
	$sql = "INSERT INTO telefone_medico (Telefone, id_medico, Tipo, Status) VALUES ('$Celular', '$id_medico', 3, 1)";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// voltar
header("Location: medico.php?id_medico=$id_medico");
exit;
?>
