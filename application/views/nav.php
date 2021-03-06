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
  <link href="<?php echo base_url('assets/clockpicker/css/bootstrap-clockpicker.min.css') ?>" rel="stylesheet">
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
            <i class="fa fa-fw fas fa-tachometer-alt"></i>
            <span class="nav-link-text">Dashboard</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Acessos">
         <a id = "navAcessos" class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-map-marker"></i>
            <span class="nav-link-text">Acessos</span>
          </a>
           <ul class="sidenav-second-level collapse" id="collapseComponents">
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
              <a id = "navTabelas" class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents.00" data-parent="#exampleAccordion">
                <i class="fa fa-fw fa-table"></i>
                <span class="nav-link-text">Tabelas</span>
              </a>
              <ul class="sidenav-third-level collapse" id="collapseComponents.00">
                <li>
                  <a id = "BotaoAcessosAlunos" href="#">Alunos</a>
                </li>
                    <li>
                  <a id = "BotaoAcessosDocentes" href="#">Docentes</a>
                </li>
                <li>
                  <a id = "BotaoAcessosNaoDocentes" href="#">Não Docentes</a>
                </li>
              </ul>
            </li>
             <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
             <a id = "navGraficos" class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents.01" data-parent="#exampleAccordion">
                <i class="fa fa-fw fa-area-chart"></i>
                <span class="nav-link-text">Gráficos</span>
              </a>
              <ul class="sidenav-third-level collapse" id="collapseComponents.01">
                <li>
                  <a id ="BotaoAcessos24" href = "#">Acessos últimas 24 h</a>
                </li>
                <li>
                  <a id ="BotaoAcessos6m" href=#>Acessos últimos 6 meses</a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="servicos">
         <a id = "navServicos" class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents2" data-parent="#exampleAccordion">
            <i class="fa fa-fw fas fa-graduation-cap"></i>
            <span class="nav-link-text">Serviços Académicos</span>
          </a>
           <ul class="sidenav-second-level collapse" id="collapseComponents2">

                  <li>
                    <a id = "BotaoTabelaAlunos" href="#">Alunos</a>
                  </li>
                  <li>
                    <a id = "BotaoTabelaDocentes" href="#">Docentes</a>
                  </li>
                  <li>
                    <a id ="BotaoAlunosDepartamento" href = "#">Alunos por Departamento</a>
                  </li>
                  
          </ul>
        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
          <a id = "navFerramentas"class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents3" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-wrench"></i>
            <span class="nav-link-text">Ferramentas</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseComponents3">
            <li>
              <a id = "BotaoGerarAcessos" href="#"">Gerar Acessos</a>
            </li>
              <li>
              <a id = "BotaoGerarAcessosDetalhados" href="#"">Gerar Acessos Detalhados</a>
            </li>
            <li>
              <a id = "BotaoGerarAcessosDetalhadosAluno" href="#"">Gerar Entrada Detalhada </a>
            </li>
          </ul>
        </li>
        <!--<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseExamplePages" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-file"></i>
            <span class="nav-link-text">Example Pages</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseExamplePages">
            <li>
              <a href="login.html">Login Page</a>
            </li>
            <li>
              <a href="register.html">Registration Page</a>
            </li>
            <li>
              <a href="forgot-password.html">Forgot Password Page</a>
            </li>
            <li>
              <a href="blank.html">Blank Page</a>
            </li>
          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-sitemap"></i>
            <span class="nav-link-text">Menu Levels</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseMulti">
            <li>
              <a href="#">Second Level Item</a>
            </li>
            <li>
              <a href="#">Second Level Item</a>
            </li>
            <li>
              <a href="#">Second Level Item</a>
            </li>
            <li>
              <a class="nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti2">Third Level</a>
              <ul class="sidenav-third-level collapse" id="collapseMulti2">
                <li>
                  <a href="#">Third Level Item</a>
                </li>
                <li>
                  <a href="#">Third Level Item</a>
                </li>
                <li>
                  <a href="#">Third Level Item</a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Link">
          <a class="nav-link" href="#">
            <i class="fa fa-fw fa-link"></i>
            <span class="nav-link-text">Link</span>
          </a>
        </li>-->
      </ul>
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
   
      <ul class="navbar-nav ml-auto">
      <?php if(!empty($sensores)){
      ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-bell"></i>
            <span class="d-lg-none">Alertas
              <span class="badge badge-pill badge-warning"><?php echo sizeof($sensores); ?> Novos</span>
            </span>
            <span class="indicator text-danger d-none d-lg-block">
              <i class="fa fa-fw fa-circle"></i>
            </span>
          </a>
          <div class="dropdown-menu" aria-labelledby="alertsDropdown" >
            <h6 class="dropdown-header">Estado dos sensores:</h6>
            
            <?php 
            $i=0;
            foreach ($sensores as $sensor) {
              if($i>4){break;}
              ?>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">
                <span class="text-danger">
                  <strong>
                    <i class="fa fa-long-arrow-alt-down fa-fw"></i>Possíveis Falhas</strong>
                </span>
                <span class="medium float-right text-danger"><?php echo $sensor->porta; ?></span>
                <div class="dropdown-message small">O sensor de <?php echo $sensor->sentido." da porta ".$sensor->porta;?> não <br>regista nenhum acesso desde <?php echo $sensor->data; ?></div>
              </a>
             <?php 
              $i++;
            } ?> 
           <a class="dropdown-item small" id="BotaoVerTodosAlertas" href="#">Ver todos os Alertas</a>

            </div>

          </li>

            <?php 
          }
          else{?>
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-bell"></i>
            <span class="d-lg-none"> Sem alertas
            </span>
             <span class="indicator text-success d-none d-lg-block">
              <i class="fa fa-fw fa-circle"></i>
            </span>
          </a>
          <div class="dropdown-menu" aria-labelledby="alertsDropdown">
            <h6 class="dropdown-header">Estado dos sensores:</h6>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <span class="text-success">
                <strong>
                  <i class="fa fa-long-arrow-alt-down fa-fw"></i>Estado Positivo</strong>
              </span>
              <span class="small float-right text-muted">
                <?php date_default_timezone_set("Europe/Lisbon");
                  echo date("G:i");
                  ?>      
              </span>
              <div class="dropdown-message small">Tudo parece estar em ordem.</div>
            </a>
            <div class="dropdown-divider"></div>

          </div>
          </li>
          <?php }?>
        </li>
        <li class="nav-item" style=" margin:0 auto;">
          <a class="nav-link" style="color:white; cursor: default;">
            <i class="fa fa-fw fa-user-secret"></i><?php echo "Bem-vindo, ".$this->session->userdata('nome')?>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" href="<?php echo base_url('Login/logout') ?>" data-target="#exampleModal">
            <i class="fa fa-fw fas fa-sign-out-alt"></i>Terminar sessão</a>
        </li>
      </ul>
    </div>
  </nav>

  <div id = "content" class="content-wrapper">
