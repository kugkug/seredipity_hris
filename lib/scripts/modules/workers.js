$(document).ready(function () {
    $('.table-data').DataTable(
      {
          'paging'      : true,
          'lengthChange': true,
          'searching'   : true,
          'ordering'    : false,
          'info'        : true,
          'autoWidth'   : false,
          "pageLength"  : 10
      });
	$("a[data-trigger]").on('click', function(e) {
        e.preventDefault();
        
        var sTrigger    =   $(this).attr('data-trigger');
        var nId         =   $(this).attr('data-id');
        var sTrParent   =   $(this).closest('tr');

        _execAction(sTrigger, nId, sTrParent);
    });

});

function _execAction(sAction, nId, sTrParent) {

    if (sAction == "endo") {
        _confirm(sAction, "Are you sure you want to END EMPLOYEE's CONTRACT?", sTrParent, {'AgentTrxId': nId, 'AgentStatus' : sAction});
    }  else if (sAction == "view") {  
        
        window.location = 'workerinfo?'  + nId;
    }
}

function _conTinue(sAction, sFrmId, sObjData) {

    $.ajax({
        url      : "proc-workers",
        type     : "POST",
        data     : {'data' : sObjData, 'action' : sAction},
        dataType : 'JSON',  
        beforeSend  : function()
        {
            
        },
        success  : function(data) 
        {
        	var aTds =	$($(sFrmId)[0]).find("td");
        	$(aTds[aTds.length - 2]).removeClass('text-green').addClass('text-red').html(sAction).css('textTransform', 'capitalize');
        
        	console.log(data);
            // if (data.return == "ok") {

            //     _systemMsg(data.message);

            //     if (data.message == "saved") {
            //         _clearFields(sFrmId);
            //         $("#ulDept").html('');
            //     } 

            // } else {

            //     _systemAlert('system');

            // }
        },  
        error :function(xhr) {
            console.log(xhr.responseText);
            _systemAlert('system');
        }
    });
}