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

// verificar se o objetivo foi utilizada
$sql = "SELECT * FROM prog_objetivo_paciente WHERE id_objetivo = '$id_objetivo'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		// mensagem de alerta
		echo "<script type=\"text/javascript\">
		    alert(\"Erro: o objetivo está sendo utilizado.\");
		    window.location = \"cadastrar-objetivo.php\"
		    </script>";
	    exit;
    }
} else {
	// não tem
	echo 'não tem';
	// apagar
	$sqlA = "DELETE FROM prog_objetivo WHERE id_objetivo = '$id_objetivo'";
	if ($conn->query($sqlA) === TRUE) {
		echo 'Objetivo apagado';
	} else {
		echo 'O objetivo não foi apagado.';
	}
}

// voltar
header("Location: cadastrar-objetivo.php");
exit;
?>
