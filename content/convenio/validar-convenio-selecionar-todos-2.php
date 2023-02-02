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
$Validar = $_POST['Validar'];

if (!empty($_SESSION['DataAgenda'])) {
	$DataAgenda = $_SESSION['DataAgenda'];
	
} else {
	$_SESSION['DataAgenda'] = $DataAtual;
	$DataAgenda = $DataAtual;
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

if (!empty($_SESSION['id_categoria'])) {
	$id_categoria = $_SESSION['id_categoria'];
	$FiltroCategoria = 'AND categoria.id_categoria = '.$id_categoria;
	$sql = "SELECT * FROM categoria WHERE id_categoria = '$id_categoria'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$NomeCategoria = $row['NomeCategoria'];
	    }
	} else {
		// não tem
	}
} else {
	$id_categoria = NULL;
	$FiltroCategoria = NULL;
	$NomeCategoria = 'Selecionar';
}

if (!empty($_SESSION['id_convenio'])) {
	$id_convenio = $_SESSION['id_convenio'];
	$FiltroConvenio = 'AND convenio_paciente.id_convenio = '.$id_convenio;
	$sql = "SELECT * FROM convenio WHERE id_convenio = '$id_convenio'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$NomeConvenio = $row['NomeConvenio'];
	    }
	} else {
		// não tem
	}
} else {
	$id_convenio = NULL;
	$FiltroConvenio = NULL;
	$NomeConvenio = 'Selecionar';
}

if (!empty($_SESSION['Presenca'])) {	
	$Presenca1 = $_SESSION['Presenca'];
	if ($Presenca1 == 1) {
		$NomePresenca1 = 'Agendado';
	} elseif ($Presenca1 == 2) {
		$NomePresenca1 = 'Realizado';
	} elseif ($Presenca1 == 3) {
		$NomePresenca1 = 'Cancelado';
	} elseif ($Presenca1 == 4) {
		$NomePresenca1 = 'Outros';
	} else {
		$NomePresenca1 = 'Selecionar';
	}
	$FiltroPresenca = 'AND agenda_paciente.Presenca = '.$Presenca1;
} else {
	$FiltroPresenca = NULL;
	$NomePresenca1 = 'Selecionar';
	$Presenca1 = NULL;
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

// total
$sql = "SELECT COUNT(id_agenda_paciente) AS Soma
FROM agenda_paciente
INNER JOIN paciente ON paciente.id_paciente = agenda_paciente.id_paciente
INNER JOIN hora ON hora.id_hora = agenda_paciente.id_hora
INNER JOIN categoria ON categoria.id_categoria = agenda_paciente.id_categoria
INNER JOIN convenio_paciente ON convenio_paciente.id_paciente = agenda_paciente.id_paciente
WHERE agenda_paciente.Data = '$DataAgenda' AND convenio_paciente.StatusConvenio = 1
$FiltroPaciente $FiltroCategoria $FiltroConvenio $FiltroPresenca $FiltroHora
";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	// tem
	while($row = $result->fetch_assoc()) {
		$Soma = $row['Soma'];
	}
// não tem
} else {
	$Soma = NULL;
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
$sql = "SELECT 
agenda_paciente.*,
paciente.NomeCompleto, 
hora.Hora, 
categoria.NomeCategoria, 
convenio_paciente.id_convenio
FROM agenda_paciente
INNER JOIN paciente ON paciente.id_paciente = agenda_paciente.id_paciente
INNER JOIN hora ON hora.id_hora = agenda_paciente.id_hora
INNER JOIN categoria ON categoria.id_categoria = agenda_paciente.id_categoria
INNER JOIN convenio_paciente ON convenio_paciente.id_paciente = agenda_paciente.id_paciente
WHERE agenda_paciente.Data = '$DataAgenda' AND convenio_paciente.StatusConvenio = 1
$FiltroPaciente $FiltroCategoria $FiltroConvenio $FiltroPresenca $FiltroHora
ORDER BY hora.Hora ASC, paciente.NomeCompleto ASC
LIMIT $ItensPorPagina $PageOffset1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_paciente = $row['id_paciente'];
		// $NomeCompleto = $row['NomeCompleto'];
		// $Hora = $row['Hora'];
		$id_agenda_paciente = $row['id_agenda_paciente'];
		// $Convenio = $row['Convenio'];
		// $NomeCategoria = $row['NomeCategoria'];
		// $id_convenio = $row['id_convenio'];
		// $id_convenio_validado = $row['id_convenio_validado'];
		// $Presenca = $row['Presenca'];

		// buscar xxx
		$sqlA = "SELECT * FROM convenio_paciente WHERE id_paciente = '$id_paciente' AND StatusConvenio = 1";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$id_convenio = $rowA['id_convenio'];

				if ($Validar == 1) {
					// atualizar
					$sqlB = "UPDATE agenda_paciente SET id_convenio_validado = '$id_convenio' WHERE id_agenda_paciente = '$id_agenda_paciente' ";
					if ($conn->query($sqlB) === TRUE) {
					} else {
					}
				}
				if ($Validar == 2) {
					// atualizar
					$sqlB = "UPDATE agenda_paciente SET id_convenio_validado = NULL WHERE id_agenda_paciente = '$id_agenda_paciente' ";
					if ($conn->query($sqlB) === TRUE) {
					} else {
					}
				}
		    }
		} else {
			// não tem
		}
    }
} else {
	// não tem
}

// voltar
header("Location: index.php");
exit;
?>
