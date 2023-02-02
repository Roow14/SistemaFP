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
$id_terapia = $_GET['id_terapia'];
$HorasTerapia = $_POST['HorasTerapia'];
$Origem = $_GET['Origem'];

// buscar xxx
$sql = "SELECT * FROM terapia_paciente WHERE id_paciente = '$id_paciente' AND id_terapia = '$id_terapia'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    	// tem 
		$id_terapia_paciente = $row['id_terapia_paciente'];

		// atualizar
		$sqlA = "UPDATE terapia_paciente SET HorasTerapia = '$HorasTerapia' WHERE id_terapia_paciente = '$id_terapia_paciente' ";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
    }
} else {
	// não tem
	// inserir
	$sqlA = "INSERT INTO terapia_paciente (HorasTerapia, id_terapia, id_paciente) VALUES ('$HorasTerapia', '$id_terapia', '$id_paciente')";
	if ($conn->query($sqlA) === TRUE) {
	} else {
	}
}

// voltar
header("Location: $Origem?id_paciente=$id_paciente");
exit;
?>
