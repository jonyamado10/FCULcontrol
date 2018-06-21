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
          <i class="fa fa-table"></i> As minhas aulas
        <a id = "retrocederBtn" href="#" >Voltar a Disciplinas</a></div>
        <div class="card-body">
          <div class="table-responsive">
     
    <table class="table table-bordered" id="tabela" cellspacing="0">
     <thead>
   <tr>
    <th>Disciplina</th><th>Turma</th><th>Data</th><th>Horário</th><th>Sala</th><th>Aula Nº</th><th>Presente?</th></tr>
     </thead>
     <tbody>
     </tbody>
      <tfoot>
   <tr>
<th>Disciplina</th><th>Turma</th><th>Data</th><th>Horário</th><th>Sala</th><th>Aula Nº</th><th>Presente?</th></tr>
              </tfoot>
     </table>

              
          </div>
        </div>
        <div class="card-footer small text-muted"><?php date_default_timezone_set("Europe/Lisbon"); echo "Atualizado pela última vez às: " . date("G:i");?></div>
      </div>
   </div>

<script type="text/javascript">
    $("#retrocederBtn").click(function(){
      $("#content").load("<?php echo base_url("Aluno/minhasDisciplinas") ?>");
    });
    $('#tabela').DataTable({
  
        "ajax": {
            url : "<?php echo base_url("Tabelas/tabela_aulas_aluno_disciplina_licenciatura/").$id_disciplina ?>",
            type : 'GET'
        },
              "language": {
            "emptyTable": "Não tem disciplinas."
        }
    });

</script>
