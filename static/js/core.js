$(document).ready(function () {
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