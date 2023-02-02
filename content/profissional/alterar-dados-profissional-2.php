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
$id_profissional = $_GET['id_profissional'];
$NomeCompleto = $_POST['NomeCompleto'];
$NomeCurto = $_POST['NomeCurto'];
$Usuario = $_POST['Usuario'];
$Senha = $_POST['Senha'];
$Nivel = $_POST['Nivel'];
$Rg = $_POST['Rg'];
$OrgaoEmissor = $_POST['OrgaoEmissor'];
$Cpf = $_POST['Cpf'];
$Registro = $_POST['Registro'];
$Crpj = $_POST['Crpj'];
$Status = $_POST['Status'];
$id_periodo = $_POST['id_periodo'];
$id_funcao = $_POST['id_funcao'];
$id_unidade = $_POST['id_unidade'];
$Endereco = $_POST['Endereco'];	
$Numero = $_POST['Numero'];	
$Complemento = $_POST['Complemento'];	
$Cep = $_POST['Cep'];	
$Bairro = $_POST['Bairro'];	
$Cidade = $_POST['Cidade'];	
$Estado = $_POST['Estado'];

$Telefone = $_POST['Telefone'];
$id_telefone = $_POST['id_telefone'];
$Celular = $_POST['Celular'];
$id_celular = $_POST['id_celular'];
$id_email_profissional = $_POST['id_email_profissional'];
$EmailProfissional = $_POST['EmailProfissional'];

$DataInicio = $_POST['DataInicio'];
$DataNascimento = $_POST['DataNascimento'];
$ProfissionalObservacao = $_POST['ProfissionalObservacao'];
$Graduacao = $_POST['Graduacao'];

if (empty($_POST['Graduacao'])) {
	// apagar
	$sql = "DELETE FROM profissional_graduacao WHERE id_profissional_graduacao = '$id_profissional_graduacao'";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// verificar se existe
	$sql = "SELECT * FROM profissional_graduacao WHERE id_profissional_graduacao = '$id_profissional_graduacao'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	    	// tem
			// atualizar
			$sqlA = "UPDATE profissional_graduacao SET Graduacao = '$Graduacao' WHERE id_profissional_graduacao = '$id_profissional_graduacao' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
	    }
	} else {
		// não tem
		// inserir
		$sqlA = "INSERT INTO profissional_graduacao (Graduacao, id_profissional) VALUES ('$Graduacao', '$id_profissional')";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
	}
}

if (empty($_POST['ProfissionalObservacao'])) {
	// apagar
	$sql = "DELETE FROM profissional_observacao WHERE id_profissional_observacao = '$id_profissional_observacao'";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// verificar se existe
	$sql = "SELECT * FROM profissional_observacao WHERE id_profissional_observacao = '$id_profissional_observacao'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	    	// tem
			// atualizar
			$sqlA = "UPDATE profissional_observacao SET ProfissionalObservacao = '$ProfissionalObservacao' WHERE id_profissional_observacao = '$id_profissional_observacao' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
	    }
	} else {
		// não tem
		// inserir
		$sqlA = "INSERT INTO profissional_observacao (ProfissionalObservacao, id_profissional) VALUES ('$ProfissionalObservacao', '$id_profissional')";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
	}
}

if (empty($_POST['DataInicio'])) {
	// atualizar
	$sql = "UPDATE profissional SET DataInicio = NULL WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE profissional SET DataInicio = '$DataInicio' WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['DataNascimento'])) {
	// atualizar
	$sql = "UPDATE profissional SET DataNascimento = NULL WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE profissional SET DataNascimento = '$DataNascimento' WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['EmailProfissional'])) {
	// apagar
	$sql = "DELETE FROM email_profissional WHERE id_email_profissional = '$id_email_profissional'";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// verificar se existe
	$sql = "SELECT * FROM email_profissional WHERE id_email_profissional = '$id_email_profissional'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	    	// tem
			// atualizar
			$sqlA = "UPDATE email_profissional SET EmailProfissional = '$EmailProfissional' WHERE id_email_profissional = '$id_email_profissional' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
	    }
	} else {
		// não tem
		// inserir
		$sqlA = "INSERT INTO email_profissional (EmailProfissional, TipoEmail, id_profissional) VALUES ('$EmailProfissional', 2, '$id_profissional')";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
	}
}

if (empty($_POST['Telefone'])) {
	// apagar
	$sql = "DELETE FROM telefone_profissional WHERE id_telefone_profissional = '$id_telefone'";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// verificar se existe
	$sql = "SELECT * FROM telefone_profissional WHERE id_telefone_profissional = '$id_telefone'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	    	// tem
			// atualizar
			$sqlA = "UPDATE telefone_profissional SET NumeroTel = '$Telefone' WHERE id_telefone_profissional = '$id_telefone' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
	    }
	} else {
		// não tem
		// inserir
		$sqlA = "INSERT INTO telefone_profissional (NumeroTel, ClasseTel, id_profissional) VALUES ('$Telefone', 1, '$id_profissional')";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
	}
}

if (empty($_POST['Celular'])) {
	// apagar
	$sql = "DELETE FROM telefone_profissional WHERE id_telefone_profissional = '$id_celular'";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// verificar se existe
	$sql = "SELECT * FROM telefone_profissional WHERE id_telefone_profissional = '$id_celular'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	    	// tem
			// atualizar
			$sqlA = "UPDATE telefone_profissional SET NumeroTel = '$Celular' WHERE id_telefone_profissional = '$id_celular' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
	    }
	} else {
		// não tem
		// inserir
		$sqlA = "INSERT INTO telefone_profissional (NumeroTel, ClasseTel, id_profissional) VALUES ('$Celular', 2, '$id_profissional')";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
	}
}

if (empty($_POST['id_periodo'])) {
	// atualizar
	$sql = "UPDATE profissional SET id_periodo = NULL WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE profissional SET id_periodo = '$id_periodo' WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['id_unidade'])) {
	// atualizar
	$sql = "UPDATE profissional SET id_unidade = NULL WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE profissional SET id_unidade = '$id_unidade' WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['id_funcao'])) {
	// atualizar
	$sql = "UPDATE profissional SET id_funcao = NULL WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE profissional SET id_funcao = '$id_funcao' WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['Registro'])) {
	// atualizar
	$sql = "UPDATE profissional SET Registro = NULL WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE profissional SET Registro = '$Registro' WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['Crpj'])) {
	// atualizar
	$sql = "UPDATE profissional SET Crpj = NULL WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE profissional SET Crpj = '$Crpj' WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['Rg'])) {
	// atualizar
	$sql = "UPDATE profissional SET Rg = NULL WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE profissional SET Rg = '$Rg' WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['OrgaoEmissor'])) {
	// atualizar
	$sql = "UPDATE profissional SET OrgaoEmissor = NULL WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE profissional SET OrgaoEmissor = '$OrgaoEmissor' WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['Cpf'])) {
	// atualizar
	$sql = "UPDATE profissional SET Cpf = NULL WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE profissional SET Cpf = '$Cpf' WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['NomeCompleto'])) {
	// atualizar
	$sql = "UPDATE profissional SET NomeCompleto = NULL WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE profissional SET NomeCompleto = '$NomeCompleto' WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['NomeCurto'])) {
	// atualizar
	$sql = "UPDATE profissional SET NomeCurto = NULL WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE profissional SET NomeCurto = '$NomeCurto' WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['Usuario'])) {
	// atualizar
	$sql = "UPDATE profissional SET Usuario = NULL WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE profissional SET Usuario = '$Usuario' WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST["Senha"])) {
} else {
	$Senha = $_POST["Senha"];
	$sql = "UPDATE profissional SET Senha = SHA1('$Senha') WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['Nivel'])) {
	// atualizar
	$sql = "UPDATE profissional SET Nivel = NULL WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE profissional SET Nivel = '$Nivel' WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['Status'])) {
	// atualizar
	$sql = "UPDATE profissional SET Status = NULL WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE profissional SET Status = '$Status' WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}


// endereço
// verificar se tem endereço
// buscar xxx
$sql = "SELECT * FROM endereco_profissional WHERE id_profissional = '$id_profissional'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_endereco_profissional = $row['id_endereco_profissional'];

		if (empty($_POST['Endereco'])) {
			// atualizar
			$sql = "UPDATE endereco_profissional SET Endereco = NULL WHERE id_endereco_profissional = '$id_endereco_profissional' ";
			if ($conn->query($sql) === TRUE) {
			} else {
			}
		} else {
			// atualizar
			$sql = "UPDATE endereco_profissional SET Endereco = '$Endereco' WHERE id_endereco_profissional = '$id_endereco_profissional' ";
			if ($conn->query($sql) === TRUE) {
			} else {
			}
		}

		if (empty($_POST['Numero'])) {
			// atualizar
			$sql = "UPDATE endereco_profissional SET Numero = NULL WHERE id_endereco_profissional = '$id_endereco_profissional' ";
			if ($conn->query($sql) === TRUE) {
			} else {
			}
		} else {
			// atualizar
			$sql = "UPDATE endereco_profissional SET Numero = '$Numero' WHERE id_endereco_profissional = '$id_endereco_profissional' ";
			if ($conn->query($sql) === TRUE) {
			} else {
			}
		}

		if (empty($_POST['Complemento'])) {
			// atualizar
			$sql = "UPDATE endereco_profissional SET Complemento = NULL WHERE id_endereco_profissional = '$id_endereco_profissional' ";
			if ($conn->query($sql) === TRUE) {
			} else {
			}
		} else {
			// atualizar
			$sql = "UPDATE endereco_profissional SET Complemento = '$Complemento' WHERE id_endereco_profissional = '$id_endereco_profissional' ";
			if ($conn->query($sql) === TRUE) {
			} else {
			}
		}

		if (empty($_POST['Cep'])) {
			// atualizar
			$sql = "UPDATE endereco_profissional SET Cep = NULL WHERE id_endereco_profissional = '$id_endereco_profissional' ";
			if ($conn->query($sql) === TRUE) {
			} else {
			}
		} else {
			// atualizar
			$sql = "UPDATE endereco_profissional SET Cep = '$Cep' WHERE id_endereco_profissional = '$id_endereco_profissional' ";
			if ($conn->query($sql) === TRUE) {
			} else {
			}
		}

		if (empty($_POST['Bairro'])) {
			// atualizar
			$sql = "UPDATE endereco_profissional SET Bairro = NULL WHERE id_endereco_profissional = '$id_endereco_profissional' ";
			if ($conn->query($sql) === TRUE) {
			} else {
			}
		} else {
			// atualizar
			$sql = "UPDATE endereco_profissional SET Bairro = '$Bairro' WHERE id_endereco_profissional = '$id_endereco_profissional' ";
			if ($conn->query($sql) === TRUE) {
			} else {
			}
		}

		if (empty($_POST['Cidade'])) {
			// atualizar
			$sql = "UPDATE endereco_profissional SET Cidade = NULL WHERE id_endereco_profissional = '$id_endereco_profissional' ";
			if ($conn->query($sql) === TRUE) {
			} else {
			}
		} else {
			// atualizar
			$sql = "UPDATE endereco_profissional SET Cidade = '$Cidade' WHERE id_endereco_profissional = '$id_endereco_profissional' ";
			if ($conn->query($sql) === TRUE) {
			} else {
			}
		}

		if (empty($_POST['Estado'])) {
			// atualizar
			$sql = "UPDATE endereco_profissional SET Estado = NULL WHERE id_endereco_profissional = '$id_endereco_profissional' ";
			if ($conn->query($sql) === TRUE) {
			} else {
			}
		} else {
			// atualizar
			$sql = "UPDATE endereco_profissional SET Estado = '$Estado' WHERE id_endereco_profissional = '$id_endereco_profissional' ";
			if ($conn->query($sql) === TRUE) {
			} else {
			}
		}
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

	if (empty($_POST['Endereco'])) {
		// atualizar
		$sql = "UPDATE endereco_profissional SET Endereco = NULL WHERE id_endereco_profissional = '$id_endereco_profissional' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	} else {
		// atualizar
		$sql = "UPDATE endereco_profissional SET Endereco = '$Endereco' WHERE id_endereco_profissional = '$id_endereco_profissional' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}

	if (empty($_POST['Numero'])) {
		// atualizar
		$sql = "UPDATE endereco_profissional SET Numero = NULL WHERE id_endereco_profissional = '$id_endereco_profissional' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	} else {
		// atualizar
		$sql = "UPDATE endereco_profissional SET Numero = '$Numero' WHERE id_endereco_profissional = '$id_endereco_profissional' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}

	if (empty($_POST['Complemento'])) {
		// atualizar
		$sql = "UPDATE endereco_profissional SET Complemento = NULL WHERE id_endereco_profissional = '$id_endereco_profissional' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	} else {
		// atualizar
		$sql = "UPDATE endereco_profissional SET Complemento = '$Complemento' WHERE id_endereco_profissional = '$id_endereco_profissional' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}

	if (empty($_POST['Cep'])) {
		// atualizar
		$sql = "UPDATE endereco_profissional SET Cep = NULL WHERE id_endereco_profissional = '$id_endereco_profissional' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	} else {
		// atualizar
		$sql = "UPDATE endereco_profissional SET Cep = '$Cep' WHERE id_endereco_profissional = '$id_endereco_profissional' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}

	if (empty($_POST['Bairro'])) {
		// atualizar
		$sql = "UPDATE endereco_profissional SET Bairro = NULL WHERE id_endereco_profissional = '$id_endereco_profissional' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	} else {
		// atualizar
		$sql = "UPDATE endereco_profissional SET Bairro = '$Bairro' WHERE id_endereco_profissional = '$id_endereco_profissional' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}

	if (empty($_POST['Cidade'])) {
		// atualizar
		$sql = "UPDATE endereco_profissional SET Cidade = NULL WHERE id_endereco_profissional = '$id_endereco_profissional' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	} else {
		// atualizar
		$sql = "UPDATE endereco_profissional SET Cidade = '$Cidade' WHERE id_endereco_profissional = '$id_endereco_profissional' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}

	if (empty($_POST['Estado'])) {
		// atualizar
		$sql = "UPDATE endereco_profissional SET Estado = NULL WHERE id_endereco_profissional = '$id_endereco_profissional' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	} else {
		// atualizar
		$sql = "UPDATE endereco_profissional SET Estado = '$Estado' WHERE id_endereco_profissional = '$id_endereco_profissional' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}

	
}

// voltar
header("Location: alterar-profissional.php?id_profissional=$id_profissional");
exit;
?>
