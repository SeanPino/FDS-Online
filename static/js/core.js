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
					console.log(data);
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