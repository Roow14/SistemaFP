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
$id_pedido_medico = $_GET['id_pedido_medico'];

// buscar xxx
$sql = "SELECT * FROM midia_exame WHERE id_pedido_medico = '$id_pedido_medico'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$ArquivoMidia = $row['ArquivoMidia'];
		$Arquivo = '../../vault/exame/'.$ArquivoMidia;
		unlink($Arquivo);
    }
} else {
}

// apagar
$sql = "DELETE FROM midia_exame WHERE id_pedido_medico = '$id_pedido_medico'";
if ($conn->query($sql) === TRUE) {
} else {
}

// apagar
$sql = "DELETE FROM pedido_medico WHERE id_pedido_medico = '$id_pedido_medico'";
if ($conn->query($sql) === TRUE) {
} else {
}

unset($_SESSION['AtivarRemocaoPedidoMedico']);
unset($_SESSION['ApagarArquivoExame']);

// voltar
header("Location: listar-pedidos-medicos.php?id_paciente=$id_paciente");
exit;
