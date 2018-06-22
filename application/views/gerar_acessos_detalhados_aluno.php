<div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Ferramentas</a>
        </li>
        <li class="breadcrumb-item active">Gerar 1 Entrada Detalhada</li>
      </ol>
      <!-- Example DataTables Card-->
      <div class="card mb-3">
<?php  
        echo form_open('Acessos/acessos_detalhados_aluno_validation','class="contact100-form validate-form" id = "myForm"'); 
        echo validation_errors();
        $attr = array(
        'class'         => 'form-control input100',
        'id'           => 'data'
);
        ?>
        <div class="form-group validate-input" style="margin: 0 auto;"> 
           <div class="wrap-input100 validate-input" > 
 
                <input id = "data" type="date" class="input100" placeholder="Data">
                <span class="focus-input100"></span>
                <label class="label-input100" for="data">
                  <span ><i class="fas fa-calendar-alt"></i></span>
                </label>
           
           </div>
           <div class="wrap-input100 validate-input" > 
 
                <input id = "num_aluno" type="text" class="input100" placeholder="Nº Aluno">
                <span class="focus-input100"></span>
                <label class="label-input100" for="Nº Aluno">
                  <span ><i class="fas fa-user"></i></span>
                </label>
           
           </div>
          
        

            <div class="wrap-input100 validate-input" > 
                <div class = "clockpicker1" data-placement="right" data-align="top" data-autoclose="true">  
                <input id = "hora_inicial" type="text" class="input100" placeholder="Hora Inicial">
                <span class="focus-input100"></span>
                <label class="label-input100" for="hora_inicial">
                  <span ><i class="fas fa-clock"></i></span>
                </label>
               </div>
              
            </div>

 
          <div class="wrap-input100 validate-input" > 
 
                <input id = "edificio" type="text" class="input100" placeholder="Nº Edificio">
                <span class="focus-input100"></span>
                <label class="label-input100" for="edificio">
                  <span ><i class="fas fa-building"></i></span>
                </label>
           
           </div>
               <div class="wrap-input100 validate-input" > 
 
                <input id = "piso" type="text" class="input100" placeholder="Nº Piso">
                <span class="focus-input100"></span>
                <label class="label-input100" for="piso">
                  <span ><i class="fas fa-chevron-circle-down"></i></span>
                </label>
           
           </div>
               <div class="wrap-input100 validate-input" > 
 
                <input id = "porta" type="text" class="input100" placeholder="Nº Porta">
                <span class="focus-input100"></span>
                <label class="label-input100" for="porta">
                  <span ><i class="fas fa-door-open"></i></span>
                </label>
           
           </div>
          

            <div class="container-contact100-form-btn">
                  <button class="contact100-form-btn" id= "BotaoGerar">Gerar</button>
                     <?php  
                      echo form_close(); 
                               
                        ?>
            </div>
        </div>
        <div id = "lo"></div>
        <script>
  $('#BotaoGerar').click(function(){
      $('#lo').html("<div class='loader' style = 'width:120px; height:120px; margin:0 auto'> </div>Aguarde ");
        var data = $("input#data").val();
        var hora_inicial = $("input#hora_inicial").val();
        var num_aluno = $("input#num_aluno").val();
        var edificio = $("input#edificio").val();
        var piso = $("input#piso").val();
        var porta = $("input#porta").val();



        var dataString = 'data='+ data + '&hora_inicial=' + hora_inicial + '&num_aluno=' + num_aluno +'&piso=' + piso +'&edificio=' + edificio +'&porta=' + porta + '&<?php echo $this->security->get_csrf_token_name(); ?>=' + '<?php echo $this->security->get_csrf_hash(); ?>';
         var url = "<?php echo base_url('Acessos/acessos_detalhados_aluno_validation') ?>"; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
                data: dataString ,
               success: function(data)
               {
                   alert(data); // show response from the php script.
                   $("#content").load("<?php echo base_url('Admin/gerar_acessos_detalhados_aluno') ?>");
                   
               }, 
               error: function(XMLHttpRequest, textStatus, errorThrown) {
                 alert("Base de dados não autoriza escritas");
                 $("#content").load("<?php echo base_url('Admin/gerar_acessos_detalhados_aluno') ?>");
              }
             });

        return false; // avoid to execute the actual submit of the form.
     
    });
        </script>
      
</div>

<script type="text/javascript">
$('.clockpicker1').clockpicker();
</script>