
var metReport =  {
    callBack        :   "",
    sortCallBack    :   "",
    orderBy         :   "",
    clickable       :   false,
    clickBack       :   "",
    sDestination    :   "",
    createTabular   : function(objParam)
    {
        var vDestinationID  =   objParam.elemId; this.sDestination = vDestinationID;
        var nDestinationID  =   document.getElementById(vDestinationID);
        var oColumns        =   objParam.tableCols;
        var aDatas          =   objParam.tableData;
        var nTotalCount     =   objParam.recCount;
        var sDropCols       =   "";
        var sTableCols      =   "";
        var sDatas          =   "";

        if (objParam.title)
        {
            var sTitle      =   objParam.title == "" ? "Tabular" : objParam.title;
        }
        else
        {
            var sTitle      =   "Tabular";

        }
            
        var sTitleIcon      =   sTitle == "Tabular" ? " fa-list-alt" : " fa-search";

        this.callBack       =   objParam.callBack;
        this.orderBy        =   objParam.orderBy;
        this.sortCallBack   =   objParam.sortCallBack;

        this.clickable      =   (!objParam.clickable) ? false : objParam.clickable;
        this.clickBack      =   (!objParam.clickBack) ? "" : objParam.clickBack;

        if (objParam.orderBy)
        {
            var nOrderBy1    =   parseInt(objParam.orderBy.nOrderBy1) - 1;
            var sOrderBy1    =   objParam.orderBy.sOrderBy1;

            var nOrderBy2    =   parseInt(objParam.orderBy.nOrderBy2) - 1;
            var sOrderBy2    =   objParam.orderBy.sOrderBy2;
        }
        else
        {
            var nOrderBy1    =   "";
            var sOrderBy1    =   "";

            var nOrderBy2    =   "";
            var sOrderBy2    =   "";
        }

        if (vDestinationID == "") {
            console.log("Invalid Destination ID");
        }
        else {
            
            if(!jQuery.isEmptyObject(aDatas))
            {
                if (nDestinationID) 
                {
                    var n = 0;
                    var aShowCols = [];

                    
                    if ($(".trRepData").length)
                    {   
                        var aColPos     =   [];

                        var aThs =  $(".trRepData th");
                        var nThs =  aThs.length;
                        
                        for (var i = 0; i < nThs; i++) {
                            var sThClass = $(aThs[i]).attr("class");
                            var aThClass = sThClass.split("_");
                            aColPos.push(aThClass[1]);
                        }

                        var aNewCols =  [];
                        var aNewData =  [];

                        
                        sTableCols = `<thead><tr class="trRepData">`;
                            for (var i = 0; i < aColPos.length; i++) {

                                if (parseInt(nOrderBy1) >= 0)
                                {
                                    if (nOrderBy1 == aColPos[i])
                                    {
                                        var sFa =   sOrderBy1 == "ASC" ? "fa-sort-asc" : "fa-sort-desc";

                                        sTableCols  += `<th class="col_`+aColPos[i]+`">`+oColumns[aColPos[i]]+` <i class="fa `+sFa+`"></i> </th>`;
                                    }
                                    else
                                    {
                                        if (parseInt(nOrderBy2) >= 0)
                                        {
                                            if (nOrderBy2 == aColPos[i])
                                            {
                                                var sFa =   sOrderBy2 == "ASC" ? "fa-sort-amount-asc" : "fa-sort-amount-desc";

                                                sTableCols  += `<th class="col_`+aColPos[i]+`"> `+oColumns[aColPos[i]]+` <i class="fa `+sFa+`"></i> </th>`;
                                            }
                                            else
                                            {
                                                sTableCols  += `<th class="col_`+aColPos[i]+`"> `+oColumns[aColPos[i]]+` </th>`;
                                            }
                                        }
                                        else
                                        {
                                            sTableCols  += `<th class="col_`+aColPos[i]+`"> `+oColumns[aColPos[i]]+` </th>`;
                                        }
                                    }
                                }
                                else
                                {
                                    sTableCols  += `<th class="col_`+aColPos[i]+`"> `+oColumns[aColPos[i]]+` </th>`;
                                }
                            }
                        sTableCols += `</tr><thead>`;

                        sDatas += "<tbody>";
                        $.each(aDatas, function(arrId, arrData)
                        {
                            sDatas += `<tr class="tr_`+arrId+` trRepData">`;
                            
                            for (var i = 0; i < aColPos.length; i++) {
                                sDatas += `<td class="col_`+aColPos[i]+`">`+arrData[aColPos[i]]+`</td>`;
                            }
                        });
                        sDatas += "</tbody>";
                    }
                    else
                    {
                        sTableCols = `<thead><tr class="trRepData">`;
                        $.each(oColumns, function(id, val) {

                            sDropCols   += `<li> 
                                                <a href="#" class="small" data-value ='`+ id +`'/> 
                                                    <label class='chkColCheckbox'>
                                                        <input type="checkbox" name='chkRepCols[]' value ='`+id+`' id='chk_`+ val.replace(' ', '_') +`' checked/>
                                                        <span class='checkmark'></span> &nbsp;`+val+`
                                                    </label>
                                                </a> 
                                            </li>`;
                            
                            if (parseInt(nOrderBy1) >= 0)
                            {
                                if (nOrderBy1 == n)
                                {
                                    var sFa =   sOrderBy1 == "ASC" ? "fa-sort-asc" : "fa-sort-desc";
                                    sTableCols  += `<th class="col_`+n+`"> `+val+` <i class="fa `+sFa+`"></i>  </th>`;  
                                }
                                else
                                {
                                    if (parseInt(nOrderBy2) >= 0)
                                    {
                                        if (nOrderBy2 == n)
                                        {
                                            var sFa =   sOrderBy2 == "ASC" ? "fa-sort-asc" : "fa-sort-desc";
                                            sTableCols  += `<th class="col_`+n+`"> `+val+` <i class="fa `+sFa+`"></i>  </th>`;  
                                        }
                                        else
                                        {
                                            sTableCols  += `<th class="col_`+n+`"> `+val+` </th>`;
                                        }
                                    }
                                    else
                                    {
                                        sTableCols  += `<th class="col_`+n+`"> `+val+` </th>`;
                                    }
                                    // sTableCols  += `<th class="col_`+n+`"> `+val+` </th>`;
                                }
                            }
                            else
                            {
                                sTableCols  += `<th class="col_`+n+`"> `+val+` </th>`;
                            }

                            aShowCols.push( id );
                            n++;
                        });
                        sTableCols += `</tr><thead>`;

                        // Table Values
                        sDatas += "<tbody>";
                            $.each(aDatas, function(arrId, arrData)
                            {
                                var n = 0;

                                sDatas += `<tr class="tr_`+arrId+` trRepData">`;

                                $.each(arrData, function(key, val)
                                {
                                    sDatas += `<td class="col_`+n+`">`+val+`</td>`;
                                    n++;
                                });
                                sDatas += `</tr>`;
                            });
                        sDatas += "</tbody>";
                    }

                    if (!$("#tblTabReport").length)
                    {

                        if (objParam.exports == false)
                        {
                            var oExports    =   '';
                        }
                        else
                        {
                            var oExports    =  `<div class="box-tools pull-left" id="divExports">
                                                    <button class="btn btn-default btn-flat btn-export" data-file="exl" title="Download to Excel File">
                                                        <i class="fa fa-file-excel-o text-green" style="font-size: 24px !important;"></i>
                                                    </button>

                                                    <button class="btn btn-default btn-flat btn-export" data-file="pdf" title="Download to PDF File">
                                                        <i class="fa fa-file-pdf-o text-red" style="font-size: 24px !important; "></i>
                                                    </button>

                                                    <button class="btn btn-default btn-flat btn-export" data-file="csv" title="Download to CSV File">
                                                        <i class="fa fa-file-text-o text-aqua" style="font-size: 24px !important;"></i>
                                                    </button>

                                                </div>`;
                        }
                        
                        var sTabular    =   `<div class="box box-widget repBox" id="divRepBox">
                                                <div class="box-header">
                                                    <h3 class="box-title">
                                                        <i class="fa `+sTitleIcon+`" style="font-size: 18px !important;"></i>
                                                        <span id="spnTitle">`+sTitle+`</span>: <abbr style='font-weight: normal;' id='abbrSubTitle'>`+parseInt(nTotalCount).toLocaleString() +` Records </abbr>
                                                    </h3>
                                                    <div class="box-tools pull-right">
                                                        <span class="fa fa-columns dropdown-toggle" data-toggle="dropdown" style="font-size: 18px !important; cursor: pointer;" title='Customise Columns'></span>
                                                        <ul class="dropdown-menu" id="ulColDrop">
                                                            `+sDropCols+`
                                                        </ul>

                                                    </div>
                                                </div>
                                                <div class="box-body">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <table class="table table-hover table-striped tableReport" id="tblTabReport">
                                                                
                                                                `+sTableCols+`
                                                                
                                                                
                                                                `+sDatas+`
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="box-footer clearfix">
                                                    `+oExports+`
                                                    <div class="box-tools pull-right" id="divPager"></div>
                                                </div>
                                            </div>`;

                            document.getElementById(vDestinationID).innerHTML = sTabular;
                        }
                        else
                        {
                            var sResult = sTableCols + "" + sDatas;
                            $("#tblTabReport").html(sResult);

                            $("#spnTitle").html(sTitle);
                            $("#abbrSubTitle").html(parseInt(nTotalCount).toLocaleString() + " Records");

                            //columns to show
                            if($("#ulColDrop").length)
                            {
                                $("#ulColDrop input[type=checkbox]").each(function(e)
                                {
                                    var bChecked    =   $(this).prop("checked");
                                    var sValue      =   $(this).val();

                                    if (bChecked == true)
                                    {
                                        $(".col_" + sValue).show();
                                    }
                                    else
                                    {
                                        $(".col_" + sValue).hide();
                                    }
                                });
                            }
                        }

                        this.activateFuncs('tableReport', aShowCols);
                } 
                else {
                    console.log("Element does not exist");
                }
            }
            else{
                 var sTabular    =   `<div class="box box-widget repBox" id="divRepBox">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">
                                                        <i class="fa `+sTitleIcon+`" style="font-size: 16px !important;"></i>
                                                        `+sTitle+`: <abbr style='font-weight: normal;'>0 Records </abbr>
                                                    </h3>
                                                </div>
                                                <div class="box-body">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            No Record Found...
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>`;
                document.getElementById(vDestinationID).innerHTML = sTabular;
            }
        }
    },
    createGraph   : function(objParam)
    {
        var vDestinationID  =   objParam.elemId;
        var nDestinationID  =   document.getElementById(vDestinationID);


        if (vDestinationID == "") {
            console.log("Invalid Destination ID");
        }
        else {
            if (nDestinationID) {

                var sGraph =    `<div class="box box-widget repBox" id="divRepBox">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><i class="fa fa-bar-chart" style="font-size: 16px !important;"></i> Bar Graph<span id="spnDownloadLink"></span></h3>
                                    </div>
                                    <div class="box-body divReportBody">
                                        <div class="chart">
                                            <canvas id="barChart" style="position: relative; height: 300px;  width: 487px;" width="487" height="219"></canvas>
                                        </div>
                                    </div>
                                    <div class="box-footer clearfix"></div>
                                </div>`;

                document.getElementById(vDestinationID).innerHTML = sGraph;

                this.generateGraph(objParam.graphDatas);

            } else {
                console.log("Element does not exist");
            }
        }
    },
    activateFuncs : function(tblClass, aData)
    {
        var options = [];

        // $('.dropdown-menu a' ).on( 'click', function( event ) {

        //     var $target = $( event.currentTarget );
        //     var val     = $target.attr( 'data-value' );
        //     var $inp    = $target.find( 'input' );
        //     var idx;

        //     var nChild  =    parseInt(val) + 1;
        //     var isChecked   =$inp.prop( 'checked');


        //     if ( ( idx  = options.indexOf( val ) ) > -1 ) {

        //         options.splice( idx, 1 );
        //         setTimeout( function() { $inp.prop( 'checked', false ) }, 0);

        //         $('.col_' + val).hide('fast');
                
        //     } else {
                
        //         options.push( val );
        //         if ($inp.prop( 'checked'))
        //         {
        //             idx  = options.indexOf( val );
        //             options.splice( idx, 1 );
        //             setTimeout( function() { $inp.prop( 'checked', false ) }, 0);    
        //             $('.col_' + val).hide('fast');   
        //         }
        //         else
        //         {
        //             setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
        //             $('.col_' + val).show('fast');
        //         }
        //     }
            
        //     $( event.target ).blur();
        //     return false;
        // });


        $('.tableReport').dragableColumns({
           drag: true,
           dragClass: 'drag',
           overClass: 'over',
           movedContainerSelector: '.trRepData'
        });

        if (this.orderBy)
        {
            $(".tableReport th").click(function(e)
            {
                var aClass      =   $(this).attr("class").split("_");
                var nColPos     =   aClass[1];
                var vIcoCls     =   $($(this)[0].firstElementChild).attr("class");
                var aSiblings   =   $(this).closest("table").find("th");
                var aSorts      =   {};
                
                var nSortCntr   =    0;
                // for (var x = 0; x < aSiblings.length; x++) {
                //     var aSibClass    =   $(aSiblings[x]).attr("class").split("_");
                //     var nSibColPos   =   aSibClass[1];
                //     var vSibIcoCls   =   $(aSiblings[x].firstElementChild).attr("class");
                    
                //     if (nColPos != nSibColPos)
                //     {
                //         if (vSibIcoCls)
                //         {
                //             var aSibIcoCls =   vSibIcoCls.split(" ");
                //             var sSibIcoCls =   aSibIcoCls[1];
                //             var arrSibIco  =   sSibIcoCls.split("-");
                //             var sSibSortBy =   arrSibIco[parseInt(arrSibIco.length) - 1];

                //             if (sSibSortBy == "asc") {
                //                 var vSortBy =   "DESC";
                //                 var nSortBy =   parseInt(nSibColPos) + 1;
                //             }
                //             else if (sSibSortBy == "desc") {
                //                 var vSortBy =   "DESC";
                //                 var nSortBy =   parseInt(nSibColPos) + 1;
                //             }
                //             aSorts[nSortBy] = vSortBy;
                //             nSortCntr++;
                //         }
                //     }
                // }

                // if (nSortCntr <= 2)
                // {

                // }
                if (vIcoCls)
                {
                    var aIcoCls =   vIcoCls.split(" ");
                    var sIcoCls =   aIcoCls[1];
                    var arrIco  =   sIcoCls.split("-");
                    var sSortBy =   arrIco[parseInt(arrIco.length) - 1];

                    if (sSortBy == "asc") {
                        var vSortBy =   "DESC";
                        var nSortBy =   parseInt(nColPos) + 1;
                    }
                    else if (sSortBy == "desc") {
                        var vSortBy =   "ASC";
                        var nSortBy =   parseInt(nColPos) + 1;
                    }
                }
                else{
                    var vSortBy =   "ASC";
                    var nSortBy =   parseInt(nColPos) + 1;
                }
                
                aSorts[nSortBy] = vSortBy;    
               

                var aSortData   = {};
                var n           = 1;
                $.each(aSorts, function(key, val) {
                    aSortData['nOrderBy' + n] = key;
                    aSortData['sOrderBy' + n] = val;
                    n++;
                });

                var nSortBy1    =   aSortData.nOrderBy1;
                var sSortBy1    =   aSortData.sOrderBy1;

                var nSortBy2    =   aSortData.nOrderBy2 !== undefined ? aSortData.nOrderBy2 : "";
                var sSortBy2    =   aSortData.sOrderBy2 !== undefined ? aSortData.sOrderBy2 : "";

                var aParam =    `{"nStart" : "0", "nRecMax" : "10", "nLimit" : "10", "nOrderBy1" : "`+nSortBy1+`", "sOrderBy1" : "`+sSortBy1+`", "nOrderBy2" : "`+nSortBy2+`", "sOrderBy2" : "`+sSortBy2+`"}`;
                
                eval(metReport.sortCallBack + "(" + aParam + ");");
            });
        }

        $(".btn-export").unbind();
        $(".btn-export").click(function(e)
        {
            e.stopPropagation();
            var vType = e.currentTarget.dataset.file;

            if (vType == "exl")
            {
                _loader('reporter', 'on', "divRepBox");
                _generateReport(vType);
            }
        });

        if (this.clickable == true) {

            $(".trRepData").css("cursor","pointer");

            $("tbody .trRepData").click(function(e)
            {
                var aClass  =   $(this).attr("class").split(" ");
                var sClass  =   aClass[0].split("_");
                var nId     =   sClass[1];

                if (metReport.clickBack != "")
                {
                    eval(metReport.clickBack + "('', '"+nId+"')");
                }
                else
                {
                    console.log("Function not found...");
                }
            });
        }
    },
    generateGraph : function(objParam)
    {
        var aLabels     =   objParam.graphLabels;
        var aDatas      =   objParam.graphData;

        var areaChartData = {
            labels  : aLabels,
            datasets: [
                    {
                        label               : 'Electronics',
                        fillColor           : 'rgba(210, 214, 222, 1)',
                        strokeColor         : 'rgba(210, 214, 222, 1)',
                        pointColor          : 'rgba(210, 214, 222, 1)',
                        pointStrokeColor    : '#c1c7d1',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data                : aDatas
                    }
                    // ,
                    // {
                    //     label               : 'Digital Goods',
                    //     fillColor           : 'rgba(60,141,188,0.9)',
                    //     strokeColor         : 'rgba(60,141,188,0.8)',
                    //     pointColor          : '#3b8bba',
                    //     pointStrokeColor    : 'rgba(60,141,188,1)',
                    //     pointHighlightFill  : '#fff',
                    //     pointHighlightStroke: 'rgba(60,141,188, 1)',
                    //     data                : aDatas
                    // }
                ]
            }

            //-------------
            //- BAR CHART -
            //-------------
            var barChartCanvas                   = $('#barChart').get(0).getContext('2d')
            var barChart                         = new Chart(barChartCanvas)
            var barChartData                     = areaChartData
            barChartData.datasets[0].fillColor   = '#00a65a'
            barChartData.datasets[0].strokeColor = '#00a65a'
            barChartData.datasets[0].pointColor  = '#00a65a'
            var barChartOptions                  = {
              //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
              scaleBeginAtZero        : true,
              //Boolean - Whether grid lines are shown across the chart
              scaleShowGridLines      : true,
              //String - Colour of the grid lines
              scaleGridLineColor      : 'rgba(0,0,0,.05)',
              //Number - Width of the grid lines
              scaleGridLineWidth      : 1,
              //Boolean - Whether to show horizontal lines (except X axis)
              scaleShowHorizontalLines: true,
              //Boolean - Whether to show vertical lines (except Y axis)
              scaleShowVerticalLines  : true,
              //Boolean - If there is a stroke on each bar
              barShowStroke           : true,
              //Number - Pixel width of the bar stroke
              barStrokeWidth          : 2,
              //Number - Spacing between each of the X value sets
              barValueSpacing         : 5,
              //Number - Spacing between data sets within X values
              barDatasetSpacing       : 1,
              //String - A legend template
              legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
              //Boolean - whether to make the chart responsive
              responsive              : true,
              maintainAspectRatio     : true
            }

            barChartOptions.datasetFill = false;
            barChart.Bar(barChartData, barChartOptions);
    },
}




$(function()
{
    $(".aRepType").click(function(e)
    {
        var sType = e.currentTarget.dataset.rep;
        if (sType == "tabular") {
            $("#divTabular").show();
            $("#divGraph").hide();

            $("#aRepTabs").hide();
            $("#aRepGraph").show();

        } else {
            $("#divTabular").hide();
            $("#divGraph").show();

            $("#aRepTabs").show();
            $("#aRepGraph").hide();
        }
    });

    $('.repBox').boxWidget({
      animationSpeed: 500,
      collapseTrigger: '.btnCollapse',
      // removeTrigger: '#my-remove-button-trigger',
      collapseIcon: 'fa-minus',
      expandIcon: 'fa-plus',
      removeIcon: 'fa-times'
    });


    $(".week-picker").on('change', function()
    {
        $('.daterange-picker').val('');
        $('.month-picker').val('');

        $("#abbrDateType").html(': Weekly');
    });

    $(".month-picker").datepicker({
        format : "mm/yyyy",
        viewMode : 1,
        minViewMode : 1,
        endDate: new Date()

    }).on('change', function()
    {
        $('.week-picker').val('');
        $(".daterange-picker").val('');
        $("#abbrDateType").html(': Monthly');
    });

    $(".daterange-picker").daterangepicker({
        showDropdowns: true,
        maxDate: new Date()
    }).on('change', function()
    {
        $('.week-picker').val('');
        $('.month-picker').val('');
        $("#abbrDateType").html(': Date Range');
    });

    $(".week-picker, .month-picker, .daterange-picker").on("keypress", function()
    {
        return false;
    });


    $(".chkData").click(function(e)
    {
        e.stopPropagation();

        var bCheckAll   =  "";
        var nChecked    =  0;
        var nCount      =  0;
        var aChkIds     =  [];
        var bActivate   =  "";
        var bLocked     =  "";
       

        var sTableId    =  e.currentTarget.dataset.parent;

        if ($("#" + e.currentTarget.id).val() == "all")
        {
            var aStatus     =  [];
            var aLocked     =  [];
            
            if ($("#" + e.currentTarget.id).is(":checked")) {

                $("#" + sTableId + " :checkbox").each(function() 
                {
                    var sChkId  =   $(this).attr("id");
                    var sValue  =   $(this).attr("value");
                    var sClass  =   $(this).attr("class");
                    

                    if (sClass == "chkData")
                    {
                        if (sValue != "all") {
                            $("#" + sChkId).prop('checked', true);
                        }
                    }
                });
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
            }
        }
        else
        {
            var aStatus     =  [];
            var aLocked     =  [];
            $("#" + sTableId + " :checkbox").each(function() 
            {

                var sChkId  =   $(this).attr("id");
                var sValue  =   $(this).attr("value");
                var sClass  =   $(this).attr("class");

                if (sClass == "chkData")
                {
                    if (sValue != "all") 
                    {
                        nCount++;
                        if ($("#" + sChkId).is(":checked"))
                        {
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

                var nLength =   nCount;
            }
            else
            {
                var nLength =   nChecked;
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
            }
        }
    });

    $(" button[data-trigger] ").click(function(e)
    {
        e.preventDefault();
        var sFormId     =   e.currentTarget.dataset.form;
        var sTrigger    =   e.currentTarget.dataset.trigger;

        if (sTrigger == "submit")
        {
            var aParam =    {"nStart" : "0", "nRecMax" : "10", "nLimit" : "10", "nOrderBy1" : "1", "sOrderBy1" : "ASC", "nOrderBy2" : "", "sOrderBy2" : ""};

            _fetch(aParam);
        }
        else
        {
            location.reload();   
        }
    });
});



function _generateReport(vType)
{
    var sDate = _getDateRange();

    $.ajax({
        url         : "generate-report",
        type        : "POST",
        data        : {'type' : vType, 'date_type' : sDate.date_type},
        dataType    : 'JSON',
        beforeSend  : function(){

        },
        success     : function(response){
            _loader('reporter', 'off');
            console.log(response);

            window.location.href = response;
        },
        error       : function(xhr)
        {console.log(xhr);
            _loader('reporter', 'off');
            _systemAlert('error', 'Failed to fetch data');
        }
    });
}

function _getDateRange()
{
    var sWeekly     =   $(".week-picker").length ? $(".week-picker").val() : "";
    var sMonthly    =   $(".month-picker").length ? $(".month-picker").val() : "";
    var sRange      =   $(".daterange-picker").length ? $(".daterange-picker").val() : "";
    var aDate       =   [];
    var sDate       =   {};

    if (sWeekly == "") {
        if (sMonthly == "") {
            if (sRange == "") {
                var dToday =    moment().toDate();
                sDate['date_type']  = "range";
                sDate['date_from']  = dToday.getMonth() + 1 + "/" + dToday.getDate() + "/"  + dToday.getFullYear();
                sDate['date_to']    = dToday.getMonth() + 1 + "/" + dToday.getDate() + "/"  + dToday.getFullYear();

            } else {
                aDate = sRange.split("-");
                sDate['date_type']  = "range";
                sDate['date_from'] = aDate[0].trim();
                sDate['date_to'] = aDate[1].trim();
            }
        } else {
            var aMonthly    =   sMonthly.split("/");
            var sFromDate   =   moment([aMonthly[1], Math.abs(aMonthly[0]) - 1]).toDate()
            var sToDate     =   moment(sFromDate).endOf('month').toDate();

            sDate['date_type']  = "monthly";
            sDate['date_from']  = sFromDate.getMonth() + 1 + "/" + sFromDate.getDate() + "/"  + sFromDate.getFullYear();
            sDate['date_to']    = sToDate.getMonth() + 1 + "/" + sToDate.getDate() + "/"  + sToDate.getFullYear();

        }
    } else {
        aDate = sWeekly.split("-");
        
        sDate['date_type']  = "weekly";
        sDate['date_from']  = aDate[0].trim();
        sDate['date_to']    = aDate[1].trim();
    }

    return sDate;
}

function _getAgents()
{
    var sAgents =   $("#selAgents").val();

    if (sAgents.length > 0)
    {
        return sAgents.join(','); 
    }
    else
    {
        return false;
    }
}

function _getAppliances()
{
    var sApps =   $("#selApps").val();

    if (sApps.length > 0)
    {
        return sApps.join(','); 
    }
    else
    {
        return false;
    }
}



function _getBrowser()
{
    var ua= navigator.userAgent, tem, 
    M= ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
    if(/trident/i.test(M[1])){
        tem=  /\brv[ :]+(\d+)/g.exec(ua) || [];
        return 'IE '+(tem[1] || '');
    }
    if(M[1]=== 'Chrome'){
        tem= ua.match(/\b(OPR|Edge)\/(\d+)/);
        if(tem!= null) return tem.slice(1).join(' ').replace('OPR', 'Opera');
    }
    M= M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
    if((tem= ua.match(/version\/(\d+)/i))!= null) M.splice(1, 1, tem[1]);
    return M.join(' ');
}