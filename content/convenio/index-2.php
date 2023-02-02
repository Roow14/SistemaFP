 <?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
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
// unset($_SESSION['id_paciente']);

if (isset($_POST['DataAgenda'])) {
	$DataAgenda = $_POST['DataAgenda'];
	$_SESSION['DataAgenda'] = $DataAgenda;
} elseif (isset($_SESSION['DataAgenda'])) {
	$DataAgenda = $_SESSION['DataAgenda'];
} else {
	$_SESSION['DataAgenda'] = $DataAtual;
	$DataAgenda = $DataAtual;
}
$DataAgendaX = date("d/m/Y", strtotime($DataAgenda));

// dia da semana
setlocale(LC_TIME,"pt");
$DiaSemana = strftime("%A", strtotime($DataAgenda));

if (isset($_POST['PesquisaPaciente'])) {
	$PesquisaPaciente = $_POST['PesquisaPaciente'];
	$_SESSION['PesquisaPaciente'] = $PesquisaPaciente;
	$FiltroPaciente = 'AND paciente.NomeCompleto LIKE "%'.$PesquisaPaciente.'%"';
} elseif (isset($_SESSION['PesquisaPaciente'])) {
	$PesquisaPaciente = $_SESSION['PesquisaPaciente'];
	$FiltroPaciente = 'AND paciente.NomeCompleto LIKE "%'.$PesquisaPaciente.'%"';
} else {
	$PesquisaPaciente = NULL;
	$FiltroPaciente = NULL;
}

$FiltroConvenio = 'AND convenio_paciente.id_convenio = 3';

// buscar xxx
$sql = "SELECT agenda_paciente.*, paciente.NomeCompleto, hora.Hora
FROM agenda_paciente
INNER JOIN paciente ON paciente.id_paciente = agenda_paciente.id_paciente
INNER JOIN hora ON hora.id_hora = agenda_paciente.id_hora
WHERE Data = '$DataAgenda'
ORDER BY paciente.NomeCompleto ASC, hora.Hora ASC
";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_agenda_paciente = $row['id_agenda_paciente'];
		$id_paciente = $row['id_paciente'];
		$NomeCompleto = $row['NomeCompleto'];
		$Hora = $row['Hora'];
		
		// buscar xxx
		$sqlA = "SELECT * FROM convenio_paciente
		INNER JOIN convenio ON convenio_paciente.id_convenio = convenio.id_convenio
		WHERE convenio_paciente.id_paciente = '$id_paciente' AND convenio_paciente.StatusConvenio = 1 $FiltroConvenio";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$id_convenio = $rowA['id_convenio'];
				$NomeConvenio = $rowA['NomeConvenio'];
				echo $Hora.' - ' .$NomeCompleto.' - '.$NomeConvenio.'<br>';
		    }
		} else {
			// não tem
		}
    }
} else {
	// não tem
}

// buscar xxx
$sql = "SELECT * FROM convenio_paciente";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_convenio_paciente = $row['id_convenio_paciente'];
		$id_paciente = $row['id_paciente'];
		$id_convenio = $row['id_convenio'];
    }
} else {
	// não tem
}
?>
