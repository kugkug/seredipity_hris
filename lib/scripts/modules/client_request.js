
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

    $("div.dataTables_wrapper div.dataTables_filter input").attr('placeholder', 'Client Name or Work Location');
    execFuncs();
    $("button").click(function (e)
	{
		e.preventDefault();

		var sTrigger    =	$(this).attr("data-trigger");
        var sDataForm   =   $(this).closest("form");
        var sFormId     =   $(sDataForm).attr('id');
        var sDataId     =   $('input[data-key=DataId]').val();

		if (sTrigger == "save") {
            
            var sFields     =   _checkFormFields(sDataForm);
            var sPositions  =   _checkTickBoxes($(".divPositions"));

            if (sFields == true) {

                if (sPositions == true) {

                    if ($('input[value=Reliever]').is(':checked') == true && $('[data-key=NatureDuration]').val() == "") {

                        _systemAlert("Please fill Job Duration");

                    } else {
                        if ($('input[value=license]').is(':checked') == true && $('[data-key=BasicLicenseCode]').val() == "") {

                            _systemAlert("Please select License Code");

                        } else {

                            if (sDataId != "") {
                                sAction     =   "update";
                            } else {
                                sAction     =   "save";
                            }
        
                            _confirm(sAction, "Do you want to continue?", sFormId);
                        }
                    }

                } else {

                    _systemAlert("Please select position/s");

                    return false;
                }                
            }
            else {
                _systemAlert("empty");
                return false;
            }
		} else if (sTrigger == "clear") {

            location.reload();

        }
        else {
            window.location ='newrequest';
        }

	});

    // $("a[data-trigger]").on('click', function(e) {
    //     e.preventDefault();
        
    //     var sTrigger    =   $(this).attr('data-trigger');
    //     var nId         =   $(this).attr('data-id');
    //     var sTrParent   =   $(this).closest('tr');

    //     _execAction(sTrigger, nId, sTrParent);
    // });


	$('[data-key=ClientId]').on('change', function() {

        var nClientId   =   $(this).val();
        
        if (nClientId != "") {
            $.ajax({
                url      : "proc-client-request",
                type     : "POST",
                data     : {'data' : nClientId, 'action' : 'clientdds'},
                beforeSend  : function()
                {
                    
                },
                success  : function(data)
                {
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

            $("[data-key=PositionId]").attr('disabled', true);
            $("[data-key=PositionId]").val('');               
        }
    });

    

});


function _conTinue(sAction, sFrmId, sObjData) {


    if (sAction != "delete" && sAction != "close") {
        

        var sJSonFields     =   _collectFields(sFrmId);
        var sPositions      =   _collectTickBoxes($(".divPositions"));
        var sReqNature      =   _collectTickBoxes($(".divNature"));
        var sReqQualify     =   _collectTickBoxes($(".divQualifications"));

        $.ajax({
            url      : "proc-client-request",
            type     : "POST",
            data     : {'action' : sAction, 'type' : 'newreques', 'data' : sJSonFields, 'positions' : sPositions, 'reqnature' : sReqNature, 'reqqualify' : sReqQualify},
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
                console.log(xhr.responseText);
                _systemAlert('system');
            }
        });
    } else {

        var nTrxtId =   sObjData.requestid;
        var sParent =   $('a[data-id='+nTrxtId+']').closest('tr');
         $.ajax({
            url      : "proc-client-request",
            type     : "POST",
            data     : {'data' : sObjData.requestid, 'action' : sAction, 'type' : 'newreques'},
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
        _confirm(sAction, "Are you sure you want to CANCEL this request?", '', {'requestid': nId, 'trparent' : sTrParent});
    } else if (sAction == "close") {

        _confirm(sAction, "Are you sure you want to close this request?", '', {'requestid': nId, 'trparent' : sTrParent});

    } else if (sAction == "process") {

        window.location = 'procclient?'  + nId;

    } else {
        
        window.location = 'editrequest?'  + nId;
    }
}

function execFuncs() {
    $("input[type=checkbox]").click(function() {

        var bChecked    =   $(this).is(':checked');
        var sText       =   $(this).closest("label").text().trim();
        var sValue      =   $(this).val();
        
        if (sText == "Reliever / Seasonal") {
            if (bChecked == true) {
                $("[data-key=NatureDuration]").show();
            } else {
                $("[data-key=NatureDuration]").hide();
            }
        } else if (sText == "With Driver's License") {
            if (bChecked == true) {
                $("[data-key=BasicLicenseCode]").show();
            } else {
                $("[data-key=BasicLicenseCode]").hide();
            }
        }

    });

    $('[data-key=BranchId]').on('change', function() {

        var nBranchId   =   $(this).val();
        
        if (nBranchId != "") {
            $.ajax({
                url      : "proc-client-request",
                type     : "POST",
                data     : {'data' : nBranchId, 'action' : 'clientrep'},
                beforeSend  : function()
                {
                    
                },
                success  : function(data)
                {console.log(data);
                    eval(data);
                },  
                error :function(xhr) {
                    console.log(xhr.responseText);
                    _systemAlert('system');             
                }
            });
        } else {
            $(['data-key=ReqContactPerson']).val('');
            $(['data-key=ReqContactNumber']).val('');
            $(['data-key=ReqContactEmail']).val('');                
        }
    });
}