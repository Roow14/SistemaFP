<?php
// buscar dados
$sql = "SELECT * FROM profissional WHERE id_profissional = '$id_profissional'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$NomeCompleto = $row['NomeCompleto'];
		$NomeCurto = $row['NomeCurto'];
		$Usuario = $row['Usuario'];
		if (isset($row['Senha'])) {$NomeSenha = '******';} else {$NomeSenha = '';}
		$Nivel = $row['Nivel'];
		if ($Nivel == 2) {$NomeNivel = 'Administrador';} else {$NomeNivel = 'Usuário';}
		
		$Registro = $row['Registro'];
		$Crpj = $row['Crpj'];
		$Rg = $row['Rg'];
		$OrgaoEmissor = $row['OrgaoEmissor'];
		$Cpf = $row['Cpf'];
		$Status = $row['Status'];
		if ($Status == 2) {$NomeStatus = 'Inativo';} else {$NomeStatus = 'Ativo';}

		$DataNascimento = $row['DataNascimento'];
		
		if (empty($row['DataNascimento'])) {
			$DataNascimento1 = NULL;
		} else {
			$DataNascimento1 = date("d/m/Y", strtotime($DataNascimento));
		}

		$id_funcao = $row['id_funcao'];
		
		// buscar xxx
		$sqlA = "SELECT * FROM funcao WHERE id_funcao = '$id_funcao'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				$NomeFuncao = $rowA['NomeFuncao'];
		    }
		} else {
			$NomeFuncao = NULL;
		}
    }
} else {
}

// buscar xxx
$sql = "SELECT * FROM endereco_profissional WHERE id_profissional = '$id_profissional'";
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
	$Endereco = NULL;
	$Endereco1 = NULL;
	$Numero = NULL;
	$Complemento = NULL;
	$Cep = NULL;
	$Bairro = NULL;
	$Cidade = NULL;
	$Estado = NULL;
	$NomeEstado = 'Selecionar';
}

// buscar xxx
$sql = "SELECT * FROM profissional_graduacao WHERE id_profissional = '$id_profissional'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_profissional_graduacao = $row['id_profissional_graduacao'];
		$Graduacao = $row['Graduacao'];
    }
} else {
	$Graduacao = NULL;
}

// buscar xxx
$sql = "SELECT * FROM profissional_observacao WHERE id_profissional = '$id_profissional'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_profissional_observacao = $row['id_profissional_observacao'];
		$ProfissionalObservacao = $row['ProfissionalObservacao'];
    }
} else {
	$ProfissionalObservacao = NULL;
}

// verificar se o profissional está associado em uma sessão
$sql = "SELECT * FROM agenda_paciente WHERE id_profissional = '$id_profissional'";
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
$sqlA = "SELECT * FROM fisiofor_prog.prog_incidental_1 WHERE fisiofor_prog.prog_incidental_1.id_profissional = '$id_profissional' LIMIT 1";
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
$sqlA = "SELECT * FROM agenda_paciente_base WHERE id_profissional = '$id_profissional' LIMIT 1";
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
$sqlA = "SELECT * FROM agenda_paciente WHERE id_profissional = '$id_profissional' LIMIT 1";
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

$Check = $Checkagenda + $Checkagendabase + $Checkfp;
?>