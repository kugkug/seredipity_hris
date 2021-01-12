
    function removeHighlight() {
        $('span.highlight').contents().unwrap();
    };

    function highlightTextInTable($tableElements, searchText) {
        // highlights if text found (during typing)
        var matched = false;
        //remove spans
        removeHighlight();

        $.each($tableElements, function (index, item) {

            var $el         = $(item);

            var sTdText     = $el.text();
            var sSearchText = searchText.toLowerCase();
            var nTdTxtLen   = sTdText.length;  
            var nSrchTxtLen = sSearchText.length;



            var nSrchTxtPosi=   sTdText.toLowerCase().indexOf(sSearchText);

            if (nSrchTxtPosi > -1)
            {
                var sNewText    =   "";

                // if (nSrchTxtLen > nSrchTxtPosi)
                // {
                //     var nStart  =   nSrchTxtPosi;
                //     var nEnd    =   nSrchTxtLen;
                // }
                // else
                // {
                    var nStart  =   nSrchTxtPosi;
                    var nEnd    =   parseInt(nSrchTxtLen) + parseInt(nSrchTxtPosi);
                // }

                var sChoseChars =   sTdText.substring(nStart, nEnd);
                var sHighLight  =   "<span class='highlight'>"+sChoseChars+"</span>";

                // console.log("START : " + nStart + "\nEND : " + nEnd);
                // console.log(("Jesthony Morales").substring(1, 4));

                // console.log("TD TEXT : "+sTdText + "\nSEARCH : " + sSearchText + "\n nSrchTxtLen :"+nSrchTxtLen + "\n nSrchTxtPosi : " +nSrchTxtPosi +"\nNEWTEXT : "+ sHighLight + "\n\n");


                
                for(var x = 0; x < nTdTxtLen; x++) {

                    if (x == nStart) {
                        sNewText += sHighLight;
                    } 
                    else  {

                        if (x < nStart || x > nEnd - 1) {
                            
                            sNewText += sTdText[x];
                        } 
                    }
                }
                $el.html(sNewText);
            }
        });
    }
