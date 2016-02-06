<html>
	<head>
		<title>PyroSim</title>
		<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="/static/foundation/bower_components/foundation/css/foundation.min.css?<?php print time(); ?>" />
		<link rel="stylesheet" href="/static/foundation/stylesheets/app.css?<?php print time(); ?>" />
        <link rel="shortcut icon" href="static/images/favicon.ico" type="image/x-icon">
        <link rel="icon" href="static/images/favicon.ico" type="image/x-icon">
		<script src="/static/foundation/bower_components/foundation/js/vendor/modernizr.js?<?php print time(); ?>"></script>
		<script src="/static/foundation/bower_components/foundation/js/vendor/jquery.js"></script>
		<script src="/static/js/mustache.js?<?php print time(); ?>"></script>
		<script src="/static/js/api.js?<?php print time(); ?>"></script>
	</head>
	<body onload="loadApi">
		<div id="target">Loading...</div>
		<script id="template" type="x-tmpl-mustache">
			Hello {{name}}!
		</script>
			<div class="row">
				<div id="main" class="small-12 columns">
					<div class="row">
						<img src="/static/images/100px_PyroSim_Logo.png"/>
						<div class="small-12 columns">
							<h1>API Documentation</h1>
						</div>
					</div>
					<div class="row">
						<div id="docs" class="small-12 columns">

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

		<script src="/static/foundation/bower_components/foundation/js/vendor/fastclick.js"></script>

		<script src="/static/foundation/bower_components/foundation/js/foundation.min.js"></script>


		<script>
			$(document).foundation();
		</script>
	</body>
</html>
