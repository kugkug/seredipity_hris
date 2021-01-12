$(document).ready(function() {
    $("button[data-trigger]").click(function(e){

		e.preventDefault();

        var sTrigger    =   $(this).attr("data-trigger");
        var sParent     =   $(this).attr('data-form');
        var sDataId     =   $('input[data-key=DataId]').val();
        

        if (sTrigger == "newsup") {
            $("#modalNewSup").modal("show");
            _clearFields(sParent);
        } else if (sTrigger == "save") {

            if (_checkFields(sParent) == true) {

                var sObjData    =   _collectFields(sParent);
                
                if (sDataId != "")                 {
                    sAction     =   "update";
                } else {
                    sAction     =   "save";
                }
                _confirm(sAction, "Do you want to continue?", sParent, sObjData);

            } else {
                _systemAlert('empty');
            }
            
        } else {
            location.reload(true);
        }
	});

    $('[data-key=ClientId]').on('change', function() {
        var nClientId   =   $(this).val();

        _getClientDds(nClientId);
        
    });

    $("a[data-trigger]").on('click', function(e) {
        e.preventDefault();
        
        var sTrigger    =   $(this).attr('data-trigger');
        var nId         =   $(this).attr('data-id');

        _execAction(sTrigger, nId);
    });
});


function _conTinue(sAction, sFrmId, sData) {
    
    $.ajax({
        url      : "proc-supervisors",
        type     : "POST",
        data     : {'data' : sData, 'type': sFrmId, 'action' : sAction},
        dataType : 'JSON',  
        beforeSend  : function()
        {
            
        },
        success  : function(data) 
        {
            if (data.return == "ok") {

                _systemMsg(data.message);
                _fetch();

                if (data.message != "saved") {
                    $("#modalNewSup").modal("hide");   
                } else {
                    _clearFields(sFrmId);
                }

            } else if (data.return == "edit") {
                console.log(data.message);
                $(data.message).each(function(id, sScript) {

                    eval(sScript);
                });


                $("#modalNewSup").modal("show");
            } else {

                _systemAlert('system');
            }
        },  
        error :function(xhr) {
            console.log(xhr.responseText);
            _systemAlert('system');             
        }
    });
}

function _fetch() {
    $.ajax({
        url      : "proc-supervisors",
        type     : "POST",
        data     : {'action' : 'fetch'},
        
        beforeSend  : function()
        {
            
        },
        success  : function(response) 
        {
            eval(response);
            $("a[data-trigger]").on('click', function(e) {
                e.preventDefault();
                
                var sTrigger    =   $(this).attr('data-trigger');
                var nId         =   $(this).attr('data-id');
                _execAction(sTrigger, nId);
            });
        },  
        error :function(xhr) {
            console.log(xhr);
            _systemAlert('system');
        }
    });
}


function _getClientDds(nClientId)
{
    if (nClientId != "") {
        $.ajax({
            url      : "proc-supervisors",
            type     : "POST",
            data     : {'data' : nClientId, 'action' : 'clientdds'},
            beforeSend  : function()
            {
                
            },
            success  : function(data) 
            {
                console.log(data);
                eval(data);
            },  
            error :function(xhr) {
                console.log(xhr.responseText);
                _systemAlert('system');             
            }
        });
    } else {
        $('[data-key=BranchId]').attr('disabled', true);
        $('[data-key=DeptId]').attr('disabled', true);
    }
}

function _execAction(sAction, nId) {

    if (sAction == "delete") {
        _confirm(sAction, "Are you sure you want to DELETE this record ?", '', {'supid': nId});
    }  else {

        _conTinue(sAction, '', {'supid': nId});
    }
}