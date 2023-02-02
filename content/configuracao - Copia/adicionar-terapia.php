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
$NomeTerapia = $_POST['NomeTerapia'];
if (empty($_GET['Origem'])) {
} else {
	$Origem = $_GET['Origem'];
}

// buscar terapia
$sql = "SELECT * FROM terapia WHERE NomeTerapia = '$NomeTerapia'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		echo 'Erro: O nome se encontra cadastrado no sistema.<br>';
		echo '<a href="configurar-terapia.php">Voltar</a>';
		echo '<br>';
		$_SESSION['ErroAdicionarTerapia'] = 'erro';
		if (empty($_GET['Origem'])) {
			header("Location: configurar-terapia.php");
		} else {
			$Origem = $_GET['Origem'];
			header("Location: configurar-terapia.php?Origem=$Origem");
		}
		exit;
    }
} else {
}
echo $sql;
echo '<br>';

if (empty($_POST['NomeTerapia'])) {

} else {
	// inserir
	$sql = "INSERT INTO terapia (NomeTerapia) VALUES ('$NomeTerapia')";
	if ($conn->query($sql) === TRUE) {
		echo 'terapia criado com sucesso.';
	} else {
		echo 'erro ao criar terapia' .$sql;
	}
}

// voltar
if (empty($_GET['Origem'])) {
	header("Location: configurar-terapia.php");
} else {
	$Origem = $_GET['Origem'];
	header("Location: configurar-terapia.php?Origem=$Origem");
}
exit;
?>
