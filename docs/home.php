<html>
	<head>
		<title>FDS Online</title>
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="static/foundation/bower_components/foundation/css/foundation.min.css?<?php print time(); ?>" />
		<link rel="stylesheet" href="static/foundation/stylesheets/app.css?<?php print time(); ?>" />
		<script src="static/foundation/bower_components/foundation/js/vendor/modernizr.js?<?php print time(); ?>"></script>
        <link rel="shortcut icon" href="static/images/favicon.ico" type="image/x-icon">
        <link rel="icon" href="static/images/favicon.ico" type="image/x-icon">
	</head>
	<body>
		<div class="row">
			<div id="main" class="small-12 columns">
				<div class="row">
					<div class="small-12 columns">
						<h1 class="header"><a href="/">FDS Online</a></h1>
						<h1>Online Simulator</h1>
					</div>
				</div>
				<div class="row">
					<div class="small-12 columns">
						<p>Select a file to upload.  The server will run a simulation and you will be updated with its status.</p>
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
					<div class="small-12 columns">
						<form action="/pyro/api/v1/jobs" method="post" enctype="application/octet-stream">
							<fieldset>
								<legend>FDS Upload</legend>
								<input id="file" type="file" accept=".fds" name="file" />
								<button id="upload_file" type="submit" class="tiny pyro-color">Upload</button>
							</fieldset>
						</form>
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
