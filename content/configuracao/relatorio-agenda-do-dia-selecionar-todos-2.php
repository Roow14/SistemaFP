<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

date_default_timezone_set("America/Sao_Paulo");
$DataAtualX = date("d/m/Y");
$DataAtual = date("Y-m-d");

// conexão com banco
include '../conexao/conexao.php';

// input
$Presenca = $_POST['Presenca'];
$Origem  = 'relatorio-agenda-do-dia.php';
unset($_SESSION['id_paciente']);
unset($_SESSION['id_profissional']);
 	
if (empty($_SESSION['DataAgenda'])) {
	$_SESSION['DataAgenda'] = $DataAtual;
	$DataAgenda = $DataAtual;
} else {
	$DataAgenda = $_SESSION['DataAgenda'];
}
$DataAgendaX = date("d/m/Y", strtotime($DataAgenda));

// dia da semana
setlocale(LC_TIME,"pt");
$DiaSemana = strftime("%A", strtotime($DataAgenda));

if (empty($_SESSION['PesquisaPaciente'])) {
	$PesquisaPaciente = NULL;
	$FiltroPaciente = NULL;
} else {
	$PesquisaPaciente = $_SESSION['PesquisaPaciente'];
	$FiltroPaciente = 'AND paciente.NomeCompleto LIKE "%'.$PesquisaPaciente.'%"';
}

if (empty($_SESSION['PesquisaTerapeuta'])) {
	$PesquisaTerapeuta = NULL;
	$FiltroTerapeuta = NULL;
} else {
	$PesquisaTerapeuta = $_SESSION['PesquisaTerapeuta'];
	$FiltroTerapeuta = 'AND profissional.NomeCompleto LIKE "%'.$PesquisaTerapeuta.'%"';
}

if (empty($_SESSION['id_hora'])) {
	$id_hora = NULL;
	$FiltroHora = NULL;
	$Hora = 'Selecionar';
} else {
	$id_hora = $_SESSION['id_hora'];
	$FiltroHora = 'AND agenda_paciente.id_hora ='.$id_hora;
	// buscar xxx
	$sql = "SELECT * FROM hora WHERE id_hora = '$id_hora'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$Hora = $row['Hora'];
	    }
	} else {
		// não tem
	}
}

// filtrar por unidade
if (empty($_SESSION['id_unidade'])) {
	$id_unidade = NULL;
	$NomeUnidade = 'Todos';
	$FiltroUnidade = NULL;
} else {
	$id_unidade = $_SESSION['id_unidade'];
	// buscar xxx
	$sql = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$NomeUnidade = $row['NomeUnidade'];
			$FiltroUnidade = 'AND paciente.id_unidade ='.$id_unidade;
	    }
	} else {
		// não tem
	}
}

$sql = "SELECT COUNT(agenda_paciente.id_paciente) AS Soma
FROM agenda_paciente
INNER JOIN paciente ON agenda_paciente.id_paciente = paciente.id_paciente
INNER JOIN profissional ON agenda_paciente.id_profissional = profissional.id_profissional
WHERE agenda_paciente.Data = '$DataAgenda'
$FiltroPaciente $FiltroTerapeuta $FiltroHora $FiltroUnidade";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	// tem
	while($row = $result->fetch_assoc()) {
		$Soma = $row['Soma'];
	}
// não tem
} else {
}

if ((empty($_SESSION['PageOffset']))) {
    $PageOffset = NULL;
    $PageOffset1 = NULL;
} else {
    $PageOffset = $_SESSION['PageOffset'];
    $PageOffset1 = 'OFFSET '.$PageOffset;
}

// buscar xxx
$id_usuario = $_SESSION['UsuarioID'];
$sql = "SELECT * FROM configuracao WHERE Variavel = 'ItensPorPagina' AND id_usuario = '$id_usuario'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // tem
        $ItensPorPagina = $row['Valor'];
    }
} else {
    // não tem
    $ItensPorPagina = 10;
}

$TotalPaginas = round($Soma / $ItensPorPagina) + 1;
$NumeroPagina = ($PageOffset / $ItensPorPagina) + 1;

// buscar xxx
$sql = "SELECT agenda_paciente.*, paciente.NomeCompleto
FROM agenda_paciente
INNER JOIN paciente ON agenda_paciente.id_paciente = paciente.id_paciente
INNER JOIN profissional ON agenda_paciente.id_profissional = profissional.id_profissional
WHERE agenda_paciente.Data = '$DataAgenda'
$FiltroPaciente $FiltroTerapeuta $FiltroHora $FiltroUnidade
ORDER BY agenda_paciente.id_hora ASC, paciente.NomeCompleto ASC
LIMIT $ItensPorPagina $PageOffset1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_agenda_paciente = $row['id_agenda_paciente'];
		$id_paciente = $row['id_paciente'];
		$id_profissional = $row['id_profissional'];
		$id_hora = $row['id_hora'];
		$id_categoria = $row['id_categoria'];
		$id_unidade = $row['id_unidade'];
		$Convenio = $row['Convenio'];
		$id_convenio_validado = $row['id_convenio_validado'];

		if (!empty($id_convenio_validado)) {
			// atualizar
			$sqlA = "UPDATE agenda_paciente SET Presenca = '$Presenca' WHERE id_agenda_paciente = '$id_agenda_paciente' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
		}
    }
} else {
	// não tem
}

// voltar
header("Location: relatorio-agenda-do-dia.php");
exit;
?>