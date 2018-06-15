<div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Acesso</a>
        </li>
        <li class="breadcrumb-item active">Tabelas</li>
      </ol>
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Docentes</div>
        <div class="card-body">
          <div class="table-responsive">
     
    <table class="table table-bordered" id="tabela-acessos-docentes" width="100%" cellspacing="0">
     <thead>
   <tr>
<th>Funcionário Nº</th><th>Nome</th><th>Data</th><th>Hora</th><th>Porta</th><th>Sentido</th><th>Passou Cartão?</th></tr>
     </thead>
     <tbody>
     </tbody>
      <tfoot>
   <tr>
<th>Funcionário Nº</th><th>Nome</th><th>Data</th><th>Hora</th><th>Porta</th><th>Sentido</th><th>Passou Cartão?</th></tr>
              </tfoot>
     </table>

              
          </div>
        </div>
        <div class="card-footer small text-muted"><?php date_default_timezone_set("Europe/Lisbon"); echo "Atualizado pela última vez às: " . date("G:i");?></div>
      </div>
   </div>

     <!-- Bootstrap core CSS-->
    <link rel="stylesheet" href="<?php echo base_url("assets/css/main.css") ?>">
      <link rel="stylesheet" href="<?php echo base_url("assets/css/util.css") ?>">
  <link href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url('assets/vendor/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="<?php echo base_url('assets/css/sb-admin.css') ?>" rel="stylesheet">
  <!-- Page level plugin CSS-->
  <link href="<?php echo base_url('assets/vendor/datatables/dataTables.bootstrap4.css') ?>" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">

    <script src=<?php echo base_url("assets/vendor/jquery/jquery.min.js") ?>></script>
    <script src=<?php echo base_url("assets/vendor/bootstrap/js/bootstrap.bundle.min.js") ?>></script>
    <!-- Core plugin JavaScript-->
    <script src=<?php echo base_url("assets/vendor/jquery-easing/jquery.easing.min.js") ?>></script>
    <!-- Page level plugin JavaScript-->
    <script src=<?php echo base_url("assets/vendor/chart.js/Chart.min.js") ?>></script>
    <script src=<?php echo base_url("assets/vendor/datatables/jquery.dataTables.js") ?>></script>
    <script src=<?php echo base_url("assets/vendor/datatables/dataTables.bootstrap4.js") ?>></script>
    <!-- Custom scripts for all pages-->
    <script src=<?php echo base_url("assets/js/sb-admin.min.js") ?>></script>
    <!-- Custom scripts for this page-->
    <script src=<?php echo base_url("assets/js/sb-admin-datatables.min.js") ?>></script>
    <script src=<?php echo base_url("assets/js/sb-admin-charts.min.js") ?>></script>

<script type="text/javascript">

    $('#tabela-acessos-docentes').DataTable({

        "processing": true,
        "serverSide": true,
        "ajax":{
         "url": "<?php echo base_url("Tabelas/acessos_docentes") ?>",
         "dataType": "json",
         "type": "GET",
         "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                       },

        "createdRow": function( row, data, dataIndex){
                if( data[5] ==  'Entrada'){
                    $('td', row).eq(5).css("background-color", "#4af444");
                }
                if( data[5] ==  'Saida'){
                  $('td', row).eq(5).css("background-color", "#f43838");
                }
                if( data[6] ==  'Não'){
                  $(row).css("background-color", "#bedfe2");
                  $('td', row).eq(3).text( "Indefenida" );

                }
          }
    });

</script>
