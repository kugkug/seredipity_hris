$(function()
{

	$("button[data-trigger='refresh']").on('click', function(e) { _clear(); });
	
 	// $("#ul-sidebar-menu a").click(function(e) {
 		
 	// 	e.preventDefault();
 	// 	var sTitle 		=	$(this).text();
 	// 	var sHref		=	e.currentTarget.href;
 	// 	var sPath		=	e.currentTarget.dataset.path;
 		
 	// 	if (sHref.indexOf("menu-link") >= 0)
 	// 	{
 	// 		$("#ul-sidebar-menu li").removeClass("active");
 			
 	// 		var sHrefText	=	e.currentTarget.text.trim().replace(" ", "_");

 	// 		$(this).closest("li").addClass("active");
 	// 		$(this).closest("li").closest("ul").closest("li").addClass("active");


 	// 		_load(sPath, "", sTitle);
 	// 	} 		
 	// });

 // 	$(".breadcrumb a").click(function(e)
	// {
	// 	e.preventDefault();
	// 	var sPagePath		=	e.currentTarget.innerText.trim().replace(" ", "_");

	// 	_load(sPagePath.toLowerCase());
	// });

	toastr.options = {
	  "closeButton" 		: true,
	  "debug" 				: false,
	  "newestOnTop" 		: true,
	  "progressBar" 		: false,
	  "rtl" 				: false,
	  // "positionClass"		: "toast-top-full-width",
	  "positionClass"		: "toast-top-right",
	  "preventDuplicates"	: true,
	  "onclick"				: null,
	  "showDuration"		: 300,
	  "hideDuration"		: 300,
	  "timeOut" 			: 3000,
	  "extendedTimeOut"		: 1000,
	  "showEasing"			: "swing",
	  "hideEasing"			: "linear",
	  "showMethod"			: "fadeIn",
	  "hideMethod"			: "fadeOut"
	}

    $("#frm_login").submit(function (e)
    {
        e.preventDefault();

        var $form   = $(this);
        var sFrmId  = $form.attr('id');

        var bFields = _checkFields(sFrmId);

        if (bFields)
        {
            $.ajax({
               url      : "check-login",
               type     : "POST",
               data     : $(this).serialize(),
               dataType : 'JSON',
            }).done(function(data) {
            	console.log(data);
                var vReturn  =   data.return;
                var vMessage =   data.message;

                if (vReturn == "good")
                {
                    window.location.href=vMessage;
                    // throw new Error('go');
                }
                else
                {
                    _errorMsg(vReturn, vMessage);
                }
            });
        }
        else
        {
            _errorMsg("empty");
        }
    });
});

// eto yung nag loload ng page
function _load(mod="", moddata="", modtitle="")
{
    $.ajax(
    {
        url     : "get-page",
        type    : "POST",
        data    : {'module' : mod, 'moddata' : moddata, 'modtitle' : modtitle},
        dataType: 'JSON',
        beforeSend : function()
        {
        	_loader("fullpage", "on");
        },
        success : function(response)
        {
        	// console.log(response);
        	var sReturn 	=	response.return;
	        var sPage 		=	response.page;
	        var sHome 		=	response.home;
	        var sSecPage	=	response.secpage;
	        var sTitle 		=	response.title != "" ? response.title : response.home;
	        
        	if (sPage != "")
        	{
				$("#main-div").load(sPage,  function() { 

					_loader("fullpage", "off");
					$("#hPageTitle").html(sTitle);
					$("#spnSubTitle").html("");
					$("#liBackButton").html(" ");
					
					// Pace.stop();

					if (sSecPage != null && sSecPage != "")
	        		{
	        			$("#spnHome").html(sHome);
	        			$("#spnSecPage").html(sSecPage);
	        			// $(".breadcrumb").show();
	        		}
	        		else
	        		{
	        			// $(".breadcrumb").hide();
	        		}
				});
	        }
	        else
	        {
	        	// $(".breadcrumb").hide();
	        	 _loader("fullpage", "off");
	        }
        },
        error: function(e)
        {


            _errorMsg("server");
        }
    });
}

//check ung mga empty fields ng isang form
function _checkFields(frmId="")
{
	var nEmpty = 0;

	$("#" +frmId+" input, #"+frmId+" select, #"+frmId+" textarea").each(function()
	{
		if ($(this).attr('type') != "button" && $(this).attr('type') != "submit" && $(this).attr('type') != "reset")
		{
			if ($(this).attr('data') == 'req')
			{
				var vDiv 	=	$("#div_" + $(this).attr('id'));
				if ($(this).is(":visible") == true) {
					if ($(this).val() == "")
					{
						$(this).closest(" div ").addClass(" has-error ");
						nEmpty++;
					}
					else
					{
						$(this).closest(" div ").removeClass(" has-error ");
					}
				}
			}
		}
	});


	if (nEmpty > 0) {
		return false;
	}
	else {
		return true;
	}
}

function _checkFormFields(frmId="")
{
	var nCnt 	=	0;
	var nEmpty 	= 0;
	var aElements 	=	$(frmId).find("input, textarea, select");
	
	for (nCnt = 0; nCnt < aElements.length; nCnt++) {
		var sElement=	aElements[nCnt];
		var sValue 	=	$(sElement).val();
		var sData 	=	$(sElement).attr("data");

		

		if (sData != 'exclude')
		{
			if (sData == "req") {
				if (sValue == "")
				{
					$(sElement).closest(" div ").addClass(" has-error ");
					nEmpty++;
				}
				else
				{
					$(sElement).closest(" div ").removeClass(" has-error ");
				}
			}
		}

		

	}

	if (nEmpty > 0) {
		return false;
	}
	else {
		return true;
	}
	// $(frmId+" input, "+frmId+" select, "+frmId+" textarea").each(function()
	// {
	// 	if ($(this).attr('type') != "button" && $(this).attr('type') != "submit" && $(this).attr('type') != "reset")
	// 	{
	// 		if ($(this).attr('data') != 'exclude')
	// 		{
	// 			var vDiv 	=	$("#div_" + $(this).attr('id'));
	// 			if ($(this).val() == "")
	// 			{
	// 				$(this).closest(" div ").addClass(" has-error ");
	// 				nEmpty++;
	// 			}
	// 			else
	// 			{
	// 				$(this).closest(" div ").removeClass(" has-error ");
	// 			}
	// 		}
	// 	}
	// });


	
}

//check  kung empty ang field
function _checkField(sFieldId)
{
	var sFieldType =	$("#" + sFieldId).attr("type");

	if ($("#" + sFieldId).val() == "")
	{
		$("#" + sFieldId).closest(" div ").addClass(" has-error ");
		return "empty";
	}
	else
	{
		$("#" + sFieldId).closest(" div ").removeClass(" has-error ");

		if (sFieldType == "email")
		{
			if (_valEmail($("#" + sFieldId).val()) == true)
			{
				$("#" + sFieldId).closest(" div ").removeClass(" has-error ");
				return true;
			}
			else
			{
				$("#" + sFieldId).closest(" div ").addClass(" has-error ");
				return "email";
			}
		}
		else
		{
			$("#" + sFieldId).closest(" div ").removeClass(" has-error ");
			return true;
		}
	}

}

function _clearFields(frmId="")
{
	var nEmpty = 0;

	$("#" +frmId+" input, select, textarea").each(function()
	{
		if ($(this).attr('type') != "button" && $(this).attr('type') != "submit" && $(this).attr('type') != "reset")
		{
			if ($(this)) {
				$(this).val("");
				$(this).closest(" div ").removeClass(" has-error ");
			}
		}
	});
}

function _clearFormFields(frmId="")
{
	var nEmpty = 0;

	$("#" +frmId+" input, #" +frmId+" select, #" +frmId+" textarea").each(function()
	{
		if ($(this).attr('type') != "button" && $(this).attr('type') != "submit" && $(this).attr('type') != "reset" && !$(this).prop("readonly"))
		{
			$(this).val("");
			$(this).closest(" div ").removeClass(" has-error ");
		}
	});
}




function _showToastr(sType="", sMessage="", sTitle="")
{
	Command: toastr[sType](sMessage, sTitle);
}

function _errorMsg(type="", msg="")
{
	switch(type)
	{
		case	"empty"	:
					var sTitle 		=	"System Alert";
					var sMessage	=	"Cannot continue, Please complete the required fields.";
		break;

		case	"email"	:
					var sTitle 		=	"System Alert";
					var sMessage	=	"Cannot continue, Invalid Email Address.";
		break;

		case	"system": 
		case 	"server":
					var sTitle 		=	"System Alert";
					var sMessage	=	"Cannot continue, Please call your system administrator.";
		break;

		case	"error"	:
					var sTitle 		=	"System Alert";
					var sMessage	=	msg;
		break;

		default:
					var sTitle 		=	"Developer";
					var sMessage	=	type;
		break;
	}

	_showToastr("error", "<b>" +sTitle + "</b> <br /> " + sMessage, "");
}


function _systemMsg(type="", msg="")
{
	switch(type)
	{
		case	"saved"	:
					var sMessage	=	"Data successfully saved.";
		break;

		case	"updated"	:
					var sMessage	=	"Data successfully updated.";
		break;

		case	"removed"	:
					var sMessage	=	"Data successfully removed.";
		break;

		case	"deactivated"	:
					var sMessage	=	"Data successfully deactivated.";
		break;

		default 		:
					var sMessage	=	type;
		break;
	}

	// _showToastr("success", "<b>System Notification</b> <br /> " + sMessage, "");
	_infoBox(sMessage);
}

function _systemAlert(type="", msg="")
{
	switch(type)
	{
		case	"empty"	:
					var sTitle 		=	"System Alert";
					var sMessage	=	"Cannot continue, Please complete the required fields.";
		break;

		case	"email"	:
					var sTitle 		=	"System Alert";
					var sMessage	=	"Cannot continue, Invalid Email Address.";
		break;

		case	"system": 
		case 	"server":
					var sTitle 		=	"System Alert";
					var sMessage	=	"Cannot continue, Please call your system administrator.";
		break;

		case	"error"	:
					var sTitle 		=	"System Alert";
					var sMessage	=	msg;
		break;

		default:
					var sTitle 		=	"System Alert";
					var sMessage	=	type;
		break;
	}


	 $.alert({ title: sTitle, icon: 'fa fa-exclamation', type: 'red', content: sMessage, });
}



function _logout() {
	location = "../index.php?action=logout";
}

function _loader(path="", type="", msg="") {
	if (path != "fullpage")
	{
		if (path == "reporter")
		{
			if (type == "on")
			{
				$("#" + msg).append(`<div class="overlay text-blue" id="divOverlay"><i class="fa fa-refresh fa-spin" style="font-size : 16px; !important"></i> </div>`);
				$("html").css("pointer-events", "none");
			}
			else
			{
				$("#divOverlay").remove();
				$("html").css("pointer-events", "");
			}
		}
		else
		{
			if (type == "on")
			{
				$("#" + path).html("<div class='divLoader'>"+msg+" <img src='images/loader/hatvc_loader.gif' style='height:30px;'></div>");
				$("html").css("pointer-events", "none");
			}
			else
			{
				$("#" + path).html("");
				$("html").css("pointer-events", "");
			}
		}
	}
	else
	{
		if (type == "on")
		{
			// Pace.restart();
			// $("body").append("<div class='divLoaderFull'><div></div>");
			// <img src='images/loader/hatvc_loader.gif'></div>
			$("html").css("pointer-events", "none");
		}
		else
		{
			// $(".divLoaderFull").remove();
			$("html").css("pointer-events", "");
		}
	}
}

function _manageForm(type="")
{
	if (type == "disable") {
		$("#divMainBody").addClass("disDiv");
	}
	else {
		$("#divMainBody").removeClass("disDiv");
	}
}

function _numOnly(evt) {

    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;

    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function _numDec(el, evt) {

    evt = (evt) ? evt : window.event;
    var number = el.value.split('.');

    var charCode = (evt.which) ? evt.which : evt.keyCode;

    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }

    if (number.length > 1 && charCode == 46) {
        return false;
    }

    if ((number[0].length > 9)) {
        return false;
    }

    var caratPos = _getSelectionStart(el);
    var dotPos = el.value.indexOf(".");
    if (caratPos > dotPos && dotPos > -1 && (number[1].length > 1 )) {
        return false;
    }

    return true;
}

function _getSelectionStart(o) {
    if (o.createTextRange) {
        var r = document.selection.createRange().duplicate()
        r.moveEnd('character', o.value.length)
        if (r.text == '') return o.value.length
        return o.value.lastIndexOf(r.text)
    } else return o.selectionStart
}

function _alphaOnly(evt)
{
	evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;

    if (charCode == 32 || (charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123)) {
        return true;
    }
    return false;
}

function _valEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}


function _checkOptExists($sSelectId, sValue)
{	
	var sSelectValues	=	"";
	$("#" + $sSelectId + " option").each(function()
	{
		if ($(this).text() != "")
		{
			var selOptValue =	$(this).val();
			var selOptText 	=	$(this).text().trim();

			if (sValue.toLowerCase() == selOptText.toLowerCase())
			{
				sSelectValues = selOptValue;
			}
		}
	});

	if (sSelectValues != "") {
		var vMess =	true;
	}
	else {
		var vMess =	false;	
	}
	return {"mess" : vMess, "value" : sSelectValues};
}

function _checkTickBoxes(sObjParent) {

	var nEmpty 		=	0;
	var nCtr 		=	0;
	var aTickBoxes 	=	$(sObjParent).find('input[type=checkbox], input[type=radio]');

	if (aTickBoxes.length > 0) {
		for (nCtr = 0; nCtr < aTickBoxes.length; nCtr++) {
			var vTickBox =	aTickBoxes[nCtr];

			if ($(vTickBox).is(':checked') == true)
			{
				nEmpty++
			}
		}
	}
	if (nEmpty > 0) {
		return true;
	} else {
		return false;	
	}	
}

function _collectTickBoxes(sObjParent)
{
	var nCtr			=	0;
	var aTickBoxesRet 	=	[];
	var aTickBoxes 		=	$(sObjParent).find('input[type=checkbox], input[type=radio]');

	if (aTickBoxes.length > 0) {
		for (nCtr = 0; nCtr < aTickBoxes.length; nCtr++) {
			var vTickBox =	aTickBoxes[nCtr];

			if ($(vTickBox).is(':checked') == true)
			{
				aTickBoxesRet.push($(vTickBox).val());
			}
		}
	}

	return JSON.stringify(aTickBoxesRet);
}


function _clearTickBoxes(vFormId, vExemptId)
{
	$("#" + vFormId + " [type=checkbox], #" + vFormId + " [type=radio]").each(function()
	{
		var sTickId 	=	$(this).attr('id');
		var sTickName 	=	$(this).attr('name');
		var sTickType 	=	$(this).attr('type');

		if (sTickId != vExemptId)
		{
			if (sTickType == "checkbox" || sTickType == "radio")
			{
				$("#" + sTickId).prop("checked", false);
			}
		}
	});
}

function _collectFields(vFormId){

	var sJsonFields =	{};
	$("#" + vFormId + " input, #" + vFormId + " select, #" + vFormId + " textarea").each(function()
	{
		var sDataKey 	=	$(this).attr('data-key');
		var sValue 		=	$(this).val();
		if ($(this).is(":visible") === true) {
			if (sDataKey) {
				sJsonFields[sDataKey] = sValue;
			}
		}
	});

	return sJsonFields;
}
function _collectFieldsBatch(vFormId){

	
	var sAllData 	=	[];
	var nCntr 		=	0;


	$("#" + vFormId + " div.divOrig").each(function()
	{
		var sJsonFields =	{};
		var aElements	=	$($(this)).find('input, select, textarea');
		var nLength 	=	aElements.length;
		var nLooper 	=	0;

		for (nLooper = 0; nLooper < nLength; nLooper++) {
			var sDataKey 	=	$(aElements[nLooper]).attr('data-key');
			var sValue 		=	$(aElements[nLooper]).val();
			if (sDataKey) {
				sJsonFields[sDataKey] = sValue;
			}
		}
		sAllData.push(sJsonFields);
		nCntr++;
	});

	return JSON.stringify(sAllData);
}
function partIdOnly(event) {

	var vKey	=	event.keyCode;
	
	if ((vKey >= 48 && vKey <= 57) || vKey == 45) {
		return true;
	} else {
		return false;
	}	
}

function rangeOnly(event) {

	var vKey	=	event.keyCode;
	
	if ((vKey >= 48 && vKey <= 57) || (vKey == 45 || vKey == 46)) {
		return true;
	} else {
		return false;
	}	
}

function getAge(dateString) {
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}

function getMonthDuration(dDateFrom, dDateTo) {

	return dDateTo.getMonth() - dDateFrom.getMonth() + (12 * (dDateTo.getFullYear() - dDateFrom.getFullYear()));
}

function _clear() {

    var nUnSaved =  $(".box-warning").length;
    console.log(nUnSaved);
    if (nUnSaved > 0) {
        _conBox('_refresh', '', "It looks like you have been editing something<br />If you leave before saving, your changes will be lost.<br /><br />Do you want to continue?");
    } else {
        _refresh();
    }
}

function _refresh() {
	location.reload(true);
}

function compAge(dob) { 
	
    var diff_ms = Date.now() - dob.getTime();
    var age_dt = new Date(diff_ms); 
  
    return Math.abs(age_dt.getUTCFullYear() - 1970);
}
