<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
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
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

			<h2>Configuração</h2>
<div class="row">
	<div class="col-sm-6">
		<h3>Horário</h3>
		<p>Configuração do horário e período <a href="configurar-horas.php" class="btn btn-default">Configurar</a></p>

		<!-- <h3>Período</h3>
		<p>Configuração do período <a href="configurar-periodo.php" class="btn btn-default">Configurar</a></p> -->

		<h3>Unidade</h3>
		<p>Configuração da unidade <a href="configurar-unidade.php" class="btn btn-default">Configurar</a></p>

		<h3>Função</h3>
		<p>Configuração da função do profissional <a href="configurar-funcao.php" class="btn btn-default">Configurar</a></p>

		<h3>Categoria</h3>
		<p>Configuração da categoria do profissional <a href="configurar-categoria.php" class="btn btn-default">Configurar</a></p>

		<h3>Diagnóstico</h3>
		<p>Configuração do diagnóstico <a href="configurar-diagnostico.php" class="btn btn-default">Configurar</a></p>

		<h3>Exame médico</h3>
		<p>Configuração do exame médico <a href="configurar-exame.php" class="btn btn-default">Configurar</a></p>

		<h3>Terapia</h3>
		<p>Configuração da terapia <a href="configurar-terapia.php" class="btn btn-default">Configurar</a></p>

		<h3>Estado</h3>
		<p>Configuração do Estado <a href="configurar-estado.php" class="btn btn-default">Configurar</a></p>

		<h3>Arquivos</h3>
		<p>Listar arquivos importados <a href="configurar-arquivos-importados.php" class="btn btn-default">Confirmar</a></p>
	</div>

	<div class="col-sm-6">
		<h3>Primeiro nome</h3>
		<p>Obter o primeiro nome a partir de um nome completo dos <b>profissionais</b>. <a href="configurar-primeiro-nome-profissionais.php" class="btn btn-default">Próxima página</a></p>
		<p>Obter o primeiro nome a partir de um nome completo dos <b>pacientes</b>. <a href="configurar-primeiro-nome-pacientes.php" class="btn btn-default">Próxima página</a></p>

		<!-- <h3>Importar dados</h3>
		<p>Importar nomes dos <b>profissionais</b> que estão em uma planilha excel para o banco de dados <a href="importar-profissionais.php" class="btn btn-default">Próxima página</a></p>
		<p>Importar nomes dos <b>pacientes</b>. <a href="importar-pacientes.php" class="btn btn-default">Próxima página</a></p>
		<p>Criar e adicionar o primeiro nome na tabela <b>paciente</b>. <a href="adicionar-nome-social-paciente.php" class="btn btn-default">Próxima página</a></p> -->

		<!-- <h3>Importar atendimento</h3>
		<p>Importar dados da planilha de atendimento. <a href="importar-atendimento.php" class="btn btn-default">Próxima página</a></p> -->

		<h3>Agenda base do paciente</h3>
		<p>Relatório completo da agenda base <a href="relatorio-agenda-base.php" class="btn btn-default">Continuar</a></p>
		<p>Conferir se existe duplicidade de profissionais <a href="agenda-base-paciente-conferir-duplicidade.php" class="btn btn-default">Continuar</a></p>
		<p>Verificar na tabela agenda_paciente_base, id_profissional 0<a href="verificar-agenda-base.php" class="btn btn-default">Continuar</a></p>
		<p>Listar id_profissional = 0 <a href="apagar-profissional-zero.php" class="btn btn-default">Continuar</a></p>
		<p>Corrigir os perídos ds terapeutas <a href="corrigir-periodo-terapeutas.php" class="btn btn-default">Continuar</a></p>


		<h3>Comparar tabela profissional e tmp_profissional</h3>
		<p><a href="comparar-tabelas-profissionais-tmp.php" class="btn btn-default">Continuar</a></p>



		<!-- <h3>Associar período na tabela profissional</h3>
		<p>Atualizar a tabela profissional associando período à hora. <a href="associar-periodo-a-hora.php" class="btn btn-default">Continuar</a></p> -->

		<h3>Limpar preferência de horário duplicados</h3>
		<p><a href="limpar-preferencia-horario-paciente.php" class="btn btn-default">Limpar</a></p>

		<h3>Corrigir categoria</h3>
		<!-- <p>Em paciente, adicionar demais períodos para manhã-tarde. <a href="adicionar-periodo-manha-ou-tarde.php" class="btn btn-default">Continuar</a></p> -->
		<p>Copiar o profissional, categoria e unidade da tabela categoria_profissional para tabela categoria_profissional_tmp e organizar os períodos em colunas. Criar uma coluna período manhã + tarde.<a href="adicionar-periodo-manha-tarde.php" class="btn btn-default">Continuar</a></p>
		<p>Copiar os dados da coluna período manhã + tarde da tabela tmp para categoria_profissional. <a href="copiar-periodo-manha-tarde-para-tabela.php" class="btn btn-default">Continuar</a></p>
		<p>Remover itens vazios na tabela categoria_profissional <a href="categoria-paciente-apagar-periodo-vazio.php" class="btn btn-default">Continuar</a></p>

		<h3>Correção FP+</h3>
		<p>Inserir nome do paciente na tabela FP <a href="inserir-nome-paciente-tabela-fp.php" class="Link">Avançar</a></p>
		<p>Copiar o usuário e senha do profissional da tabela profissional para prog_profissional <a href="copiar-profissional-usuario-senha-para-prog.php" class="Link">Avançar</a></p>
		<p>teste <a href="teste-1.php" class="Link">Avançar</a></p>

		<h3>Pacientes duplicados</h3>
		<p>Analisar pacientes duplicados <a href="listar-pacientes-duplicados-novo.php" class="Link">Avançar</a> </p>
		
	</div>
</div>
		</div>
    </div>
</div>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>
