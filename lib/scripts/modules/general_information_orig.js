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


    $("input[data-key=DateOfBirth]").on('change', function() {
        var nAge =  compAge(new Date($(this).val()));
        $("input[data-key=Age]").val(nAge);
    });

    /* BUTTON ON CLICK*/
    $("button[data-trigger]").on('click', function(e) {
        e.preventDefault();

        var sBtnId      =   $(this).attr("id");
        var sTrigger    =   $(this).attr("data-trigger");
        var sDataForm   =   $(this).attr("data-form");

        if (sTrigger == "save")
        {            
            if (_checkFields(sDataForm) == true) {

                var sObjData    =   _collectFields(sDataForm);
                
                _confirm(sTrigger, "Do you want to continue?", sDataForm, sObjData);
            }  
            else {
                _systemAlert("empty");
                return false;
            }
        }
        // else if (sTrigger == "clear")
        // {
        //     _clearFields(sDataForm);
        // }
    });


    $("#selRegion").on('change', function() {
        var sValue =    $(this).val();

        if (sValue != "") {
            $.ajax({
                url      : "proc-general-information",
                type     : "POST",
                data     : $("#frmData").serialize() + "&action=dropcitymuniprov",
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
                data     : $("#frmData").serialize() + "&action=dropbrgy",
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

   

    $(".divPhoto, .divSign").click(function()
    {
        $("#modalUploadPhoto").modal({ backdrop: 'static', keyboard: true, 'open' : true });

    });

    $("#modalUploadPhoto").on('shown.bs.modal', function (e) {
        _runApp();
    })

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
        }
        else {
            $(".box-photo").html("<img src='"+sFullPath+"' style='height: 200px;'>");
        }
        
    });

    $("#chkHHHead").click(function(e){
        if ($(this).prop("checked"))
        {
            $("#txtHouseHoldHead").val("yes");
        }
        else {
            $("#txtHouseHoldHead").val("no");
        }
    })

   
});


function _conTinue(sAction, sFrmId, sData) {
    
    $.ajax({
        url      : "proc-general-information",
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

            } else {
                _systemAlert('system');
            }
        },  
        error :function(xhr) {
            _systemAlert('system');             
        }
    });
}