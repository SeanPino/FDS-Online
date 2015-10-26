function loadApi() {
	var template = $('#template').html();
	$.mustache.parse(template);
	var rendered = $.mustache.render(template, {name: "Alex"});
	console.log(rendered);
	$('#target').html(rendered);
}
$(document).ready(function() {
	// $.getJSON("../apidoc/api_data.json", function (data) {
	// 	$.each(data, walker);
	// });

	// function walker(key, value) {
	// 	if(key == 'type') {
	// 		$("#docs").html('<ul><li>' + key + '<ul><li>' + value + '</li></ul></li></ul>');
	// 		console.log("Key:\t" + key);
	// 		console.log("Val:\t" + value);
	// 	}
	// 	if(value !== null && typeof value === "object") {
	// 		$.each(value, walker);
	// 	}
	// }
})