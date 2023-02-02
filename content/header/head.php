<?php
    if (!isset($_SESSION)) session_start();
    $nivel_necessario = 1;
    if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
    session_destroy();
    header("Location: ../../index.html"); exit;
    }
?>

<head>
    <meta charset="utf-8">
    <meta lang="pt">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Agenda FP</title>

     <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- google icon -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="../../style.css">
    <link rel="icon" href="../../favicon-fisiopeti.ico" type="image/ico" sizes="16x16">

    <meta name="robots" content="noindex">
    <meta name="googlebot" content="noindex">
</head>