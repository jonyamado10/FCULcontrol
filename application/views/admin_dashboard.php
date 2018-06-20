
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">My Dashboard</li>
		<li class="breadcrumb-item"><?php echo $_SERVER["location"]; echo "  |   "; echo $this->db->hostname; ?></li> 
      </ol>
      <!-- Icon Cards-->
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-map-marker"></i>
              </div>
              <div class="mr-5"><?php echo $num_acessos_hj ?> Acessos nas últimas 24 horas!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="#">
              <span class="float-left">Ver Detalhes</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
    
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fas fa-trophy"></i>
              </div>
              <div class="mr-5"><?php echo $num_acessos_corrigidos_hj;?> Acessos Corrigidos nas últimas 24 horas!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="#">
              <span class="float-left">Ver Detalhes</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-warning o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-exclamation"></i>
              </div>
                <div class="mr-5"><?php echo $num_alunos_nao_passou_cartao?> Alunos que não passaram cartão nas últimas 24 horas!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" id="#BotaoVerAlunosCorrigidos" href="#">
              <span class="float-left">Ver Detalhes</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
<?php  if(empty($num_sensores)){ ?> 
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-exclamation-triangle"></i>
              </div>
                <div class="mr-5">Sem Alertas!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" id="BotaoVerTodosAlertas" href="#">
              <span class="float-left">Ver Detalhes</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <?php }
        else{?>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-danger o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-exclamation-triangle"></i>
              </div>
                <div class="mr-5"><?php echo sizeof($num_sensores); ?> Sensores Possivelmente Danificados!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="#">
              <span class="float-left">Ver Detalhes</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div> 
         <?php } ?>
      </div>
      <!-- Area Chart Example-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-area-chart"></i> Area Chart Example</div>
        <div class="card-body">
          <canvas id="myAreaChart" width="100%" height="30"></canvas>
        </div>
        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
      </div>
      
      <!-- Example DataTables Card-->

    </div>
   
<script type="text/javascript">
     $("#BotaoVerAlunosCorrigidos").click(function(){
        $('.container-fluid').remove();
        $('#content').html("<div class='loader'></div> ");
         $("#content").load("<?php echo base_url('Admin/tabela_acessos_alunos_corrigidos') ?>");
    });
   $("#BotaoVerTodosAlertas").click(function(){
        $('.container-fluid').remove();
        $('#content').html("<div class='loader'></div> ");
        $("#content").load("<?php echo base_url('Admin/tabela_alertas') ?>");
    });
  
</script>