<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// limpar dados da tabela
$sql = "TRUNCATE categoria_profissional_tmp";
if ($conn->query($sql) === TRUE) {
} else {
}

// buscar id_periodo 1 e salvar na tabela tmp
$sql = "SELECT * FROM profissional ORDER BY id_profissional ASC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_profissional = $row['id_profissional'];

		// buscar id_periodo 1 e salvar na tabela tmp
		$sqlA = "SELECT * FROM categoria_profissional WHERE id_profissional = '$id_profissional'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$id_profissional = $rowA['id_profissional'];
				$id_categoria_profissional = $rowA['id_categoria_profissional'];
				$id_categoria = $rowA['id_categoria'];
				$id_unidade = $rowA['id_unidade'];
				$id_periodo = $rowA['id_periodo'];

				if ($id_periodo == 1) {

					// buscar xxx
					$sqlB = "SELECT * FROM categoria_profissional_tmp WHERE id_profissional = '$id_profissional' AND id_categoria = '$id_categoria' AND id_unidade = '$id_unidade' AND id_periodo1 = '$id_periodo'";
					$resultB = $conn->query($sqlB);
					if ($resultB->num_rows > 0) {
					    while($rowB = $resultB->fetch_assoc()) {
							// tem
						
					    }
					} else {
						// não tem
						// inserir
						$sqlC = "INSERT INTO categoria_profissional_tmp (id_profissional, id_categoria, id_unidade, id_periodo1) VALUES ('$id_profissional', '$id_categoria', '$id_unidade', '$id_periodo')";
						if ($conn->query($sqlC) === TRUE) {

							// buscar xxx
							$sqlD = "SELECT * FROM categoria_profissional_tmp ORDER BY id_categoria_profissional DESC LIMIT 1";
							$resultD = $conn->query($sqlD);
							if ($resultD->num_rows > 0) {
							    while($rowD = $resultD->fetch_assoc()) {
									// tem
									$id_categoria_profissional = $rowD['id_categoria_profissional'];

									// buscar xxx
									$sqlE = "SELECT * FROM categoria_profissional WHERE id_profissional = '$id_profissional' AND id_categoria = '$id_categoria' AND id_unidade = '$id_unidade' AND id_periodo = 2";
									$resultE = $conn->query($sqlE);
									if ($resultE->num_rows > 0) {
									    while($rowE = $resultE->fetch_assoc()) {
											// tem
											// atualizar
											$sqlF = "UPDATE categoria_profissional_tmp SET id_periodo2 = 2 WHERE id_categoria_profissional = '$id_categoria_profissional' ";
											if ($conn->query($sqlF) === TRUE) {
											} else {
											}

											// atualizar
											$sqlF = "UPDATE categoria_profissional_tmp SET id_periodo10 = 10 WHERE id_categoria_profissional = '$id_categoria_profissional' ";
											if ($conn->query($sqlF) === TRUE) {
											} else {
											}
										
									    }
									} else {
										// não tem
										
									}
							    }
							} else {
								// não tem
							}

						} else {
						}
					}

									
							
				} else {

				}
					

				echo $id_profissional.' - '.$id_categoria.' - '.$id_unidade.' - '.$id_periodo.'<br>';
		    }
		} else {
			// não tem
		}
		
    }
} else {
	// não tem
	// mensagem de alerta
	echo "<script type=\"text/javascript\">
	    alert(\"Erro .\");
	    window.location = \"configuracao.php\"
	    </script>";
	exit;
}

// mensagem de alerta
echo "<script type=\"text/javascript\">
    alert(\"Sucesso: itens salvos na tabela categoria_profissional_tmp.\");
    window.location = \"configuracao.php\"
    </script>";
exit;	

// voltar
// header("Location: configurar-estado.php?id=#$id_estado");
exit;
?>
