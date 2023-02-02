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
$id_avaliacao = $_GET['id_avaliacao'];
$DataInicio = $_POST['DataInicio'];
$DataAvaliacao = $_POST['DataAvaliacao'];
$Avaliacao = $_POST['Avaliacao'];
$Avaliacao = str_replace("'","&#39;",$Avaliacao);
$Avaliacao = str_replace('"','&#34;',$Avaliacao);
$TituloAvaliacao = $_POST['TituloAvaliacao'];
// $PlanoTerapeutico = $_POST['PlanoTerapeutico'];
$LocalAvaliacao = $_POST['LocalAvaliacao'];
$LocalTerapia = $_POST['LocalTerapia'];
$Responsavel = $_POST['Responsavel'];
$Status = $_POST['Status'];

if ($Status == 1) {
	// ver se tem status da avaliação 1 ativo e alterá-la para 2 inativo
	$sql = "SELECT * FROM avaliacao WHERE id_paciente = '$id_paciente' AND Status = 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$id_avaliacaoX = $row['id_avaliacao'];
			// atualizar
			$sqlA = "UPDATE avaliacao SET Status = 2 WHERE id_avaliacao = '$id_avaliacaoX' ";
			if ($conn->query($sqlA) === TRUE) {
			}
	    }
	} else {
		// não tem
	}
}

// atualizar
$sql = "UPDATE avaliacao SET Status = '$Status' WHERE id_avaliacao = '$id_avaliacao' ";
if ($conn->query($sql) === TRUE) {
}	

if (!empty($Responsavel)) {
	// atualizar
	$sql = "UPDATE avaliacao SET Responsavel = '$Responsavel' WHERE id_avaliacao = '$id_avaliacao' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (!empty($LocalAvaliacao)) {
	// atualizar
	$sql = "UPDATE avaliacao SET LocalAvaliacao = '$LocalAvaliacao' WHERE id_avaliacao = '$id_avaliacao' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (!empty($LocalTerapia)) {
	// atualizar
	$sql = "UPDATE avaliacao SET LocalTerapia = '$LocalTerapia' WHERE id_avaliacao = '$id_avaliacao' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// if (!empty($PlanoTerapeutico)) {
// 	// atualizar
// 	$sql = "UPDATE avaliacao SET PlanoTerapeutico = '$PlanoTerapeutico' WHERE id_avaliacao = '$id_avaliacao' ";
// 	if ($conn->query($sql) === TRUE) {
// 	} else {
// 	}
// } else {
// 	// atualizar
// 	$sql = "UPDATE avaliacao SET PlanoTerapeutico = NULL WHERE id_avaliacao = '$id_avaliacao' ";
// 	if ($conn->query($sql) === TRUE) {
// 	} else {
// 	}
// }

// atualizar
$sql = "UPDATE avaliacao SET TituloAvaliacao = '$TituloAvaliacao' WHERE id_avaliacao = '$id_avaliacao' ";
if ($conn->query($sql) === TRUE) {
} else {
}

// atualizar
$sql = "UPDATE avaliacao SET DataAvaliacao = '$DataAvaliacao' WHERE id_avaliacao = '$id_avaliacao' ";
if ($conn->query($sql) === TRUE) {
} else {
}

if (!empty($DataInicio)) {
	// atualizar
	$sql = "UPDATE avaliacao SET DataInicio = '$DataInicio' WHERE id_avaliacao = '$id_avaliacao' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// atualizar
$sql = "UPDATE avaliacao SET Avaliacao = '$Avaliacao' WHERE id_avaliacao = '$id_avaliacao' ";
if ($conn->query($sql) === TRUE) {
} else {
	// mensagem de alerta
	echo "<script type=\"text/javascript\">
	    alert(\"Erro: o conteúdo não foi alterado.\");
	    window.location = \"index.php?id_paciente=$id_paciente\"
	    </script>";
	exit;
}

// voltar
header("Location: alterar-avaliacao.php?id_paciente=$id_paciente&id_avaliacao=$id_avaliacao");
exit;
?>