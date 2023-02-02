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
$id_paciente = $_POST['id_paciente'];
$id_convenio_paciente = $_POST['id_convenio_paciente'];
$NotaConvenio = $_POST['NotaConvenio'];
$NumeroConvenio = $_POST['NumeroConvenio'];
$StatusConvenio = $_POST['StatusConvenio'];
$id_convenio = $_POST['id_convenio'];
$HorasConvenio = $_POST['HorasConvenio'];
$LiberacaoAT = $_POST['LiberacaoAT'];

// buscar dados para usar no log
$sql = "SELECT convenio_paciente.*, convenio.NomeConvenio
FROM convenio_paciente
INNER JOIN convenio ON convenio_paciente.id_convenio = convenio.id_convenio
WHERE convenio_paciente.id_convenio_paciente = '$id_convenio_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_convenioX = $row['id_convenio'];
		$NomeConvenioX = $row['NomeConvenio'];
		$NumeroConvenioX = $row['NumeroConvenio'];
		$NotaConvenioX = $row['NotaConvenio'];
		$HorasConvenioX = $row['HorasConvenio'];
		$StatusConvenioX = $row['StatusConvenio'];
		if ($StatusConvenio == 1) {
			$NomeStatusX = 'Ativo';
		} else {
			$NomeStatusX = 'Inativo';
		}
		$LiberacaoATX = $row['LiberacaoAT'];
		if ($LiberacaoATX == 2) {
			$NomeLiberacaoATX = 'Social';
		} elseif ($LiberacaoATX == 3) {
			$NomeLiberacaoATX = 'Escolar';
		}
		else {
			$NomeLiberacaoATX = 'Nenhum';
		}
    }
} else {
	// não tem
}

// verificar se o número está cadastrado
$sql = "SELECT * FROM convenio_paciente WHERE id_convenio = '$id_convenio' AND NumeroConvenio = '$NumeroConvenio'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    	// está cadastrado
    	// ver se pertence ao cliente
		$sqlA = "SELECT * FROM convenio_paciente WHERE id_convenio = '$id_convenio' AND NumeroConvenio = '$NumeroConvenio' AND id_paciente = '$id_paciente'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
		    }
		} else {
			// não tem
			// mensagem de alerta
			echo "<script type=\"text/javascript\">
			    alert(\"Erro: o nº da carteirinha está sendo utilizado.\");
			    window.location = \"alterar-convenio-paciente.php?id_paciente=$id_paciente&id_convenio_paciente=$id_convenio_paciente\"
			    </script>";
			exit;
		}
    }
} else {
	// não está cadastrado, atualizar
	$sqlA = "UPDATE convenio_paciente SET NumeroConvenio = '$NumeroConvenio' WHERE id_convenio_paciente = '$id_convenio_paciente' ";
	if ($conn->query($sqlA) === TRUE) {
	} else {
	}
}	

// alterar status para ativo
if ($StatusConvenio == 1) {

	// ver o status ativo dos demais convênios e mudar para inativo
	$sql = "SELECT * FROM convenio_paciente WHERE StatusConvenio = 1 AND id_paciente = '$id_paciente' AND id_convenio_paciente != '$id_convenio_paciente'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// status ativo, alterar para inativo
			$id_convenio_paciente1 = $row['id_convenio_paciente'];
			$sqlA = "UPDATE convenio_paciente SET StatusConvenio = 2 WHERE id_convenio_paciente = '$id_convenio_paciente1' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}

			$sqlA = "UPDATE convenio_paciente SET StatusConvenio = 1 WHERE id_convenio_paciente = '$id_convenio_paciente' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
	    }
	} else {
		// alterar para ativo
		$sqlA = "UPDATE convenio_paciente SET StatusConvenio = 1 WHERE id_convenio_paciente = '$id_convenio_paciente' ";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
	}
} else {
	// alterar para inativo
	$sqlA = "UPDATE convenio_paciente SET StatusConvenio = 2 WHERE id_convenio_paciente = '$id_convenio_paciente' ";
	if ($conn->query($sqlA) === TRUE) {
	} else {
	}  
}

if (empty($NotaConvenio)) {
	// atualizar
	$sql = "UPDATE convenio_paciente SET NotaConvenio = NULL WHERE id_convenio_paciente = '$id_convenio_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE convenio_paciente SET NotaConvenio = '$NotaConvenio' WHERE id_convenio_paciente = '$id_convenio_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($HorasConvenio)) {
	// atualizar
	$sql = "UPDATE convenio_paciente SET HorasConvenio = NULL WHERE id_convenio_paciente = '$id_convenio_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE convenio_paciente SET HorasConvenio = '$HorasConvenio' WHERE id_convenio_paciente = '$id_convenio_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// atualizar
$sql = "UPDATE convenio_paciente SET LiberacaoAT = '$LiberacaoAT' WHERE id_convenio_paciente = '$id_convenio_paciente' ";
if ($conn->query($sql) === TRUE) {
} else {
}

// salvar log
date_default_timezone_set("America/Sao_Paulo");
$DataHora= date("d/m/Y H:i:s");
$DataAtual = date("Y-m-d");
$UsuarioID = $_SESSION['UsuarioID'];

// ver se teve alteração, se teve, criar log
// if (($id_convenio != $id_convenioX) OR ($NumeroConvenio != $NumeroConvenioX) OR ($HorasConvenio != $HorasConvenioX) OR ($NomeStatus != $NomeStatusX) OR ($NomeLiberacaoAT != $NomeLiberacaoATX) OR ($NotaConvenio != $NotaConvenioX)) {
if (($NotaConvenio != $NotaConvenioX) OR ($StatusConvenio != $StatusConvenioX) OR ($NumeroConvenio != $NumeroConvenioX) OR ($HorasConvenio != $HorasConvenioX)) {
	$print = 
	$DataHora.' era id_paciente: '.$id_paciente.', convenio: '.$id_convenioX.'-'.$NomeConvenioX.' num.cart: '.$NumeroConvenioX.', hr.lib: '.$HorasConvenioX.', Status: '.$NomeStatusX.', id_usuario: '.$UsuarioID.', Lib AT: '.$NomeLiberacaoATX.', Obs: '.$NotaConvenioX;
	error_log(PHP_EOL.$print, 3, $id_paciente.'.log');
}

// voltar
header("Location: alterar-convenio-paciente.php?id_paciente=$id_paciente&id_convenio_paciente=$id_convenio_paciente");
exit;
?>
