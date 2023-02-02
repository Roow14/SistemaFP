 <?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

$target_dir = "../../vault/convenio/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$Origem = 'ajuda.php';

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

// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "<script type=\"text/javascript\">
    alert(\"Erro: o tamanho do arquivo deve ser menor do que 500kb.\");
    window.location = \"$Origem\"
    </script>";
exit;
} else {

}

// importar o arquivo
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    
    // iniciar conexão
    include "../conexao/conexao.php";
    
    // atualizar tabela midia
    $ArquivoMidia = basename($_FILES["fileToUpload"]["name"]);

    // buscar xxx
    $sql = "SELECT * FROM fisiofor_agenda.midia_convenio WHERE ArquivoMidia = '$ArquivoMidia'";
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

    $sql = "INSERT INTO fisiofor_agenda.midia_convenio (ArquivoMidia)
    VALUES ('$ArquivoMidia')";
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