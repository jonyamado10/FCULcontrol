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
          <i class="fa fa-table"></i> Não Docentes
            <div class = "corrigir">
            <div id = "corrigirText"><i class="fa fa-check-circle"></i> Corrigir</div>
            <label class="switch">
              <input id = "s" type="checkbox" value = "corrigir" title="Corrigir Acessos"> 
              <span class="slider round"></span>
            </label>
            </div>
          </div>

        <div class="card-body">
          <div class="table-responsive">
    
            <table class="table table-bordered" id="tabela" width="" cellspacing="0">
             <thead>
           <tr>
        <th>Nº Funcionário</th><th>Nome</th><th>Data</th><th>Hora</th><th>Porta</th><th>Sentido</th><th>Passou Cartão?</th></tr>
             </thead>
             <tbody>
             </tbody>
              <tfoot>
           <tr>
        <th>Nº Funcionário</th><th>Nome</th><th>Data</th><th>Hora</th><th>Porta</th><th>Sentido</th><th>Passou Cartão?</th></tr>
                      </tfoot>
             </table>

              
          </div>
        </div>
        <div class="card-footer small text-muted"><?php date_default_timezone_set("Europe/Lisbon"); echo "Atualizado pela última vez às: " . date("G:i");?></div>
      </div>
   </div>

<script type="text/javascript">


$('#s').change(function() {
   if($(this).is(":checked")) {
      //'checked' event code
    //  if(confirm("Esta operação pode demorar alguns minutos, Quer continuar?")){
         $('.container-fluid').remove();
         $('#content').html("<div class='loader'></div> ");
          $("#content").load("<?php echo base_url('Admin/tabela_acessos_naoDocentes_corrigidos') ?>");

     // }

   }

   //'unchecked' event code
});
$('#tabela tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" id ="searchcol"  placeholder="Procurar '+title+'" />' );
        $(this).css("background-color", "#d7dbe2");
        
    } );

   var url = "<?php echo base_url("Tabelas/acessos_naoDocentes") ?>";

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
              { "data": "num_funcionario" },
              { "data": "nome" },
              { "data": "data" },
              { "data": "hora" },
              { "data": "porta" },
              { "data": "sentido" },
              { "data": "passou_cartao" },
           ],
            "columnDefs": [
    { "orderable": false, "targets": 6 }
  ],
        "createdRow": function( row, data, dataIndex){
                if( data["sentido"] ==  'Entrada'){
                    $('td', row).eq(5).css("background-color", "#4af444");
                }
                if( data["sentido"] ==  'Saida'){
                  $('td', row).eq(5).css("background-color", "#f43838");
                }
                if( data["passou_cartao"] ==  'Não'){
                  $(row).css("background-color", "#bedfe2");
                  $('td', row).eq(3).text( "Indefinida" );

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


