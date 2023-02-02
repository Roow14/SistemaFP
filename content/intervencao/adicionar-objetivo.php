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
$NomeObjetivo = $_POST['NomeObjetivo'];

// buscar objetivo
$sql = "SELECT * FROM prog_objetivo WHERE NomeObjetivo = '$NomeObjetivo'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// mensagem de alerta
		echo "<script type=\"text/javascript\">
		    alert(\"Erro: existe um objetivo com o mesmo nome cadastrado no sistema. Digite outro objetivo.\");
		    window.location = \"cadastrar-objetivo.php\"
		    </script>";
		exit;
    }
} else {
}
echo $sql;
echo '<br>';

if (empty($_POST['NomeObjetivo'])) {

} else {
	// inserir
	$sql = "INSERT INTO prog_objetivo (NomeObjetivo) VALUES ('$NomeObjetivo')";
	if ($conn->query($sql) === TRUE) {
		echo 'objetivo criado com sucesso.';
	} else {
		echo 'erro ao criar objetivo' .$sql;
	}
}

// voltar
header("Location: cadastrar-objetivo.php");
exit;
?>
 