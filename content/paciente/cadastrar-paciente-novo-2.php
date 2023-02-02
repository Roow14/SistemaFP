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
$DataNascimento = $_POST['DataNascimento'];
$Cpf = $_POST['Cpf'];
$Rg = $_POST['Rg'];
// $PacienteObservacao = $_POST['PacienteObservacao'];
$id_convenio = $_POST['id_convenio'];
$NumeroConvenio = $_POST['NumeroConvenio'];
// $NotaConvenio = $_POST['NotaConvenio'];
$Pai = $_POST['Pai'];
// $NumeroTelPai = $_POST['NumeroTelPai'];
// $EmailPai = $_POST['EmailPai'];
$Mae = $_POST['Mae'];
// $NumeroTelMae = $_POST['NumeroTelMae'];
// $EmailMae = $_POST['EmailMae'];
// $NotaMae = $_POST['NotaMae'];
$OrgaoEmissor = $_POST['OrgaoEmissor'];
$id_processo = $_POST['id_processo'];

// buscar xxx
$sql = "SELECT * FROM paciente WHERE NomeCompleto = '$NomeCompleto'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		// mensagem de alerta
		echo "<script type=\"text/javascript\">
		    alert(\"Erro: existe um paciente com o mesmo nome no sistema..\");
		    window.location = \"cadastrar-paciente-novo.php\"
		    </script>";
		exit;
    }
} else {
	// não tem
}

// obter o primeiro nome
function fullNameToFirstName($fullName, $checkFirstNameLength=TRUE)
{
	// Split out name so we can quickly grab the first name part
	$nameParts = explode(' ', $fullName);
	$firstName = $nameParts[0];

	// If the first part of the name is a prefix, then find the name differently
	if(in_array(strtolower($firstName), array('mr', 'ms', 'mrs', 'miss', 'dr'))) {
		if($nameParts[2]!='') {
			// E.g. Mr James Smith -> James
			$firstName = $nameParts[1];
		} else {
			// e.g. Mr Smith (no first name given)
			$firstName = $fullName;
		}
	}

	// make sure the first name is not just "J", e.g. "J Smith" or "Mr J Smith" or even "Mr J. Smith"
	if($checkFirstNameLength && strlen($firstName)<3) {
		$firstName = $fullName;
	}
	return $firstName;
}

$NomeCurto = fullNameToFirstName($NomeCompleto);

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
		$_SESSION['id_paciente'] = $id_paciente;
    }
} else {
}

if (empty($_POST['DataNascimento'])) {
} else {
	// atualizar
	$sql = "UPDATE paciente SET DataNascimento = '$DataNascimento' WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['Rg'])) {
} else {
	// atualizar
	$sql = "UPDATE paciente SET Rg = '$Rg' WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['OrgaoEmissor'])) {
} else {
	// atualizar
	$sql = "UPDATE paciente SET OrgaoEmissor = '$OrgaoEmissor' WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['Cpf'])) {
} else {
	// atualizar
	$sql = "UPDATE paciente SET Cpf = '$Cpf' WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['Pai'])) {
} else {
	// atualizar
	$sql = "UPDATE paciente SET Pai = '$Pai' WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['Mae'])) {
} else {
	// atualizar
	$sql = "UPDATE paciente SET Mae = '$Mae' WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// if (empty($_POST['PacienteObservacao'])) {
// } else {
// 	// inserir
// 	$sql = "INSERT INTO paciente_observacao (PacienteObservacao, id_paciente) VALUES ('$PacienteObservacao', '$id_paciente')";
// 	if ($conn->query($sql) === TRUE) {
// 	} else {
// 	}
// }

if (empty($_POST['id_convenio'])) {
} else {
	// inserir
	$sql = "INSERT INTO convenio_paciente (id_convenio, id_paciente) VALUES ('$id_convenio', '$id_paciente')";
	if ($conn->query($sql) === TRUE) {
		// buscar xxx
		$sqlA = "SELECT * FROM convenio_paciente ORDER BY id_convenio_paciente DESC LIMIT 1";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$id_convenio_paciente = $rowA['id_convenio_paciente'];

				if (empty($_POST['NumeroConvenio'])) {
				} else {
					// atualizar
					$sqlB = "UPDATE convenio_paciente SET NumeroConvenio = '$NumeroConvenio' WHERE id_paciente = '$id_paciente' ";
					if ($conn->query($sqlB) === TRUE) {
					} else {
					}
				}

				// if (empty($_POST['NotaConvenio'])) {
				// } else {
				// 	// atualizar
				// 	$sqlB = "UPDATE convenio_paciente SET NotaConvenio = '$NotaConvenio' WHERE id_paciente = '$id_paciente' ";
				// 	if ($conn->query($sqlB) === TRUE) {
				// 	} else {
				// 	}
				// }
		    }
		} else {
			// não tem
		}
	} else {
	}	
}

if (empty($_POST['id_processo'])) {
} else {
	// atualizar
	$sql = "UPDATE paciente SET id_processo = '$id_processo' WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// voltar
header("Location: alterar-paciente-novo.php");
exit;
?>
