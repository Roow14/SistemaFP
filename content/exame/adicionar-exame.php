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
$DataExame = $_POST['DataExame'];
$Exame = $_POST['Exame'];
$TituloExame = $_POST['TituloExame'];
$Exame = str_replace("'","&#39;",$Exame);
$Exame = str_replace('"','&#34;',$Exame);

// inserir
$sql = "INSERT INTO exame_novo (id_paciente, TituloExame, DataExame, Exame) VALUES ('$id_paciente', '$TituloExame', '$DataExame', '$Exame')";
if ($conn->query($sql) === TRUE) {
} else {
}

// buscar xxx
$sql = "SELECT * FROM exame_novo ORDER BY id_exame DESC LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_exame = $row['id_exame'];
    }
} else {
}


// voltar
header("Location: index.php?id_paciente=$id_paciente");
exit;
?>
