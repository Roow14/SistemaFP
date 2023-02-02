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

// buscar xxx
$sql = "SELECT * FROM horas_terapia WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // tem
        $Horas = $row['Horas'];
    }
} else {
    // não tem
    $Horas = NULL;
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
    @media print {
        .janela {
            border: none;
        }
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
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral-paciente.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

<h2 class="hidden-print">Paciente</h2>

<ul class="nav nav-tabs hidden-print">
    <li class="inactive"><a href="../paciente/">Lista</a></li>
    <li class="inactive"><a href="../paciente/paciente.php">Criança</a></li>
    <li class="inactive"><a href="../paciente/escola-paciente.php">Escola</a></li>
    <li class="inactive"><a href="../paciente/convenio-paciente.php">Convênio</a></li>
    <li class="active"><a href="../avaliacao/">Plano terapêutico</a></li>
    <li class="inactive"><a href="../exame/">Dados médicos</a></li>
    <li class="inactive"><a href="../agenda/agenda-paciente.php">Agenda</a></li>
    <li class="inactive"><a href="../agenda/agenda-base-paciente.php">Agenda base</a></li>
</ul>

<div class="janela">
    <div style="margin-bottom: 15px;">
        <h3 class="visible-print">Plano terapêutico</h3>
        <li><label>Nome completo:</label> <?php echo $NomeCompleto;?></li>
        <a href="cadastrar-avaliacao-2.php" class="btn btn-default hidden-print">Adicionar plano</a>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php
            // buscar xxx
            $sql = "SELECT * FROM avaliacao WHERE id_paciente = '$id_paciente' ORDER BY DataAvaliacao DESC, id_avaliacao DESC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo '<table class="table table-striped table-hover table-condensed">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Avaliação</th>';
                echo '<th>Início</th>';
                echo '<th>Avaliação</th>';
                echo '<th>Plano terapêutico</th>';
                echo '<th>Terapias por semana (horas)</th>';
                echo '<th>Uso na agenda base</th>';
                echo '<th>Ação</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while($row = $result->fetch_assoc()) {
                    $id_avaliacao = $row['id_avaliacao'];
                    $sqlA = "SELECT SUM(Horas) AS Soma1 FROM categoria_paciente
                    WHERE id_avaliacao = '$id_avaliacao'";
                    $resultA = $conn->query($sqlA);
                    if ($resultA->num_rows > 0) {
                        // tem
                        while($rowA = $resultA->fetch_assoc()) {
                            $Soma1 = $rowA['Soma1'];
                        }
                    // não tem
                    } else {
                    }

                    $sqlA = "SELECT * FROM avaliacao WHERE id_avaliacao = '$id_avaliacao'";
                    $resultA = $conn->query($sqlA);
                    if ($resultA->num_rows > 0) {
                        while($rowA = $resultA->fetch_assoc()) {
                            $DataAvaliacao = $rowA['DataAvaliacao'];
                            $DataAvaliacao1 = date("d/m/Y", strtotime($DataAvaliacao));
                            if (empty($rowA['DataInicio'])) {
                                $DataInicio1 = NULL;
                            } else {
                                $DataInicio = $rowA['DataInicio'];
                                $DataInicio1 = date("d/m/Y", strtotime($DataInicio));
                            }
                            $TituloAvaliacao = $rowA['TituloAvaliacao'];
                            $PlanoTerapeutico = $rowA['PlanoTerapeutico'];
                            $Avaliacao = $row['Avaliacao'];
                            $AvaliacaoX = substr($Avaliacao, 0, 200) . '...';
                            $LocalAvaliacao = $rowA['LocalAvaliacao'];
                            $LocalTerapia = $rowA['LocalTerapia'];
                            $Responsavel = $rowA['Responsavel'];
                            $Status = $rowA['Status'];
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

                    echo '<tr>';
                    echo '<td>'.$DataAvaliacao1.'</td>';
                    echo '<td>'.$DataInicio1.'</td>';
                    echo '<td>'.$AvaliacaoX.'</td>';
                    echo '<td>'.$PlanoTerapeutico.'</td>';
                    
                    echo '<td>';
                    // buscar xxx
                    $sqlA = "SELECT categoria_paciente.*, categoria.NomeCategoria
                    FROM categoria_paciente
                    INNER JOIN categoria ON categoria_paciente.id_categoria = categoria.id_categoria
                    WHERE categoria_paciente.id_avaliacao = '$id_avaliacao'";
                    $resultA = $conn->query($sqlA);
                    if ($resultA->num_rows > 0) {
                        while($rowA = $resultA->fetch_assoc()) {
                            // tem
                            $id_categoria_paciente = $rowA['id_categoria_paciente'];
                            $id_categoria = $rowA['id_categoria'];
                            $NomeCategoria = $rowA['NomeCategoria'];
                            $Horas = $rowA['Horas'];
                            echo $NomeCategoria.' ('.$Horas.')<br>';
                        }
                    } else {
                        // não tem
                    }
                    echo '<b>Total:</b> '.$Soma1; 
                    echo '</td>';
                    
                    echo '<td>'.$NomeStatus.'</td>';
                    echo '<td><a href="alterar-avaliacao.php?id_avaliacao='.$id_avaliacao.'" class="btn btn-default hidden-print">Abrir</a></td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo 'Não foi encontrado nenhuma avaliação.';
            }
            ?>
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
                        <input type="text" class="form-control" name="TituloAvaliacao" >
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
</body>
</html>