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
$NomeProcedimento = $_POST['NomeProcedimento'];

// buscar procedimento
$sql = "SELECT * FROM prog_procedimento WHERE NomeProcedimento = '$NomeProcedimento'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// mensagem de alerta
		echo "<script type=\"text/javascript\">
		    alert(\"Erro: existe um procedimento com o mesmo nome cadastrado no sistema. Digite outro procedimento.\");
		    window.location = \"cadastrar-procedimento.php\"
		    </script>";
		exit;
    }
} else {
}
echo $sql;
echo '<br>';

if (empty($_POST['NomeProcedimento'])) {

} else {
	// inserir
	$sql = "INSERT INTO prog_procedimento (NomeProcedimento) VALUES ('$NomeProcedimento')";
	if ($conn->query($sql) === TRUE) {
		echo 'procedimento criado com sucesso.';
	} else {
		echo 'erro ao criar procedimento' .$sql;
	}
}

// voltar
header("Location: cadastrar-procedimento.php");
exit;
?>
 