<?php
session_start();
$target_dir = "../../vault/paciente/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imagemFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$id_paciente = $_SESSION['id_paciente'];

// verificar se é uma imagem
if(isset($_POST["submit"])) {
    if (($imagemFileType == 'jpg') OR ($imagemFileType == 'png') OR ($imagemFileType == 'jpeg') OR ($imagemFileType == 'gif')) {
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
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Erro: O tamanho do arquivo é muito grande.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imagemFileType != "jpg" && $imagemFileType != "png" && $imagemFileType != "jpeg" && $imagemFileType != "gif") {
    echo "Erro: Os arquivos devem conter as extensões jpg, png, jpeg ou gif.";
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
        $sql = "INSERT INTO midia_paciente (ArquivoMidia, id_paciente)
		VALUES ('$ArquivoMidia', '$id_paciente')";
		if ($conn->query($sql) === TRUE) {
		} else {
		}

        unset($_SESSION['id_paciente']);

        // fechar e voltar
		header("Location: paciente.php?id_paciente=$id_paciente");
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
exit;
?>