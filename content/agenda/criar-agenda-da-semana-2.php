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
$DayWeek = $_POST['DayWeek'];

// verificar se o input dia é segunda
// input
$DayWeek1 = (strftime("%a", strtotime($DayWeek)));
// verificar se é segunda
if ($DayWeek1 == 'Mon') {
	// ok
} else {
	// Não é segunda
	// mensagem de alerta
	echo "<script type=\"text/javascript\">
	    alert(\"Erro: Não é 2ª feira. Selecione uma nova data.\");
	    window.location = \"criar-agenda-da-semana.php\"
	    </script>";
	exit;
}

// verificar se a semana está criada
$sql = "SELECT * FROM agenda_paciente WHERE Data = '$DayWeek' LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		// mensagem de alerta
		echo "<script type=\"text/javascript\">
		    alert(\"Erro: A semana se encontrada cadastrada no sistema. Selecione uma nova semana.\");
		    window.location = \"criar-agenda-da-semana.php\"
		    </script>";
		exit;
    }
} else {
	// não tem
	$DiaSemana = 2;
	include 'criar-agenda-da-semana-3.php';

	$DiaSemana = 3;
	include 'criar-agenda-da-semana-3.php';

	$DiaSemana = 4;
	include 'criar-agenda-da-semana-3.php';

	$DiaSemana = 5;
	include 'criar-agenda-da-semana-3.php';

	$DiaSemana = 6;
	include 'criar-agenda-da-semana-3.php';
}

// mensagem de alerta
echo "<script type=\"text/javascript\">
alert(\"Sucesso: a agenda da semana foi criada.\");
window.location = \"criar-agenda-da-semana.php\"
</script>";
exit;

// voltar
header("Location: criar-agenda-da-semana.php");
exit;
?>
