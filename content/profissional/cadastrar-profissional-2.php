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
$NomeCompleto = $_POST['NomeCompleto'];
$NomeCurto = $_POST['NomeCurto'];
$Registro = $_POST['Registro'];
$Crpj = $_POST['Crpj'];
$Rg = $_POST['Rg'];
$OrgaoEmissor = $_POST['OrgaoEmissor'];
$Cpf = $_POST['Cpf'];
$DataNascimento = $_POST['DataNascimento'];
$id_funcao = $_POST['id_funcao'];
$id_periodo = $_POST['id_periodo'];
$id_unidade = $_POST['id_unidade'];
$Email = $_POST['Email'];
$Telefone = $_POST['Telefone'];
$Celular = $_POST['Celular'];
$ProfissionalObservacao = $_POST['ProfissionalObservacao'];
$Graduacao = $_POST['Graduacao'];

// inserir
$sql = "INSERT INTO profissional (NomeCurto, NomeCompleto) VALUES ('$NomeCurto', '$NomeCompleto')";
if ($conn->query($sql) === TRUE) {
} else {
}

// buscar recém criado
$sql = "SELECT * FROM profissional ORDER BY id_profissional DESC LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_profissional = $row['id_profissional'];
    }
} else {
}

// input múlitplo
// exames
foreach ($_POST['Categoria'] as $Item => $Valor) {
	echo $Item.' > '.$Valor.'<br>';

	// verificar se a categoria está cadastrada
	$sql = "SELECT * FROM categoria_profissional WHERE id_categoria = '$Valor' AND id_profissional = '$id_profissional' ";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	    	// está cadastrada
	    }
	} else {
		// inserir
		$sql = "INSERT INTO categoria_profissional (id_categoria, id_profissional) VALUES ('$Valor', '$id_profissional')";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}
}

if (empty($_POST['ProfissionalObservacao'])) {
} else {
	// inserir
	$sqlA = "INSERT INTO profissional_observacao (ProfissionalObservacao, id_profissional) VALUES ('$ProfissionalObservacao', '$id_profissional')";
	if ($conn->query($sqlA) === TRUE) {
	} else {
	}
}

if (empty($_POST['Graduacao'])) {
} else {
	// inserir
	$sqlA = "INSERT INTO profissional_graduacao (Graduacao, id_profissional) VALUES ('$Graduacao', '$id_profissional')";
	if ($conn->query($sqlA) === TRUE) {
	} else {
	}
}

// buscar xxx
$sql = "SELECT * FROM categoria_profissional WHERE id_profissional = '$id_profissional'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_categoria_profissional = $row['id_categoria_profissional'];

		// atualizar
		if (empty($_POST['id_periodo'])) {
		} else {
			$sqlA = "UPDATE categoria_profissional SET id_periodo = '$id_periodo' WHERE id_categoria_profissional = '$id_categoria_profissional' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
		}

		// atualizar
		if (empty($_POST['id_unidade'])) {
		} else {
			$sqlA = "UPDATE categoria_profissional SET id_unidade = '$id_unidade' WHERE id_categoria_profissional = '$id_categoria_profissional' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
		}
    }
} else {
}

// atualizar
if (empty($_POST['id_unidade'])) {
} else {
	$sql = "UPDATE profissional SET id_unidade = '$id_unidade' WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// atualizar
if (empty($_POST['id_periodo'])) {
} else {
	$sql = "UPDATE profissional SET id_periodo = '$id_periodo' WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// atualizar
if (empty($_POST['id_funcao'])) {
} else {
	$sql = "UPDATE profissional SET id_funcao = '$id_funcao' WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// atualizar
if (empty($_POST['Registro'])) {
} else {
	$sql = "UPDATE profissional SET Registro = '$Registro' WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// atualizar
if (empty($_POST['Crpj'])) {
} else {
	$sql = "UPDATE profissional SET Crpj = '$Crpj' WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// atualizar
if (empty($_POST['Rg'])) {
} else {
	$sql = "UPDATE profissional SET Rg = '$Rg' WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// atualizar
if (empty($_POST['OrgaoEmissor'])) {
} else {
	$sql = "UPDATE profissional SET OrgaoEmissor = '$OrgaoEmissor' WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// atualizar
if (empty($_POST['Cpf'])) {
} else {
	$sql = "UPDATE profissional SET Cpf = '$Cpf' WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// atualizar
if (empty($_POST['DataNascimento'])) {
} else {
	$sql = "UPDATE profissional SET DataNascimento = '$DataNascimento' WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// atualizar
if (empty($_POST['Telefone'])) {
} else {
	// Tipo: 1 comercial, 2 residencial
	// ClasseTel: 1 fixo, 2 celular
	$Tipo = 2;
	$ClasseTel = 1;
	// inserir
	$sql = "INSERT INTO telefone_profissional (id_profissional, NumeroTel, Tipo, ClasseTel) VALUES ('$id_profissional', '$Telefone', '$Tipo', '$ClasseTel')";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// atualizar
if (empty($_POST['Celular'])) {
} else {
	// Tipo: 1 comercial, 2 residencial
	// ClasseTel: 1 fixo, 2 celular
	$Tipo = 2;
	$ClasseTel = 2;
	// inserir
	$sql = "INSERT INTO telefone_profissional (id_profissional, NumeroTel, Tipo, ClasseTel) VALUES ('$id_profissional', '$Celular', '$Tipo', '$ClasseTel')";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// atualizar
if (empty($_POST['Email'])) {
} else {
	// TipoEmail: 1 comercial, 2 particular
	$TipoEmail = 2;
	// inserir
	$sql = "INSERT INTO email_profissional (id_profissional, EmailProfissional, TipoEmail) VALUES ('$id_profissional', '$Email', '$TipoEmail')";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}


// endereço
// ============================
// verificar se tem endereço cadastrado
$sql = "SELECT * FROM endereco_profissional WHERE id_profissional = '$id_profissional'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    	// tem
		$id_endereco_profissional = $row['id_endereco_profissional'];
    }
} else {
	// não tem
	// inserir
	$sqlA = "INSERT INTO endereco_profissional (id_profissional) VALUES ('$id_profissional')";
	if ($conn->query($sqlA) === TRUE) {
	} else {
	}

	// buscar xxx
	$sqlA = "SELECT * FROM endereco_profissional ORDER BY id_endereco_profissional DESC LIMIT 1";
	$resultA = $conn->query($sqlA);
	if ($resultA->num_rows > 0) {
	    while($rowA = $resultA->fetch_assoc()) {
			$id_endereco_profissional = $rowA['id_endereco_profissional'];
	    }
	} else {
	}
}

if (empty($id_endereco_profissional)) {
} else {
	// atualizar
	if (empty($_POST['Endereco'])) {
	} else {
		$Endereco = $_POST['Endereco'];
		// atualizar
		$sql = "UPDATE endereco_profissional SET Endereco = '$Endereco' WHERE id_endereco_profissional = '$id_endereco_profissional' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}

	// atualizar
	if (empty($_POST['Numero'])) {
	} else {
		$Numero = $_POST['Numero'];
		// atualizar
		$sql = "UPDATE endereco_profissional SET Numero = '$Numero' WHERE id_endereco_profissional = '$id_endereco_profissional' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}

	// atualizar
	if (empty($_POST['Complemento'])) {
	} else {
		$Complemento = $_POST['Complemento'];
		// atualizar
		$sql = "UPDATE endereco_profissional SET Complemento = '$Complemento' WHERE id_endereco_profissional = '$id_endereco_profissional' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}

	// atualizar
	if (empty($_POST['Cep'])) {
	} else {
		$Cep = $_POST['Cep'];
		// atualizar
		$sql = "UPDATE endereco_profissional SET Cep = '$Cep' WHERE id_endereco_profissional = '$id_endereco_profissional' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}

	// atualizar
	if (empty($_POST['Bairro'])) {
	} else {
		$Bairro = $_POST['Bairro'];
		// atualizar
		$sql = "UPDATE endereco_profissional SET Bairro = '$Bairro' WHERE id_endereco_profissional = '$id_endereco_profissional' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}

	// atualizar
	if (empty($_POST['Cidade'])) {
	} else {
		$Cidade = $_POST['Cidade'];
		// atualizar
		$sql = "UPDATE endereco_profissional SET Cidade = '$Cidade' WHERE id_endereco_profissional = '$id_endereco_profissional' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}

	// atualizar
	if (empty($_POST['Estado'])) {
	} else {
		$Estado = $_POST['Estado'];
		// atualizar
		$sql = "UPDATE endereco_profissional SET Estado = '$Estado' WHERE id_endereco_profissional = '$id_endereco_profissional' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}
}

// voltar
header("Location: profissional.php?id_profissional=$id_profissional");
exit;
?>
