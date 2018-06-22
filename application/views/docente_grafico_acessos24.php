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
          <i class="fa fa-area-chart"></i> Acessos últimas 24 h</div>
        <div class="card-body">
          <canvas id="acessos24" width="100%" height="30"></canvas>
        </div>
      
        <div class="card-footer small text-muted"><?php date_default_timezone_set("Europe/Lisbon");
echo "Atualizado pela última vez às: " . date("G:i");
?>
      
        </div>
    </div>
</div>

<script type="text/javascript">
  <?php 
  $js_array = json_encode(array_keys($acessos24));
  echo "var javascript_array = ". $js_array . ";\n";
  ?>
var ctx = document.getElementById("acessos24");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: javascript_array,
    datasets: [{
      label: "acessos",
      lineTension: 0.3,
      backgroundColor: "rgba(2,117,216,0.2)",
      borderColor: "rgba(2,117,216,1)",
      pointRadius: 5,
      pointBackgroundColor: "rgba(2,117,216,1)",
      pointBorderColor: "rgba(255,255,255,0.8)",
      pointHoverRadius: 5,
      pointHoverBackgroundColor: '#dc3545',
      pointHitRadius: 20,
      pointBorderWidth: 2,
      data:  <?php echo json_encode(array_values($acessos24));?>,
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'hour'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 24
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: Math.max(...<?php echo json_encode(array_values($acessos24));?>) +5,
          maxTicksLimit: 5
        },
        gridLines: {
          color: "rgba(0, 0, 0, .125)",
        }
      }],
    },
    legend: {
      display: true
    }
  }
});


</script>