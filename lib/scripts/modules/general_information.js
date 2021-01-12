$(document).ready(function () {

    /* TAB ON CLICK CHANGE */
    $(".nav-tabs > li > a").click(function (e) {
    
        var sTarget = $(this).attr("aria-controls");

        if (sTarget == "divPerInfo") {
            $("button[data-div]").fadeOut();
        } else {
            $("button[data-div]").fadeIn();
        }
        $("button[data-div]").attr("data-div", sTarget);
        $("button[data-form]").attr("data-form", sTarget);
    });

    $(".btn-remove").click(function () {
            
        $(this).closest("div.divOrig").remove();
    });


    $("input[data-key=DateOfBirth]").on('change', function() {
        var nAge =  compAge(new Date($(this).val()));
        $("input[data-key=Age]").val(nAge);
    });

    $("[data-key=BranchId], [data-key=DeptId]").on('change', function(){

        var nClientId   =   $("[data-key=ClientId]").val();    
        var nBranchId   =   $("[data-key=BranchId]").val();
        var nDeptId     =   $("[data-key=DeptId]").val();
        
        if (nClientId != "" && nBranchId != "" && nDeptId != "") {
            _getBranchSup(nClientId, nBranchId, nDeptId);    
        } else {
            $("[data-key=SupId]").attr('disabled', true);
            $("[data-key=SupId]").val('');
        }        
    });

    /* BUTTON ON CLICK*/
    $("button[data-trigger]").on('click', function(e) {
        e.preventDefault();

        var sBtnId      =   $(this).attr("id");
        var sTrigger    =   $(this).attr("data-trigger");
        var sDataForm   =   $(this).attr("data-form");

        if (sTrigger == "save")
        {
            if (sDataForm =="divPerInfo")
            {
                if (_checkFields(sDataForm) == true) {

                    var sObjData    =   _collectFields(sDataForm);
                        sObjData['AgentTrxId'] = $("#spnAppTrxId").html();
                    
                    _confirm(sTrigger, "Do you want to continue?", sDataForm, sObjData);
                }  
                else 
                {
                    _systemAlert("empty");
                    return false;
                }
            
            } else {
                if (_checkFields(sDataForm) == true) 
                {
                    var sObjData    =   _collectFieldsBatch(sDataForm);
                    // _confirm(sTrigger, "Do you want to continue?", sDataForm, sObjData);
                    _conTinue(sTrigger, sDataForm, sObjData);                   
                }
                else 
                {
                    _systemAlert("empty");
                        return false;
                }
            }
            
        }
        else if (sTrigger == "cancel")
        {
            _confirm(sTrigger, "You may have an unsaved changes, do you want to continue?", sDataForm, sObjData);
        } 
        else if (sTrigger == "text") 
        {
            $("#modalMessage").modal("show");
        } 
        else if (sTrigger == "deploy") 
        {
            $(".divDeploy").fadeIn();
        } 
        else if (sTrigger == "remove") {

            _confirm(sTrigger, "Are you sure you want to REMOVE this application? Please be advised that this action cannot be undone.", sDataForm,{'AgentTrxId': $("#spnAppTrxId").html(), 'AgentStatus' : sTrigger});
        }
        else if (sTrigger == "sendsms") 
        {
            var sCelNo   =   {};
            sCelNo[$("#spnAppTrxId").html()] = $("[data-key=EmpCellNo]").val();


            if ($('#txtMessage').val() !== "") {

                 $.ajax({
                    url      : "proc-general-information",
                    type     : "POST",
                    data     : {'action' : sTrigger, 'data' : JSON.stringify(sCelNo), 'message' : $('#txtMessage').val()},
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
        }
    });

    $('button[data-div]').click(function (e) {
        var sContentHolder = $(this).attr('data-div');
        var sStatus = $("#selStatus").val();

        var sClone = "";

        sClone = $("#" + sContentHolder + " div.divOrig:first-child").clone();

        $(sClone).find('input[type="text"]').val('');
        $(sClone).find('input[type="file"]').val('');
        $(sClone).find('select').val('');
        $(sClone).find('textarea').val('');

        $("#" + sContentHolder).append(sClone);           
        $("#" + sContentHolder + " div.divOrig:last-child div.divRemove").append(`<button class="btn btn-sm btn-danger btn-remove"><i class="fa fa-times" title="Remove"></i></button>`);

        $(".btn-remove").click(function () {

            $(this).closest("div.divOrig").remove();
        });

        _execWidgets();
        _execFuns();

    });



    $("#selRegion").on('change', function() {
        var sValue =    $(this).val();

        if (sValue != "") {
            $.ajax({
                url      : "proc-general-information",
                type     : "POST",
                data     : {'data' : sValue, 'action' : 'dropcitymuniprov'},
                dataType : 'JSON',
                success   : function(data) {
                        console.log(data);
                    var vReturn  =   data.prov.return;
                    var vMessage =   data.prov.message;
                    
                    if (vReturn == "ok")
                    {
                        $("#selCityMuniProv").attr("disabled", false);
                        $("#selCityMuniProv").html(vMessage);

                        $("#selBrgy").attr("disabled", true);
                        $("#selBrgy").val('');

                        // $("#hPartId").html(data.partinfo.pp_code);
                        // $("#txtHouseHoldCode").val(data.partinfo.hh_code);
                        // $("#txtHouseHoldCode").attr("readOnly", true);

                        // $("#txtPartId").val(data.partinfo.pp_code);
                        // $("#txtPartIdUpload").val(data.partinfo.pp_code);
                    }
                    else
                    {
                        _systemAlert(vReturn, vMessage);
                    }
                },
                error : function(e) {
                    console.log(e.responseText);
                    _systemAlert("system");
                }   
            });
        } else {
            $("#selCityMuniProv").attr("disabled", true);
            $("#selCityMuniProv").val('');
            $("#selBrgy").attr("disabled", true);
            $("#selBrgy").val('');

            $("#hPartId").html("0");
            $("#txtHouseHoldCode").val("");
            $("#txtPartId").val("");
            // $("#txtPartIdUpload").val("");

            // $("#txtHouseHoldCode").attr("readOnly", false);

        }
    });


    $("#selCityMuniProv").on('change', function() {
        var sValue =    $(this).val();

        if (sValue != "") {
            $.ajax({
                url      : "proc-general-information",
                type     : "POST",
                data     : {'data' : sValue, 'action' : 'dropbrgy'},

                dataType : 'JSON',
            }).done(function(data) {

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
            });
        } else {
            $("#selBrgy").attr("disabled", true);
        }
    });


    $('[data-key=ClientId]').on('change', function() {

        var nClientId   =   $(this).val();
        
        if (nClientId != "") {
            $.ajax({
                url      : "proc-general-information",
                type     : "POST",
                data     : {'data' : nClientId, 'action' : 'clientdds'},
                beforeSend  : function()
                {
                    
                },
                success  : function(data) 
                {
                    console.log(data);
                    eval(data);

                    $("[data-key=BranchId], [data-key=DeptId]").on('change', function(){
                        
                        var nClientId   =   $("[data-key=ClientId]").val();    
                        var nBranchId   =   $("[data-key=BranchId]").val();
                        var nDeptId     =   $("[data-key=DeptId]").val();
                        
                        if (nClientId != "" && nBranchId != "" && nDeptId != "") {
                            _getBranchSup(nClientId, nBranchId, nDeptId);    
                        } else {
                            $("[data-key=SupId]").attr('disabled', true);
                            $("[data-key=SupId]").val('');
                        }
                        
                    });
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
    });
   
    $(".divPhoto, .divSign").click(function()
    {
        $("#modalUploadPhoto").modal({ backdrop: 'static', keyboard: true, 'open' : true });
    });

    $(".box-photo").click(function() {
        $("#txtPhoto").click();
    });

    $("input[id=txtPhoto]").on("change", function(e)
    {
        var nSize = $(this).get(0).files[0].size;
        var sFileName = $(this).get(0).files[0].name;
        var sFullPath = URL.createObjectURL(e.target.files[0]);
        

        var aFileName = sFileName.split(".");
        var sFileType = aFileName[aFileName.length -1].toLowerCase();

        var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'), h=0;
        while(nSize>900)
        {
            nSize/=1024;
            h++;
        }

        var vFileName   =   "";
        var sInvalid    =   "";
        var sTooLarge   =   "";
        var sWrongCamp  =   "";

        var nExactSize  =   Math.ceil((Math.ceil(nSize * 100)/100));
        var vSizeCat    =   fSExt[h];    
        var sSize       =   nExactSize+''+vSizeCat;

        if (sFileType != "png" && sFileType != "jpg" && sFileType != "jpeg") 
        {
            sInvalid += sFileName + " - " + sFileType +".<br />";
        }
        else
        {
            
            if (h < 3) 
            {
                if (h == 2 && nExactSize > 25)
                {
                    sTooLarge += sFileName + " - " + sSize +".<br />";
                }
                else
                {
                    vFileName += sFileName + "\n\n";
                }
            } 
            else 
            {
                sTooLarge += sFileName + " - " + sSize +".<br />";
            }
        }

        var sMessage =  "";

        if (sInvalid != "")
        {
            sMessage += "<b>File/s Invalid Format:</b> <br />" + sInvalid + "<br /><br />";
        }

        if (sTooLarge != "") 
        {
            sMessage += "<b>File/s Too Large:</b> <br />" + sTooLarge + "<br /><br />";
        }

        sMessage += "Please be advised, this system can only accept PNG, JPG and JPEG formatted file with up to 25MB max size.";
        
        if (sTooLarge != "" || sInvalid != "" || sWrongCamp != "")
        {
            _systemAlert('error', sMessage);
            $("[data-action=save-png]").attr("disabled", true);
        }
        else {

            $(".box-photo").html("<img src='"+sFullPath+"' style='height: 200px;'>");
            $("[data-action=save-png]").attr("disabled", false);
        }
        
    });

    $("#frmUpload").on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url : 'proc-upload-photo-sign',
            method: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,
            beforeSend : function() {
                
            },
            success: function (data) {
                
                var aResult =   JSON.parse(data);
                console.log(aResult);
                if (aResult.return == "ok") {
                    $(".divPhoto div").css("background-image", "url('photos/" + aResult.photo_file + "')");
                    $("input[data-key=Photo]").val(aResult.photo_file);

                    $("#modalUploadPhoto").modal("hide");

                } else {
                    _systemAlert('system');
                }
                
            },
            error: function (xhr) {
                _systemAlert('system');
                console.log(xhr);
            }
        });
    });

   
});


function _conTinue(sAction, sFrmId, sData) {

    if (sAction != "cancel") {
        $.ajax({
            url      : "proc-general-information",
            type     : "POST",
            data     : {'data' : sData, 'type': sFrmId, 'action' : sAction},

            beforeSend  : function()
            {
                
            },
            success  : function(data) 
            {console.log(data);
                eval(data);
                // if (data.return == "ok") {
                //     _systemMsg(data.message);

                // } else {
                //     _systemAlert('system');
                // }
            },  
            error :function(xhr) {

                console.log(xhr.responseText);
                _systemAlert('system');             
            }
        });
    } else {
        _refresh();
    }
}

function _getBranchSup(nClientId, nBranchId, nDeptId) {

    $.ajax({
        url      : "proc-general-information",
        type     : "POST",
        data     : {'data' : {'ClientId': nClientId, 'BranchId' : nBranchId, 'DeptId' : nDeptId}, 'action' : 'getsup'},
        dataType : 'JSON',  
        beforeSend  : function()
        {
            
        },
        success  : function(data) 
        {console.log(data);
            if (data.return == "ok") {
                $('[data-key=SupId]').html(data.message);

            } else {
                _systemAlert('system');
            }
        },  
        error :function(xhr) {
            console.log(xhr);
            _systemAlert('system');             
        }
    });
    $('[data-key=SupId]').attr('disabled', false);
}



function _execFuns() {
    $(".btn-attach").on('click', function(event) {

        event.stopPropagation();
        event.stopImmediatePropagation();

        var sBtn        =   $(this);
        var sParent     =   $(this).closest('div.form-group');
        var sFile       =   $(sParent).find("input[type=file]");
        var sText       =   $(sParent).find("[data-key]");

        $(sFile).click();

        $(sFile).on("change", function(e)
        {
          
            var nSize = $(this).get(0).files[0].size;
            var sFileName = $(this).get(0).files[0].name;
            var sFullPath = URL.createObjectURL(e.target.files[0]);
            

            var aFileName = sFileName.split(".");
            var sFileType = aFileName[aFileName.length -1].toLowerCase();

            var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'), h=0;
            while(nSize>900)
            {
                nSize/=1024;
                h++;
            }

            var vFileName   =   "";
            var sInvalid    =   "";
            var sTooLarge   =   "";
            var sWrongCamp  =   "";

            var nExactSize  =   Math.ceil((Math.ceil(nSize * 100)/100));
            var vSizeCat    =   fSExt[h];    
            var sSize       =   nExactSize+''+vSizeCat;

            if (sFileType != "png" && sFileType != "jpg" && sFileType != "jpeg") 
            {
                sInvalid += sFileName + " - " + sFileType +".<br />";
            }
            else
            {
                
                if (h < 3) 
                {
                    if (h == 2 && nExactSize > 25)
                    {
                        sTooLarge += sFileName + " - " + sSize +".<br />";
                    }
                    else
                    {
                        vFileName += sFileName + "\n\n";
                    }
                } 
                else 
                {
                    sTooLarge += sFileName + " - " + sSize +".<br />";
                }
            }

            var sMessage =  "";

            if (sInvalid != "")
            {
                sMessage += "<b>File/s Invalid Format:</b> <br />" + sInvalid + "<br /><br />";
            }

            if (sTooLarge != "") 
            {
                sMessage += "<b>File/s Too Large:</b> <br />" + sTooLarge + "<br /><br />";
            }

            sMessage += "Please be advised, this system can only accept PNG, JPG and JPEG formatted file with up to 25MB max size.";
            
            if (sTooLarge != "" || sInvalid != "" || sWrongCamp != "")
            {
                $(this).removeClass('btn-success').addClass('btn-primary');
                $(sFile).val('');
                _systemAlert('error', sMessage);
            }
            else {

                var formData = new FormData();
                formData.append('attachment', $(this)[0].files[0]);
                formData.append('txtid', $("#spnAppTrxId").html());

                $.ajax({
                    url : 'proc-upload-attachment',
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend : function() {
                      _screenLoader('on');  
                    },
                    success: function (response) {
                        _screenLoader('off'); 
                        
                        $(sBtn).removeClass('btn-primary').addClass('btn-success');
                        eval(response);                        
                    },
                    error: function (xhr) {
                        _screenLoader('off');  
                        _systemAlert('system');
                        // console.log(xhr);
                    }
                });
            }
        });
    });

    
}