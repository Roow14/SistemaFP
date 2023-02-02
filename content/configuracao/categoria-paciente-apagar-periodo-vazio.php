<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// buscar id_periodo 1 e salvar na tabela tmp
$sqlA = "SELECT * FROM categoria_profissional";
$resultA = $conn->query($sqlA);
if ($resultA->num_rows > 0) {
    while($rowA = $resultA->fetch_assoc()) {
		// tem
		$id_categoria_profissional = $rowA['id_categoria_profissional'];
		$id_periodo = $rowA['id_periodo'];

		if ((empty($id_periodo)) OR ($id_periodo == 0)) {
			// apagar
			$sqlA = "DELETE FROM categoria_profissional WHERE id_categoria_profissional = '$id_categoria_profissional'";
			if ($conn->query($sqlA) === TRUE) {
				$Status = 1;
			} else {
			}
		} else {
		}
    }
} else {
	// não tem
}

if ($Status == 1) {
	// mensagem de alerta
	echo "<script type=\"text/javascript\">
	    alert(\"Sucesso: itens vazios forma removidos da tabela categoria_profissional.\");
	    window.location = \"configuracao.php\"
	    </script>";
	exit;
} else {
	// mensagem de alerta
	echo "<script type=\"text/javascript\">
	    alert(\"Não foi encontrado nenhum item vazio na tabela categoria_profissional.\");
	    window.location = \"configuracao.php\"
	    </script>";
	exit;
}

// voltar
// header("Location: configurar-estado.php?id=#$id_estado");
exit;
?>
