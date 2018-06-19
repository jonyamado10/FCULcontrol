
<!DOCTYPE html>
<html lang="en">
<head>
	<title>FCUL-Controlo de Acessos</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="<?php echo base_url("assets/images/icons/favicon.ico") ?>"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/vendor/bootstrap/css/bootstrap.min.css") ?>">
<!--===============================================================================================-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">

<!--===============================================================================================-->

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
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/vendor/daterangepicker/daterangepicker.css") ?>">
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
					login<BR><?php echo $_SERVER["location"];?>
				</button>
			</div>
		</div>
	</div>
			
	<div class="container-contact100" ><!-- style = "display:none;" -->
		<div class="wrap-contact100">
			<button class="btn-hide-contact100">
				<i class="zmdi zmdi-close"></i>
			</button>

			<div class="contact100-form-title" style="background-image: url(<?php echo base_url("assets/images/bg-02.jpg"); ?>">
				<span>Login</span>
			</div>

				<?php  
				echo form_open('login/login_validation','class="contact100-form validate-form"'); 
				echo validation_errors();
				?>
				<div class="wrap-input100 validate-input"> <?php echo form_input('email',$this -> input->post('email'),'class="input100", placeholder="Email" id="email" type="email"');?>
					<span class="focus-input100"></span>
					<label class="label-input100" for="name">
						<span class="glyphicon glyphicon-user"></span>
					</label>
				</div>

				<div class="wrap-input100 validate-input"> <?php echo form_password('password','','class="input100", placeholder="Palavra-passe" id="password" type="password"');?>
					<span class="focus-input100"></span>
					<label class="label-input100" for="name">
						<span class="glyphicon glyphicon-lock"></span>
					</label>
				</div>


				

				<div class="container-contact100-form-btn">
					<?php  
			            echo form_submit('login','Entrar', array('class' =>'contact100-form-btn'));
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
