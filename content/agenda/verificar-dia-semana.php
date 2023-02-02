<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// input
$DayWeek = (strftime("%a", strtotime($DataAgenda)));

// verificar se é segunda
if ($DayWeek == 'Mon') {
} elseif ($DayWeek == 'Tue' ) {
	$date = date_create($DataAgenda);
	date_add($date,date_interval_create_from_date_string("-1 day"));
	$DataAgenda = date_format($date,"Y-m-d");
} elseif ($DayWeek == 'Wed' ) {
	$date = date_create($DataAgenda);
	date_add($date,date_interval_create_from_date_string("-2 day"));
	$DataAgenda = date_format($date,"Y-m-d");
} elseif ($DayWeek == 'Thu' ) {
	$date = date_create($DataAgenda);
	date_add($date,date_interval_create_from_date_string("-3 day"));
	$DataAgenda = date_format($date,"Y-m-d");
} elseif ($DayWeek == 'Fri' ) {
	$date = date_create($DataAgenda);
	date_add($date,date_interval_create_from_date_string("-4 day"));
	$DataAgenda = date_format($date,"Y-m-d");
} elseif ($DayWeek == 'Sat' ) {
	$date = date_create($DataAgenda);
	date_add($date,date_interval_create_from_date_string("-5 day"));
	$DataAgenda = date_format($date,"Y-m-d");
} else {
	$date = date_create($DataAgenda);
	date_add($date,date_interval_create_from_date_string("-6 day"));
	$DataAgenda = date_format($date,"Y-m-d");
}
?>
