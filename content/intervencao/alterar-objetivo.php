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
$id_objetivo = $_GET['id_objetivo'];
$NomeObjetivo = $_POST['NomeObjetivo'];

if (empty($_POST['NomeObjetivo'])) {
	// mensagem de alerta
	echo "<script type=\"text/javascript\">
	    alert(\"Erro: O nome do objetivo está vazio.\");
	    window.location = \"cadastrar-objetivo.php\"
	    </script>";
	exit;
} else {
}

// verificar se o nome está duplicado
$sql = "SELECT * FROM prog_objetivo WHERE NomeObjetivo = '$NomeObjetivo'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// mensagem de alerta
		echo "<script type=\"text/javascript\">
		    alert(\"Erro: existe um objetivo com o mesmo nome cadastrado no sistema. Digite outro objetivo.\");
		    window.location = \"cadastrar-objetivo.php\"
		    </script>";
		exit;
    }
} else {
}

// atualizar
$sql = "UPDATE prog_objetivo SET NomeObjetivo = '$NomeObjetivo' WHERE id_objetivo = '$id_objetivo' ";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: cadastrar-objetivo.php");
exit;
?>
