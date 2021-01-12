$(document).ready(function () {

	$("form").submit(function (e)
    {
        e.preventDefault();

        var $form   = $(this);
        var sFrmId  = $form.attr('id');

        var bFields = _checkFields(sFrmId);
        var sFields = _collectFields(sFrmId);
        if (bFields)
        {

            $.ajax({
               url      : "proc-accounts",
               type     : "POST",
               data     : {'action' : 'updatepass','data' : sFields},
            }).done(function(data) {
                console.log(data);
                eval(data);
            });
        }
        else
        {
            _errorMsg("empty");
        }
    });

});

