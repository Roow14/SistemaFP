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
$id_profissional = $_GET['id_profissional'];
$id_paciente = $_GET['id_paciente'];
$NomeCompleto = $_GET['NomeCompleto'];

function fullNameToFirstName($fullName, $checkFirstNameLength=TRUE)
{
	// Split out name so we can quickly grab the first name part
	$nameParts = explode(' ', $fullName);
	$firstName = $nameParts[0];

	// If the first part of the name is a prefix, then find the name differently
	if(in_array(strtolower($firstName), array('mr', 'ms', 'mrs', 'miss', 'dr'))) {
		if($nameParts[2]!='') {
			// E.g. Mr James Smith -> James
			$firstName = $nameParts[1];
		} else {
			// e.g. Mr Smith (no first name given)
			$firstName = $fullName;
		}
	}

	// make sure the first name is not just "J", e.g. "J Smith" or "Mr J Smith" or even "Mr J. Smith"
	if($checkFirstNameLength && strlen($firstName)<3) {
		$firstName = $fullName;
	}
	return $firstName;
}

$NomeCurto = fullNameToFirstName($NomeCompleto);

if (isset($_GET['id_profissional'])) {
	// atualizar
	$sql = "UPDATE profissional SET NomeCurto = '$NomeCurto' WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} elseif (isset($_GET['id_paciente'])) {
	// atualizar
	$sql = "UPDATE paciente SET NomeCurto = '$NomeCurto' WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {

}

// voltar
header("Location: configurar-primeiro-nome-paciente.php");
exit;
?>

