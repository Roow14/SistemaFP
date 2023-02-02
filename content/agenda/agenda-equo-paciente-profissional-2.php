<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

date_default_timezone_set("America/Sao_Paulo");

// input
$id_paciente = $_GET['id_paciente'];
$Data = $_GET['Data'];
$id_hora = $_GET['id_hora'];
$id_profissional = $_POST['id_profissionalPesq'];
$id_categoria = 14;
$id_unidade = 1;

if (empty($id_profissional)) {
	// mensagem de alerta
	echo "<script type=\"text/javascript\">
	    alert(\"Erro: o terapeuta está agendado neste horário. Selecione um outro terapeuta.\");
	    window.location = \"agenda-equo.php\"
	    </script>";
	exit;
}

// dia da semana
$DataX = date("d-m-Y", strtotime($Data));
setlocale(LC_TIME,"pt");
$DiaSemana = (strftime("%u", strtotime($DataX)));
$DiaSemanaX = $DiaSemana + 1;

// buscar xxx
$sql = "SELECT * FROM hora WHERE id_hora = '$id_hora'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_periodo = $row['Periodo'];
    }
} else {
	// não tem
}

// verificar se o profissional já está cadastrado neste horário
// buscar xxx
$sql = "SELECT * FROM agenda_paciente WHERE id_profissional = '$id_profissional' AND Data = '$Data' AND id_hora = '$id_hora'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		// mensagem de alerta
		echo "<script type=\"text/javascript\">
		    alert(\"Erro: o terapeuta já está cadastrado neste horário.\");
		    window.location = \"agenda-equo.php\"
		    </script>";
		exit;
    }
} else {
	// não tem
}

// inserir
$sql = "INSERT INTO agenda_paciente (id_paciente, id_profissional, Data, id_hora, id_categoria, id_unidade, id_periodo, DiaSemana, Auxiliar) VALUES ('$id_paciente', '$id_profissional', '$Data', '$id_hora', '$id_categoria', '$id_unidade', '$id_periodo', '$DiaSemanaX', 1)";
if ($conn->query($sql) === TRUE) {
} else {
}

// // verificar quantos terapeutas estão cadastrados no mesmo horário
// $sql = "SELECT COUNT(id_profissional) AS Soma FROM agenda_paciente WHERE id_paciente = '$id_paciente' AND Data = '$Data' AND id_hora = '$id_hora' AND id_categoria = '$id_categoria'";
// $result = $conn->query($sql);
// if ($result->num_rows > 0) {
// 	// tem
// 	while($row = $result->fetch_assoc()) {
// 		$Soma = $row['Soma'];
// 	}
// // não tem
// } else {
// 	$Soma = NULL;
// }

// if ($Soma > 2) {
// 	// mensagem de alerta
// 	echo "<script type=\"text/javascript\">
// 	    alert(\"Erro: Tem 2 terapeutas cadastrados neste horário.\");
// 	    window.location = \"agenda-equo.php\"
// 	    </script>";
// 	exit;
// } else {
// 	// inserir
// 	$sql = "INSERT INTO agenda_paciente (id_paciente, id_profissional, Data, id_hora, id_categoria, id_unidade, id_periodo, DiaSemana, Auxiliar) VALUES ('$id_paciente', '$id_profissional', '$Data', '$id_hora', '$id_categoria', '$id_unidade', '$id_periodo', '$DiaSemanaX', 1)";
// 	if ($conn->query($sql) === TRUE) {
// 	} else {
// 	}
// }
	


// voltar
header("Location: agenda-equo.php");
exit;
?>
