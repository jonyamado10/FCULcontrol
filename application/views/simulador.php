
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Simulador</title>
	<?php echo base_url("assets/vendor/bootstrap/css/bootstrap.min.css") ?>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="<?php echo base_url("assets/images/icons/favicon.ico") ?>"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/vendor/bootstrap/css/bootstrap.min.css") ?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css") ?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/fonts/iconic/css/material-design-iconic-font.min.css") ?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/fonts/Linearicons-Free-v1.0.0/icon-font.min.css") ?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/vendor/animate/animate.css") ?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/vendor/css-hamburgers/hamburgers.min.css") ?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/vendor/animsition/css/animsition.min.css") ?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/vendor/select2/select2.min.css") ?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/vendor/daterangepicker/daterangepicker.css") ?>>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/css/util.css") ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/css/main.css") ?>">
<!--===============================================================================================-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

	<div class="bg-container-contact100" style="background-image: url(<?php echo base_url("assets/images/bg-01.jpg"); ?>">
		<div class="contact100-header flex-sb-m">
			<a href="#" class="contact100-header-logo">
				<img src=<?php echo base_url("assets/images/icons/logo.png") ?> alt="LOGO">
			</a>

			<div>
				<button class="btn-show-contact100">
					Simular
				</button>
			</div>
		</div>
	</div>
			
	<div class="container-contact100">
		<div class="wrap-contact100">
			<button class="btn-hide-contact100">
				<i class="zmdi zmdi-close"></i>
			</button>

			<div class="contact100-form-title" style="background-image: url(<?php echo base_url("assets/images/bg-02.jpg"); ?>">
				<span>Simulador</span>
			</div>

				<?php  
				echo form_open('Acessos/acessos_validation','class="contact100-form validate-form"'); 
				echo validation_errors();
				?>
				<div class="wrap-input100 validate-input"> <?php echo form_input('cardnumber',$this->input->post('cardnumber'),'class="input100", placeholder="Cartão" id="cardnumber" type="number"');?>
					<span class="focus-input100"></span>
					<label class="label-input100" for="name">
						<span class="glyphicon glyphicon-credit-card"></span>
					</label>
				</div>


				<div class="wrap-input100 validate-input">
					<select name="edificio" id="edificio" class="input100" style = "height: 60px;")">
							<option value=""<?php echo  set_select('edificio', 'none', TRUE); ?>>Edifício..</option>
								<option value="C1">C1</option>
								<option value="C2">C2</option>
								<option value="C3">C3</option>
								<option value="C4">C4</option>
								<option value="C5">C5</option>
								<option value="C6">C6</option>
								<option value="C7">C7</option>
								<option value="C8">C8</option>
								<option value="G">Garagem</option>
					</select>
		
					<span class="focus-input100"></span>
					<label class="label-input100" for="edificio">
						<span class="glyphicon glyphicon-tower"></span>
					</label>
				</div>


				<div class="wrap-input100 validate-input">
					<select name="piso" id="piso" class="input100" style = "height: 60px;")">
							<option value=""<?php echo  set_select('piso', 'none', TRUE); ?>>Piso..</option>
								<option value="1">Piso 1</option>
								<option value="2">Piso 2</option>
								<option value="3">Piso 3</option>
								<option value="4">Piso 4</option>
								<option value="5">Piso 5</option>
					</select>
					<span class="focus-input100"></span>
					<label class="label-input100" for="piso">
						<span class="glyphicon glyphicon-triangle-top"></span>
					</label>
				</div>


				<div class="wrap-input100 validate-input">
					<select name="porta" id="porta" class="input100" style = "height: 60px;")">
							<option value=""<?php echo  set_select('porta', 'none', TRUE); ?>>Sala/Porta..</option>
								<option value="E1">Entrada 1</option>
								<option value="E2">Entrada 2</option>
								<option value="E3">Entrada 3</option>
								<option value="E4">Entrada 4</option>
								<option value="1">Sala 1</option>
								<option value="2">Sala 2</option>
								<option value="3">Sala 2</option>

					</select>
					<span class="focus-input100"></span>
					<label class="label-input100" for="porta">
						<span class="glyphicon glyphicon-modal-window"></span>
					</label>
				</div>

				<div class="container-contact100-form-btn">
					<?php  
			            echo form_submit('simular','Submeter', array('class' =>'contact100-form-btn'));
			            echo form_close(); 
			                     
                    ?>
				</div>
			</form>
		</div>
	</div>



<!--===============================================================================================-->
	<script src=<?php echo base_url("assets/vendor/jquery/jquery-3.2.1.min.js") ?>></script>
<!--===============================================================================================-->
	<script src=<?php echo base_url("assets/vendor/animsition/js/animsition.min.js") ?>></script>
<!--===============================================================================================-->
	<script src=<?php echo base_url("assets/vendor/bootstrap/js/popper.js") ?>></script>
	<script src=<?php echo base_url("assets/vendor/bootstrap/js/bootstrap.min.js") ?>></script>
<!--===============================================================================================-->
	<script src=<?php echo base_url("assets/vendor/select2/select2.min.js") ?>></script>
<!--===============================================================================================-->
	<script src=<?php echo base_url("assets/vendor/daterangepicker/moment.min.js") ?>></script>
	<script src=<?php echo base_url("assets/vendor/daterangepicker/daterangepicker.js") ?>></script>
<!--===============================================================================================-->
	<script src=<?php echo base_url("assets/vendor/countdowntime/countdowntime.js") ?>></script>
<!--===============================================================================================-->
	<script src=<?php echo base_url("assets/js/main.js") ?>></script>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-23581568-13');
	</script>
</body>
</html>
