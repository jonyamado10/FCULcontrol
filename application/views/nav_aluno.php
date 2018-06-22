<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>FCUL - Controlo de Acessos</title>
  <link rel="icon" type="image/png" href="<?php echo base_url("assets/images/icons/favicon.ico") ?>"/>

  <!-- Bootstrap core CSS-->
    <link rel="stylesheet" href="<?php echo base_url("assets/css/main.css") ?>">
      <link rel="stylesheet" href="<?php echo base_url("assets/css/util.css") ?>">
  <link href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url('assets/vendor/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="<?php echo base_url('assets/css/sb-admin.css') ?>" rel="stylesheet">
  <!-- Page level plugin CSS-->
  <link href="<?php echo base_url('assets/vendor/datatables/dataTables.bootstrap4.css') ?>" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">

      <script src=<?php echo base_url("assets/vendor/jquery/jquery.min.js") ?>></script>
    <script src=<?php echo base_url("assets/vendor/chart.js/Chart.min.js") ?>></script>


</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href=""><img id="logo" src = "<?php echo base_url('assets/img/logo.png') ?>"></a>

    <button id = "botao" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion" style= "margin-top:100px;">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" id = "BotaoDashboard">
            <i class="fa fa-fw fa-tachometer-alt"></i>
            <span class="nav-link-text">Dashboard</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
         <a id = "navGraficos" class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents1" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-area-chart"></i>
            <span class="nav-link-text">Gráficos</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseComponents1">
            <li>
              <a id ="BotaoMeusAcessos24h" href = "#">Acessos últimas 24 h</a>
            </li>
          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
          <a id = "navTabelas" class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents2" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-table"></i>
            <span class="nav-link-text">Tabelas</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseComponents2">
            <li>
              <a id = "BotaoTabelaMeusAcessos" href="#">Os Meus Acessos</a>
            </li>
            <li>
              <a id = "minhasDisciplinas" href="#">As Minhas Disciplinas</a>
            </li>
          </ul>
        </li>
      </ul>
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item" style=" margin:0 auto;">
          <a class="nav-link" style="color:white; cursor: default;">
            <i class="fa fa-fw fa-user-secret"></i><?php echo "Bem-vindo, ".$this->session->userdata('nome')?>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" href="<?php echo base_url('Login/logout') ?>" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out-alt"></i>Terminar sessão</a>
        </li>
      </ul>
    </div>
  </nav>

  <div id = "content" class="content-wrapper">