<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// $file = $_POST['csv'];
// $table = 'teste';

// limpar dados da tabela
$sql = "TRUNCATE tmp_paciente";
if ($conn->query($sql) === TRUE) {
} else {
}

// importar os dados do paciente na tabela tmp_paciente
if(isset($_POST["Import"])){

$filename=$_FILES["file"]["tmp_name"];    
	if($_FILES["file"]["size"] > 0) {
	$file = fopen($filename, "r");
		while (($getData = fgetcsv($file, 10000, ";")) !== FALSE) {
			$sql = "INSERT into tmp_paciente (NomeTmp, Pais, DataNascimento) values ('".$getData[0]."','".$getData[1]."','".$getData[2]."')";
			$result = mysqli_query($conn, $sql);

			if (!isset($result)) {
			  echo "<script type=\"text/javascript\">
			      alert(\"Invalid File:Please Upload CSV File.\");
			      window.location = \"importar-pacientes.php\"
			      </script>";    
			} else {
			    echo "<script type=\"text/javascript\">
			    alert(\"CSV File has been successfully Imported.\");
			    window.location = \"importar-pacientes.php\"
			  </script>";
			}
		}

	   	fclose($file);  
	}
}

// separar o nome dos pais em 2 variáveis e salvar nas colunas
// buscar xxx
$sql = "SELECT * FROM tmp_paciente";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_tmp_paciente = $row['id_tmp_paciente'];
		
		$Pais = $row['Pais'];
		list($Pai, $Mae) = explode('MaE:', $Pais);
		$Mae1 = strtolower($Mae);
		$Mae2 = ucwords($Mae1);

		$Pai1 = trim($Pai,"PAI: ");
		$Pai2 = strtolower($Pai1);
		$Pai3 = ucwords($Pai2);

		// atualizar
		$sqlA = "UPDATE tmp_paciente SET Pai = '$Pai3', Mae = '$Mae2' WHERE id_tmp_paciente = '$id_tmp_paciente' ";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}

		$NomeTmp = $row['NomeTmp'];
		$NomeTmp1 = strtolower($NomeTmp);
		$NomeCompleto = ucwords($NomeTmp1);

		// atualizar
		$sqlA = "UPDATE tmp_paciente SET NomeCompleto = '$NomeCompleto' WHERE id_tmp_paciente = '$id_tmp_paciente' ";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
    }
} else {
}

?>