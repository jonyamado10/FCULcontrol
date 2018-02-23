
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
</head>
<body>

	<div class="bg-container-contact100" style="background-image: url(<?php echo base_url("assets/images/bg-01.jpg"); ?>">
		<div class="contact100-header flex-sb-m">
			<a href="#" class="contact100-header-logo">
				<img src=<?php echo base_url("assets/images/icons/logo.png") ?> alt="LOGO">
			</a>

			<div>
				<button class="btn-show-contact100">
					Contact Us
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
				<span>Contact Us</span>
			</div>

			<form class="contact100-form validate-form">
				<div class="wrap-input100 validate-input">
					<input id="name" class="input100" type="text" name="name" placeholder="Full name">
					<span class="focus-input100"></span>
					<label class="label-input100" for="name">
						<span class="lnr lnr-user m-b-2"></span>
					</label>
				</div>


				<div class="wrap-input100 validate-input">
					<input id="email" class="input100" type="text" name="email" placeholder="Eg. example@email.com">
					<span class="focus-input100"></span>
					<label class="label-input100" for="email">
						<span class="lnr lnr-envelope m-b-5"></span>
					</label>
				</div>


				<div class="wrap-input100 validate-input">
					<input id="phone" class="input100" type="text" name="phone" placeholder="Eg. +1 800 000000">
					<span class="focus-input100"></span>
					<label class="label-input100" for="phone">
						<span class="lnr lnr-smartphone m-b-2"></span>
					</label>
				</div>


				<div class="wrap-input100 validate-input">
					<textarea id="message" class="input100" name="message" placeholder="Your comments..."></textarea>
					<span class="focus-input100"></span>
					<label class="label-input100 rs1" for="message">
						<span class="lnr lnr-bubble"></span>
					</label>
				</div>

				<div class="container-contact100-form-btn">
					<button class="contact100-form-btn">
						Send Now
					</button>
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
