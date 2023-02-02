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
$NomeCurto = $_POST['NomeCurto'];
$NomeCompleto = $_POST['NomeCompleto'];

// inserir
$sql = "INSERT INTO paciente (NomeCurto, NomeCompleto) VALUES ('$NomeCurto', '$NomeCompleto')";
if ($conn->query($sql) === TRUE) {
} else {
}

// buscar recém criado
$sql = "SELECT * FROM paciente ORDER BY id_paciente DESC LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_paciente = $row['id_paciente'];
    }
} else {
}

if (empty($_POST['DataNascimento'])) {
} else {
	$DataNascimento = $_POST['DataNascimento'];
	// atualizar
	$sql = "UPDATE paciente SET DataNascimento = '$DataNascimento' WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['Rg'])) {
} else {
	$Rg = $_POST['Rg'];
	// atualizar
	$sql = "UPDATE paciente SET Rg = '$Rg' WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['OrgaoEmissor'])) {
} else {
	$OrgaoEmissor = $_POST['OrgaoEmissor'];
	// atualizar
	$sql = "UPDATE paciente SET OrgaoEmissor = '$OrgaoEmissor' WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['Cpf'])) {
} else {
	$Cpf = $_POST['Cpf'];
	// atualizar
	$sql = "UPDATE paciente SET Cpf = '$Cpf' WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['Cpf'])) {
} else {
	$Cpf = $_POST['Cpf'];
	// atualizar
	$sql = "UPDATE paciente SET Cpf = '$Cpf' WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['Pai'])) {
} else {
	$Pai = $_POST['Pai'];
	// atualizar
	$sql = "UPDATE paciente SET Pai = '$Pai' WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['Mae'])) {
} else {
	$Mae = $_POST['Mae'];
	// atualizar
	$sql = "UPDATE paciente SET Mae = '$Mae' WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['UsoImagem'])) {
} else {
	$UsoImagem = $_POST['UsoImagem'];
	// atualizar
	$sql = "UPDATE paciente SET UsoImagem = '$UsoImagem' WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['id_periodo'])) {
} else {
	$id_periodo = $_POST['id_periodo'];
	// atualizar
	$sql = "UPDATE paciente SET id_periodo = '$id_periodo' WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['id_unidade'])) {
} else {
	$id_unidade = $_POST['id_unidade'];
	// atualizar
	$sql = "UPDATE paciente SET id_unidade = '$id_unidade' WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['PacienteObservacao'])) {
} else {
	$PacienteObservacao = $_POST['PacienteObservacao'];
	// inserir
	$sql = "INSERT INTO paciente_observacao (PacienteObservacao, id_paciente) VALUES ('$PacienteObservacao', '$id_paciente')";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}


// endereço
// ============================
// verificar se tem endereço cadastrado
$sql = "SELECT * FROM endereco_paciente WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    	// tem
		$id_endereco_paciente = $row['id_endereco_paciente'];
    }
} else {
	// não tem
	// inserir
	$sqlA = "INSERT INTO endereco_paciente (id_paciente) VALUES ('$id_paciente')";
	if ($conn->query($sqlA) === TRUE) {
	} else {
	}

	// buscar xxx
	$sqlA = "SELECT * FROM endereco_paciente ORDER BY id_endereco_paciente DESC LIMIT 1";
	$resultA = $conn->query($sqlA);
	if ($resultA->num_rows > 0) {
	    while($rowA = $resultA->fetch_assoc()) {
			$id_endereco_paciente = $rowA['id_endereco_paciente'];
	    }
	} else {
	}
}

if (empty($id_endereco_paciente)) {
} else {
	// atualizar
	if (empty($_POST['Endereco'])) {
	} else {
		$Endereco = $_POST['Endereco'];
		// atualizar
		$sql = "UPDATE endereco_paciente SET Endereco = '$Endereco' WHERE id_endereco_paciente = '$id_endereco_paciente' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}

	// atualizar
	if (empty($_POST['Numero'])) {
	} else {
		$Numero = $_POST['Numero'];
		// atualizar
		$sql = "UPDATE endereco_paciente SET Numero = '$Numero' WHERE id_endereco_paciente = '$id_endereco_paciente' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}

	// atualizar
	if (empty($_POST['Complemento'])) {
	} else {
		$Complemento = $_POST['Complemento'];
		// atualizar
		$sql = "UPDATE endereco_paciente SET Complemento = '$Complemento' WHERE id_endereco_paciente = '$id_endereco_paciente' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}

	// atualizar
	if (empty($_POST['Cep'])) {
	} else {
		$Cep = $_POST['Cep'];
		// atualizar
		$sql = "UPDATE endereco_paciente SET Cep = '$Cep' WHERE id_endereco_paciente = '$id_endereco_paciente' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}

	// atualizar
	if (empty($_POST['Bairro'])) {
	} else {
		$Bairro = $_POST['Bairro'];
		// atualizar
		$sql = "UPDATE endereco_paciente SET Bairro = '$Bairro' WHERE id_endereco_paciente = '$id_endereco_paciente' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}

	// atualizar
	if (empty($_POST['Cidade'])) {
	} else {
		$Cidade = $_POST['Cidade'];
		// atualizar
		$sql = "UPDATE endereco_paciente SET Cidade = '$Cidade' WHERE id_endereco_paciente = '$id_endereco_paciente' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}

	// atualizar
	if (empty($_POST['Estado'])) {
	} else {
		$Estado = $_POST['Estado'];
		// atualizar
		$sql = "UPDATE endereco_paciente SET Estado = '$Estado' WHERE id_endereco_paciente = '$id_endereco_paciente' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}
}

	

// voltar
header("Location: paciente.php?id_paciente=$id_paciente");
exit;
?>
