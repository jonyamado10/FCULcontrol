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
          <i class="fa fa-table"></i> As minhas disciplinas
        <a id = "retrocederBtn" href="#" >Voltar a Aulas</a></div>

        <div class="card-body">
          <div class="table-responsive">
     
    <table class="table table-bordered" id="tabela-disciplinas" width="100%" cellspacing="0">
     <thead>
   <tr>
    <th>Disciplina</th><th>Regente</th><th>Semestre</th><th>ECTS</th><th>Turma</th><th>Ano Letivo</th><th>Grau</th><th>Nº Alunos Inscritos</th><th></th></tr>
     </thead>
     <tbody>
     </tbody>
      <tfoot>
   <tr>
<th>Disciplina</th><th>Regente</th><th>Semestre</th><th>ECTS</th><th>Turma</th><th>Ano Letivo</th><th>Grau</th><th>Nº Alunos Inscritos</th><th></th></tr>
              </tfoot>
     </table>

              
          </div>
        </div>
        <div class="card-footer small text-muted"><?php date_default_timezone_set("Europe/Lisbon"); echo "Atualizado pela última vez às: " . date("G:i");?></div>
      </div>
   </div>

<script type="text/javascript">
      
    $('#tabela-disciplinas').DataTable({
  
        "ajax": {
            url : "<?php echo base_url("Tabelas/tabela_disciplinas") ?>",
            type : 'GET'
        },
              "language": {
            "emptyTable": "Não tem disciplinas."
        },
        "columnDefs": [
    { "orderable": false, "targets": 8 }
  ]
    });

</script>
