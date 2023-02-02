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
$id_paciente = $_GET['id_paciente'];
$DataAvaliacao = $_POST['DataAvaliacao'];
$Avaliacao = $_POST['Avaliacao'];
$TituloAvaliacao = $_POST['TituloAvaliacao'];
$Avaliacao = str_replace("'","&#39;",$Avaliacao);
$Avaliacao = str_replace('"','&#34;',$Avaliacao);

// inserir
$sql = "INSERT INTO avaliacao (id_paciente, TituloAvaliacao, DataAvaliacao, Avaliacao) VALUES ('$id_paciente', '$TituloAvaliacao', '$DataAvaliacao', '$Avaliacao')";
if ($conn->query($sql) === TRUE) {
} else {
}

// buscar xxx
$sql = "SELECT * FROM avaliacao ORDER BY id_avaliacao DESC LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_avaliacao = $row['id_avaliacao'];
    }
} else {
}


// voltar
header("Location: listar-avaliacoes.php?id_paciente=$id_paciente");
exit;
?>
