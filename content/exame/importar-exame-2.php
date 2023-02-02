<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// input 
$id_paciente = $_SESSION['id_paciente'];
$target_dir = '../../vault/exame/'.$id_paciente.'/';
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

$id_exame = $_POST['id_exame'];
$Origem = 'alterar-exame.php?id_exame='.$id_exame;
$imagemFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// verificar se a pasta existe
// o nome da pasta deverá ser o id_paciente
// se não existir, criar pasta
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777);
}

// verificar arquivo
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

// verificar se é uma imagem
// if (isset($_POST["submit"])) {
//     if (($imagemFileType == 'jpg') OR ($imagemFileType == 'png') OR ($imagemFileType == 'jpeg') OR ($imagemFileType == 'gif') OR ($imagemFileType == 'pdf')) {
//     } else {
//         echo "<Erro: os arquivos devem conter as extensões jpg, png, jpeg, gif ou pdf.\");
//         window.location = \"$Origem\"
//         </script>";
//         exit;
//     }
// }

// Check file size
// o arquivo ver ser menor do que 1MB
if ($_FILES["fileToUpload"]["size"] > 10000000) {
    echo "<script type=\"text/javascript\">
    alert(\"Erro: o tamanho do arquivo é maior do que 1MB.\");
    window.location = \"$Origem\"
    </script>";
exit;
}

// Allow certain file formats
// if($imagemFileType != "jpg" && $imagemFileType != "png" && $imagemFileType != "jpeg" && $imagemFileType != "gif" && $imagemFileType != "pdf") {
//     echo "<script type=\"text/javascript\">
//     alert(\"Erro: os arquivos devem conter as extensões jpg, png, jpeg, gif ou pdf.\");
//     window.location = \"$Origem\"
//     </script>";
// }

// importar o arquivo
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    
    // iniciar conexão
    include "../conexao/conexao.php";
    
    // atualizar tabela midia
    $ArquivoMidia = basename($_FILES["fileToUpload"]["name"]);

    // buscar xxx
    $sql = "SELECT * FROM midia_exame WHERE ArquivoMidia = '$ArquivoMidia' AND id_paciente = '$id_paciente'";
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

    $sql = "INSERT INTO midia_exame (ArquivoMidia, id_paciente, id_exame)
    VALUES ('$ArquivoMidia', '$id_paciente', '$id_exame')";
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
header("Location: alterar-exame.php?id_exame=$id_exame");
exit;
?>