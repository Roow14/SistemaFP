<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// denifir a próxima semana iniciando na segunda
// input próxima segunda
$DataInicial = strtotime("Monday");
$X = date("Y-m-d", $DataInicial);
echo $X;
echo '<br>';
// terça
$date = date_create($X);
date_add($date,date_interval_create_from_date_string("1 day"));
echo date_format($date,"Y-m-d");
echo '<br>';
// quarta
$date = date_create($X);
date_add($date,date_interval_create_from_date_string("2 day"));
echo date_format($date,"Y-m-d");
echo '<br>';
// quinta
$date = date_create($X);
date_add($date,date_interval_create_from_date_string("3 day"));
echo date_format($date,"Y-m-d");
echo '<br>';
// sexta
$date = date_create($X);
date_add($date,date_interval_create_from_date_string("4 day"));
echo date_format($date,"Y-m-d");
echo '<br>';

// verificar se o input dia é segunda
// input
$Y = '2020-06-01';
$DayWeek = (strftime("%a", strtotime($Y)));
echo '<label>Dia da semana:</label> '.$DayWeek;
echo '<br>';
// verificar se é segunda
if ($DayWeek == 'Mon') {
	echo 'É segunda';
} else {
	echo 'Não é segunda';
}
?>