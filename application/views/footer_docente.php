   </div>

<!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container2">
        <div class="text-center">
          <small>Copyright © PTI/PTR - Grupo 4 2018</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tem a certeza que pretende sair?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-footer">
            <a class="btn btn-primary" href="<?php echo base_url('Login/logout') ?>">Sim</a>
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Não</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
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

<script >
$(function(){
    // don't cache ajax or content won't be fresh
/*  $(document)
    .ajaxStart(function () {
      $('.container-fluid').remove();
      $('#content').html("<div class='loader'></div> ");
    })
    .ajaxStop(function () {
      $('.loader').remove();
      $('.container-fluid').show();
    });
    $.ajaxSetup ({
        cache: false
    });*/

    $("#BotaoDashboard").click(function(){
        $('.container-fluid').remove();
        $('#content').html("<div class='loader'></div> ");
        $("#content").load("<?php echo base_url('Docente/dashboard') ?>");
    });

    $("#BotaoTabelaMeusAcessos").click(function(){
        $('.container-fluid').remove();
         $('#content').html("<div class='loader'></div> ");
        $("#content").load("<?php echo base_url('Docente/tabela_meus_acessos') ?>");
    });

    $("#BotaoMeusAcessos24h").click(function(){
        $('.container-fluid').remove();
         $('#content').html("<div class='loader'></div> ");
        $("#content").load("<?php echo base_url('Docente/grafico_meus_acessos_24h') ?>");
    });

    $("#BotaoRequisitarSala").click(function(){
        $("#content").load("<?php echo base_url('Docente/RequisitarSala') ?>");
    });

    $("#BotaoTabelaDisciplinas").click(function(){
      $('.container-fluid').remove();
         $('#content').html("<div class='loader'></div> ");
        $("#content").load("<?php echo base_url('Docente/minhasDisciplinas') ?>");
    });
    $("#BotaoTabelaAulas").click(function(){
      $('.container-fluid').remove();
         $('#content').html("<div class='loader'></div> ");
        $("#content").load("<?php echo base_url('Docente/minhasAulas') ?>");
    });
    $( "#acessosSemana" ).click(function() {
        $('.container-fluid').remove();
         $('#content').html("<div class='loader'></div> ");
        $("#content").load("<?php echo base_url('Docente/tabela_meus_acessos') ?>");
    });
    $( "#aulasHoje" ).click(function() {
        $('.container-fluid').remove();
         $('#content').html("<div class='loader'></div> ");
        $("#content").load("<?php echo base_url('Docente/minhasAulas') ?>");
    });
// end  
});
</script>


  </div>
</body>

</html>