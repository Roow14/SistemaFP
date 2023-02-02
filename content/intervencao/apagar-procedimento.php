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
$id_procedimento = $_GET['id_procedimento'];

// verificar se o procedimento foi utilizada
$sql = "SELECT * FROM prog_objetivo_paciente WHERE id_procedimento = '$id_procedimento'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		// mensagem de alerta
		echo "<script type=\"text/javascript\">
		    alert(\"Erro: o procedimento está sendo utilizado.\");
		    window.location = \"cadastrar-procedimento.php\"
		    </script>";
	    exit;
    }
} else {
	// não tem
	echo 'não tem';
	// apagar
	$sqlA = "DELETE FROM prog_procedimento WHERE id_procedimento = '$id_procedimento'";
	if ($conn->query($sqlA) === TRUE) {
		echo 'Procedimento apagado';
	} else {
		echo 'O procedimento não foi apagado.';
	}
}

// voltar
header("Location: cadastrar-procedimento.php");
exit;
?>
