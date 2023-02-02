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
$id_treino_paciente = $_GET['id_treino_paciente'];
$id_paciente = $_GET['id_paciente'];
$id_reforcador = $_POST['id_reforcador'];

// buscar xxx
$sql = "SELECT * FROM prog_treino_paciente WHERE id_treino_paciente = '$id_treino_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_objetivo_paciente = $row['id_objetivo_paciente'];
    }
} else {
}

// verificar se existe reforcador cadastrado
$sql = "SELECT * FROM prog_reforcador_paciente WHERE id_objetivo_paciente = '$id_objetivo_paciente' AND id_reforcador = '$id_reforcador'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$aa = $row['aa'];
		// mensagem de alerta
		echo "<script type=\"text/javascript\">
		    alert(\"Erro: o reforçador já está selecionado. Selecione um outro reforçador.\");
		    window.location = \"alterar-treino.php?id_treino_paciente=$id_treino_paciente&id_paciente=$id_paciente\"
		    </script>";
		exit;
    }
} else {
	// não tem
	// inserir
	$sql = "INSERT INTO prog_reforcador_paciente (id_reforcador, id_objetivo_paciente, id_paciente) VALUES ('$id_reforcador', '$id_objetivo_paciente', '$id_paciente')";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// voltar
header("Location: alterar-treino.php?id_treino_paciente=$id_treino_paciente&id_paciente=$id_paciente");
exit;
?>
