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
$id_avaliacao = $_GET['id_avaliacao'];
$id_nav = 'avaliacao';

// buscar xxx
$sql = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // tem
        $NomeCompleto = $row['NomeCompleto'];
    }
} else {
    // não tem
}

$sql = "SELECT * FROM avaliacao WHERE id_avaliacao = '$id_avaliacao'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $DataAvaliacao = $row['DataAvaliacao'];
        if (empty($row['DataInicio'])) {
            $DataInicio1 = NULL;
        } else {
            $DataInicio = $row['DataInicio'];
            $DataInicio1 = date("d/m/Y", strtotime($DataInicio));
        }
        $TituloAvaliacao = $row['TituloAvaliacao'];
        $PlanoTerapeutico = $row['PlanoTerapeutico'];
        $Avaliacao = $row['Avaliacao'];

        $LocalAvaliacao = $row['LocalAvaliacao'];
        $LocalTerapia = $row['LocalTerapia'];
        $Responsavel = $row['Responsavel'];
        $Status = $row['Status'];
        if ($Status == 1) {
            $NomeStatus = 'Ativo';
        } else {
            $NomeStatus = 'Inativo';
        }

        if (!empty($Responsavel)) {
            $sqlB = "SELECT * FROM profissional WHERE id_profissional = '$Responsavel'";
            $resultB = $conn->query($sqlB);
            if ($resultB->num_rows > 0) {
                while($rowB = $resultB->fetch_assoc()) {
                    // tem
                    $NomeResponsavel = $rowB['NomeCompleto'];
                }
            } else {
                // não tem
            }
        } else {
            $NomeResponsavel = 'Selecionar';
        }

        if (!empty($LocalAvaliacao)) {
            $sqlB = "SELECT * FROM unidade WHERE id_unidade = '$LocalAvaliacao'";
            $resultB = $conn->query($sqlB);
            if ($resultB->num_rows > 0) {
                while($rowB = $resultB->fetch_assoc()) {
                    // tem
                    $NomeUnidadeAvaliacao = $rowB['NomeUnidade'];
                }
            } else {
                // não tem
            }
        } else {
            $NomeUnidadeAvaliacao = 'Selecionar';
        }

        if (!empty($LocalTerapia)) {
            $sqlB = "SELECT * FROM unidade WHERE id_unidade = '$LocalTerapia'";
            $resultB = $conn->query($sqlB);
            if ($resultB->num_rows > 0) {
                while($rowB = $resultB->fetch_assoc()) {
                    // tem
                    $NomeUnidadeTerapia = $rowB['NomeUnidade'];
                }
            } else {
                // não tem
            }
        } else {
            $NomeUnidadeTerapia = 'Selecionar';
        }
    }
} else {
}

$sql = "SELECT * FROM midia_avaliacao WHERE id_avaliacao = '$id_avaliacao' LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $CheckMidia = 1;
    }
} else {
    $CheckMidia = 2;
}
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../header/head.php';?>

<style type="text/css">
    .janela {
        background-color: #fafafa;
        /*min-height: 300px;*/
        padding: 15px;
        border-left: 1px solid #ddd;
        border-right: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
        border-radius: 4px;
    }
    .conteudo {

    }
    li {
        list-style: none;
    }
    .Link {
        background-color: transparent;
        border: none;
    }
    input[type=checkbox] {
        transform: scale(1.3);
        margin: 5px 10px;
    }
    hr {
        border-color: #ccc;
    }
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral-paciente.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

<h2>Pacientes</h2>

<ul class="nav nav-tabs">
    <li class="inactive"><a href="../paciente/">Lista</a></li>
    <li class="inactive"><a href="../paciente/paciente.php">Criança</a></li>
    <li class="inactive"><a href="../paciente/escola-paciente.php">Escola</a></li>
    <li class="inactive"><a href="../paciente/convenio-paciente.php">Convênio</a></li>
    <li class="active"><a href="../avaliacao/">Plano terapêutico</a></li>
    <li class="inactive"><a href="../exame/">Dados médicos</a></li>
    <li class="inactive"><a href="../agenda/agenda-paciente.php">Agenda</a></li>
    <!-- <li class="inactive"><a href="../configuracao/relatorio-agenda-paciente.php">Agenda</a></li> -->
    <li class="inactive"><a href="../agenda/agenda-base-paciente.php">Agenda base</a></li>
</ul>

<div class="janela">
    <p><label>Nome:</label> <?php echo $NomeCompleto;?></p>
    <div class="row">
        <form action="alterar-avaliacao-2.php?id_paciente=<?php echo $id_paciente;?>&id_avaliacao=<?php echo $id_avaliacao;?>" method="post" style="margin-bottom: 25px;">
            <div class="">
                <div class="form-group col-sm-4">
                    <label>Título da avaliação</label>
                    <input type="text" class="form-control" name="TituloAvaliacao" value="<?php echo $TituloAvaliacao;?>" placeholder="Opcional">
                </div>
                <div class="form-group col-sm-4">
                    <label>Terapeuta responsável</label>
                    <select name="Responsavel" class="form-control">
                        <?php
                        echo '<option value="'.$Responsavel.'">'.$NomeResponsavel.'</option>';
                        // buscar xxx
                        $sql = "SELECT * FROM profissional WHERE Status = 1 AND Nivel != 3 ORDER BY NomeCompleto ASC";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                // tem
                                $ResponsavelX = $row['id_profissional'];
                                $NomeResponsavelX = $row['NomeCompleto'];
                                echo '<option value="'.$ResponsavelX.'">'.$NomeResponsavelX.'</option>';
                            }
                        } else {
                            // não tem
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-sm-4">
                    <label>Data da avaliação</label>
                    <input type="date" class="form-control" name="DataAvaliacao" value="<?php echo $DataAvaliacao;?>" required>
                </div>

                <div class="form-group col-sm-4">
                    <label>Data de início da terapia</label>
                    <input type="date" class="form-control" name="DataInicio" value="<?php echo $DataInicio;?>">
                </div>

                <div class="form-group col-sm-4">
                    <label>Unidade da avaliação</label>
                    <select name="LocalAvaliacao" class="form-control">
                        <?php
                        echo '<option value="'.$LocalAvaliacao.'">'.$NomeUnidadeAvaliacao.'</option>';
                        // buscar xxx
                        $sql = "SELECT * FROM unidade WHERE Status = 1 ORDER BY NomeUnidade ASC";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                // tem
                                $id_unidadeX = $row['id_unidade'];
                                $NomeUnidadeX = $row['NomeUnidade'];
                                echo '<option value="'.$id_unidadeX.'">'.$NomeUnidadeX.'</option>';
                            }
                        } else {
                            // não tem
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-sm-4">
                    <label>Unidade da terapia</label>
                    <select name="LocalTerapia" class="form-control">
                        <?php
                        echo '<option value="'.$LocalTerapia.'">'.$NomeUnidadeTerapia.'</option>';
                        // buscar xxx
                        $sql = "SELECT * FROM unidade WHERE Status = 1 ORDER BY NomeUnidade ASC";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                // tem
                                $id_unidadeX = $row['id_unidade'];
                                $NomeUnidadeX = $row['NomeUnidade'];
                                echo '<option value="'.$id_unidadeX.'">'.$NomeUnidadeX.'</option>';
                            }
                        } else {
                            // não tem
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-sm-12">
                    <label>Observação</label>
                    <textarea id="editor" rows="15" class="form-control" name="Avaliacao"><?php echo $Avaliacao;?></textarea>
                </div>

                <div class="form-group col-sm-4">
                    <label>Plano terapêutico</label>
                    <input type="text" class="form-control" name="PlanoTerapeutico" value="<?php echo $PlanoTerapeutico;?>" >
                </div>

                <div class="form-group col-sm-4">
                    <label>Uso das horas na agenda base <span class="botao-ajuda" data-toggle="tooltip" title="Ao ativar, os outros planos serão inativados">?</span></label>
                    <select name="Status" class="form-control" required>
                        <option value="<?php echo $Status;?>"><?php echo $NomeStatus;?></option>
                        <option value="1">Ativo</option>
                        <option value="2">Inativo</option>
                    </select>
                </div>
            </div>

            <div class="col-sm-12">
                <a href="index.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Voltar</a>
                <button type="submit" class="btn btn-success">Confirmar</button>
                <?php
                if ($CheckMidia == 1) {
                    echo '<button type="button" class="btn btn-default" data-toggle="modal" data-target="#NaoApagar">Apagar</button>';
                } else {
                    echo '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#Apagar">Apagar</button>';
                }
                ?>
            </div>
        </form>

        <div class="col-sm-12">
            <hr>
        </div>

        <div class="col-sm-6">
            <!-- <form action="alterar-plano-terapeutico-2.php?id_paciente=<?php echo $id_paciente;?>&id_avaliacao=<?php echo $id_avaliacao;?>" method="post">
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label>Frequência semanal:</label>
                        <input type="text" class="form-control" name="PlanoTerapeutico" value="<?php echo $PlanoTerapeutico;?>"  placeholder="Ex.: 3x por semana, 2h por dia">
                    </div>
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-success">Confirmar</button>
                        <a href="" class="btn btn-default" data-toggle="modal" data-target="#addterapia">Adicionar terapia</a>
                    </div>
                </div>
            </form>
            <br> -->
            <a href="" class="btn btn-success" data-toggle="modal" data-target="#addterapia">Adicionar terapia</a>
            <?php
            $sql = "SELECT SUM(Horas) AS Soma1 FROM categoria_paciente
            WHERE id_avaliacao = '$id_avaliacao'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                // tem
                while($row = $result->fetch_assoc()) {
                    $Soma1 = $row['Soma1'];
                }
            // não tem
            } else {
            }

            // buscar xxx
            $sql = "SELECT categoria_paciente.*, categoria.NomeCategoria
            FROM categoria_paciente
            INNER JOIN categoria ON categoria_paciente.id_categoria = categoria.id_categoria
            WHERE categoria_paciente.id_avaliacao = '$id_avaliacao'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo '<table class="table table-striped table-hover table-condensed">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Terapia</th>';
                echo '<th>Horas/semana</th>';
                echo '<th>Ação</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while($row = $result->fetch_assoc()) {
                    // tem
                    $id_categoria_paciente = $row['id_categoria_paciente'];
                    $id_categoria = $row['id_categoria'];
                    $NomeCategoria = $row['NomeCategoria'];
                    $Horas = $row['Horas'];
                    echo '<tr>';
                    echo '<td>'.$NomeCategoria.'</td>';
                    echo '<form action="alterar-horas-2.php" method="post">';
                    echo '<input type="text" name="id_categoria_paciente" value="'.$id_categoria_paciente.'" hidden>';
                    echo '<input type="text" name="id_avaliacao" value="'.$id_avaliacao.'" hidden>';
                    echo '<td style="width: 100px"><input type="number" class="form-control" name="Horas" value="'.$Horas.'" required></td>';
                    echo '<td style="width: 180px">';
                    echo '<button type="submit" class="btn btn-default">Alterar</button>';
                    echo '<a href="apagar-terapia-da-avaliacao-2.php?id_categoria_paciente='.$id_categoria_paciente.'&id_avaliacao='.$id_avaliacao.'" class="btn btn-default">Apagar</a>';
                    echo '</td>';
                    echo '</form>';
                    echo '</tr>';
                }
                echo '<tbody>';
                echo '<tr>';
                echo '<th><label>Total de horas semanais</label></th>';
                echo '<th>'.$Soma1.'</th>';
                echo '</tr>';
                echo '</tbody>';

                echo '</tbody>';
                echo '</table>';
            } else {
                // não tem
            }
            ?>        
        </div>

        <div class="col-sm-6">
            <li><label>Arquivos:</label></li>
            <a href="" class="btn btn-success" data-toggle="modal" data-target="#Importar">Importar arquivo</a>
            <br>
            <br>
            <?php
            // arquivo avaliacao
            $sqlA = "SELECT * FROM midia_avaliacao WHERE id_avaliacao = '$id_avaliacao' ORDER BY ArquivoMidia ASC";
            $resultA = $conn->query($sqlA);
            if ($resultA->num_rows > 0) {
                echo '<table class="table table-striped table-hover table-condensed">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Nome</th>';
                echo '<th>Ação</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while($rowA = $resultA->fetch_assoc()) {
                    $id_midia_avaliacao = $rowA['id_midia_avaliacao'];
                    $ArquivoMidia = $rowA['ArquivoMidia'];

                    echo '<tr>';
                    echo '<td><a href="../../vault/avaliacao/'.$id_paciente.'/'.$ArquivoMidia.'" class="Link" target="blank" data-toggle="tooltip" title="Abrir arquivo">'.$ArquivoMidia.' </a></td>';
                    echo '<td><a href="apagar-arquivo-avaliacao.php?id_midia_avaliacao='.$id_midia_avaliacao.'&ArquivoMidia='.$ArquivoMidia.'&id_paciente='.$id_paciente.'&id_avaliacao='.$id_avaliacao.'" class="btn btn-default">Apagar</a></td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
            }
            ?>
        </div>
    </div>
</div>

<!-- adicionar terapia -->
<div class="modal fade" id="addterapia" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="adicionar-terapia-2.php" method="post">
                <input type="text" name="id_avaliacao" value="<?php echo $id_avaliacao;?>" hidden>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Adicionar terapia</h4>
                </div>
                <div class="modal-body" style="background-color: #fafafa;">
                    <div class="form-group">
                        <label>Terapia</label>
                        <select class="form-control" name="id_categoria" required>
                            <option value="">Selecionar</option>
                            <?php
                            // buscar xxx
                            $sql = "SELECT * FROM categoria ORDER BY NomeCategoria ASC";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    // tem
                                    $id_categoria = $row['id_categoria'];
                                    $NomeCategoria = $row['NomeCategoria'];
                                    echo '<option value="'.$id_categoria.'">'.$NomeCategoria.'</option>';
                                }
                            } else {
                                // não tem
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Horas</label>
                        <input type="number" class="form-control" name="Horas" required>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success">Confirmar</button>
                </div>
            </form>    
        </div>
    </div>
</div>

<!-- importar -->
<div class="modal fade" id="Importar" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="importar-avaliacao-2.php?id_paciente=<?php echo $id_paciente;?>" method="post" class="form-inline" enctype="multipart/form-data">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Importar documento</h4>
                </div>
                <div class="modal-body" style="background-color: #fafafa;">
                    <label>Selecione:</label>
                    <div class="form-group">
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <input type="text" hidden name="submit">
                        <input type="text" hidden name="id_avaliacao" value="<?php echo $id_avaliacao;?>">

                    </div>
                    <div style="clear: both;"></div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success">Confirmar</button>
                </div>
            </form>    
        </div>
    </div>
</div>

<!-- cadastrar -->
<div class="modal fade" id="Cadastrar" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="adicionar-avaliacao-2.php" method="post">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Cadastrar avaliação</h4>
                </div>
                <div class="modal-body" style="background-color: #fafafa;">
                    <div class="form-group">
                        <label>Título da avaliação</label>
                        <input type="text" class="form-control" name="TituloAvaliacao" required>
                    </div>
                    <div class="form-group">
                        <label>Data</label>
                        <input type="date" class="form-control" name="DataAvaliacao" required>
                    </div>
                    <div class="form-group">
                        <label>Observação</label>
                        <textarea id="editor" class="form-control" name="Avaliacao"></textarea>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success">Confirmar</button>
                </div>
            </form>    
        </div>
    </div>
</div>

<!-- apagar -->
<div id="Apagar" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Apagar avaliação</h4>
            </div>
            <div class="modal-body">
                <p>Cuidado! A avaliação será removida do sistema.<br>Deseja continuar?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <a href="apagar-avaliacao-2.php?id_avaliacao=<?php echo $id_avaliacao;?>" class="btn btn-danger">Apagar</a>
            </div>
        </div>

    </div>
</div>

<!-- não apagar -->
<div id="NaoApagar" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Apagar avaliação</h4>
            </div>
            <div class="modal-body">
                <p><b>Erro:</b> A avaliação não pode ser apagada porque tem arquivos associados.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>

    </div>
</div>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>

<script src="https://cdn.ckeditor.com/ckeditor5/31.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>

<!-- mantem a posição após o reload -->
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) { 
        var scrollpos = localStorage.getItem('scrollpos');
        if (scrollpos) window.scrollTo(0, scrollpos);
    });

    window.onbeforeunload = function(e) {
        localStorage.setItem('scrollpos', window.scrollY);
    };
</script>

<!-- mantem a posição após o reload -->
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) { 
        var scrollpos = localStorage.getItem('scrollpos');
        if (scrollpos) window.scrollTo(0, scrollpos);
    });

    window.onbeforeunload = function(e) {
        localStorage.setItem('scrollpos', window.scrollY);
    };
</script>

<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});
</script>
</body>
</html>