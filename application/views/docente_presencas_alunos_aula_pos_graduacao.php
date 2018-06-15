<div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Acessos</a>
        </li>
        <li class="breadcrumb-item active">Tabelas</li>
      </ol>
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> <?php echo $disciplina ?> / Presenças
        <a id = "retrocederBtn" href="#" >Voltar a Aulas</a></div>
        <div class="card-body">
          <div class="table-responsive">
     
    <table class="table table-bordered" id="tabela" width="100%" cellspacing="0">
     <thead>
   <tr>
    <th>Nº Aluno</th><th>Nome</th><th>Hora de Entrada</th><th>Hora da Aula</th></tr>
     </thead>
     <tbody>
     </tbody>
      <tfoot>
   <tr>
    <th>Nº Aluno</th><th>Nome</th><th>Hora de Entrada</th><th>Hora da Aula</th></tr>
              </tfoot>
     </table>

              
          </div>
        </div>
        <div class="card-footer small text-muted"><?php date_default_timezone_set("Europe/Lisbon"); echo "Atualizado pela última vez às: " . date("G:i");?></div>
      </div>
   </div>

<script type="text/javascript">
    $("#retrocederBtn").click(function(){
      $("#content").load("<?php echo base_url("Docente/aulasPorDisciplinaPosGraduacao/").$id_disciplina ?>");
    });
    $('#tabela').DataTable({
  
        "ajax": {
            url : "<?php echo base_url("Tabelas/tabela_presencas_aula_pos_graduacao/").$id_aula ?>",
            type : 'GET'
        },
              "language": {
            "emptyTable": "Não há presenças para esta aula."
        }
    });

</script>
