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
$sql = "TRUNCATE tmp_profissional";
if ($conn->query($sql) === TRUE) {
} else {
}

// importar os dados do profissional na tabela tmp_profissional
if(isset($_POST["Import"])){

$filename=$_FILES["file"]["tmp_name"];    
	if($_FILES["file"]["size"] > 0) {
	$file = fopen($filename, "r");
		while (($getData = fgetcsv($file, 10000, ";")) !== FALSE) {
			$sql = "INSERT into tmp_profissional (NomeTmp, FuncaoTmp, id_funcao) values ('".$getData[0]."','".$getData[1]."','".$getData[2]."')";
			$result = mysqli_query($conn, $sql);

			if (!isset($result)) {
			  echo "<script type=\"text/javascript\">
			      alert(\"Invalid File:Please Upload CSV File.\");
			      window.location = \"importar-profissionais.php\"
			      </script>";    
			} else {
			    echo "<script type=\"text/javascript\">
			    alert(\"CSV File has been successfully Imported.\");
			    window.location = \"importar-profissionais.php\"
			  </script>";
			}
		}

	   	fclose($file);  
	}
}

// separar o nome dos pais em 2 variáveis e salvar nas colunas
// buscar xxx
$sql = "SELECT * FROM tmp_profissional";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_tmp_profissional = $row['id_tmp_profissional'];
		
		$NomeTmp = $row['NomeTmp'];
		list($Nome1, $Nome2) = explode(' ', $NomeTmp);

		// atualizar
		$sqlA = "UPDATE tmp_profissional SET NomeCurto = '$Nome1' WHERE id_tmp_profissional = '$id_tmp_profissional' ";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}

		// atualizar
		$sqlA = "UPDATE tmp_profissional SET NomeCompleto = '$NomeTmp' WHERE id_tmp_profissional = '$id_tmp_profissional' ";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
    }
} else {
}
?>