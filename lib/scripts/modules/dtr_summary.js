$(document).ready(function() {

	$("[data-trigger]").click(function(e){
		var sLink 	=	$(this).attr('data-src');

		var aLinks	=	sLink.split("|");

		$("#divTimeIn").html(`<img src ='`+aLinks[0]+`' style='max-width: 200px; max-height: 200px;'>`);

		if (aLinks[1] != '') {
			$("#divTimeOut").html(`<img src ='`+aLinks[1]+`' style='max-width: 200px; max-height: 200px;'>`);			
		} else {
			$("#divTimeOut").html('');			
		}

		$("#modalLogPhotos").modal('show');
	});
});
