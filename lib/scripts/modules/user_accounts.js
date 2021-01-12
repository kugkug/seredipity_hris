	$(function()
	{
		_fetch();

		$("#txtFilter").on('change', function() {
			_fetch();
		});

		$("#txtSearch").on('keyup', function(){ 
			_fetch();
		});


		$("#btnNewAccounts").click(function (e)
		{	
			e.preventDefault();

			_clearFields("frmMain");

			$('#modalNewAccnt').appendTo("body");
			$("#modalNewAccnt").modal(
			{
				backdrop: 'static',
		    	keyboard: false
		    });

		    $("#txtUname").attr("readOnly", false);
			$("#btnSave").show();
			$(".btn-edit").hide();
		    $("#modalNewAccnt").modal('show');
		});

		$("#btnSave").click(function (e)
		{
			e.preventDefault();
			
			if (_validate("frmMain") == true)
			{
				$.ajax({
					url      : "proc-accounts",
	               	type     : "POST",
	               	data     : $("#frmMain").serialize() + "&action=save",
	               	dataType : 'JSON',
	            }).done(function(data){
	            	// alert(data);
	            	// console.log(data);
	            	var vReturn  =   data.return;
	            	var vMessage =   data.message;
	            	
	                if (vReturn == "ok")
	                {
	                    _systemMsg(vMessage);
	                    _clearFields("frmMain");
	                    $("#modalNewAccnt").modal("hide");
	                    _fetch();
	                }
	                else
	                {
	                    _errorMsg(vReturn, vMessage);
	                }
	            });
	        }
		});

		$(".btn-edit").click(function(e)
		{
			e.preventDefault();

			var sValue 	=	e.currentTarget.value;

			if (sValue == "u")
			{
				if (_validate("frmMain") == true)
				{
					$.ajax({
						url      : "proc-accounts",
		               	type     : "POST",
		               	data     : $("#frmMain").serialize() + "&action=update&val=" + sValue,
		               	dataType : 'JSON',
		            }).done(function(data){

		            	
		            	var vReturn  =   data.return;
		            	var vMessage =   data.message;
		            	
		                if (vReturn == "ok")
		                {
		                    _systemMsg(vMessage);
		                    _clearFields("frmMain");
		                    $("#modalNewAccnt").modal("hide");
		                    _fetch();
		                }
		                else
		                {
		                    _errorMsg(vReturn, vMessage);
		                }
		            });
		        }
			}
			else
			{
				var vAction 	= "";
				switch(sValue)
				{
					case 'd' : vAction = 'Deactivate'; break;
					case 'r' : vAction = 'Remove'; break;
					case 'k' : vAction = 'Unlock'; break;
					case 'a' : vAction = 'Activate'; break;
				}

				_confirm("single", "Are you sure you want to " + vAction + " this account?", "", sValue);
			}
		});


		$(".btn-data").click(function(e)
		{
			e.preventDefault();

			var sValue 		=	e.currentTarget.value;

			var vAction 	=	sValue == "d" ? "Deactivate" : sValue == "r" ? "Remove" : "Unlock";
			var sChecked	=	_getChecked("tblData", "all");

			_confirm("batch", "Are you sure you want to " + vAction + " " + sChecked.count  +" account/s?", sChecked.result, sValue);
		});
	});

	function _conTinue(sAction, sValue, vType)
	{
		switch(sAction)
		{
			case "single":
				$.ajax({
					url      : "proc-accounts",
		           	type     : "POST",
		           	data     : $("#frmMain").serialize() + "&action=update&val=" + vType,
		           	dataType : 'JSON',
		           	beforeSend : function()
		           	{
		           		_loader('fullpage', 'on');
		           	},
		        }).done(function(data){
		        	_loader('fullpage', 'off');

		        	console.log(data);

		        	var vReturn  =   data.return;
		        	var vMessage =   data.message;
		        	
		            if (vReturn == "ok")
		            {
		                _systemMsg(vMessage);
		                _clearFields("frmMain");
		                $("#modalNewAccnt").modal("hide");
		                _fetch();
		            }
		            else
		            {
		                _errorMsg(vReturn, vMessage);
		            }
		        });
			break;
			case "batch":

				$.ajax({
					url      : "proc-accounts",
		           	type     : "POST",
		           	data     : {"action" : "update_batch", "acctids" : sValue, "val" : vType},
		           	dataType : 'JSON',
		           	beforeSend : function()
		           	{
		           		_loader('fullpage', 'on');
		           	},
		        }).done(function(data){
		        	_loader('fullpage', 'off');
		        	console.log(data);
		        	var vReturn  =   data.return;
		        	var vMessage =   data.message;
		        	
		            if (vReturn == "ok")
		            {
		                _systemMsg(vMessage);
		                _fetch();
		            }
		            else
		            {
		                _errorMsg(vReturn, vMessage);
		            }
		        });
			break;
		}
		
	}

	function _fetch()
	{
		$.ajax({
			url      	: "proc-accounts",
           	type     	: "POST",
           	data     	: {'txtSearch' : $("#txtSearch").val(), 'txtFilter' : $("#txtFilter").val(), 'action' : 'fetch' },
           	dataType 	: 'JSON',
           	beforeSend 	: function()
           	{
           		if ($("#divData").html() == "")
           		{
           			_loader("divData", "on");
           		}
           	},
        }).done(function(data){
        	_loader("divData", "off");
			console.log(data);
        	var vReturn  =   data.return;
        	var vMessage =   data.message;
        	
            if (vReturn == "ok")
            {
            	
                $("#divData").html(vMessage);

                execFunction();
                _activateEdit();
            }
            else
            {
                _errorMsg(vReturn, vMessage);
            }
        });
	}

	function _activateEdit()
	{
		$(".table-data tbody").on("click", 'tr', function(e)
	    {
	    	_clearFields("frmMain");

	    	var sCell		=	$(e.target).closest('td');
			var sTrId    	=  	$(e.target).closest(" tr ").find("td");
			var sStatus 	=  	$(sTrId[2]).text().toLowerCase();
			
			switch(sStatus)
			{
				case 'deactivated' : 
// console.log("1 " + sStatus);
					$("#btnAct").show();
					$("#btnRem").show();

					$("#btnDeAct").hide();
					$("#btnUnlock").hide();
				break;

				case 'removed' : 
				// console.log(" 2 " + sStatus);
					$("#btnAct").show();
					$("#btnRem").hide();
					
					$("#btnDeAct").show();
					$("#btnUnlock").hide();
				break;

				case 'locked' : 
				// console.log("3 " + sStatus);
					$("#btnAct").hide();
					$("#btnRem").show();
					
					$("#btnDeAct").show();
					$("#btnUnlock").show();
				break;

				case 'active' : 
				// console.log(" 4 " + sStatus);
					$("#btnAct").hide();
					$("#btnRem").show();
					
					$("#btnDeAct").show();
					$("#btnUnlock").hide();
				break;
			}


	    	if (sCell.length > 0)
	    	{
	    		if (sCell[0].cellIndex > 0)
		    	{
			        var sFirstElement   =   e.currentTarget.firstElementChild.firstElementChild.firstElementChild.id;
			        
			        var sValue          =   $("#" + sFirstElement).val();
			        
			        $.ajax({
						url      : "proc-accounts",
		           		type     : "POST",
		           		data     : {id : sValue, action : 'edit'},
		           		dataType : 'JSON',
			        }).done(function(data) {

						var vReturn  =  data.return;
			        	var vMessage =  data.message;
			        	var sStatus  =	vMessage.txtStatus;

			        	if (vReturn == "ok") {
							$.each(vMessage, function (key, val)
							{
								$("#" + key).val(val);
							});

							$("#txtUname").attr("readOnly", true);
							$("#btnSave").hide();
							$("#btnUpdate").show();
							$("#modalNewAccnt").modal("show");

							//kugkug to be continued
						}
						else{
							_errorMsg(vReturn, vMessage);
						}
			        });
			    }
			}
	    });
    }

    function _validate(sFrmId)
	{
		var vFields = _checkFields(sFrmId);
		
		if (vFields == false)
		{
			_errorMsg('empty');
		}
		else
		{
			var sPass 	= $("#txtPword").val();
			var sCPass 	= $("#txtConPword").val();
			// var sEmail 	= $("#txtEmail").val();

			if (sPass.length < 8)
			{
				$("#txtPword").closest(" div ").addClass(" has-error ");
				_errorMsg("error", "Password minimum length is 8 characters.");
				return false;
			}
			else
			{
				if (sPass != sCPass)
				{
					$("#txtPword").closest(" div ").addClass(" has-error ");
					$("#txtConPword").closest(" div ").addClass(" has-error ");
					_errorMsg("error", "Passwords did not matched.");
					return false;
				}
				else
				{
					// if (_valEmail(sEmail) == false)
					// {
					// 	$("#txtEmail").closest(" div ").addClass(" has-error ");
					// 	_errorMsg("error", "Invalid email address");

					// 	return false;
					// }
					// else
					// {
						return true;
					// }
				}
			}
		}
	}

	function execFunction()
	{
	    // $('.datepicker').datepicker({
	    //     autoclose: true
	    // });

	    $('#tblData').DataTable(
	    {
	        'paging'      : true,
	        'lengthChange': true,
	        'searching'   : false,
	        'ordering'    : false,
	        'info'        : true,
	        'autoWidth'   : false,
	        "pageLength"  : 10
	    });

	    $(".chkData").click(function(e)
	    {
	        e.stopPropagation();

	        var bCheckAll   =  "";
	        var nChecked    =  0;
	        var nCount      =  0;
	        var aChkIds     =  [];
	        var bActivate   =  "";
	        var bLocked	    =  "";
	       
	        
	        var sTableId    =  $("#" + e.currentTarget.id).closest(" table ")[0].id;
	        
	        if ($("#" + e.currentTarget.id).val() == "all")
	        {
	        	var aStatus 	=  [];
	        	var aLocked 	=  [];
	            if ($("#" + e.currentTarget.id).is(":checked")) {

	                $("#" + sTableId + " :checkbox").each(function() 
	                {
	                    var sChkId  =   $(this).attr("id");
	                    var sValue  =   $(this).attr("value");
	                    var sClass  =   $(this).attr("class");

	                    var sTrId    	=  $(this).closest(" tr ").find("td");
				        var sStatus 	=  $(sTrId[2]).text();

				        if (sStatus != "")
				        {
				        	aStatus.push(sStatus.toLowerCase());
				        }

	                    if (sClass == "chkData")
	                    {
	                        if (sValue != "all") {
	                            $("#" + sChkId).prop('checked', true);
	                        }
	                    }
	                });

	                var nLength =   aStatus.length;
                    if (nLength > 0)
                    {
                        for (var i = 0; i < nLength ; i++) {
                            if (aStatus[i] == "locked")
                            {
                               aLocked.push(aStatus[i]);
                            }
                        }

                        if (nLength == aLocked.length)
                        {
                            bLocked = true;
                        }
                        else
                        {
                            bLocked = false;
                        }
                    }
                    else
                    {
                            bLocked = false;
                    }

                    bActivate       = true;
	            }
	            else
	            {
	                $("#" + sTableId + " :checkbox").each(function() 
	                {
	                    var sChkId  =   $(this).attr("id");
	                    var sValue  =   $(this).attr("value");
	                    var sClass  =   $(this).attr("class");
	                    if (sClass == "chkData")
	                    {
	                        if (sValue != "all") {
	                            $("#" + sChkId).prop('checked', false);
	                        }
	                    }
	                });

	                bLocked 	= false;
	                bActivate 	= false;
	            }
	        }
	        else
	        {
	        	var aStatus 	=  [];
	        	var aLocked 	=  [];
	            $("#" + sTableId + " :checkbox").each(function() 
	            {
	                var sChkId  =   $(this).attr("id");
	                var sValue  =   $(this).attr("value");
	                var sClass  =   $(this).attr("class");

	                var sTrId    	=  $(this).closest(" tr ").find("td");
			        var sStatus 	=  $(sTrId[2]).text();

	                if (sClass == "chkData")
	                {
	                    if (sValue != "all") 
	                    {
	                        nCount++;
	                        if ($("#" + sChkId).is(":checked"))
	                        {
	                        	aStatus.push(sStatus.toLowerCase());
	                            aChkIds.push(sChkId);
	                            nChecked++;
	                        }
	                    }
	                }
	            });
	            
	            if (nCount == nChecked)
	            {
	            	var nLength = nCount;
	                $("#" + sTableId + " :checkbox").each(function() 
	                {
	                    var sChkId  =   $(this).attr("id");
	                    var sValue  =   $(this).attr("value");
	                    var sClass  =   $(this).attr("class");

	                    if (sClass == "chkData")
	                    {
	                        if (sValue == "all") 
	                        {
	                            $("#" + sChkId).prop('checked', true);
	                        }
	                    }
	                });

	                var nLength =	nCount;

	                bActivate = true;
	            }
	            else
	            {
	            	var nLength =	nChecked;
	                $("#" + sTableId + " :checkbox").each(function()
	                {
	                    var sChkId  =   $(this).attr("id");
	                    var sValue  =   $(this).attr("value");
	                    var sClass  =   $(this).attr("class");

	                    if (sClass == "chkData")
	                    {
	                        if (sValue == "all") 
	                        {
	                            $("#" + sChkId).prop('checked', false);
	                        }
	                    }
	                });

  	                if (nChecked > 0)
	                {
	                    bActivate = true;
	                }
	                else
	                {
	                    bActivate = false;
	                }
	            }

                if (nLength > 0)
                {
                    for (var i = 0; i < nLength ; i++) {
                        if (aStatus[i] == "locked")
                        {
                           aLocked.push(aStatus[i]);
                        }
                    }

                    if (nLength == aLocked.length)
                    {
                        bLocked = true;
                    }
                    else
                    {
                        bLocked = false;
                    }
                }
                else
                {
                   bLocked = false;
                }
	        }


	        if (bActivate == true) {
	            
	            $("#btnDisable").attr("disabled", false);
	            $("#btnRemove").attr("disabled", false);

	            $("#btnDisable").removeClass("disabled");
	            $("#btnRemove").removeClass("disabled");  

	            $("#btnDisable").removeClass("btn-default").addClass('btn-danger');
	            $("#btnRemove").removeClass("btn-default").addClass('btn-warning');
	        }
	        else
	        {
	            $("#btnDisable").attr("disabled", true);
	            $("#btnRemove").attr("disabled", true);

	            $("#btnDisable").removeClass("disabled");
	            $("#btnRemove").removeClass("disabled");   

	            // $("#btnDisable").addClass("disabled");
	            // $("#btnRemove").addClass("disabled"); 

	            $("#btnDisable").removeClass("btn-danger").addClass('btn-default');
	            $("#btnRemove").removeClass("btn-warning").addClass('btn-default');
	        }

	        if (bLocked == true)
	        {
	        	$("#btnUnLocked").attr("disabled", false);
	        	$("#btnUnLocked").removeClass("disabled");  
	            $("#btnUnLocked").removeClass("btn-default").addClass('btn-success');	            
	        }
	        else
	        {
	        	$("#btnUnLocked").attr("disabled", true);
	        	$("#btnUnLocked").addClass("disabled");  
	            $("#btnUnLocked").removeClass("btn-success").addClass('btn-default');
	        }
	    });
	}