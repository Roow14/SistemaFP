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
$id_paciente = $_POST['id_paciente'];
$id_convenio_paciente = $_POST['id_convenio_paciente'];
$AdicionarHoras = $_POST['AdicionarHoras'];
$Nota = $_POST['Nota'];

date_default_timezone_set("America/Sao_Paulo");
$DataHora= date("d/m/Y H:i:s");
$DataAtual = date("Y-m-d");
$UsuarioID = $_SESSION['UsuarioID'];

// buscar xxx
$sql = "SELECT * FROM convenio_paciente WHERE id_convenio_paciente = '$id_convenio_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$Total = $row['Total'];
    }
} else {
}

// atualizar total
$TotalAtualizado = $Total + $AdicionarHoras;

// atualizar
$sql = "UPDATE convenio_paciente SET Total = '$TotalAtualizado' WHERE id_convenio_paciente = '$id_convenio_paciente' ";
if ($conn->query($sql) === TRUE) {
} else {
}

// histórico
// inserir
if (!empty($Nota)) {
	$sql = "INSERT INTO convenio_horas_liberadas (Data, Horas, id_paciente, id_convenio_paciente, Nota) VALUES ('$DataAtual', '$AdicionarHoras', '$id_paciente', '$id_convenio_paciente', '$Nota')";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	$sql = "INSERT INTO convenio_horas_liberadas (Data, Horas, id_paciente, id_convenio_paciente) VALUES ('$DataAtual', '$AdicionarHoras', '$id_paciente', '$id_convenio_paciente')";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// salvar log
$print = 
$DataHora.' id_paciente = '.$id_paciente.', id_convenio_paciente = '.$id_convenio_paciente.' Total inicial = '.$Total.', Horas adicionadas = '.$AdicionarHoras.', Total final = '.$TotalAtualizado.', id_usuario = '.$UsuarioID.', Nota = '.$Nota;
error_log(PHP_EOL.$print, 3, "horas_liberadas.log");


// voltar
header("Location: alterar-convenio-paciente.php?id_convenio_paciente=$id_convenio_paciente");
exit;
?>