

    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">My Dashboard</li>
		<li class="breadcrumb-item"><p>Servidor da BD:</p><?php echo $_SERVER["location"]; echo "  |   "; echo $this->db->hostname; ?></li> 
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
            <a class="card-footer text-white clearfix small z-1" id="BotaoVerAcessos24" href="#">
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
            <a class="card-footer text-white clearfix small z-1" id="BotaoVerAcessosAlunos" href="#">
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
            <a class="card-footer text-white clearfix small z-1" id="BotaoVerAlunosCorrigidos" href="#">
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
            <a class="card-footer text-white clearfix small z-1" id="BotaoVerTodosAlertas" href="#">
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
              <i class="fa fa-bar-chart"></i> TOP 10 alunos que não passam cartão.</div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-8 my-auto">
                  <canvas id="graficotop10" width="100" height="60"></canvas>
                </div>
                <div class="col-sm-4 text-center my-auto">
                  <div class="h4 mb-0 text-primary">
                  <?php 
                  $ar = explode(":",$rebelde);
                  echo "Nº ".$ar[0]."<br>".$ar[1]; ?>

                  </div>
                  <div class="small text-muted">Pior do Mês</div>
                  <hr>
                  <div class="h4 mb-0 text-success">
                    <?php 
                  $ar = explode(":",$rebeldeWK);
                  echo "Nº ".$ar[0]."<br>".$ar[1]; ?>
                  </div>
                  <div class="small text-muted">Da Semana</div>
                </div>
              </div>
            </div>
        <div class="card-footer small text-muted"><?php date_default_timezone_set("Europe/Lisbon");
echo "Atualizado pela última vez às: " . date("G:i");
?>
      
        </div>
    </div>
      
      <!-- Example DataTables Card-->

    </div>
    <script type="text/javascript">
    <?php 
  $js_array = json_encode(array_keys($top10));
  echo "var javascript_array = ". $js_array . ";\n";
  ?>
var ctx = document.getElementById("graficotop10");
var myLineChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: javascript_array,
    datasets: [{
      label: "Acessos",
      backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745', '#f58293 ','#911eb4','#46f0f0','#f032e6','#d2f53c','#fabebe'],
      borderColor: "rgba(2,117,216,1)",
      data:  <?php echo json_encode(array_values($top10));?>,
    }],
  },
  options: {
    scales: {
      xAxes: [{
      
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 6
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max:  Math.max(...<?php echo json_encode(array_values($top10));?>) +2,
          maxTicksLimit: 10
        },
        gridLines: {
          display: true
        }
      }],
    },
    legend: {
      display: false
    }
  }
});

 

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
    $("#BotaoVerAcessosAlunos").click(function(){
         $('.container-fluid').remove();
         $('#content').html("<div class='loader'></div> ");
        $("#content").load("<?php echo base_url('Admin/tabela_acessos_alunos') ?>");
    });
      $("#BotaoVerAcessos24").click(function(){
        $('.container-fluid').remove();
        $('#content').html("<div class='loader'></div> ");
        $("#content").load("<?php echo base_url('Admin/grafico_acessos24') ?>");
    });
</script>
