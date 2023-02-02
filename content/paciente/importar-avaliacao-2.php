<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

$target_dir = "../../vault/avaliacao/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);


$imagemFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// $id_produto = $_GET['id_produto'];

function resize_imagejpg($file, $w, $h) {
   list($width, $height) = getimagesize($file);
   $src = imagecreatefromjpeg($file);
   $dst = imagecreatetruecolor($w, $h);
   imagecopyresampled($dst, $src, 0, 0, 0, 0, $w, $h, $width, $height);
   return $dst;
}


function resize_imagepng($file, $w, $h) {
   list($width, $height) = getimagesize($file);
   $src = imagecreatefrompng($file);
   $dst = imagecreatetruecolor($w, $h);
   imagecopyresampled($dst, $src, 0, 0, 0, 0, $w, $h, $width, $height);
   return $dst;
}
$id_paciente = $_GET['id_paciente'];
$Origem = 'listar-avaliacoes.php?id_paciente='.$id_paciente;

// verificar se é uma imagem
if (isset($_POST["submit"])) {
    if (($imagemFileType == 'jpg') OR ($imagemFileType == 'png') OR ($imagemFileType == 'jpeg') OR ($imagemFileType == 'gif') OR ($imagemFileType == 'pdf')) {
    } else {
        echo "<Erro: os arquivos devem conter as extensões jpg, png, jpeg, gif ou pdf.\");
        window.location = \"$Origem\"
        </script>";
        exit;
    }
} else {

}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 10000000) {
    echo "<script type=\"text/javascript\">
    alert(\"Erro: o tamanho do arquivo é muito grande.\");
    window.location = \"$Origem\"
    </script>";
exit;
} else {

}

// Allow certain file formats
if($imagemFileType != "jpg" && $imagemFileType != "png" && $imagemFileType != "jpeg" && $imagemFileType != "gif" && $imagemFileType != "pdf") {
    echo "<script type=\"text/javascript\">
    alert(\"Erro: os arquivos devem conter as extensões jpg, png, jpeg, gif pdf.\");
    window.location = \"$Origem\"
    </script>";
} else {

}

// importar o arquivo
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    
    // iniciar conexão
    include "../conexao/conexao.php";
    
    // atualizar tabela midia
    $ArquivoMidia = basename($_FILES["fileToUpload"]["name"]);

    // obter tamanho do arquivo
    // list($width, $height) = getimagesize($target_file);
    // $widthX = 400;
    // $heightX = 400 * $height / $width;

    // // ajustar tamanho do arquivo
    // if($imagemFileType == 'png'){
    //   $img = resize_imagepng($target_file,400,400);
    // }else{
    //   $img = resize_imagejpg($target_file,$widthX,$heightX);
    // }

    // imagejpeg($img, $target_file);

    // buscar xxx
    $sql = "SELECT * FROM midia_avaliacao WHERE ArquivoMidia = '$ArquivoMidia'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // tem
            echo "<script type=\"text/javascript\">
                alert(\"Erro: o nome do arquivo já existe e não foi importado.\");
                window.location = \"$Origem\"
                </script>";
            exit;
        }
    } else {
        // não tem
    }

    $sql = "INSERT INTO midia_avaliacao (ArquivoMidia, id_paciente)
    VALUES ('$ArquivoMidia', '$id_paciente')";
    if ($conn->query($sql) === TRUE) {
    } else {
    }

} else {
    echo "<script type=\"text/javascript\">
        alert(\"Erro: o arquivo não foi importado.\");
        window.location = \"$Origem\"
        </script>";
    exit;
}

// fechar e voltar
header("Location: $Origem");
exit;
?>