<?php
session_start();
$target_dir = "../../vault/avaliacao/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imagemFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$id_paciente = $_SESSION['id_paciente'];
$id_avaliacao = $_SESSION['id_avaliacao'];

// verificar se é uma imagem
if(isset($_POST["submit"])) {
    if (($imagemFileType == 'jpg') OR ($imagemFileType == 'jpeg') OR ($imagemFileType == 'pdf')) {
        $uploadOk = 1;
    } else {
        echo "Erro: Escolha um arquivo no formato correto."; exit;
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Erro: O arquivo já existe";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 1000000) {
    echo "Erro: O tamanho do arquivo é muito grande.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imagemFileType != "pdf" && $imagemFileType != "jpg" && $imagemFileType != "jpeg") {
    echo "Erro: Os arquivos devem conter as extensões pdf, jpg ou jpeg.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo " e não foi importado.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        
        // iniciar conexão
        include "../conexao/conexao.php";
        
        // atualizar tabela midia
        $ArquivoMidia = basename($_FILES["fileToUpload"]["name"]);
        $sql = "INSERT INTO midia_exame (ArquivoMidia, id_paciente, id_avaliacao)
		VALUES ('$ArquivoMidia', '$id_paciente', '$id_avaliacao')";
		if ($conn->query($sql) === TRUE) {
		} else {
		}

		// buscar mídia recém criada
        $sql = "SELECT * FROM midia_exame ORDER BY id_midia_exame DESC LIMIT 1 ";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			// tem
			while($row = $result->fetch_assoc()) {
				$id_midia_exame = $row['id_midia_exame'];
		    }
		// não tem
		} else {
		}

        unset($_SESSION['id_avaliacao']);
        unset($_SESSION['id_paciente']);

        // fechar e voltar
		header("Location: pedido-medico.php?id_avaliacao=$id_avaliacao&id_paciente=$id_paciente");
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
exit;
?>