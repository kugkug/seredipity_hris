$(document).ready(function () {

    

    var sTabledata =    $('.table-data').DataTable(
    {
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false,
      "pageLength"  : 10
    });


    _funcs(sTabledata);

    $("div.dataTables_wrapper div.dataTables_filter input").attr('placeholder', 'Fullname, Work Location or Positions');

    $("[data-key=ClientId]").on('change', function() {

        var aTextVal    =   $(this).find("option");

        for (var n = 0; n < aTextVal.length; n++ )
        {
            if ($(aTextVal[n]).is(":selected")){
                var sTextVal = $(aTextVal[n]).text();
                $("div.dataTables_wrapper div.dataTables_filter input").val(sTextVal);
                // $("div.dataTables_wrapper div.dataTables_filter input").focus();
                sTabledata.columns( 5 ).search( sTextVal ).draw();
            }
        }        
    });


    $("[data-key=AppstatId]").on('change', function() {

        var aTextVal    =   $(this).find("option");

        for (var n = 0; n < aTextVal.length; n++ )
        {
            if ($(aTextVal[n]).is(":selected")){
                var sTextVal = $(aTextVal[n]).text();
                $("div.dataTables_wrapper div.dataTables_filter input").val(sTextVal);
                // $("div.dataTables_wrapper div.dataTables_filter input").focus();
                sTabledata.columns( 7 ).search( sTextVal ).draw();
            }
        }        
    });

    

    $("button[data-trigger]").on('click', function(e) {
        e.preventDefault();
        var sAction         =   $(this).attr('data-trigger');

        if (sAction != "texts") {

            var sCelNos   =   _collectCelNo(sTabledata);

            if ($('textarea').val() !== "") {

                 $.ajax({
                    url      : "proc-general-information",
                    type     : "POST",
                    data     : {'action' : sAction, 'data' : sCelNos, 'message' : $('textarea').val()},
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
                _systemAlert('Empty message not allowed!');
            }
            
        } else {
            $("#modalMessage").modal('show');
        }

    });
    // _screenLoader('off');   
});

function _execAction(sAction, nId) {

    if (sAction == "remove") {
        _confirm(sAction, "Are you sure you want to REMOVE this application, Please be advised that this action cannot be undone?", {'AgentTrxId': nId, 'AgentStatus' : sAction});
    }  else if (sAction == "view") {
         _conTinue(sAction, {'AgentTrxId': nId});
    }  else if (sAction == "process") {  
        window.location = 'applicantinfo?'  + nId;
    }
}

function _conTinue(sAction, sObjData) {

    var nTrxtId =   sObjData.AgentTrxId;
    var sParent =   $('a[data-id='+nTrxtId+']').closest('tr');
    
    $.ajax({
        url      : "proc-applicants",
        type     : "POST",
        data     : {'data' : sObjData, 'action' : sAction},
        beforeSend  : function()
        {
            _screenLoader('on');   
        },
        success  : function(data) 
        {
            console.log(data);
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

function _collectCelNo(sTabledata) {
    var nCntr       =   0;
    var aCelNo      =   {};
    var sTrxId      =   "";

    sTabledata.$('input:checked').each(function () {
        if (!$(this).attr('trigger')) {
            sTrxId =    $(this).closest('tr').attr('data-id');
            aCelNo[sTrxId] = $(this).val();
        }
    });
    
    return JSON.stringify(aCelNo);
    
}

function _funcs(sTabledata) {

    $("input[trigger]").on('click', function(e) {
        var bChecked        =   $(this).is(':checked');
        if (bChecked) 
        {
            sTabledata.$('input[type=checkbox]').each(function () {
                if (!$(this).attr("disabled")) {
                    $(this).prop('checked', true); 
                }
            });
            $("[data-trigger=texts]").removeClass('disabled');
            
        } else {
            sTabledata.$('input[type=checkbox]').each(function () {$(this).prop('checked', false); });
            $("[data-trigger=texts]").addClass('disabled');
        }
    });
    sTabledata.$('input[type=checkbox]').each(function() {

        $(this).on('click', function() {
            var aCheckBox = sTabledata.$('input[type=checkbox]');
            var nChecked = 0;  

            if ($(this).attr('trigger')) {

                var bChecked        =   $(this).is(':checked');
                if (bChecked) 
                {
                    sTabledata.$('input[type=checkbox]').each(function () {

                            $(this).prop('checked', true); 
                        
                    });
                    $("[data-trigger=texts]").removeClass('disabled');
                    
                } else {
                    sTabledata.$('input[type=checkbox]').each(function () {$(this).prop('checked', false); });
                    $("[data-trigger=texts]").addClass('disabled');
                }
            } 
            else {
                sTabledata.$('input[type=checkbox]').each(function () {
                    if ($(this).is(':checked'))
                    {
                        nChecked++;
                    }
                });
                // console.log(nChecked);
                if (nChecked == (aCheckBox.length)) {
                    $("[trigger=all]").prop('checked', true);
                } else {

                    $("[trigger=all]").prop('checked', false);
                }

                if (nChecked == 0) {
                    $("[data-trigger=texts]").addClass('disabled');
                } else {
                    $("[data-trigger=texts]").removeClass('disabled');
                }
            }      
        });
    });
}