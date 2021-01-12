$(document).ready(function() {

    $("button[data-trigger]").click(function(e){

        e.preventDefault();

        var sTrigger    =   $(this).attr("data-trigger");
        

        if (sTrigger == "addshift") {
            var sDataForm   =   $(this).closest(".box-tools");
            var aText       =   $(sDataForm).find('input[type=text]');
            var sFrom       =   $(aText[0]).val();
            var sTo         =   $(aText[1]).val();

            var sText       =   sFrom + "-" + sTo;

            if (sFrom == "" || sTo == "") {
                _systemAlert('empty');
            } else {
                _conTinue(sTrigger, {'dropkey' : '', 'dropval' : sText, 'dropsub' : ''}, aText);  
            }

        } else if (sTrigger == "addbranch") {
            var aHeader     =   $(this).closest(".box-header");            
            var aText       =   $(aHeader).find('input[type=text]');

            var aClientId   =   $(aHeader).find('select');

            var sBranchName =   $(aText[0]).val();
            var sConPerson  =   $(aText[1]).val();
            var sConNumber  =   $(aText[2]).val();
            var sConEmail   =   $(aText[3]).val();

            var nCLientId   =   $(aClientId[0]).val();
            var nCityCode   =   $(aClientId[1]).val();

            if (sText == "" || nCLientId == "" || nCityCode == "") {
                _systemAlert('empty');
            } else {
                _conTinue(sTrigger, {'dropkey' : nCLientId, 'dropval' : sBranchName, 'dropsub' : nCityCode, 'conperson' : sConPerson, 'connumber' : sConNumber, 'conemail' : sConEmail}, aText);  
            }

        } else if (sTrigger == "addposi") {
            var aHeader     =   $(this).closest(".box-header");
            var aText       =   $(aHeader).find('input[type=text]');
            var aClientId   =   $(aHeader).find('select');
            var sText       =   $(aText).val();
            var nCLientId   =   $(aClientId).val();

            if (sText == "" || nCLientId == "") {

            _systemAlert('empty');
            } else {
                _conTinue(sTrigger, {'dropkey' : nCLientId, 'dropval' : sText, 'dropsub' : ''}, aText);  
            }
        } 

        else {
            var sDataForm   =   $(this).closest(".input-group");
            var aText       =   $(sDataForm).find('input[type=text]');
            var sText       =   $(aText).val();
            if (sText == "") {
                _systemAlert('empty');
            } else {
                _conTinue(sTrigger, {'dropkey' : '', 'dropval' : sText, 'dropsub' : ''}, aText);   
            }    
        }
    });

    $("a[data-trigger]").on('click', function(e) {
        e.preventDefault();
        
        var sTrigger    =   $(this).attr('data-trigger');
        var nId         =   $(this).attr('data-id');

        _conTinue(sTrigger, {'dropkey' : '', 'dropval' : nId, 'dropsub' : ''});
        
    });

    $("[data-key=ClientId]").on('change', function(e) {
        var sContainer  =   $(this).closest(".box");
        var sTextValue  =   $(this).children("option:selected").text().toLowerCase().trim();
        var sTable      =   $(sContainer).find(".table-data");

        var aTblDatas   =   $(sTable).find("tr");

        if (sTextValue != "") {
            for (var i = 0; i < aTblDatas.length; i++) {
                var sTrParent   =   $(aTblDatas[i]);
                var aTdValue    =   $(sTrParent).find("td");

                var sTdValue    =   $(aTdValue[1]).html().toLowerCase().trim();

                if (sTdValue == sTextValue) {
                    $(sTrParent).show();
                } else {
                    $(sTrParent).hide();
                }
            }

            $(sTable).removeClass("table-striped");
        } else {
            $(sTable).find("tr").show();
            $(sTable).addClass("table-striped");
        }
        
    });
});

function _conTinue(sAction, sData, aInput = "") {
    
    $.ajax({
        url      : "proc-dropdowns",
        type     : "POST",
        data     : {'data' : sData, 'action' : sAction},
        dataType : 'JSON',  
        beforeSend  : function()
        {
            
        },
        success  : function(data) 
        {
            console.log(data);
            if (data.return == "ok") {

                _systemMsg(data.message);

                if (aInput != '') {
                    $(aInput).val('');
                    $(aInput).focus();

                    $("select").val('');
                }
                _fetch();

            } else {
                _systemAlert('system');
            }
        },  
        error :function(xhr) {
            console.log(xhr);
            _systemAlert('system');
        }
    });
}

function _fetch() {
    $.ajax({
        url      : "proc-dropdowns",
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
                _conTinue(sTrigger, {'dropkey' : '', 'dropval' : nId, 'dropsub' : ''});
            });
        },  
        error :function(xhr) {
            console.log(xhr);
            _systemAlert('system');
        }
    });
}
