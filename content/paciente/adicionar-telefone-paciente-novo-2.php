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
$id_paciente = $_SESSION['id_paciente'];
$ClasseTel = $_POST['ClasseTel'];
$NumeroTel = $_POST['NumeroTel'];
$NotaTel = $_POST['NotaTel'];


// inserir
$sql = "INSERT INTO telefone_paciente (id_paciente, NumeroTel, ClasseTel) VALUES ('$id_paciente', '$NumeroTel', '$ClasseTel')";
if ($conn->query($sql) === TRUE) {
} else {
	// mensagem de alerta
	echo "<script type=\"text/javascript\">
	    alert(\"Erro: entre com os dados novamente.\");
	    window.location = \"cadastrar-paciente-novo.php\"
	    </script>";
	exit;
}

// buscar xxx
$sql = "SELECT * FROM telefone_paciente ORDER BY id_telefone_paciente DESC LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_telefone_paciente = $row['id_telefone_paciente'];

		if (empty($_POST['NotaTel'])) {
		} else {
			// atualizar
			$sqlA = "UPDATE telefone_paciente SET NotaTel = '$NotaTel' WHERE id_telefone_paciente = '$id_telefone_paciente' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
		}
    }
} else {
}

// voltar
header("Location: alterar-paciente-novo.php");
exit;
?>
