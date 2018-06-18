


<div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Ferramentas</a>
        </li>
        <li class="breadcrumb-item active">Gerar Acessos</li>
      </ol>
      <!-- Example DataTables Card-->
      <div class="card mb-3">
<?php  
        echo form_open('Acessos/acessos_validation','class="contact100-form validate-form" id = "myForm"'); 
        echo validation_errors();
        
        ?>
        
           <div class="form-group validate-input" style="margin: 0 auto;" > 
              <div class="wrap-input100 validate-input" > 
                  <input id = "data" type="date" class="input100" placeholder="Data">
                  <span class="focus-input100"></span>
                  <label class="label-input100" for="data">
                    <span ><i class="fas fa-calendar-alt"></i></span>
                  </label>
              </div>
          
     
            <div class="container-contact100-form-btn">
              <button class="contact100-form-btn" id= "BotaoGerar">Gerar</button>
              <?php  
                      echo form_close(); 
                               
                        ?>
            </div>
            <h6 style = "margin:0 auto;">Gera 1000 acessos para a data escolhida</h6><br>
         </div>
        <div id = "lo"></div>
  <script>
  $('#BotaoGerar').click(function(){
      $('#lo').html("<div class='loader' style = 'width:120px; height:120px; margin:0 auto'> </div>Aguarde ");
      var datainput = $("input#data").val();
      var dataString = datainput ;
         var url = "<?php echo base_url('Acessos/acessos_validation') ?>"; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
                // serializes the form's elements.
              "data":{  data: dataString,'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' },
               success: function(data)
               {
                   alert(data); // show response from the php script.
                   $("#content").load("<?php echo base_url('Admin/gerar_acessos') ?>");
                   
               }
             });

        return false; // avoid to execute the actual submit of the form.
     
    });
        </script>
      </div>
</div>
