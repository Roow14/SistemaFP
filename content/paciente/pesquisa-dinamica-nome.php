<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) 
{
session_destroy();
header("Location: ../../index.html"); exit;
}
?>

<style type="text/css">
	.txt-dinamico {
	    /*font-family: 'Poppins', sans-serif;*/
	    /*font-size: 16px;*/
	    /*font-weight: 400;*/
	    color: #3399ff;
	}
	.txt-dinamico:hover {
		color: #0066cc;
	}
	.txt-done {
		/*font-family: 'Poppins', sans-serif;*/
	    /*font-size: 16px;*/
	    font-weight: 600;
		color: #33cc33;
	}
</style>

<?php
include '../conexao/conexao.php';

// input
$search = $_POST['keywordNome'];

// buscar nome do paciente
$sql = "SELECT DISTINCT NomeCompleto FROM paciente WHERE NomeCompleto LIKE '%$search%' ORDER BY NomeCompleto LIMIT 0,5 ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$NomeCompleto = $row['NomeCompleto'];
		?>
		<div>
			<span onClick="selectNome('<?php echo $NomeCompleto;?>');" class="txt-dinamico"><?php echo $NomeCompleto;?></span>
		</div>
		<?php
    }
} else {
	// não encontrado
	?><span class="txt-done">Novo</span><?php
	exit;
}
?>