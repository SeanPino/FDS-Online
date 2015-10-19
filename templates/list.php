<html>
	<head>
		<title>PyroSim</title>
		<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="../static/foundation/bower_components/foundation/css/foundation.min.css?<?php print time(); ?>" />
		<link rel="stylesheet" href="../static/foundation/stylesheets/app.css?<?php print time(); ?>" />
		<script src="../static/foundation/bower_components/foundation/js/vendor/modernizr.js?<?php print time(); ?>"></script>
	</head>
	<body>
		<div class="row">
			<div id="main" class="small-12 columns">
				<div class="row">
					<img src="../static/images/100px_PyroSim_Logo.png"/>
					<div class="small-12 columns">
						<h1>Online Simulator</h1>
					</div>
				</div>
				<div class="row">
					<div class="small-12 columns">
						<p>The current simulations in storage.</p>
					</div>
				</div>
				<div class="row">
					<input type="button" id="refresh" value="Refresh List" />
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
					<div id="results">
					Now Loading Results.
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
		<script src="../static/foundation/bower_components/foundation/js/vendor/jquery.js"></script>
		<script src="../static/foundation/bower_components/foundation/js/vendor/fastclick.js"></script>
		<script src="../static/foundation/bower_components/foundation/js/foundation.min.js"></script>

		<script>
			$(document).foundation();
			$(document).ready(function(){
				getList();
			});
			$("#refresh").click(function(){
				getList();
			});
			function getList(){
				$.ajax({
					//url: 'api/v1/jobs',
					url: 'http://localhost/pyro/api/v1/list/',
					type: 'GET',
					//data: data,
					cache: false,
					//dataType: 'json',
					processData: false,
					contentType: false,
					success: function (object) {
                                            if(!object){
                                                output = "No jobs in storage.";
                                            }else{
                                                result = jQuery.parseJSON(object);
                                                output = "<table class='sim-list'><tr><th>ID</th><th>Name</th><th>Status</th><th>Percent Complete</th></tr>";
                                                for(x=0; x<result.length; x++){
                                                    switch(parseInt(result[x]["status_id"])){
                                                        case 1:
                                                            status = "In Queue";
                                                            break;
                                                        case 2:
                                                            status = "Processing";
                                                            break;
                                                        case 3:
                                                            status = "Completed";
                                                            break;
                                                        default:
                                                            status = "Error";
                                                    }
                                                    percent = "Not started";
                                                    output += ("<tr><td>" + result[x]["id"] + "</td><td>" + result[x]["name"] + "</td><td>" + status + "</td><td>" + percent + "</td></tr>");
                                                }
                                                output += "</table>";
                                            }
                                            $("#results").html(output);
					},
					error: function (object, status, error) {
                                                console.log("The response text: " + object.responseText);
						console.log("There was an error: " + error);
					}
				});
			}
		
		</script>

		<script src="../static/js/core.js?<?php print time(); ?>"></script>
	</body>
</html>