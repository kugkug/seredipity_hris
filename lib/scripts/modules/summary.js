$(document).ready(function () {

	$("#btn-print").click(function(e)
	{
		e.preventDefault();

		
		$.ajax({
           	url      : "proc-summary-report",
           	type     : "POST",
        	success  : function(data) {
        		console.log(data);
        		window.open(data);
            },
            error 	 : function (ret) {
            	console.log(ret.responseText);
            	_systemAlert('system');
            }
        });
	})
});