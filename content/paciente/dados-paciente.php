<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// buscar dados
$sql = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$NomeCompleto = $row['NomeCompleto'];
		$NomeCurto = $row['NomeCurto'];
		$Rg = $row['Rg'];
		$OrgaoEmissor = $row['OrgaoEmissor'];
		
		if (!empty($row['Cpf'])) {
			$Cpf = $row['Cpf'];
			$Checkcpf = 1;
		} else {
			$Cpf = NULL;
			$Checkcpf = 0;
		}

		if (!empty($row['id_processo'])) {
			$id_processo = $row['id_processo'];
			$Checkprocesso = 1;
			// buscar xxx
			$sqlA = "SELECT * FROM processo WHERE id_processo = '$id_processo'";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					// tem
					$Processo = $rowA['Processo'];
			    }
			} else {
				// não tem
				$Processo = NULL;
			}
		} else {
			$id_processo = NULL;
			$Checkprocesso = 0;
			$Processo = NULL;
		}

		$DataNascimento = $row['DataNascimento'];
		if (empty($row['DataNascimento'])) {
			$DataNascimento1 = NULL;
		} else {
			$DataNascimento1 = date("d/m/Y", strtotime($DataNascimento));
			$DataNascimento2 = date("Y-m-d", strtotime($DataNascimento));
		}

		$DataInicio = $row['DataInicio'];
		if (empty($row['DataInicio'])) {
			$DataInicio1 = NULL;
		} else {
			$DataInicio1 = date("d/m/Y", strtotime($DataInicio));
			$DataInicio2 = date("Y-m-d", strtotime($DataInicio));
		}

		$Pai = $row['Pai'];
		$Mae = $row['Mae'];
		$Status = $row['Status'];
		if ($Status == 1) {
			$NomeStatus = 'Ativo';
		} else {
			$NomeStatus = 'Inativo';
		}
		$UsoImagem = $row['UsoImagem'];
		if ($UsoImagem == 1) {
			$NomeUsoImagem = 'Sim';
		} elseif ($UsoImagem == 2) {
			$NomeUsoImagem = 'Não';
		} else {
			$NomeUsoImagem = 'Selecionar';
		}

		$id_periodo = $row['id_periodo'];
		// buscar xxx
		$sqlA = "SELECT * FROM periodo WHERE id_periodo = '$id_periodo'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				$NomePeriodo = $rowA['NomePeriodo'];
		    }
		} else {
			$NomePeriodo = 'Selecionar';
		}

		$id_unidade = $row['id_unidade'];
		// buscar xxx
		$sqlA = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				$NomeUnidade = $rowA['NomeUnidade'];
		    }
		} else {
			$NomeUnidade = 'Selecionar';
		}
		if (!empty($id_unidade)) {
			$CheckUnidade = 1;
		} else {
			$CheckUnidade = 0;
		}

		// buscar xxx
		$sqlA = "SELECT * FROM periodo WHERE id_periodo = '$id_periodo'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				$NomePeriodo = $rowA['NomePeriodo'];
		    }
		} else {
			$NomePeriodo = NULL;
		}
		if (!empty($id_periodo)) {
			$CheckPeriodo = 1;
		} else {
			$CheckPeriodo = 0;
		}

		// buscar xxx
		$sqlA = "SELECT * FROM processo WHERE id_processo = '$id_processo'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				$Processo = $rowA['Processo'];
		    }
		} else {
			$Processo = NULL;
		}
    }
} else {
}

// buscar xxx
$sql = "SELECT * FROM endereco_paciente WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$Endereco = $row['Endereco'];
		$Numero = $row['Numero'];
		$Complemento = $row['Complemento'];
		$Cep = $row['Cep'];
		$Bairro = $row['Bairro'];
		$Cidade = $row['Cidade'];
		$Estado = $row['Estado'];
		if (!empty($Endereco)) {
			$Checkendereco = 1;
		} else {
			$Checkendereco = 0;
		}
		if (!empty($Numero)) {
			$Checknumero = 1;
		} else {
			$Checknumero = 0;
		}
		if (!empty($Cep)) {
			$Checkcep = 1;
		} else {
			$Checkcep = 0;
		}
		if (!empty($Bairro)) {
			$Checkbairro = 1;
		} else {
			$Checkbairro = 0;
		}
		if (!empty($Cidade)) {
			$Checkcidade = 1;
		} else {
			$Checkcidade = 0;
		}
		if (!empty($Estado)) {
			$Checkestado = 1;
		} else {
			$Checkestado = 0;
		}
		$Totalendereco = $Checkendereco + $Checknumero + $Checkbairro + $Checkcidade + $Checkestado;
		if ($Totalendereco == 5) {
			// todos os campos preenchidos
			$Checkaddress = 1;
		} else {
			$Checkaddress = 0;
		}
		
		if (empty($Complemento)) {
			$Endereco1 = $Endereco.', '.$Numero;
		} else {
			$Endereco1 = $Endereco.', '.$Numero.' - '.$Complemento;
		}

		// buscar xxx
		$sqlA = "SELECT * FROM estado WHERE Estado = '$Estado'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				$NomeEstado = $rowA['NomeEstado'];
		    }
		} else {
			$NomeEstado = 'Selecionar';
		}
    }
} else {
	$Endereco1 = NULL;
	$Endereco = NULL;
	$Numero = NULL;
	$Complemento = NULL;
	$Cep = NULL;
	$Bairro = NULL;
	$Cidade = NULL;
	$Estado = NULL;
	$NomeEstado = 'Selecionar';
	$Checkaddress = 0;
}

// buscar xxx
$sql = "SELECT * FROM paciente_observacao WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$PacienteObservacao = $row['PacienteObservacao'];
    }
} else {
	$PacienteObservacao = NULL;
}

// buscar xxx
$sql = "SELECT * FROM paciente_preferencia WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$PacientePreferencia = $row['PacientePreferencia'];
		$Checkpreferenciahorario = 1;
    }
} else {
	$PacientePreferencia = NULL;
	$Checkpreferenciahorario = 0;
}

if (empty($DataNascimento)) {
	$age = NULL;
	$Idade = NULL;
} else {
	# procedural
	$age = date_diff(date_create($DataNascimento2), date_create('today'))->y;
	if ($age == 1) {
		$Idade = '1 ano';
	} else {
		$Idade = $age.' anos';
	}
}

// verificar se o profissional está associado em uma sessão
$sql = "SELECT * FROM agenda_paciente WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    	// tem
		$CheckProfissional = 1;
    }
} else {
	$CheckProfissional = 2;
}

// verificar se foi usado no programa fp+
$sqlA = "SELECT * FROM fisiofor_prog.prog_incidental_1 WHERE fisiofor_prog.prog_incidental_1.id_paciente = '$id_paciente' LIMIT 1";
$resultA = $conn->query($sqlA);
if ($resultA->num_rows > 0) {
    while($rowA = $resultA->fetch_assoc()) {
		// tem
		$Checkfp = 1;
    }
} else {
	// não tem
	$Checkfp = 0;
}

// verificar se foi usado na agenda base
$sqlA = "SELECT * FROM agenda_paciente_base WHERE id_paciente = '$id_paciente' LIMIT 1";
$resultA = $conn->query($sqlA);
if ($resultA->num_rows > 0) {
    while($rowA = $resultA->fetch_assoc()) {
		// tem
		$Checkagendabase = 1;
    }
} else {
	// não tem
	$Checkagendabase = 0;
}

// verificar se foi usado na agenda
$sqlA = "SELECT * FROM agenda_paciente WHERE id_paciente = '$id_paciente' LIMIT 1";
$resultA = $conn->query($sqlA);
if ($resultA->num_rows > 0) {
    while($rowA = $resultA->fetch_assoc()) {
		// tem
		$Checkagenda = 1;
    }
} else {
	// não tem
	$Checkagenda = 0;
}

// verificar convenio
$sqlA = "SELECT * FROM convenio_paciente WHERE id_paciente = '$id_paciente' AND StatusConvenio = 1 LIMIT 1";
$resultA = $conn->query($sqlA);
if ($resultA->num_rows > 0) {
    while($rowA = $resultA->fetch_assoc()) {
		// tem
		$Checkconvenio = 1;
    }
} else {
	// não tem
	$Checkconvenio = 0;
}

// verificar convenio
$sqlA = "SELECT * FROM convenio_paciente WHERE id_paciente = '$id_paciente' AND StatusConvenio = 1 LIMIT 1";
$resultA = $conn->query($sqlA);
if ($resultA->num_rows > 0) {
    while($rowA = $resultA->fetch_assoc()) {
		// tem
		$Checkconvenio = 1;
		$NumeroConvenio = $row['NumeroConvenio'];
		if (!empty($NumeroConvenio)) {
			$CheckNumeroConvenio = 1;
		} else {
			$CheckNumeroConvenio = NULL;
		}
    }
} else {
	// não tem
	$Checkconvenio = 0;
	$CheckNumeroConvenio = NULL;
}

$Check = $Checkagenda + $Checkagendabase + $Checkfp;
?>