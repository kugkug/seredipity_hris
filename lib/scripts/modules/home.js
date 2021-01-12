$(document).ready(function () {

	$("button").on('click', function(e) 
	{
        e.preventDefault();
        
        $.ajax({
            url      : "proc-global",
            type     : "POST",
            data     : {'action' : 'save'},
            dataType : 'JSON',
            success   : function(data) {
                console.log(data);
            },
            error : function(e) {
            	console.log(e.responseText);
                _systemAlert("system");
            }
        });
    });
    // setInterval("_getTime()", 500);
});

function _getTime() {
    $.ajax({
        url      : "proc-home-timer",
        type     : "POST",
        success   : function(data) {
            var aData = JSON.parse(data);
            $("#spnDate").html(aData.date);
            $("#spnTime").html(aData.time);
        },
        error : function(e) {
            e.responseText;
            _systemAlert("system");
        }
    });
}