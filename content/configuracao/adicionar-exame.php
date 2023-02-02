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
$NomeExame = $_POST['NomeExame'];
if (empty($_GET['Origem'])) {
} else {
	$Origem = $_GET['Origem'];
}

// buscar exame
$sql = "SELECT * FROM exame WHERE NomeExame = '$NomeExame'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		echo 'Erro: O nome se encontra cadastrado no sistema.<br>';
		echo '<a href="configurar-exame.php">Voltar</a>';
		echo '<br>';
		$_SESSION['ErroAdicionarExame'] = 'erro';
		if (empty($_GET['Origem'])) {
			header("Location: configurar-exame.php");
		} else {
			$Origem = $_GET['Origem'];
			header("Location: configurar-exame.php?Origem=$Origem");
		}
		exit;
    }
} else {
}
echo $sql;
echo '<br>';

if (empty($_POST['NomeExame'])) {

} else {
	// inserir
	$sql = "INSERT INTO exame (NomeExame) VALUES ('$NomeExame')";
	if ($conn->query($sql) === TRUE) {
		echo 'exame criado com sucesso.';
	} else {
		echo 'erro ao criar exame' .$sql;
	}
}

// voltar
if (empty($_GET['Origem'])) {
	header("Location: configurar-exame.php");
} else {
	$Origem = $_GET['Origem'];
	header("Location: configurar-exame.php?Origem=$Origem");
}
exit;
?>
