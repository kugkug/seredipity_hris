
$(document).ready(function () {

    _getCandidates();

    $("[data-trigger]").on('click', function() {

        var sAction         =   $(this).attr('data-trigger');

        if (sAction != "texts") {

            var sCollectTrxId   =   _collectTrxId();

            if (sCollectTrxId !== false) {

                 $.ajax({
                    url      : "proc-client-request",
                    type     : "POST",
                    data     : {'action' : sAction, 'data' : sCollectTrxId, 'requestid' : $('[data-key=DataId]').val()},
                    beforeSend  : function()
                    {
                        _screenLoader('on');
                    },
                    success  : function(data) 
                    { 
                        _screenLoader('off');  
                        console.log(data);
                        eval(data);
                        
                    },  
                    error :function(xhr) {
                        _screenLoader('off');  
                        console.log(xhr.responseText);
                        _systemAlert('system');
                    }
                });
                
            } else{
                _systemAlert('No Candidates Chosen.');
            }
            
        } else {
            $("#modalMessage").modal('show');
        }

    });

    $("[data-form=modalMessage]").on('click', function(e) {
        e.preventDefault();
        var sCollectCelNo   =   _collectCpNo();
        var sMessage        =   $("textarea").val().trim();

        if (sMessage == "") {
            _systemAlert('Please fill in the message box.');
        } else {
            $.ajax({
                url      : "proc-client-request",
                type     : "POST",
                data     : {'action' : 'sendsms', 'data' : sCollectCelNo, 'message' : sMessage, 'requestid' : $('[data-key=DataId]').val()},
                beforeSend  : function()
                {
                    _screenLoader('on');
                },
                success  : function(data) 
                { 
                    _screenLoader('off');  
                    console.log(data);
                    eval(data);
                    
                },  
                error :function(xhr) {
                    _screenLoader('off');  
                    console.log(xhr.responseText);
                    _systemAlert('system');
                }
            });    
        }
        
    });
});

function _getCandidates(){
    
    $.ajax({
        url      : "proc-client-request",
        type     : "POST",
        data     : {'action' : 'getcandids', 'requestid' : $('[data-key=DataId]').val()},
        beforeSend  : function()
        {
            _screenLoader('on');
        },
        success  : function(data) 
        {             
            _screenLoader('off');  
            eval(data);
            
        },  
        error :function(xhr) {
            _screenLoader('off');  
            console.log(xhr.responseText);
            _systemAlert('system');
        }
    });
}

function _execFuncs() {

    $('.btn-remove').click(function(e) {
        e.stopPropagation();
        e.stopImmediatePropagation();
        var sClone  =   $(this).closest('tr').clone();
        $(this).closest('tr').remove();
        _execAction('remove', sClone); 

    });

    $('.btn-add').click(function(e) {    
        e.stopPropagation();
        e.stopImmediatePropagation();
        var sClone  =   $(this).closest('tr').clone();
        $(this).closest('tr').remove();
        _execAction('add', sClone); 
    });
    
}

function _execAction(sAction, sClone) {
    switch(sAction) {
        case 'remove':
            var aTd     =   $(sClone).find("td");
            $(aTd[aTd.length - 1]).html("<a class='btn-add text-red' href='javascript:void(0);' title='Add'><i class='fa fa-plus'></i></a>");
            $(".divApplicants table").append(sClone);
        break;

        case 'add':
            var aTd     =   $(sClone).find("td");
            $(aTd[aTd.length - 1]).html("<a class='btn-remove text-red' href='javascript:void(0);' title='Remove'><i class='fa fa-remove'></i></a>");
            $(".divCandidates table").append(sClone);       
        break;
    }

    _execFuncs();
}

function _collectTrxId() {
    var nCntr   = 0;
    var aTrxId  = [];
    $(".divCandidates table tr").each(function() {
        var sTrxId  =   $(this).attr("data-trxid");

        if (nCntr > 0) {
            aTrxId.push(sTrxId);
        }
        nCntr++;
    });
    if (nCntr > 1) {
        return JSON.stringify(aTrxId);
    } else {
        return false;
    }
}

function _collectCpNo() {
    var nCntr   = 0;
    var aTrxId  = [];
    $(".divCandidates table tr").each(function() {
        var sTrxId  =   $(this).attr("data-celno");

        if (nCntr > 0) {
            aTrxId.push(sTrxId);
        }
        nCntr++;
    });
    if (nCntr > 1) {
        return JSON.stringify(aTrxId);
    } else {
        return false;
    }
}