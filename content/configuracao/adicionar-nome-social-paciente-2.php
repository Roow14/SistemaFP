<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// buscar xxx
$sql = "SELECT * FROM paciente WHERE Status = 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_paciente = $row['id_paciente'];
		$NomeCurto = $row['NomeCurto'];
		$NomeCompleto = $row['NomeCompleto'];

		if (empty($row['NomeCurto'])) {
			list($NomeCurto, $Sobrenome) = explode(' ', $NomeCompleto);

			// atualizar
			$sqlA = "UPDATE paciente SET NomeCurto = '$NomeCurto' WHERE id_paciente = '$id_paciente' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}

		} else {

		}
    }
} else {
}

// voltar
header("Location: adicionar-nome-social-paciente.php");
exit;
?>
