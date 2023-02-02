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
$DiaSemana = $_POST['DiaSemana'];
$id_hora = $_POST['id_hora'];
$id_categoria = $_POST['id_categoriaX'];
$id_unidade = $_POST['id_unidadeX'];

// buscar xxx
$sql = "SELECT * FROM agenda_paciente_base WHERE id_paciente = '$id_paciente' AND DiaSemana = '$DiaSemana' AND id_hora = '$id_hora'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		// mensagem de alerta
		echo "<script type=\"text/javascript\">
		    alert(\"Erro: O dia da semana e hora já está ocupado.\");
		    window.location = \"agendar-terapia-base.php\"
		    </script>";
		exit;
    }
} else {
	// não tem
}

$_SESSION['DiaSemana'] = $DiaSemana;
$_SESSION['id_hora'] = $id_hora;
$_SESSION['id_categoria'] = $id_categoria;
$_SESSION['id_unidade'] = $id_unidade;

// voltar
header("Location: agendar-terapia-base.php");
exit;
?>
