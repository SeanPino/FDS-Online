<html>
	<head>
		<title>FDS Online</title>
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="static/foundation/bower_components/foundation/css/foundation.min.css?<?php print time(); ?>" />
		<link rel="stylesheet" href="static/foundation/stylesheets/app.css?<?php print time(); ?>" />
		<script src="static/foundation/bower_components/foundation/js/vendor/modernizr.js?<?php print time(); ?>"></script>
        <link rel="shortcut icon" href="static/images/favicon.ico" type="image/x-icon">
        <link rel="icon" href="static/images/favicon.ico" type="image/x-icon">

		<style>
		#forgot-password-form input {
			max-width: 200px;
		    margin-left: auto;
		    margin-right: auto;
		}
		</style>
	</head>
	<body>
		<div class="row">
			<div id="main" class="small-12 columns">
				<div class="row">
					<div class="small-12 columns">
						<h1 class="header"><a href="/Pyro">FDS Online</a></h1>
					</div>
				</div>
				<div class="row">
					<div class="small-12 columns text-center">
						<h5>Long day?</h5>
					</div>
				</div>
				<div class="row">
					<div class="small-8 small-offset-2 columns">
						<div id="success_alert" style="display: none" data-alert class="alert-box primary">
							<label id="success_message"></label>
							<a href="#" class="close">&times;</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="small-12 columns text-center">
						<form id="forgot-password-form" action="<?php // TODO ?>" method="post">
							<fieldset>
								<legend>Enter your email and FDS Online will send you a link to reset your password</legend>
								<input type="text" id="email" name="email" placeholder="email" />
								<button id="forgot-password-submit" type="submit" class="tiny pyro-color">Send</button>
							</fieldset>
						</form>
						<div class="text-right">
							<p>Already have an account?&nbsp;<a href="<?php echo $baseUrl.'/login'; ?>">Sign in</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div id="footer" class="small-12 columns">
				<div class="row">
					<div class="small-12 columns">
						<p>Built with love by Alex Neises, Sean Pino, &amp; Shawn Contant.</p>
					</div>
				</div>
				<div class="row">
					<div class="small-12 columns">
						<p>Version <?php print $data['version']; ?></p>
					</div>
				</div>
				<div class="row">
					<div class="small-12 columns">
						<?php $status = $data['sprint']; ?>
						<p>Day <?php print $status['day']; ?> of Sprint <?php print $status['sprint']; ?></p>
					</div>
				</div>
			</div>
		</div>

		<script src="static/foundation/bower_components/foundation/js/vendor/jquery.js"></script>
		<script src="static/foundation/bower_components/foundation/js/vendor/fastclick.js"></script>

		<script src="static/foundation/bower_components/foundation/js/foundation.min.js"></script>

		<script>
			$(document).foundation();
		</script>

		<script src="static/js/core.js?<?php print time(); ?>"></script>
	</body>
</html>
