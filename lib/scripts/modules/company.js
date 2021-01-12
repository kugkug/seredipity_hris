
$(document).ready(function () {
   $('.table-data').DataTable(
      {
          'paging'      : true,
          'lengthChange': true,
          'searching'   : true,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false,
          "pageLength"  : 10
      });
    $(".numeric").autoNumeric('init');

    $("select[data-value]").each(function(){
        var sValue      =   $(this).attr('data-value');
        var sDataKey    =   $(this).attr('data-key');
        var sDataSub    =   $(this).attr('data-sub');

        $(this).val(sValue);

        if (sDataKey == "ClientPayrollPeriod") {
            _changePayroll(sValue, sDataSub);
        }
    });

    $("button").click(function (e)
    {
        e.preventDefault();

        var sTrigger    =   $(this).attr("data-trigger");
        var sDataForm   =   $(this).closest("form");
        var sFormId     =   $(sDataForm).attr('id');
        var sDataId     =   $('input[data-key=DataId]').val();
        
        if (sTrigger == "save") {

            if (_checkFormFields(sDataForm) == true) {

                if (sDataId != "")                 {
                    sAction     =   "update";
                } else {
                    sAction     =   "save";
                }

                _confirm(sAction, "Do you want to continue?", sFormId);
            }
            else {
                _systemAlert("empty");
                return false;
            }
        } else if (sTrigger == "clear") {

            // _clearFields(sFormId);
            location.reload();

        } else if (sTrigger == "add_dept") {
            
            var sClientDept =   $('#txtClientDept').val();
            if (sClientDept !== "") {
                var sDeptVal = `<li><span>` + sClientDept + `</span><a class="text-danger btn-remove pull-right"><i class="fa fa-times" title="Remove"></i></a> </li>`;

                $("ul.ulDept").append(sDeptVal);
                $(".btn-remove").click(function() 
                { 
                    $(this).closest("li").remove(); 
                });

                $('#txtClientDept').val('');
            }

        }
        else {
            window.location ='newclient';
        }

    });

    $("a[data-trigger]").on('click', function(e) {
        e.preventDefault();
        
        var sTrigger    =   $(this).attr('data-trigger');
        var nId         =   $(this).attr('data-id');
        var sTrParent   =   $(this).closest('tr');

        _execAction(sTrigger, nId, sTrParent);
    });


    $("#selRegion").on('change', function() {
        var sValue =    $(this).val();

        if (sValue != "") {
            $.ajax({
                url      : "proc-global",
                type     : "POST",
                data     : {'action' : 'dropcitymuniprov', 'data' : sValue},
                dataType : 'JSON',
                success   : function(data) {
                    
                    var vReturn  =   data.prov.return;
                    var vMessage =   data.prov.message;
                    
                    if (vReturn == "ok")
                    {
                        $("#selCityMuniProv").attr("disabled", false);
                        $("#selCityMuniProv").html(vMessage);

                        $("#selBrgy").attr("disabled", true);
                        $("#selBrgy").val('');
                    }
                    else
                    {
                        _systemAlert(vReturn, vMessage);
                    }
                },
                error : function(e) {
                    
                    _systemAlert("system");
                }   
            });
        } else {
            $("#selCityMuniProv").attr("disabled", true);
            $("#selCityMuniProv").val('');
            $("#selBrgy").attr("disabled", true);
            $("#selBrgy").val('');

        }
    });

    $("#selCityMuniProv").on('change', function() {
        var sValue =    $(this).val();

        if (sValue != "") {
            $.ajax({
                url      : "proc-global",
                type     : "POST",
                data     : {'action': 'dropbrgy', 'data' : sValue},
                dataType : 'JSON',
                success   : function(data) {

                    var vReturn  =   data.return;
                    var vMessage =   data.message;
                    
                    if (vReturn == "ok")
                    {
                        $("#selBrgy").attr("disabled", false);
                        $("#selBrgy").html(vMessage);
                    }
                    else
                    {
                        _systemAlert(vReturn, vMessage);
                    }
                },
                error : function(e) {
                    
                    _systemAlert("system");
                }   
            });
        } else {
            $("#selBrgy").attr("disabled", true);
        }
    });

    $("select[data-key=ClientPayrollPeriod]").on('change', function() {
        
        var sValue =    $(this).val();

        _changePayroll(sValue);
    });

});


function _conTinue(sAction, sFrmId, sObjData) {
    
    if (sAction != "delete") {
        var sJSonFields     =   _collectFields(sFrmId);
        var sJsonClients    =   _collectList("ulDept");

        $.ajax({
            url      : "proc-executor",
            type     : "POST",
            data     : {'data' : sJSonFields, 'action' : sAction, 'type' : 'newclient', 'deptlist' : sJsonClients},
            dataType : 'JSON',  
            beforeSend  : function()
            {
                
            },
            success  : function(data) 
            {
                if (data.return == "ok") {

                    _systemMsg(data.message);

                    if (data.message == "saved") {
                        _refresh();
                    } 

                } else {

                    _systemAlert('system');

                }
            },  
            error :function(xhr) {
                console.log(xhr.responseText);
                _systemAlert('system');
            }
        });
    } else {

         $.ajax({
            url      : "proc-executor",
            type     : "POST",
            data     : {'data' : sObjData.clientid, 'action' : sAction, 'type' : 'newclient'},
            dataType : 'JSON',  
            beforeSend  : function()
            {
                
            },
            success  : function(data) 
            {console.log(data);
                if (data.return == "ok") {
                    _systemMsg(data.message);

                    $(sObjData.trparent).fadeOut(500);
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
}

function _collectList(sParentId) {

    var sJsonFields =   [];
    $("#" + sParentId + " li span").each(function()
    {
        var sValue      =   $(this).html();

        sJsonFields.push(sValue);
        
    });

    return JSON.stringify(sJsonFields);
}

function _execAction(sAction, nId, sTrParent) {

    if (sAction == "delete") {
        _confirm(sAction, "Are you sure you want to DELETE this record ?", '', {'clientid': nId, 'trparent' : sTrParent});
    }  else {
        
        window.location = 'editclient?'  + nId;
    }
}

function _changePayroll(sValue, sDataSub) {

    var sHtmlPaySched   =   ``;
    var sHtmlCutOff     =   ``;
    switch(sValue) {
            case 'w':
                sHtmlPaySched   =   `
                                <label class="control-label">Payment Schedule:</label>
                                <select class="form-control input-sm" data-key="PaymentSched">
                                    <option value=""></option>
                                    <option value="mon">Monday</option>
                                    <option value="tue">Tuesday</option>
                                    <option value="wed">Wednesday</option>
                                    <option value="thu">Thursday</option>
                                    <option value="fri">Friday</option>
                                    <option value="sat">Saturday</option>
                                    <option value="sun">Sunday</option>
                                </select>
                            `;
                sHtmlCutOff   =   `
                                <label class="control-label">Payroll Cut Off:</label>
                                <select class="form-control input-sm" data-key="PayrollCutOff">
                                    <option value=""></option>
                                    <option value="mon">Monday</option>
                                    <option value="tue">Tuesday</option>
                                    <option value="wed">Wednesday</option>
                                    <option value="thu">Thursday</option>
                                    <option value="fri">Friday</option>
                                    <option value="sat">Saturday</option>
                                    <option value="sun">Sunday</option>
                                </select>
                            `;
            break;

            case 'sm': 
                sHtmlPaySched   =   `
                                <label class="control-label">Payment Schedule</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="number" min='0' max='31' class="form-control input-sm" placeholder="" data="req" maxlength="15" data-key="PaymentSchedFrom">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" min='0' max='31' class="form-control input-sm" placeholder="" data="req" maxlength="15" data-key="PaymentSchedTo">
                                    </div>
                                </div>
                            `;
                sHtmlCutOff   =   `
                                <label class="control-label">Payroll Cut Off</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="number" min='0' max='31' class="form-control input-sm" placeholder="" data="req" maxlength="15" data-key="PayrollCutOffFrom">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" min='0' max='31' class="form-control input-sm" placeholder="" data="req" maxlength="15" data-key="PayrollCutOffTo">
                                    </div>
                                </div>
                            `;
            break;

            case 'm':
                
                sHtmlPaySched   =   `
                                <label class="control-label">Payment Schedule</label>
                                <input type="number" class="form-control input-sm" min='0' max='31' placeholder="" data="req" maxlength="15" data-key="PaymentSched">
                                
                            `;
             sHtmlCutOff   =   `
                                <label class="control-label">Payroll Cut Off</label>
                                <input type="number" class="form-control input-sm" min='0' max='31' placeholder="" data="req" maxlength="15" data-key="PayrollCutOff">
                            `;
            break;
        }


        $("#divPaySched").html(sHtmlPaySched);
        $("#divCutOff").html(sHtmlCutOff);

        if (sDataSub) {
            var sObjData    =   JSON.parse(sDataSub);

            $.each(sObjData, function(key, value) {
                $('[data-key='+key+']').val(value);
            });

            $(".btn-remove").click(function() 
            { 
                $(this).closest("li").remove(); 
            });
        }
}