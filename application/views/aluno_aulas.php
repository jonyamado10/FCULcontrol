<div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Serviços Académicos</a>
        </li>
        <li class="breadcrumb-item active">Tabelas</li>
      </ol>
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> O Meu Horário</div>
        <div class="card-body">
          <div class="table-responsive">
     
    <table class="table table-bordered" id="tabela" width="100%" cellspacing="0">
     <thead>
   <tr>
    <th>Disciplina</th><th>Turma</th><th>Data</th><th>Horário</th><th>Sala</th></tr>
     </thead>
     <tbody>
     </tbody>
      <tfoot>
   <tr>
<th>Disciplina</th><th>Turma</th><th>Data</th><th>Horário</th><th>Sala</th></tr>
              </tfoot>
     </table>

              
          </div>
        </div>
        <div class="card-footer small text-muted"><?php date_default_timezone_set("Europe/Lisbon"); echo "Atualizado pela última vez às: " . date("G:i");?></div>
      </div>
   </div>

<script type="text/javascript">

    $('#tabela').DataTable({
  
        "ajax": {
            url : "<?php echo base_url("Tabelas/tabela_aulas_aluno") ?>",
            type : 'GET'
        },
              "language": {
            "emptyTable": "Não tem aulas."
        }
    });

</script>
