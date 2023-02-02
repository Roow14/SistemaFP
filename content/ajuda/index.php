<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// data atual
date_default_timezone_set("America/Sao_Paulo");
$DataAtual = date("Y-m-d");
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../header/head.php';?>

<style type="text/css">
    .LinkTitulo i, li i, p i {
        vertical-align: middle;
    }
    .LinkTitulo:hover {
        cursor: pointer;
        color: orange;
    }
    h4 {
        font-weight: 500;
        color: #00adef;
    }
    h5 {
        font-size: 16px;
        font-weight: 600;
        color: inherit;
        padding-top: 15px;
    }
    .txt {
        display: none;
        margin-bottom: 50px;
        padding-left: 15px;
        padding-right: 15px; 
    }
</style>

<body>

<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

            <h3>Agenda Fisiopeti</h3>
            <!-- <a href="" class="btn-icon-x" data-toggle="modal" data-target="#myModal-Ajuda"><img src="" data-toggle="tooltip" data-placement="bottom" title="Ajuda"></a> -->

            <h4 id="AbrirTexto1" class="LinkTitulo">Visão geral &#8250</h4>
            <div id="Texto1" class="txt">
                <p>A agenda deve ser criada em 2 etapas:</p>
                <ol>
                    <li>Criar uma agenda base do paciente contendo a agenda da semana.</li>
                    <li>Criar a agenda do paciente utilizando a agenda base como referência.</li>
                </ol>
                <h5>Premissas</h5>
                <ul>
                    <li>A <b>agenda base do paciente</b> tem o <b>dia da semana</b>, horário e o nome do terapeuta responsável pelo atendimento.</li>
                    <li>A <b>agenda base do terapeuta</b> tem o <b>dia da semana</b>, horário e o nome do paciente.</li>
                    <li>A <b>agenda do paciente</b> tem a <b>data</b>, horário e o nome do terapeuta responsável pelo atendimento.</li>
                    <li>A <b>agenda do terapeuta</b> tem a <b>data</b>, horário e o nome do paciente.</li>
                    <li>Os dados da agenda base são copiados para a agenda do paciente. Portanto, se a agenda base for alterada, a agenda do paciente não será alterada.</li>
                    <li>O agendamento do terapeuta é feito na <b>agenda base do paciente</b> e na <b>agenda do paciente</b>.</li>
                    <li>O <b>agendamento do terapeuta</b> é feito em apenas <b>um único horário</b>. Para isso, o sistema utiliza filtros por paciente, categoria, unidade e período de atendimento (manhã, tarde e noite).</li>
                </ul>
            </div>

            <h4 id="AbrirTexto2" class="LinkTitulo">Agenda base do paciente &#8250</h4>
            <div id="Texto2" class="txt">
                <p>São mostrados os terapeutas agendados por <b>dia da semana</b>, horário e unidade.</p>
                <p>Ela está em: <b>Menu lateral > visão geral > agenda base do paciente</b>.</p>

                <h5>O que pode ser feito nesta página:</h5>
                <ul>
                    <li>Selecionar a agenda de um paciente;</li>
                    <li>Clicar em <b>Ver paciente</b> e ver os dados do paciente;</li>
                    <li>Agendar um terapeuta;</li>
                    <li>Cancelar a agenda do terapeuta.</li>
                </ul>

                <h5>Passo a passo para agendar um terapeuta:</h5>
                <ol>
                    <li>Na linha <b>agendar terapeuta</b> selecione a <b>categoria</b>, a <b>unidade</b> e clique em confirmar.</li>
                    <li>Selecione o terapeuta disponível e clique em &#x2714;;</li>
                    <li>Clique em <b>Limpar agendamento</b> para desativar os campos de seleção dos terapeutas.</li>
                </ol>

                <h5>Cancelar um terapeuta:</h5>
                <ol>
                    <li>Clique em &#x2716; e ative o a opção para <b>cancelar</b>;</li>
                    <li>Selecione o terapeuta que será cancelado.</li>
                    <li>Clique novamente em &#x2716; e desative o a opção para <b>cancelar</b>;</li>
                </ol>
                
                <h5>Agendamento de um terapeuta</h5>
                <p>Em agendar terapeuta, selecione a categoria e a unidade do terapeuta.</p>
                <p>Após a seleção serão mostrados os campos de seleção dos terapeutas disponíveis.</p>
                <h5>Notas:</h5>
                <ul>
                    <li>Se o nome do terapeuta estiver precedido de <b>---</b> significa que o terapeuta está agendado no mesmo horário em outro paciente.</li>
                    <li>A lista de terapeutas que aparecem no campo de seleção são diferentes para os períodos da manhã, tarde e noite. São os filtros de viualização por categoria associados ao terapeuta.</li>
                    <li>As categorias dos terapeutas são criadas em: <b>Menu lateral > pesquisar um terapeuta > menu lateral do terapeuta > categoria.</b></li>
                </ul>
            </div>

            <h4 id="AbrirTexto3" class="LinkTitulo">Agenda base do terapeuta &#8250</h4>
            <div id="Texto3" class="txt">
                <p>São mostrados os pacientes agendados por <b>dia da semana</b>, horário e unidade.</p>
                <p>Ela está em: <b>Menu lateral > visão geral > agenda base do terapeuta</b></p>
                <h5>O que pode ser feito nesta página:</h5>
                <ul>
                    <li>Selecionar a agenda de um terapeuta;</li>
                    <li>Clicar no nome do paciente e abrir a agenda base do paciente;</li>
                    <li>Cancelar a agenda do terapeuta.</li>
                </ul>
                <h5>Nota:</h5>
                <ul>
                    <li>Para agendar um paciente abra a agenda base do paciente.</li>
                </ul>
            </div>

            <h4 id="AbrirTexto4" class="LinkTitulo">Criação da agenda do paciente &#8250</h4>
            <div id="Texto4" class="txt">
                <p>A agenda do paciente é criada a partir da agenda base do paciente.</p>
                <p>A criação da agenda é semanal. Para copiar os dados da agenda base para a agenda do paciente é necessário selecionar uma data que se inicia na 2ª feira.</p>
                <p>Ela está em: <b>Menu lateral > Agenda > Criar agenda da semana</b>.</p>
                <p>Selecione uma data que inicia na 2ª feira.</p>
                <h5>Notas:</h5>
                <p>O sistema mostrará mensagens de erro em 2 situações:</p>
                <ul>
                    <li>Erro: Não é 2ª feira. Selecione uma nova data.</li>
                    <li>Erro: A semana se encontrada cadastrada no sistema. Selecione uma nova semana.</li>
                </ul>
            </div>

            <h4 id="AbrirTexto5" class="LinkTitulo">Agenda do paciente &#8250</h4>
            <div id="Texto5" class="txt">
                <p>Mostra os terapeutas agendados por <b>data</b>, horário e unidade.</p>
                <p>Ela está em: <b>Menu lateral > visão geral > agenda base do paciente</b>.</p>
                <h5>O que pode ser feito nesta página:</h5>
                <ul>
                    <li>Selecionar a agenda de um paciente.</li>
                    <li>Clicar no botão <b>Ver paciente</b> e ir para a página do paciente.</li>
                    <li>Alterar a agendar de um terapeuta selecionado a categoria e unidade.</li>
                    <li>Abrir a agenda do terapeuta clicando diretamente no nome do paciente.</li>
                    <li>Cancelar a agenda do terapeuta.</li>
                </ul>

                <h5>Agendamento de um terapeuta</h5>
                <p>Em agendar terapeuta, selecione a categoria e a unidade do terapeuta.</p>
                <p>Após a seleção serão mostrados os campos de seleção dos terapeutas disponíveis.</p>
                <h5>Notas:</h5>
                <ul>
                    <li>Se o nome do terapeuta estiver precedido de --- significa que o terapeuta está agendado na mesma data e horário em outro paciente.</li>
                    <li>A lista de terapeutas que aparecem no campo de seleção são diferentes para os períodos da manhã, tarde e noite. Isto se deve por causa dos filtros por categoria associados aos terapeutas.</li>
                    <li>As categorias dos terapeutas são criadas em: <b>menu lateral > pesquisar um terapeuta > menu lateral do terapeuta > terapeuta > categoria</b>.</li>
                </ul>
            </div>

            <h4 id="AbrirTexto6" class="LinkTitulo">Agenda do terapeuta &#8250</h4>
            <div id="Texto6" class="txt">
                <p>Mostra os pacientes agendados por <b>data</b>, horário e unidade.</p>
                <h5>O que pode ser feito nesta página:</h5>
                <ul>
                    <li>Selecionar a agenda de um terapeuta.</li>
                    <li>Aplicar <b>filtro</b> de visualização da agenda do terapeuta <b>por unidade</b>.</li>
                    <li>Abrir a agenda do paciente clicando diretamente no nome do paciente.</li>
                    <li>Cancelar a agenda do terapeuta.</li>
                </ul>

                <h5>Notas:</h5>
                <ul>
                    <li>Para agendar um paciente abra a agenda do paciente.</li>
                </ul>
            </div>

            <h4 id="AbrirTexto7" class="LinkTitulo">Agenda equoterapia &#8250</h4>
            <div id="Texto7" class="txt">
                <p>A agenda equoterapia mostra a agenda semanal do paciente e o terapeuta responsável.</p>
                <p>Esta agenda permite a <b>adição de um auxiliar (2º terapeuta)</b> na <b>mesma data e horário</b>.</p>
                <p>O agendamento do auxiliar é feito somente na agenda equoterapia.</p>
                <p>Ela está em: <b>Menu lateral > visão geral > agenda equoterapia</b>.</p>

                <h5>O que pode ser feito nesta página:</h5>
                <ul>
                    <li>Adicionar um auxiliar;</li>
                    <li>Cancelar a agenda do auxiliar.</li>
                    <li>Clicar no nome do paciente e abrir a sua agenda.</li>
                    <li>Clicar no nome do terapeuta ou auxiliar e abrir a sua agenda.</li>
                    <li>Alterar a data de início da semana.</li>
                </ul>

                <h5>Passo a passo para adicionar um auxiliar:</h5>
                <ol>
                    <li>Clique em &#x270E; e ative o campo de adição do auxiliar;</li>
                    <li>Selecione o terapeuta disponível e clique em &#x2714;;</li>
                    <li>Veja a identificação: P = paciente, T = terapeuta e A = auxiliar.</li>
                    <li>Clique novamente em &#x270E; e desative o campo de adição do auxiliar;</li>
                </ol>

                <h5>Cancelar um auxiliar:</h5>
                <ol>
                    <li>Clique em &#x2716; e ative o a opção para <b>cancelar</b>;</li>
                    <li>Selecione o auxiliar será cancelado.</li>
                    <li>Clique novamente em &#x2716; e desative o a opção para <b>cancelar</b>;</li>
                </ol>
                
            </div>

        </div>

        <!-- Modal ajuda -->
        <div class="modal fade" id="myModal-Ajuda" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <form action="" method="post">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">xxx</h4>
                        </div>
                        <div class="modal-body" style="background-color: #fafafa;">
                            
                            <div class="form-group col-sm-12">
                                <p>xxx.</p>
                            </div>
                            
                            <div style="clear: both;"></div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn" data-dismiss="modal">Fechar</button>
                        </div>
                    </form>    
                </div>

            </div>
        </div>

        </div>
    </div>
</body>
</html>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
<script>
    $(document).ready(function(){
        $("#AbrirTexto1").click(function(){
            $("#Texto1").toggle(250);
        });
        $("#AbrirTexto2").click(function(){
            $("#Texto2").toggle(250);
        });
        $("#AbrirTexto3").click(function(){
            $("#Texto3").toggle(250);
        });
        $("#AbrirTexto4").click(function(){
            $("#Texto4").toggle(250);
        });
        $("#AbrirTexto5").click(function(){
            $("#Texto5").toggle(250);
        });
        $("#AbrirTexto6").click(function(){
            $("#Texto6").toggle(250);
        });
        $("#AbrirTexto7").click(function(){
            $("#Texto7").toggle(250);
        });
        $("#AbrirTexto8").click(function(){
            $("#Texto8").toggle(250);
        });
        $("#AbrirTexto9").click(function(){
            $("#Texto9").toggle(250);
        });
        $("#AbrirTexto10").click(function(){
            $("#Texto10").toggle(250);
        });
        $("#AbrirTexto11").click(function(){
            $("#Texto11").toggle(250);
        });
        $("#AbrirTexto12").click(function(){
            $("#Texto12").toggle(250);
        });
        $("#AbrirTexto13").click(function(){
            $("#Texto13").toggle(250);
        });
        $("#AbrirTexto14").click(function(){
            $("#Texto14").toggle(250);
        });
    });
</script>
</body>
</html>