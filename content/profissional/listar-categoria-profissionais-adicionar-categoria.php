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
$id_profissional = $_POST['id_profissional'];
$id_categoria = $_POST['id_categoria'];
$id_unidade = $_POST['id_unidade'];
$id_periodo = $_POST['id_periodo'];

// verificar se existe igual
$sql = "SELECT * FROM categoria_profissional WHERE id_profissional = '$id_profissional' AND id_categoria = '$id_categoria' AND id_unidade = '$id_unidade' AND id_periodo = '$id_periodo'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		// mensagem de alerta
		echo "<script type=\"text/javascript\">
		    alert(\"Erro: Dados duplicados.\");
		    window.location = \"listar-categoria-profissionais.php\"
		    </script>";
		exit;
    }
} else {
	// não tem
	// inserir
	$sqlA = "INSERT INTO categoria_profissional (id_profissional, id_categoria, id_unidade, id_periodo) VALUES ('$id_profissional', '$id_categoria', '$id_unidade', '$id_periodo')";
	if ($conn->query($sqlA) === TRUE) {
	} else {
	}
}

// voltar
header("Location: listar-categoria-profissionais.php");
exit;
?>
