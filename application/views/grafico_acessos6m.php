<div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Gráficos</li>
      </ol>
      <!-- Example DataTables Card-->
    <div class="card mb-3">
              
            <div class="card-header">
              <i class="fa fa-bar-chart"></i> Acessos últimos 6 meses</div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-8 my-auto">
                  <canvas id="grafico6m" width="100" height="50"></canvas>
                </div>
                <div class="col-sm-4 text-center my-auto">
                  <div class="h4 mb-0 text-primary">
                  <?php
                      $a = array_filter($acessos6m);
                      $total = array_sum($a);
                      echo $total . " acessos";
                  ?>

                  </div>
                  <div class="small text-muted">Nos últimos 6 meses</div>
                  <hr>
                  <div class="h4 mb-0 text-success">
                    <?php
                      $a = array_filter($acessos6m);
                      $average = array_sum($a)/6;
                      echo round($average)." acessos";
                  ?></div>
                  <div class="small text-muted">, em média, por mês</div>
                </div>
              </div>
            </div>
        <div class="card-footer small text-muted"><?php date_default_timezone_set("Europe/Lisbon");
echo "Atualizado pela última vez às: " . date("G:i");
?>
      
        </div>
    </div>
</div>

<script type="text/javascript">
    <?php 
  $js_array = json_encode(array_keys($acessos6m));
  echo "var javascript_array = ". $js_array . ";\n";
  ?>
var ctx = document.getElementById("grafico6m");
var myLineChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: javascript_array,
    datasets: [{
      label: "Acessos",
      backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745', '#f58293 ','#911eb4','#46f0f0','#f032e6','#d2f53c','#fabebe'],
      borderColor: "rgba(2,117,216,1)",
      data:  <?php echo json_encode(array_values($acessos6m));?>,
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'month'
        },
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
          max:  Math.max(...<?php echo json_encode(array_values($acessos6m));?>) +Math.max(...<?php echo json_encode(array_values($acessos6m));?>)/10,
          maxTicksLimit: 5
        },
        gridLines: {
          display: true
        }
      }],
    },
    legend: {
      display: true
    }
  }
});

 


</script>