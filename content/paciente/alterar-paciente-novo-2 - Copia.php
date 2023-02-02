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
$NomeCompleto = $_POST['NomeCompleto'];
$NomeCurto = $_POST['NomeCurto'];
$DataNascimento = $_POST['DataNascimento'];
$Cpf = $_POST['Cpf'];
$Rg = $_POST['Rg'];
$OrgaoEmissor = $_POST['OrgaoEmissor'];
$Pai = $_POST['Pai'];
$Mae = $_POST['Mae'];
$UsoImagem = $_POST['UsoImagem'];
$id_periodo = $_POST['id_periodo'];
$id_unidade = $_POST['id_unidade'];

$Endereco = $_POST['Endereco'];
$Numero = $_POST['Numero'];
$Complemento = $_POST['Complemento'];
$Cep = $_POST['Cep'];
$Bairro = $_POST['Bairro'];
$Cidade = $_POST['Cidade'];
$Estado = $_POST['Estado'];

$PacienteObservacao = $_POST['PacienteObservacao'];
$PacienteObservacao = str_replace("'","&#39;",$PacienteObservacao);
$PacienteObservacao = str_replace('"','&#34;',$PacienteObservacao);

$PacientePreferencia = $_POST['PacientePreferencia'];
$PacientePreferencia = str_replace("'","&#39;",$PacientePreferencia);
$PacientePreferencia = str_replace('"','&#34;',$PacientePreferencia);

if (empty($_POST['NomeCompleto'])) {
	// atualizar
	$sql = "UPDATE paciente SET NomeCompleto = NULL WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE paciente SET NomeCompleto = '$NomeCompleto' WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['NomeCurto'])) {
	// atualizar
	$sql = "UPDATE paciente SET NomeCurto = NULL WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE paciente SET NomeCurto = '$NomeCurto' WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['DataNascimento'])) {
	// atualizar
	$sql = "UPDATE paciente SET DataNascimento = NULL WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE paciente SET DataNascimento = '$DataNascimento' WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['Rg'])) {
	// atualizar
	$sql = "UPDATE paciente SET Rg = NULL WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE paciente SET Rg = '$Rg' WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['OrgaoEmissor'])) {
	// atualizar
	$sql = "UPDATE paciente SET OrgaoEmissor = NULL WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE paciente SET OrgaoEmissor = '$OrgaoEmissor' WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['Cpf'])) {
	// atualizar
	$sql = "UPDATE paciente SET Cpf = NULL WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE paciente SET Cpf = '$Cpf' WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['Pai'])) {
	// atualizar
	$sql = "UPDATE paciente SET Pai = NULL WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE paciente SET Pai = '$Pai' WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['Mae'])) {
	// atualizar
	$sql = "UPDATE paciente SET Mae = NULL WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE paciente SET Mae = '$Mae' WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['Mae'])) {
	// atualizar
	$sql = "UPDATE paciente SET UsoImagem = NULL WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE paciente SET UsoImagem = '$UsoImagem' WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['id_periodo'])) {
	// atualizar
	$sql = "UPDATE paciente SET id_periodo = NULL WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE paciente SET id_periodo = '$id_periodo' WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['id_unidade'])) {
	// atualizar
	$sql = "UPDATE paciente SET id_unidade = NULL WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE paciente SET id_unidade = '$id_unidade' WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// buscar xxx
$sql = "SELECT * FROM paciente_observacao WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_paciente_observacao = $row['id_paciente_observacao'];

		if (empty($_POST['PacienteObservacao'])) {
			// atualizar
			$sqlA = "UPDATE paciente_observacao SET PacienteObservacao = NULL WHERE id_paciente_observacao = '$id_paciente_observacao' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
		} else {
			// atualizar
			$sqlA = "UPDATE paciente_observacao SET PacienteObservacao = '$PacienteObservacao' WHERE id_paciente_observacao = '$id_paciente_observacao' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
		}
    }
} else {
	// não tem
	// inserir
	$sqlA = "INSERT INTO paciente_observacao (PacienteObservacao, id_paciente) VALUES ('$PacienteObservacao', '$id_paciente')";
	if ($conn->query($sqlA) === TRUE) {
	} else {
	}
}

// buscar xxx
$sql = "SELECT * FROM paciente_preferencia WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_paciente_preferencia = $row['id_paciente_preferencia'];

		if (empty($_POST['PacientePreferencia'])) {
			// atualizar
			$sqlA = "UPDATE paciente_preferencia SET PacientePreferencia = NULL WHERE id_paciente_preferencia = '$id_paciente_preferencia' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
		} else {
			// atualizar
			$sqlA = "UPDATE paciente_preferencia SET PacientePreferencia = '$PacientePreferencia' WHERE id_paciente_preferencia = '$id_paciente_preferencia' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
		}
    }
} else {
	// não tem
	// inserir
	$sqlA = "INSERT INTO paciente_preferencia (PacientePreferencia, id_paciente) VALUES ('$PacientePreferencia', '$id_paciente')";
	if ($conn->query($sqlA) === TRUE) {
	} else {
	}
}

// buscar xxx
$sql = "SELECT * FROM endereco_paciente WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_endereco_paciente = $row['id_endereco_paciente'];

		if (empty($_POST['Endereco'])) {
			// atualizar
			$sqlA = "UPDATE endereco_paciente SET Endereco = NULL WHERE id_endereco_paciente = '$id_endereco_paciente' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
		} else {
			// atualizar
			$sqlA = "UPDATE endereco_paciente SET Endereco = '$Endereco' WHERE id_endereco_paciente = '$id_endereco_paciente' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
		}

		if (empty($_POST['Numero'])) {
			// atualizar
			$sqlA = "UPDATE endereco_paciente SET  = NULL WHERE id_endereco_paciente = '$id_endereco_paciente' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
		} else {
			// atualizar
			$sqlA = "UPDATE endereco_paciente SET Numero = '$Numero' WHERE id_endereco_paciente = '$id_endereco_paciente' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
		}

		if (empty($_POST['Complemento'])) {
			// atualizar
			$sqlA = "UPDATE endereco_paciente SET Complemento = NULL WHERE id_endereco_paciente = '$id_endereco_paciente' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
		} else {
			// atualizar
			$sqlA = "UPDATE endereco_paciente SET Complemento = '$Complemento' WHERE id_endereco_paciente = '$id_endereco_paciente' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
		}

		if (empty($_POST['Cep'])) {
			// atualizar
			$sqlA = "UPDATE endereco_paciente SET Cep = NULL WHERE id_endereco_paciente = '$id_endereco_paciente' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
		} else {
			// atualizar
			$sqlA = "UPDATE endereco_paciente SET Cep = '$Cep' WHERE id_endereco_paciente = '$id_endereco_paciente' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
		}

		if (empty($_POST['Bairro'])) {
			// atualizar
			$sqlA = "UPDATE endereco_paciente SET Bairro = NULL WHERE id_endereco_paciente = '$id_endereco_paciente' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
		} else {
			// atualizar
			$sqlA = "UPDATE endereco_paciente SET Bairro = '$Bairro' WHERE id_endereco_paciente = '$id_endereco_paciente' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
		}

		if (empty($_POST['Cidade'])) {
			// atualizar
			$sqlA = "UPDATE endereco_paciente SET Cidade = NULL WHERE id_endereco_paciente = '$id_endereco_paciente' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
		} else {
			// atualizar
			$sqlA = "UPDATE endereco_paciente SET Cidade = '$Cidade' WHERE id_endereco_paciente = '$id_endereco_paciente' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
		}

		if (empty($_POST['Estado'])) {
			// atualizar
			$sqlA = "UPDATE endereco_paciente SET Estado = NULL WHERE id_endereco_paciente = '$id_endereco_paciente' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
		} else {
			// atualizar
			$sqlA = "UPDATE endereco_paciente SET Estado = '$Estado' WHERE id_endereco_paciente = '$id_endereco_paciente' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
		}
    }
} else {
	// não tem
	// inserir
	$sqlA = "INSERT INTO endereco_paciente (Endereco, id_paciente) VALUES ('$Endereco', '$id_paciente')";
	if ($conn->query($sqlA) === TRUE) {
	} else {
	}
}		

// voltar
header("Location: alterar-paciente-novo.php");
exit;
?>
