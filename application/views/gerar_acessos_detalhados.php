  <link href="<?php echo base_url('assets/clockpicker/css/bootstrap-clockpicker.min.css') ?>" rel="stylesheet">

    <script src=<?php echo base_url("assets/clockpicker/js/bootstrap-clockpicker.min.js") ?>></script>



<div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Ferramentas</a>
        </li>
        <li class="breadcrumb-item active">Gerar Acessos Detalhados</li>
      </ol>
      <!-- Example DataTables Card-->
      <div class="card mb-3">
<?php  
        echo form_open('Acessos/acessos_detalhados_validation','class="contact100-form validate-form" id = "myForm"'); 
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
                <div class = "clockpicker1" data-placement="right" data-align="top" data-autoclose="true">  
                <input id = "hora_inicial" type="text" class="input100" placeholder="Hora Inicial">
                <span class="focus-input100"></span>
                <label class="label-input100" for="hora_inicial">
                  <span ><i class="fas fa-clock"></i></span>
                </label>
               </div>
               <div class = "clockpicker2" data-placement="right" data-align="top" data-autoclose="true">  <input id = "hora_final" type="text" class="input100" placeholder="Hora Final">
                <span class="focus-input100"></span>
                <label class="label-input100" for="hora_inicial">
                  <span ><i class="fas fa-clock"></i></span>
                </label></div> 
            </div>

            <div class="wrap-input100 validate-input" > 
 
            <select name="num_acessos" id="num_acessos" class="input100" style = "height: 60px;")">
              <option value=""<?php echo  set_select('num_acessos', 'none', TRUE); ?>>Nº Acessos a Gerar</option>
                <option value="500">500</option>
                <option value="1000">1000</option>
                <option value="1500">1500</option>
                <option value="2000">2000</option>


          </select>
                <span class="focus-input100"></span>
                <label class="label-input100" for="data">
                  <span ><i class="fas fa-universal-access"></i></span>
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
        var hora_final = $("input#hora_final").val();
        var num_acessos = $("select#num_acessos").val();
        var dataString = 'data='+ data + '&hora_inicial=' + hora_inicial + '&hora_final=' + hora_final + '&num_acessos=' + num_acessos;
         var url = "<?php echo base_url('Acessos/acessos_detalhados_validation') ?>"; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
                "data":{  data: dataString,'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' },
               success: function(data)
               {
                   alert(data); // show response from the php script.
                   $("#content").load("<?php echo base_url('Admin/gerar_acessos_detalhados') ?>");
                   
               }
             });

        return false; // avoid to execute the actual submit of the form.
     
    });
        </script>
      
</div>

<script type="text/javascript">
$('.clockpicker1').clockpicker();
$('.clockpicker2').clockpicker();
</script>