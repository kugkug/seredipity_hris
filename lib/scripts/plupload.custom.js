var rABS = typeof FileReader !== "undefined" && (FileReader.prototype||{}).readAsBinaryString;

var aReportNames    =   ['interbacs', 'eazipay', 'sales'];
var aColumns        =   {
                            interbacs   : ['has_number','collection_date','collection_amount','status','type','enc_account_name','enc_account_number','enc_sortcode'],
                            eazipay     : ['reference','amount','status','type','transaction_code','payment_number','submission_date','for_date','processing_date','due_date','enc_account_name','enc_account_number','enc_sortcode'],
                            sales       : ['sale_id','uid','user_id','SaleDate','SaleStatus','Title','First','Surname','Addr1','Addr2','Addr3','Addr4','Addr5','Postcode','Phone','Payment_method','CC_Type','CC_Name','CC_Number','CC_StartDate','CC_EndDate','CC_IssueNo','CC_Security','CC_TXNid','Sort_Code','account_Number','account_name','dd_start_date','ddBank','ddBranch','NumAppliances','PayFreq','Amount','Notes','App1','App2','App3','App4','App5','App6','App7','App8','App9','App10','App11','App12','source','email','password','mobile','mk1','mk2','mk3','mk4','mk5','mk6','mk7','mk8','mk9','mk10','ag1','ag2','ag3','ag4','ag5','ag6','ag7','ag8','ag9','ag10','gdpr_phone','gdpr_mail','gdpr_email','gdpr_sms','gdpr_phone_date','gdpr_mail_date','gdpr_email_date','gdpr_sms_date','gdrp_tp_phone','gdrp_tp_sms','gdrp_tp_email','gdrp_tp_mail','gdrp_tp_phone_date','gdrp_tp_sms_date','gdrp_tp_email_date','gdrp_tp_mail_date','tp_aged50plus','tp_homeowner','tp_havelifeinsurance','tp_buildinginsurance','tp_contentsinsurance','tp_insurance_premiums','tp_boiler_age','tp_boiler_make']
                        };

var uploader = new plupload.Uploader({
    runtimes        : 'html5,flash,silverlight,html4',
    browse_button   : 'btn-upload-file', // you can pass an id...
    container       : document.getElementById('upload-file-container'), // ... or DOM Element itself
    url             : 'batch-input',
    drop_element    : "upload-file-container",
    //flash_swf_url: '../js/Moxie.swf',
    //silverlight_xap_url: '../js/Moxie.xap',

    filters: {
        max_file_size: '2GB',
        mime_types: [
            { title: "Excel files", extensions: "xlsx,xls" },
            { title: "CSV files", extensions: "csv" }
        ]
    },

    init: {
        PostInit: function () {
                document.getElementById('btn-start-upload-file').onclick = function () {

                uploader.start();
                return false;

            };
        },

        FilesAdded: function (up, files) {

            var nFileCnt = 0;
            $.each(files, function (i, file) {
                if (file) {
                    nFileCnt++;
                }
            });
            
            if (nFileCnt < 2)
            {
                plupload.each(files, function (file) {
                    
                    var reader = new FileReader();
                    var fileSheetsCol = "";

                    // $('#upload-file-container').addClass('is-dragover');

                    // reader.onload = function (e) {
                    //     var data = e.target.result;
                    //     var arr = String.fromCharCode.apply(null, new Uint8Array(data));
                    //     var wb = XLSX.read(btoa(arr), { type: 'base64' });
                    //     fileSheetsCol = getSheetsColMap(process_wb(wb, "json"));
                    //     createFileList({ id: file.id, name: file.name, size: plupload.formatSize(file.size), status: "on-queue", sheetsCols: fileSheetsCol });
                    // }

                    // reader.readAsArrayBuffer(file.getNative());

                    var reader = new FileReader();
                    reader.onload = function(e) {

                        var data = e.target.result;
                        if(!rABS) data = new Uint8Array(data);


                        fileSheetsCol = getSheetsColMap(process_wb(XLSX.read(data, {type: rABS ? 'binary' : 'array'}), "header"));
                        // console.log(fileSheetsCol);

                        // createFileList({ id: file.id, name: file.name, size: plupload.formatSize(file.size), status: "on-queue", sheetsCols: fileSheetsCol });

                        let markup = getFileListTemplate({ id: file.id, name: file.name, size: plupload.formatSize(file.size), status: "", sheetsCols: fileSheetsCol });

                        document.getElementById('upload-file-list').innerHTML = (markup);

                        $("#upload-file-list").html(markup);
                        $(".rowFooter").show();
                        $("#divUploader").hide();
                        // $('#upload-file-container').removeClass('is-dragover');

                        // fileSheetsCol = getSheetsColMap(process_wb(XLSX.read(data, {type: rABS ? 'binary' : 'array'}), "json"));
                        // createFileList({ id: file.id, name: file.name, size: plupload.formatSize(file.size), status: "on-queue", sheetsCols: fileSheetsCol });
                    }

                    if(rABS) {
                        reader.readAsBinaryString(file.getNative());
                    } else {
                        reader.readAsArrayBuffer(file.getNative());
                    }
                });
            }
            else
            {
                
                $.each(files, function (i, file) {
                
                    if (file) {
                        uploader.removeFile(file);
                    }
                });
                _systemAlert('error', 'Multiple file upload is not allowed.');
            }
        },

        BeforeUpload: function(up, file, info) {
            var sheets_opt = {};
            
            uploader.settings.multipart_params = {
                file_id     : file.id,
                file_size   : file.size,
                file_name   : file.name,
                sheets_opt  : sheets_opt
            };
        },

        UploadProgress: function (up, file) {
            // console.log(file);
            // document.getElementById("file-status").innerHTML = '<span>' + file.percent + "%</span>";
        },

        FileUploaded: function (up, file, info) {

            var response = JSON.parse(info.response);

            $(".rowBrowse").show();

            if (response.response_code != "200")
            {
                _systemAlert("error", response.message);
                $(".rowFooter").hide();
                $(".rowLists").hide();
                // $(".rowUploading").hide();
            }
            else
            {
                _systemMsg(response.message, "");
                $(".rowFooter").hide();
                $("#divUploader").show(); 
                $("#upload-file-list").html('');

                // $(".rowUploading").show();
            }

            // putFlag();
        },

        Error: function (up, err) {
            var errResponse = JSON.parse(err.response);
            // document.getElementById("file-status").innerHTML = '<span>Failed to upload file. Try again</span>';
        }
    }
});

function getSheetsColMap(XLSXHeader) {
    
    var sheets          =   [];
    var nCharCode       =   65;
    var nChar           =   "";

    var aReportTypes    =   {interbacs:[], eazipay:[], sales:[]};
    var aColCounts      =   [];

    var n           =   0;

    while(n < 3)
    {
        var nCounter    =   0;
        var nColumnsLen =   aColumns[aReportNames[n]].length;
        var nColCounts  =   0;

        for (var sheet in XLSXHeader)
        {
            for (var cols in XLSXHeader[sheet])
            {
                var sColName        =   XLSXHeader[sheet][cols];
                if (sColName !== "")
                {
                    if (aColumns[aReportNames[n]].indexOf(sColName) < 0)
                    {
                        aReportTypes[aReportNames[n]].push(sColName);
                        nCounter++;
                    }
                    nColCounts++;
                }
            } 
            
            if (nColumnsLen == nColCounts)
            {
                aColCounts[aReportNames[n]] = nCounter;
            }

        }  n++;
    }    

    if (Object.keys(aColCounts).length > 0)
    {
        var sKey  =   Object.keys(aColCounts);
        aReportTypes[sKey].push(sKey);

        return aReportTypes[sKey];
    }
    else
    {
        return nColCounts;
    }
}



function getFileListTemplate(file) {
   
    var sReturns    =   "";
    var sResults    =   file.sheetsCols;
    var nResCnts    =   file.sheetsCols.length;

    $(".rowLists").show();
    $(".rowBrowse").hide();


    if ( !isNaN(sResults) && (sResults !== aColumns.interbacs.length && sResults !== aColumns.eazipay.length && aColumns.interbacs.length !== aColumns.sales.length)) {
        $("#btn-start-upload-file").hide();

        sReturns    =   `
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                               Filename :  ${file.name} - (${file.size})
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="callout callout-danger" style="background-color: #f56954 !important">
                                    <h4>File Is Not Recognised.</h4>

                                    <p>The file you are trying to upload is invalid.</p>
                                    <p>The header counts do not match any of the prescribed file types for data import. </p>
                                    <p>Please see below number of columns for their respective file types.</p>
                                    <br />
                                    <p>Column Count : `+ sResults+`</p>
                                    <table style='width : 300px;'>
                                        <tr>
                                            <td>Data Type</td>
                                            <td>Columns Expected</td>
                                        </tr>
                                        <tr>
                                            <td>Interbacs</td>
                                            <td>`+aColumns.interbacs.length+`</td>
                                        </tr>
                                        <tr>
                                            <td>Eazipay</td>
                                            <td>`+aColumns.eazipay.length+`</td>
                                        </tr>
                                        <tr>
                                            <td>Sales</td>
                                            <td>`+aColumns.sales.length+`</td>
                                        </tr>
                                    </table>
                                    <br />
                                    <p>Please correct the file and try to upload again after.</p>
                                </div>
                            </div>
                        </div>
                        `;
    }
    else
    {
        var sTitle      =   file.sheetsCols[nResCnts -1][0].charAt(0).toUpperCase() + file.sheetsCols[nResCnts -1][0].slice(1);
        var sType       =   file.sheetsCols[nResCnts -1][0];

        if (nResCnts > 1)
        {
            var sHeaders    =   "<ul class='nav'>";
            var sRequire    =   "<ul class='nav'>";

            for(var i=0; i < (nResCnts - 1); i++)
            {
                sHeaders    += "<li>" + sResults[i] + "</li>";
            }
            sHeaders    +=  "</ul>";

            for(var i=0; i < (aColumns[sType].length - 1); i++)
            {
                sRequire    += "<li>" + aColumns[sType][i] + "</li>";
            }
            sRequire    +=  "</ul>";
            
            $("#btn-start-upload-file").hide();
            // <h4>Incorrect File Headers!</h4>
            sReturns    =   ` 
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                   Filename :  ${file.name} - (${file.size})
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="alert alert-danger">
                                        <h4>File Is Not Validated.</h4>

                                        <p>The file you are trying to upload has incorrect file headers.</p>
                                        <p>The closest we can associate this file is with the `+sTitle+` prescribed file type. However there are several header names that are not recognized. You see them in the left column below. The ones on the right (column) are the prescribed ones.</p>


                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 divCall" id="divInvalid">
                                                <b> Invalid Headers</b>
                                                `+sHeaders+`
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 divCall" id="divRequire">
                                                <b>Required Columns</b>
                                                `+sRequire+`
                                            </div>
                                        </div>
                                        <br />
                                        <p>Please correct the unrecognised header names and try to upload again after.</p>
                                    </div>
                                </div>
                            </div>
                        `;
        }
        else
        {
            $("#btn-start-upload-file").show();
            sReturns    =   `
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                   Filename :  ${file.name} - (${file.size})
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="alert alert-info">
                                        <h4>File Succesfully Validated.</h4>
                                        <p>Checking the file matches the prescribed `+sTitle +` file layout type. </p>

                                        <p>Would you want to continue with the data import?</p>

                                    </div>
                                </div>
                            </div>
                        `;
                        // <p id="file-status"></p>
        }
    }

    return sReturns;
}

$(document).ready(function()
{
    $("#btnCancel").click(function ()
    {
        $("#upload-file-list").html('');
        $(".rowFooter").hide();
        $("#divUploader").show(); 

        $(".rowLists").hide();
        $(".rowBrowse").show();

        $.each(uploader.files, function (i, file) {
            
            if (file) {

                uploader.removeFile(file);
            }
        });
    });

    $("#divUploader").hover(function()
    {
        var sList = $("#upload-file-list").html();
    });

    // $('#upload-file-container').hover(function (e) 
    // {
    //     alert("test");
        
    // });


    $('#upload-file-container').on('dragover', function (e) 
    {
        $('#upload-file-container').addClass('is-dragover');
    }).on('dragleave dragend drop', function() 
    {
        $('#upload-file-container').removeClass('is-dragover');
    });
});

setInterval("_getUploads()", 2000);
// _getUploads();

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function _getUploads()
{
   $.ajax({
        url         : 'get-uploads',
        type        : 'POST',
        dataType    : 'JSON',
        beforeSend  : function() {
            // _loader(sLoader, "on");
        },
        success     : function(response)
        {
            if (response.length > 0)
            {
                $.each(response, function(key, obj) 
                {
                    var nId         =   obj.ID;
                    var sType       =   obj.TYPE.toUpperCase();
                    var sFileName   =   obj.FILENAME;
                    var sStatus     =   obj.STAT;
                    var nRowCount   =   parseInt(obj.ROWCNT);
                    var nRowTotal   =   parseInt(obj.ROWTOT);
                    var nSize       =   formatBytes(obj.SIZE);
                    var dEntryDate  =   obj.ENTRYDATE;
                    var dEntryBy    =   obj.ENTRYBY;

                    
                    if (sStatus != "done")
                    {
                        if ($("#divProc_" + nId).length)
                        {
                            var sClass      =   "";
                            var nPercent    =   Math.ceil((nRowCount / nRowTotal) * 100);

                            if (nPercent > 0 && nPercent <= 25) {
                                sClass      =   "progress-bar-danger";
                            }
                            else if (nPercent > 25 && nPercent <= 50) {
                                sClass      =   "progress-bar-warning";
                            }   
                            else {
                                sClass      =   "progress-bar-success";
                            }

                            $("#divProc_" + nId + " div.progress-bar").removeClass("progress-bar-danger");
                            $("#divProc_" + nId + " div.progress-bar").removeClass("progress-bar-warning");
                            $("#divProc_" + nId + " div.progress-bar").removeClass("progress-bar-success");

                            $("#divProc_" + nId + " div.progress-bar").css("width", nPercent + "%");
                            $("#divProc_" + nId + " div.progress-bar").addClass(sClass);

                            $("#lblTotal_" + nId).html(nRowTotal.toLocaleString());


                            $("#lblProcessed_" + nId).html(nRowCount.toLocaleString() + " of " + nRowTotal.toLocaleString());
                            $("#lblPercent_" + nId).html(nPercent > 0 ? nPercent +"%" : "0%");


                            if (sStatus == "done")
                            {
                                $("#divProc_" + nId).removeClass("active");
                            }
                        }
                        else
                        {
                            var sHtml = "";

                            sHtml     +=    `<div class="row divAppend_`+nId+`">` +
                                                `<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">` +
                                                    sFileName + ` - <label id="lblPercent_`+nId+`">0%</label>` +
                                                    `<table class="pull-right" style="width: 25%;" border="0">` +
                                                        `<tr>` +
                                                            `<td style="width: 100%; text-align:right;"> Processed : ` + `<label id="lblProcessed_`+nId+`"> 0 of `+nRowTotal.toLocaleString()+` </label></td>` +
                                                        `</tr>` +
                                                    `</table>` +
                                                `</div>` +
                                            `</div>` +
                                            `<div class="row divAppend_`+nId+`">` +
                                                `<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">` +
                                                    `<div class="progress progress-sm active" id="divProc_`+nId+`">` +
                                                        `<div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">` +
                                                            `<span class="sr-only">20% Complete</span>` +
                                                        `</div>` +
                                                    `</div>` +
                                                `</div>` +
                                            `</div>`;
                            $("#divUploadList").prepend(sHtml);
                        }
                    }
                    else
                    {
                        if ($("#divProc_" + nId).length)
                        {
                            $(".divAppend_"+nId).fadeOut("slow", function() {
                                $(".divAppend_"+nId).remove();
                            });
                        }   

                        var sTrList     =   "";

                        sTrList     +=   `<tr id="trList_`+nId+`" onclick="viewDetails('`+nId+`', '`+sFileName+`', '`+nRowTotal+`')" >`;
                        sTrList     +=   `<td>`+ sFileName +`</td>`;
                        sTrList     +=   `<td>`+ sType +`</td>`;
                        sTrList     +=   `<td>`+ nSize +`</td>`;
                        sTrList     +=   `<td>`+ nRowTotal.toLocaleString() +`</td>`;
                        sTrList     +=   `<td>`+ dEntryDate +` | `+dEntryBy+`</td>`;
                        sTrList     +=   `</tr>`;

                        if (!$("#trList_" + nId).length)
                        {
                            $("#tbodyUploaded").prepend(sTrList);
                        }
                    }
                });
            }
            else
            {
                $("#divUploadList").html("");
            }
        },
    });
}

function formatBytes(bytes, decimals = 2) {

        if (bytes !== "" && parseInt(bytes) > 0) {
            if (bytes === 0) return '0 Bytes';

            const k = 1024;
            const dm = decimals < 0 ? 0 : decimals;
            const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

            const i = Math.floor(Math.log(bytes) / Math.log(k));

            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        }
        else {
            return "-";
        }
    }

function viewDetails(nId, sFileName, nRowTotal)
{
    var sHtml = ``;


    $('#detailsModal').modal({
        show: 'false',
        backdrop: 'static',
        keyboard: false
    }); 
    $("#detailsModal").modal("show");
    $("#detailsModal h4.modal-title").html("Load Report : <font style='color : #5bc0de'>" + sFileName + "</font> - " + parseInt(nRowTotal).toLocaleString() + " record/s");

    $.ajax({
        url         : 'get-uploads-details',
        type        : 'POST',
        dataType    : 'JSON',
        data        : {'logid' : nId},
        beforeSend  : function() {
            $("#detailsModal div.modal-body").html("Retrieving details...");
        },
        success     : function(response)
        {

            var sJson   =   JSON.parse(response[0].jsonstatus);
            var vClass  =   "";
            
            sHtml = `<table class="table" id="tblDetails">`;
            sHtml += `<tr><th>Data Type</th><th>New</th><th>Duplidate</th><th>Error</th><tr>`;

            sHtml += `<tr data="`+nId+`|`+sFileName+`|`+nRowTotal+`|C"><th>CUSTOMER</th>`;

            vClass =    parseInt(sJson.C.new).toLocaleString() > 0 ? "tdFilled" : "";
            sHtml += `<td title="New Customers" class='`+vClass+`'>`+parseInt(sJson.C.new).toLocaleString()+`</td>`;
            vClass =    parseInt(sJson.C.dup).toLocaleString() > 0 ? "tdFilled" : "";
            sHtml += `<td title="Duplicate Customers" class='`+vClass+`'>`+parseInt(sJson.C.dup).toLocaleString()+`</td>`;
            vClass =    parseInt(sJson.C.error).toLocaleString() > 0 ? "tdFilled" : "";
            sHtml += `<td title="Failed Customers" class='`+vClass+`'>`+parseInt(sJson.C.error).toLocaleString()+`</td><tr>`;

            sHtml += `<tr data="`+nId+`|`+sFileName+`|`+nRowTotal+`|P"><th>POLICY</th>`;

            vClass =    parseInt(sJson.P.new).toLocaleString() > 0 ? "tdFilled" : "";
            sHtml += `<td title="New Customers" class='`+vClass+`'>`+parseInt(sJson.P.new).toLocaleString()+`</td>`;
            vClass =    parseInt(sJson.P.dup).toLocaleString() > 0 ? "tdFilled" : "";
            sHtml += `<td title="Duplicate Customers" class='`+vClass+`'>`+parseInt(sJson.P.dup).toLocaleString()+`</td>`;
            vClass =    parseInt(sJson.P.error).toLocaleString() > 0 ? "tdFilled" : "";
            sHtml += `<td title="Failed Customers" class='`+vClass+`'>`+parseInt(sJson.P.error).toLocaleString()+`</td><tr>`;

            sHtml += `</table>`;

            $("#detailsModal div.modal-body").html(sHtml);
            _activate();
        }
    });
}

function _activate()
{
    $("#tblDetails tr td").click(function(e)
    {
        var aStatuses   =   ['new','dup','error'];

        var nCellIndex  =   e.currentTarget.cellIndex;
        var sStatus     =   aStatuses[parseInt(nCellIndex) - 1];

        var aParentData =   $(this).closest('tr').attr('data').split("|");
        var nCount      =   $(this).text();

        if (parseInt(nCount) > 0)
        {
            viewReport(aParentData[0], aParentData[1], aParentData[2], aParentData[3],sStatus, nCount);

            $("#detailsModal").modal("hide");
        }
    });

    $('#logModal').on('hidden.bs.modal', function () {

       $("#detailsModal").modal("show");
      // do something…
    });
}

function viewReport(nId, sFileName, nRowTotal, vType, vStatus, vCount)
{
    var sHtml = ``;

    $('#logModal').modal({
        show: 'false',
        backdrop: 'static',
        keyboard: false
    });

    var sType     =   vType == "C" ? "Customers" : "Policies";
    var sStatus   =   vStatus == "new" ? "New" : (vStatus == "dup" ? "Duplicate" : "Error");

    $("#logModal").modal("show");
    $("#logModal h4.modal-title").html("Load Report Details : <font style='color : #5bc0de'>" + sFileName + "</font> : <b>" + vCount.toLocaleString() + "</b> " + sStatus + " " + sType + " from <b>" + parseInt(nRowTotal).toLocaleString() + "</b> Total Records.");
    
    $.ajax({
        url         : 'get-uploads-logs',
        type        : 'POST',
        dataType    : 'JSON',
        data        : {'logid' : nId, 'status' : vStatus, 'type' : vType},
        beforeSend  : function() {
            $("#logModal div.modal-body").html("Retrieving records...");
        },
        success     : function(response)
        {
            sHtml = `<table class="table table-hover table-striped data-table">`;

            sHtml += `<tr>`;
            $.each(response[0], function(key, obj) 
            {
                if (key != "StatusC" && key != "StatusP")
                {
                    sHtml += `<th>` + key + `<th>`;
                }
            });
            sHtml += `</tr>`;


            $.each(response, function(key, obj) 
            {
                sHtml += `<tr>`;    

                $.each(obj, function(key, data) 
                {
                    if (key != "StatusC" && key != "StatusP")
                    {
                        sHtml += `<td>` + data + `<td>`;
                    }
                });

                sHtml += `</tr>`;    
            });
            sHtml += `</table>`;

            
            $("#logModal div.modal-body").html(sHtml);
        }
    });
}