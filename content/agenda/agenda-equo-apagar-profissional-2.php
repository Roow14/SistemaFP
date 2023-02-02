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
$id_agenda_paciente = $_GET['id_agenda_paciente'];
$id_categoria = 14;

// buscar xxx
$sql = "SELECT * FROM agenda_paciente WHERE id_agenda_paciente = '$id_agenda_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_paciente = $row['id_paciente'];
		$Data = $row['Data'];
		$id_hora = $row['id_hora'];
    }
} else {
	// não tem
}

// verificar quantos terapeutas estão cadastrados no mesmo horário
$sqlC = "SELECT COUNT(id_profissional) AS Soma FROM agenda_paciente WHERE id_paciente = '$id_paciente' AND Data = '$Data' AND id_hora = '$id_hora' AND id_categoria = '$id_categoria'";
$resultC = $conn->query($sqlC);
if ($resultC->num_rows > 0) {
	// tem
	while($rowC = $resultC->fetch_assoc()) {
		$Soma = $rowC['Soma'];
	}
// não tem
} else {
	$Soma = NULL;
}

if ($Soma > 1) {
	// apagar
	$sql = "DELETE FROM agenda_paciente WHERE id_agenda_paciente = '$id_agenda_paciente'";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// mensagem de alerta
	echo "<script type=\"text/javascript\">
	    alert(\"Erro: o terapeuta principal não pode ser removido. Clique no nome do paciente e na agenda do paciente, apague o terapeuta.\");
	    window.location = \"agenda-equo.php\"
	    </script>";
	exit;
}

// voltar
header("Location: agenda-equo.php");
exit;
?>
