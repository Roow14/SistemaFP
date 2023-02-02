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
$id_procedimento = $_GET['id_procedimento'];
$NomeProcedimento = $_POST['NomeProcedimento'];

if (empty($_POST['NomeProcedimento'])) {
	// mensagem de alerta
	echo "<script type=\"text/javascript\">
	    alert(\"Erro: O nome do procedimento está vazio.\");
	    window.location = \"cadastrar-procedimento.php\"
	    </script>";
	exit;
} else {
}

// verificar se o nome está duplicado
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

// atualizar
$sql = "UPDATE prog_procedimento SET NomeProcedimento = '$NomeProcedimento' WHERE id_procedimento = '$id_procedimento' ";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: cadastrar-procedimento.php");
exit;
?>
