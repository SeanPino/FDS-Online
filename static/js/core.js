// var BASE_URL = 'http://pyro.demo/';
var REFRESH_INT = 5000; //5 second refresh rate, change to 60000
$("#loading-image").show();
function getList(){
	$.ajax({
		//url: 'api/v1/jobs',
		url: 'api/v1/list/',
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
				output = "<table width='100%' class='sim-list'><tr><th class='center'>ID</th><th class='center'>Name</th><th class='center'>Status</th><th class='center'>Percent Complete</th></tr>";
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
					percent = parseFloat(result[x]["progress"]) + '%';
					if(parseFloat(result[x]["progress"]) == 100)
					{
						output += ("<tr><td class='center'>" + result[x]["id"] + "</td><td class='center'>" + result[x]["name"] + "</td><td class='center'>" + status + "</td><td class='center'><div class='progress small-12 alert'><span class='meter' style='width: " + percent + "'>" + percent + "</span></div><form action='/api/v1/download/" + result[x]["id"] + "' method='get'><input type='submit' class='button tiny' value='Download' /></form></td></tr>");
					}
					else
					{
						output += ("<tr><td class='center'>" + result[x]["id"] + "</td><td class='center'>" + result[x]["name"] + "</td><td class='center'>" + status + "</td><td class='center'><div class='progress small-12 primary'><span class='meter' style='width: " + percent + "'>" + percent + "</span></div></td></tr>");
					}
				}
				output += "</table>";
			}
			$("#results").html(output);
		},
		error: function (object, status, error) {
			console.log("The response text: " + object.responseText);
			console.log("There was an error: " + error);
			$("#results").html("<p>No jobs in storage.</p>");
		},
		complete: function () {
			$("#loading-image").hide();
		}
	});
}

$(document).ready(function () {

	if($('#list_page').length > 0) {
		getList();
		window.setInterval(function(){
			getList();
		}, REFRESH_INT);
	}

	var files;

	$('form').on('submit', uploadFiles);

	function uploadFiles(event) {
		files = $('#file').prop('files')[0];
		event.stopPropagation();
		event.preventDefault();

		// Loading spinner

		var data = new FormData();
		data.append('file', files);

		$.ajax({
			url: '/api/v1/jobs',
			type: 'POST',
			data: data,
			cache: false,
			dataType: 'json',
			processData: false,
			contentType: false,
			success: function (data, status, object) {
				if(object.status === 200) {
					$('#success_alert').show();
					$('#success_message').text('Your file, ' + data.filename + ', has been uploaded!');
					var control = $('#file');
					control.replaceWith(control = control.clone(true));
				}
				// Hide loading spinner
			},
			error: function (object, status, error) {
				console.log("ERROR");
				console.log(status);
				console.log(error);
				// Hide loading spinner
			}
		})
	}
})