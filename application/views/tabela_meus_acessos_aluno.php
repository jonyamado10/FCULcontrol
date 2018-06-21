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
          <i class="fa fa-table"></i> Os meus acessos</div>
        <div class="card-body">
          <div class="table-responsive">
     
    <table class="table table-bordered" id="tabela" width="100%" cellspacing="0">
     <thead>
   <tr>
<th>Nº</th><th>Nome</th><th>Data</th><th>Hora</th><th>Porta</th><th>Sentido</th></tr>
     </thead>
     <tbody>
     </tbody>
      <tfoot>
   <tr>
<th>Nº</th><th>Nome</th><th>Data</th><th>Hora</th><th>Porta</th><th>Sentido</th></tr>
              </tfoot>
     </table>

              
          </div>
        </div>
        <div class="card-footer small text-muted"><?php date_default_timezone_set("Europe/Lisbon"); echo "Atualizado pela última vez às: " . date("G:i");?></div>
      </div>
   </div>

<script type="text/javascript">
$('#tabela tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" id ="searchcol"  placeholder="Procurar '+title+'" />' );
        $(this).css("background-color", "#d7dbe2");
        
    } );

   var url = "<?php echo base_url("Tabelas/acessos_user_aluno") ?>";

   var table = $('#tabela').DataTable({

        "processing": true,
        "serverSide": true,
        "ajax":{
         "url": url,
         "dataType": "json",
         "type": "POST",
          "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                       },
          "columns": [
              { "data": "num_aluno" },
              { "data": "nome" },
              { "data": "data" },
              { "data": "hora" },
              { "data": "porta" },
              { "data": "sentido" },
              
           ],
        "createdRow": function( row, data, dataIndex){
                if( data["sentido"] ==  'Entrada'){
                    $('td', row).eq(5).css("background-color", "#4af444");
                }
                if( data["sentido"] ==  'Saida'){
                  $('td', row).eq(5).css("background-color", "#f43838");
                }
          }
    });
       table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );


</script>

