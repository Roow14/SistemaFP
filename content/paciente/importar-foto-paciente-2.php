 <?php
session_start();
$target_dir = "../../vault/paciente/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$id_paciente = $_SESSION['id_paciente'];
$imagemFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

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

if (empty($_GET['Origem'])) {
    $Origem = 'importar-foto-paciente.php?id_paciente='.$id_paciente;
} else {
    $Origem = $_GET['Origem'];
}

// verificar se é uma imagem
if (isset($_POST["submit"])) {
    if (($imagemFileType == 'jpg') OR ($imagemFileType == 'png') OR ($imagemFileType == 'jpeg') OR ($imagemFileType == 'gif')) {
    } else {
        echo "<Erro: os arquivos devem conter as extensões jpg, png, jpeg ou gif.\");
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
if($imagemFileType != "jpg" && $imagemFileType != "png" && $imagemFileType != "jpeg" && $imagemFileType != "gif") {
    echo "<script type=\"text/javascript\">
    alert(\"Erro: os arquivos devem conter as extensões jpg, png, jpeg ou gif.\");
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
    list($width, $height) = getimagesize($target_file);
    $widthX = 400;
    $heightX = 400 * $height / $width;

    // ajustar tamanho do arquivo
    if($imagemFileType == 'png'){
      $img = resize_imagepng($target_file,400,400);
    }else{
      $img = resize_imagejpg($target_file,$widthX,$heightX);
    }

    imagejpeg($img, $target_file);

    // buscar xxx
    $sql = "SELECT * FROM midia_paciente WHERE ArquivoMidia = '$ArquivoMidia'";
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

    $sql = "INSERT INTO midia_paciente (ArquivoMidia, id_paciente)
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
header("Location: paciente.php?id_paciente=$id_paciente");
exit;
?>