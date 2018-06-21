<div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Tabelas</li>
      </ol>
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Assiduidade Média Disciplina/Turma</div>
        <div class="card-body">
          <div class="table-responsive">
     
    <table class="table table-bordered" id="tabela-docentes" width="100%" cellspacing="0">
     <thead>
        <tr><th>Disciplina</th>
      <th>Turma</th>
      <th>Total de presencas</th>
      <th>Presenças Máximas esperadas</th>
      <th>Assiduidade %</th>
     </tr>
     </thead>
     <tbody>
     </tbody>
      <tfoot>
       <tr><th>Disciplina</th>
      <th>Turma</th>
      <th>Total de presencas</th>
      <th>Presenças Máximas esperadas</th>
      <th>Assiduidade %</th>
     </tr>
              </tfoot>
     </table>

              
          </div>
        </div>
        <div class="card-footer small text-muted"><?php date_default_timezone_set("Europe/Lisbon"); echo "Atualizado pela última vez às: " . date("G:i");?></div>
      </div>
   </div>

<script type="text/javascript">
    $('#tabela-docentes').DataTable({
        "ajax": {
           paging: false,
           searching: false,
            url : "<?php echo site_url("Tabelas/assiduidades_medias") ?>",
            type : 'GET'
        },
    });

</script>

