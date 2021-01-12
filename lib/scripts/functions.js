function _confirm(sAction, sContent, sFrmId, sObjData)
{
    $.confirm({
        title: 'System Confirmation',
        content: sContent,
        icon: 'fa fa-question-circle',
        type: 'orange',
        animation: 'scale',
        closeAnimation: 'scale',
        opacity: 0.5,
        buttons: {
            'confirm': {
                text: 'Yes',
                btnClass: 'btn-red',
                action: function(){
                    _conTinue(sAction, sFrmId, sObjData);
                }
            },
            moreButtons: {
                text: 'No',
                btnClass: 'btn-blue',
                action: function(){
                    
                }
            },
        }
    });
}

function _conBox(sFunc, sParam, sContent)
{
    $.confirm({
        title: 'Confirmation',
        content: sContent,
        icon: 'fa fa-question-circle',
        type: 'red',
        animation: 'scale',
        closeAnimation: 'scale',
        opacity: 0.5,
        buttons: {
            'confirm': {
                text: 'Yes',
                btnClass: 'btn-red',
                action: function(){
                    eval (sFunc + "('"+sParam+"')");
                }
            },
            moreButtons: {
                text: 'No',
                btnClass: 'btn-blue',
                action: function(){
                    
                }
            },
        }
    });
}

function _alertBox(sContent)
{
    $.confirm({
        title: 'System Message',
        content: sContent,
        icon: 'fa fa-question-circle',
        type: 'green',
        animation: 'scale',
        closeAnimation: 'scale',
        opacity: 0.5,
        buttons: {
            'confirm': {
                text: 'Ok',
                btnClass: 'btn-red',
                action: function(){
                    _refresh();
                }
            },
        }
    });
}

function _warningBox(sContent)
{
    $.confirm({
        title: 'System Warning',
        content: sContent,
        icon: 'fa fa-question-info',
        type: 'yellow',
        animation: 'scale',
        closeAnimation: 'scale',
        opacity: 0.5,
        buttons: {
            'confirm': {
                text: 'Ok',
                btnClass: 'btn-yellow',
                action: function(){
                    
                }
            },
        }
    });
}

function _infoBox(sContent)
{
    $.confirm({
        title: 'System Message',
        content: sContent,
        icon: 'fa fa-question-info',
        type: 'green',
        animation: 'scale',
        closeAnimation: 'scale',
        opacity: 0.5,
        buttons: {
            'confirm': {
                text: 'Ok',
                btnClass: 'btn-blue',
                action: function(){
                    
                }
            },
        }
    });
}

function _infoBox2(sContent, sFunc)
{
    $.confirm({
        title: 'System Message',
        content: sContent,
        icon: 'fa fa-question-info',
        type: 'green',
        animation: 'scale',
        closeAnimation: 'scale',
        opacity: 0.5,
        buttons: {
            'confirm': {
                text: 'Ok',
                btnClass: 'btn-blue',
                action: function(){
                    eval (sFunc);
                }
            },
        }
    });
}

function _getChecked(sParentId, sExcludedValue) 
{
    var aResult =   [];
    var nCount  =   0;

    $("#" + sParentId+ " :checkbox").each(function() 
    {
        var sChkId  =   $(this).attr("id");
        var sValue  =   $(this).attr("value");
        var sClass  =   $(this).attr("class");

        if (sValue != sExcludedValue) {
            
            if ($("#" + sChkId).is(":checked")) {
                nCount++;
                aResult.push(sValue);
            }
        }
    });

    return {'count' : nCount, result : aResult.join(',')}
}

function _getFilled(sParentId) 
{
    var aResult =   [];
    var nCount  =   0;

    $("#" + sParentId+ " input").each(function() 
    {
        var sTextId     =   $(this).attr("id");
        var sTextValue  =   $("#" + sTextId).val();

        if (sTextValue != "") {
            nCount++;
            aResult.push(sTextId + "|" +sTextValue);
        }
    });

    return {'count' : nCount, result : aResult.join(',')}
}

function _screenLoader(type) {
    if (type == "on") {
        $('body').append(`<div id="divLoader" style="width: 99%; height: 100%; background: rgba(255,255,255, 0.5); position: absolute; top: -10px; left: 10px; z-index:9999999999;">
                            <img src="images/loader/loader.gif" style="width: 15px; top: 50%; left: 50%; position : relative;">
                        </div>`);
    } else {
        $("#divLoader").remove();
    }
}

function _leave()
{
    console.log("leave");
}

