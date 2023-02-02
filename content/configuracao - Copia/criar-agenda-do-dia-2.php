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
$Data = $_POST['Dia'];
// dia da semana
setlocale(LC_TIME,"pt");
$DiaSemana = ((strftime("%w", strtotime($Data))) + 1);

// verificar se a semana está criada
$sql = "SELECT * FROM agenda_paciente WHERE Data = '$Data'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		// mensagem de alerta
		echo "<script type=\"text/javascript\">
		    alert(\"Erro: A agenda desta data já está cadastrada no sistema. Selecione uma nova data.\");
		    window.location = \"criar-agenda-da-semana.php\"
		    </script>";
		exit;
    }
} else {
	// não tem
	// buscar xxx
	$sqlA = "SELECT * FROM agenda_paciente_base WHERE DiaSemana = '$DiaSemana'";
	$resultA = $conn->query($sqlA);
	if ($resultA->num_rows > 0) {
	    while($rowA = $resultA->fetch_assoc()) {
			// tem
			$id_paciente = $rowA['id_paciente'];
			$id_profissional = $rowA['id_profissional'];
			$id_unidade = $rowA['id_unidade'];
			$id_categoria = $rowA['id_categoria'];
			$id_hora = $rowA['id_hora'];
			$id_periodo = $rowA['id_periodo'];
				
			// inserir
			$sqlB = "INSERT INTO agenda_paciente (id_paciente, id_profissional, id_unidade, id_categoria, id_hora, id_periodo, Data, DiaSemana) VALUES ('$id_paciente', '$id_profissional', '$id_unidade', '$id_categoria', '$id_hora', '$id_periodo', '$Data', '$DiaSemana')";
			if ($conn->query($sqlB) === TRUE) {
			} else {
			}
	    }
	} else {
		// não tem
	}

}

// mensagem de alerta
// echo "<script type=\"text/javascript\">
// alert(\"Sucesso: a agenda do dia foi criada.\");
// window.location = \"criar-agenda-da-semana.php\"
// </script>";
// exit;

// voltar
header("Location: criar-agenda-da-semana.php");
exit;
?>
