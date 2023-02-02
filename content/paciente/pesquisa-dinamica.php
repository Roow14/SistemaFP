<?php
    if (!isset($_SESSION)) session_start();
    $nivel_necessario = 1;
    if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
    session_destroy();
    header("Location: ../../index.html"); exit;
    }
?>

<!-- listar clientes -->
<script>
    $(document).ready(function(){
        $("#SearchNome").keyup(function(){
            $.ajax({
            type: "POST",
            url: "pesquisa-dinamica-nome.php",
            data:'keywordNome='+$(this).val(),
            beforeSend: function(){
                $("#SearchNome").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
            },
            success: function(data){
                $("#SugestaoNome").show();
                $("#SugestaoNome").html(data);
                $("#SearchNome").css("background","#FFF");
            }
            });
        });
    });
    function selectNome(val) {
    $("#SearchNome").val(val);
    $("#SugestaoNome").hide();
    }
</script>

<!-- listar site -->
<script>
    $(document).ready(function(){
        $("#SearchSite").keyup(function(){
            $.ajax({
            type: "POST",
            url: "pesquisa-dinamica-site.php",
            data:'keywordSite='+$(this).val(),
            beforeSend: function(){
                $("#SearchSite").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
            },
            success: function(data){
                $("#SugestaoSite").show();
                $("#SugestaoSite").html(data);
                $("#SearchSite").css("background","#FFF");
            }
            });
        });
    });
    function selectSite(val) {
    $("#SearchSite").val(val);
    $("#SugestaoSite").hide();
    }
</script>

<!-- listar endereço -->
<script>
    $(document).ready(function(){
        $("#SearchEndereco").keyup(function(){
            $.ajax({
            type: "POST",
            url: "pesquisa-dinamica-endereco.php",
            data:'keywordEndereco='+$(this).val(),
            beforeSend: function(){
                $("#SearchEndereco").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
            },
            success: function(data){
                $("#SugestaoEndereco").show();
                $("#SugestaoEndereco").html(data);
                $("#SearchEndereco").css("background","#FFF");
            }
            });
        });
    });
    function selectEndereco(val) {
    $("#SearchEndereco").val(val);
    $("#SugestaoEndereco").hide();
    }
</script>

<!-- listar bairro -->
<script>
    $(document).ready(function(){
        $("#SearchBairro").keyup(function(){
            $.ajax({
            type: "POST",
            url: "pesquisa-dinamica-bairro.php",
            data:'keywordBairro='+$(this).val(),
            beforeSend: function(){
                $("#SearchBairro").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
            },
            success: function(data){
                $("#SugestaoBairro").show();
                $("#SugestaoBairro").html(data);
                $("#SearchBairro").css("background","#FFF");
            }
            });
        });
    });
    function selectBairro(val) {
    $("#SearchBairro").val(val);
    $("#SugestaoBairro").hide();
    }
</script>

<!-- listar cidade -->
<script>
    $(document).ready(function(){
        $("#SearchCidade").keyup(function(){
            $.ajax({
            type: "POST",
            url: "pesquisa-dinamica-cidade.php",
            data:'keywordCidade='+$(this).val(),
            beforeSend: function(){
                $("#SearchCidade").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
            },
            success: function(data){
                $("#SugestaoCidade").show();
                $("#SugestaoCidade").html(data);
                $("#SearchCidade").css("background","#FFF");
            }
            });
        });
    });
    function selectCidade(val) {
    $("#SearchCidade").val(val);
    $("#SugestaoCidade").hide();
    }
</script>

<!-- listar e-mail -->
<script>
    $(document).ready(function(){
        $("#SearchEmail").keyup(function(){
            $.ajax({
            type: "POST",
            url: "pesquisa-dinamica-email.php",
            data:'keywordEmail='+$(this).val(),
            beforeSend: function(){
                $("#SearchEmail").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
            },
            success: function(data){
                $("#SugestaoEmail").show();
                $("#SugestaoEmail").html(data);
                $("#SearchEmail").css("background","#FFF");
            }
            });
        });
    });
    function selectEmail(val) {
    $("#SearchEmail").val(val);
    $("#SugestaoEmail").hide();
    }
</script>