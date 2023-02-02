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
$id_paciente = $_SESSION['id_paciente'];
$Horas = $_POST['Horas'];
$id_categoria_paciente = $_POST['id_categoria_paciente'];
$id_avaliacao = $_POST['id_avaliacao'];

// atualizar
$sql = "UPDATE categoria_paciente SET Horas = '$Horas' WHERE id_categoria_paciente = '$id_categoria_paciente' ";
if ($conn->query($sql) === TRUE) {
} else {
}

// buscar xxx
$sql = "SELECT * FROM horas_terapia WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_horas_terapia = $row['id_horas_terapia'];

		// atualizar
		$sqlA = "UPDATE horas_terapia SET Horas = '$Horas' WHERE id_horas_terapia = '$id_horas_terapia' ";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
    }
} else {
	// não tem
}	

// voltar
header("Location: alterar-avaliacao.php?id_avaliacao=$id_avaliacao");
exit;
?>