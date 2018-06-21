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
              <i class="fa fa-pie-chart"></i> Alunos por Departamento</div>
            <div class="card-body">
              <canvas id="alunosDepartamento" width="100%" height="50"></canvas>
            </div>
            <div class="card-footer small text-muted"><?php date_default_timezone_set("Europe/Lisbon");
echo "Atualizado pela última vez às: " . date("G:i");
?>
      
          </div>
    </div>
</div>

<script type="text/javascript">
  <?php 
  $js_array = json_encode(array_keys($alunos_departamento));
  echo "var javascript_array = ". $js_array . ";\n";
  ?>
  var ctx = document.getElementById("alunosDepartamento");
var myPieChart = new Chart(ctx, {
  type: 'pie',
  data: {
    labels: javascript_array,
    datasets: [{
      data: <?php echo json_encode(array_values($alunos_departamento));?>,
      backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745', '#f58231 ','#911eb4','#46f0f0','#f032e6','#d2f53c','#fabebe'],
    }],
  },
});

</script>
