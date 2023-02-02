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
$NomeReforcador = $_POST['NomeReforcador'];

// buscar reforcador
$sql = "SELECT * FROM prog_reforcador WHERE NomeReforcador = '$NomeReforcador'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// mensagem de alerta
		echo "<script type=\"text/javascript\">
		    alert(\"Erro: existe um reforcador com o mesmo nome cadastrado no sistema. Digite outro reforcador.\");
		    window.location = \"cadastrar-reforcador.php\"
		    </script>";
		exit;
    }
} else {
}
echo $sql;
echo '<br>';

if (empty($_POST['NomeReforcador'])) {

} else {
	// inserir
	$sql = "INSERT INTO prog_reforcador (NomeReforcador) VALUES ('$NomeReforcador')";
	if ($conn->query($sql) === TRUE) {
		echo 'reforcador criado com sucesso.';
	} else {
		echo 'erro ao criar reforcador' .$sql;
	}
}

// voltar
header("Location: cadastrar-reforcador.php");
exit;
?>
 