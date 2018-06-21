    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">My Dashboard</li>
      </ol>
      <!-- Icon Cards-->
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-map-marker"></i>
              </div>
              <div class="mr-5"><? echo $n_acessos ?> Acessos esta semana!</div>
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
              <div class="mr-5"><? echo $n_aulas ?> Aulas Hoje!</div>
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
              <div class="mr-5"><?php echo $percentagem ?>% Média de assiduidade nas suas aulas!</div>
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
              <div class="mr-5"><?php echo $n_nao_passou_cartao ?> vezes que nao passou o cartão na ultima semana!</div>
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
          <i class="fa fa-area-chart"></i> Area Chart Example</div>
        <div class="card-body">
          <canvas id="myAreaChart" width="100%" height="30"></canvas>
        </div>
       <div class="card-footer small text-muted"><?php date_default_timezone_set("Europe/Lisbon"); echo "Atualizado pela última vez às: " . date("G:i");?></div>
      </div>
    </div>
   
<script type="text/javascript">
  $( "#acessosSemana" ).click(function() {
        $('.container-fluid').remove();
         $('#content').html("<div class='loader'></div> ");
        $("#content").load("<?php echo base_url('Docente/tabela_meus_acessos') ?>");
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