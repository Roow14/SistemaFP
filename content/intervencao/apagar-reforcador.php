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

// verificar se o reforcador foi utilizada
$sql = "SELECT * FROM prog_objetivo_paciente WHERE id_reforcador = '$id_reforcador'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		// mensagem de alerta
		echo "<script type=\"text/javascript\">
		    alert(\"Erro: o reforcador está sendo utilizado.\");
		    window.location = \"cadastrar-reforcador.php\"
		    </script>";
	    exit;
    }
} else {
	// não tem
	echo 'não tem';
	// apagar
	$sqlA = "DELETE FROM prog_reforcador WHERE id_reforcador = '$id_reforcador'";
	if ($conn->query($sqlA) === TRUE) {
		echo 'Reforcador apagado';
	} else {
		echo 'O reforcador não foi apagado.';
	}
}

// voltar
header("Location: cadastrar-reforcador.php");
exit;
?>
