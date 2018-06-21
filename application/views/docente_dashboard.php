    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">A minha área</li>
        <li class="breadcrumb-item"> Localizaçao do Servidor <?php echo $_SERVER["location"]; echo "  | Servidor da BD:  "; echo $this->db->hostname; ?></li> 
      </ol>
      <!-- Icon Cards-->
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-map-marker"></i>
              </div>
              <div class="mr-5"><? echo $n_acessos ?> acesso(s) nas ultimas 24 horas!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" id="acessosSemana" href="#" >
              <span class="float-left">Ver Acessos</span>
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
                <i class="fa fa-fw fa-list"></i>
              </div>
              <div class="mr-5"><? echo $n_aulas ?> aula(s) hoje!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="#" id ="aulasHoje">
              <span class="float-left">Ver Aulas</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <?php if ($percentagem > 50){ ?>
          <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-thumbs-up"></i>
              </div>
              <?php }else{ ?>
              <div class="card text-white bg-danger o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-thumbs-down"></i>
              </div>
              <?php }?>
              <div class="mr-5"><?php echo $percentagem ?>% média de assiduidade nas suas aulas!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="#" id ="assiduidades">
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
                <i class="fa fa-fw fa-exclamation-triangle"></i>
              </div>
              <div class="mr-5"><?php echo $n_nao_passou_cartao ?> vez(es) que não passou o cartão na última semana!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="#" id ="nacessosSemana">
              <span class="float-left">Ver Acessos</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
      </div>
      <!-- Area Chart Example-->
       <div class="card mb-3">
              
            <div class="card-header">
              <i class="fa fa-bar-chart"></i> Assiduidades Médias Disciplina</div>
            <div class="card-body">
           
                  <canvas id="graficotop10" width="100" height="50"></canvas>
               
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
  $js_array = json_encode(array_keys($graf_assiduidades));
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
      data:  <?php echo json_encode(array_values($graf_assiduidades));?>,
    }],
  },
  options: {
    scales: {
      xAxes: [{
     
        
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 10
        }
      }],
      yAxes: [{
        time: {
          unit: '%'
        }
        ticks: {
          min: 0,
          max:  Math.max(...<?php echo json_encode(array_values($graf_assiduidades));?>) +2,
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

  $( "#acessosSemana" ).click(function() {
        $('.container-fluid').remove();
         $('#content').html("<div class='loader'></div> ");
        $("#content").load("<?php echo base_url('Docente/tabela_meus_acessos') ?>");
});
    $( "#assiduidades" ).click(function() {
        $('.container-fluid').remove();
         $('#content').html("<div class='loader'></div> ");
        $("#content").load("<?php echo base_url('Docente/tabela_assiduidades_medias') ?>");
});
    $( "#nacessosSemana" ).click(function() {
        $('.container-fluid').remove();
         $('#content').html("<div class='loader'></div> ");
        $("#content").load("<?php echo base_url('Docente/tabela_meus_acessos') ?>");
});
    $( "#aulasHoje" ).click(function() {
        $('.container-fluid').remove();
         $('#content').html("<div class='loader'></div> ");
        $("#content").load("<?php echo base_url('Docente/minhasAulas') ?>");
});
</script>