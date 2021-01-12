
var metPager =  {
    limit       :   0,
    pageno      :   0,
    callBack    :   "",
    orderBy     :   "",
    createPager : function(objParam)
    {
        var vElemId     =   objParam.elemId;
        var nTotalCount =   objParam.recCnt;
        var vLimitRange =   objParam.limitRange;
        var nRecMax     =   objParam.recmax;

        this.callBack   =   objParam.callBack;
        this.limit      =   objParam.limit;
        this.pageno     =   objParam.pageno;
        this.orderBy    =   objParam.orderBy; 

        var nElemId =   document.getElementById(vElemId);
        var sPager  =   '';
        if (vElemId == "") {
            console.log("Invalid Destination ID");
        } else {
            if (nElemId) {
                var aDis =  "";

                if (this.pageno <= 1)
                {
                    var aDis =  " aDis";
                }
                
                if (parseInt(nRecMax) >= parseInt(nTotalCount))
                {
                    var sDis    =   " aDis";
                    var nNewMax =   nTotalCount;
                }
                else
                {
                    var sDis    =   "";
                    var nNewMax =   nRecMax;   
                }

                var nPageNo     =   parseInt(objParam.pageno) > 0 ? parseInt(objParam.pageno) + 1 : 1;

                sPager    += `  <span class="spnPager pull-left" style="padding: 8px;"> <abbr class="pagerStart">`+nPageNo.toLocaleString()+`</abbr> - <abbr class="pagerEnd">`+parseInt(nNewMax).toLocaleString()+`</abbr> of <abbr class="pagerTotalCount">`+parseInt(nTotalCount).toLocaleString()+`</abbr> </span>
                                <ul class="pagination pagination-md inline ulPager">
                                    <li><a href="" class="aFirs `+aDis+`" data-value="firs" data-callback ="`+objParam.callBack+`"><i class="fa fa-angle-double-left"></i></a></li>
                                    <li><a href="" class="aPrev `+aDis+`" data-value="prev" data-callback ="`+objParam.callBack+`"><i class="fa fa-angle-left"></i></a></li>
                                    <li><a href="" class="aNext `+sDis+`" data-value="next" data-callback ="`+objParam.callBack+`"><i class="fa fa-angle-right"></i></a></li>
                                    <li><a href="" class="aLast `+sDis+`" data-value="last" data-callback ="`+objParam.callBack+`"><i class="fa fa-angle-double-right"></i></a></li>
                                </ul>`;

                $("#" + vElemId).html(sPager);
                this.activatePager(vElemId);

            } else {

                // console.log("Element does not exist");
            }
        }
    },
    activatePager   : function(vDestId)
    {
        $("#" + vDestId+ " ul.ulPager a").click(function(e)
        {
            e.preventDefault();

            var sClass      = e.currentTarget.dataset.value;
            var sCallBack   = e.currentTarget.dataset.callback;
              
            metPager.paginatePager(sClass, vDestId, sCallBack);
        });
    },
    paginatePager   : function(sPagerType, vDestId, sCallBack)
    {
        var nLimit      =   this.limit;

        var nNewNum     =   0;
        var nRecStart   =   parseInt($("#" +vDestId+ " .pagerStart").html().replace(",", ""));
        var nTotalCount =   parseInt($("#" +vDestId+ " .pagerTotalCount").html().replace(",", ""));

        var nPageCnt    =   Math.ceil(nTotalCount / nLimit);


        if (nRecStart == 1)
        {
            var nPageNum = 0;
        }
        else
        {
            var nPageNum = (nRecStart - 1)  / parseInt(nLimit);
        }
            
        $("#" +vDestId+ " .pagerStart").html(nRecStart);
        $("#" +vDestId+ " .pagerEnd").html(nLimit);

        switch(sPagerType)
        {
            case 'firs': 
                $("#" +vDestId+ " .aFirs").addClass("aDis");
                $("#" +vDestId+ " .aPrev").addClass("aDis");
                

                $("#" +vDestId+ " .aLast").removeClass("aDis");
                $("#" +vDestId+ " .aNext").removeClass("aDis");
                
                nNewNum = 0;
            break;

            case 'prev': 

                if (nPageNum > 0)
                {
                    nNewNum = nPageNum - 1;
                    if (nNewNum == 0)
                    {
                        $("#" +vDestId+ " .aFirs").addClass("aDis");
                        $("#" +vDestId+ " .aPrev").addClass("aDis");
                    }
                }
                else
                {
                    $("#" +vDestId+ " .aFirs").addClass("aDis");
                    $("#" +vDestId+ " .aPrev").addClass("aDis");
                }
                
                $("#" +vDestId+ " .aLast").removeClass("aDis");
                $("#" +vDestId+ " .aNext").removeClass("aDis");
                
                
            break;

            case 'next': 

                if (nPageNum < nPageCnt)
                {
                    nNewNum = nPageNum + 1;
                    if (nNewNum == nPageCnt - 1)
                    {
                        $("#" +vDestId+ " .aLast").addClass("aDis");
                        $("#" +vDestId+ " .aNext").addClass("aDis");
                    }

                    $("#" +vDestId+ " .aFirs").removeClass("aDis");
                    $("#" +vDestId+ " .aPrev").removeClass("aDis");
                }
                else
                {
                    $("#" +vDestId+ " .aFirs").removeClass("aDis");
                    $("#" +vDestId+ " .aPrev").removeClass("aDis");

                    $("#" +vDestId+ " .aLast").addClass("aDis");
                    $("#" +vDestId+ " .aNext").addClass("aDis");
                }
                
            break;

            case 'last': 

                $("#" +vDestId+ " .aLast").addClass("aDis");
                $("#" +vDestId+ " .aNext").addClass("aDis");
                
                $("#" +vDestId+ " .aFirs").removeClass("aDis");
                $("#" +vDestId+ " .aPrev").removeClass("aDis");
                
                nNewNum = (nPageCnt - 1);
            break;
        }

        var nNewStart = Math.ceil(nNewNum * nLimit) + 1;
        var nNewLimit = Math.ceil((nNewNum * nLimit) + parseInt(nLimit)) > parseInt(nTotalCount) ? parseInt(nTotalCount) : Math.ceil((nNewNum * nLimit) + parseInt(nLimit));


        $("#" +vDestId+ " .pagerStart").html(parseInt(nNewStart).toLocaleString());
        $("#" +vDestId+ " .pagerEnd").html(parseInt(nNewLimit).toLocaleString());

        var spStart =   parseInt(nNewNum);
        var spLimit =   nLimit;

        if (this.orderBy) {
            var nOrderBy1   =   this.orderBy.nOrderBy1;
            var sOrderBy1   =   this.orderBy.sOrderBy1;

            var nOrderBy2   =   this.orderBy.nOrderBy2;
            var sOrderBy2   =   this.orderBy.sOrderBy2;
        } else {
            var nOrderBy1   =   "1";
            var sOrderBy1   =   "ASC";

            var nOrderBy2   =   "";
            var sOrderBy2   =   "";
        }

        


        var aParam =    `{"nStart" : "`+(nNewStart - 1)+`", "nRecMax" : "`+nNewLimit+`", "nLimit" : "`+spLimit+`", "nOrderBy1" : "`+nOrderBy1+`", "sOrderBy1" : "`+sOrderBy1+`", "nOrderBy2" : "`+nOrderBy2+`", "sOrderBy2" : "`+sOrderBy2+`"}`;
        
        eval(sCallBack + "(" + aParam + ");");
    },
}