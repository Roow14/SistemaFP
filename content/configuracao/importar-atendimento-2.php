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
$sql = "TRUNCATE agenda_paciente_tmp";
if ($conn->query($sql) === TRUE) {
} else {
}

// importar os dados do atendimento na tabela agenda_paciente_tmp
if(isset($_POST["Import"])){

$filename=$_FILES["file"]["tmp_name"];    
	if($_FILES["file"]["size"] > 0) {
	$file = fopen($filename, "r");
		while (($getData = fgetcsv($file, 10000, ";")) !== FALSE) {
			$sql = "INSERT into agenda_paciente_tmp (NomePaciente, Hora, DiaSemana, NomeCategoria, NomeProfissional) values ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."')";
			$result = mysqli_query($conn, $sql);

			if (!isset($result)) {
			  echo "<script type=\"text/javascript\">
			      alert(\"Invalid File:Please Upload CSV File.\");
			      window.location = \"importar-atendimento.php\"
			      </script>";    
			} else {
			    echo "<script type=\"text/javascript\">
			    alert(\"CSV File has been successfully Imported.\");
			    window.location = \"importar-atendimento.php\"
			  </script>";
			}
		}

	   	fclose($file);  
	}
}
?>