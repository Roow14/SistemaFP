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
$id_paciente = $_GET['id_paciente'];
$id_convenio = $_POST['id_convenio'];
$NumeroConvenio = $_POST['NumeroConvenio'];

// verificar se o convenio está associado ao paciente
// $sql = "SELECT * FROM convenio_paciente WHERE id_paciente = '$id_paciente' AND id_convenio = '$id_convenio'";
// $result = $conn->query($sql);
// if ($result->num_rows > 0) {
//     while($row = $result->fetch_assoc()) {
// 		// tem
// 		// mensagem de alerta
// 		echo "<script type=\"text/javascript\">
// 		    alert(\"O convênio já está associado ao paciente..\");
// 		    window.location = \"convenio-paciente.php?id_paciente=$id_paciente\"
// 		    </script>";
// 		exit;
//     }
// }

// verificar se o convenio está associado ao paciente
$sql = "SELECT * FROM convenio_paciente WHERE NumeroConvenio = '$NumeroConvenio' AND id_convenio = '$id_convenio'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		// mensagem de alerta
		echo "<script type=\"text/javascript\">
		    alert(\"Erro: o nº da carteirinha já existe no sistema.\");
		    window.location = \"convenio-paciente.php?id_paciente=$id_paciente\"
		    </script>";
		exit;
    }
}

// verificar se tem ordem 1
$sql = "SELECT * FROM convenio_paciente WHERE id_paciente = '$id_paciente' AND Ordem = 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$Check = 1;
    }
}

if ($Check == 1) {
	// inserir
	$sqlA = "INSERT INTO convenio_paciente (id_convenio, id_paciente, NumeroConvenio, Ordem) VALUES ('$id_convenio', '$id_paciente', '$NumeroConvenio', 2)";
	if ($conn->query($sqlA) === TRUE) {
	} else {
	}
} else {
	// inserir
	$sqlA = "INSERT INTO convenio_paciente (id_convenio, id_paciente, NumeroConvenio) VALUES ('$id_convenio', '$id_paciente', '$NumeroConvenio')";
	if ($conn->query($sqlA) === TRUE) {
	} else {
	}
}

// voltar
header("Location: convenio-paciente.php?id_paciente=$id_paciente");
exit;
?>
