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
$id_reforcador = $_GET['id_reforcador'];
$NomeReforcador = $_POST['NomeReforcador'];

if (empty($_POST['NomeReforcador'])) {
	// mensagem de alerta
	echo "<script type=\"text/javascript\">
	    alert(\"Erro: O nome do reforcador está vazio.\");
	    window.location = \"cadastrar-reforcador.php\"
	    </script>";
	exit;
} else {
}

// verificar se o nome está duplicado
$sql = "SELECT * FROM prog_reforcador WHERE NomeReforcador = '$NomeReforcador'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// mensagem de alerta
		echo "<script type=\"text/javascript\">
		    alert(\"Erro: existe um reforcador com o mesmo nome cadastrado no sistema. Digite outro reforcador.\");
		    window.location = \"cadastrar-reforcador.php\"
		    </script>";
		exit;
    }
} else {
}

// atualizar
$sql = "UPDATE prog_reforcador SET NomeReforcador = '$NomeReforcador' WHERE id_reforcador = '$id_reforcador' ";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: cadastrar-reforcador.php");
exit;
?>
