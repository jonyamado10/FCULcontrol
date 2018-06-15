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
          <i class="fa fa-table"></i> Alunos</div>
        <div class="card-body">
          <div class="table-responsive">
     
    <table class="table table-bordered" id="tabela-alunos" width="100%" cellspacing="0">
   <thead>
     <tr><th>Nº Aluno</th>
      <th>Nome</th>
      <th>Email</th>
      <th>Nº Cartão de Cidadão</th>
      <th>Departamento</th></tr>
     </thead>
     <tbody>
     </tbody>
      <tfoot>
         <tr><th>Nº Aluno</th>
      <th>Nome</th>
      <th>Email</th>
      <th>Nº Cartão de Cidadão</th>
      <th>Departamento</th></tr>
              </tfoot>
     </table>

              
          </div>
        </div>
        <div class="card-footer small text-muted"><?php date_default_timezone_set("Europe/Lisbon"); echo "Atualizado pela última vez às: " . date("G:i");?></div>
      </div>
   </div>

<script type="text/javascript">

    $('#tabela-alunos').DataTable({
        "ajax": {
           paging: false,
           searching: false,
            url : "<?php echo site_url("Tabelas/alunos") ?>",
            type : 'GET'
        },
    });

</script>

