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
          <i class="fa fa-table"></i><?php echo $disciplina ?> | Alunos Inscritos
        <a id = "retrocederBtn" href="#" >Voltar a Disciplinas</a></div>
        <div class="card-body">
          <div class="table-responsive">
     
    <table class="table table-bordered" id="tabela" width="100%" cellspacing="0">
     <thead>
   <tr>
    <th>Nº Aluno</th><th>Nome</th><th>Disciplina</th><th>Turma</th><th>Nº Presenças</th><th>Assiduidade (%)</th></tr>
     </thead>
     <tbody>
     </tbody>
      <tfoot>
   <tr>
    <th>Nº Aluno</th><th>Nome</th><th>Disciplina</th><th>Turma</th><th>Nº Presenças</th><th>Assiduidade (%)</th></tr>              </tfoot>
     </table>

              
          </div>
        </div>
        <div class="card-footer small text-muted"><?php date_default_timezone_set("Europe/Lisbon"); echo "Atualizado pela última vez às: " . date("G:i");?></div>
      </div>
   </div>

<script type="text/javascript">
    $("#retrocederBtn").click(function(){
      $("#content").load("<?php echo base_url("Docente/minhasDisciplinas") ?>");
    });
    $('#tabela').DataTable({
  
        "ajax": {
            url : "<?php echo base_url("Tabelas/tabela_alunos_inscritos_disciplina_pos_graduacao/").$id_disciplina ?>",
            type : 'GET'
        },
              "language": {
            "emptyTable": "Não tem alunos inscritos."
        }
    });

</script>
