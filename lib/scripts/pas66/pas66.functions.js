/*
Author: Glai Mores
Version: 1.1.0 
Date : 05/03/2016
*/
var mainURL = "http://api.pas66.com/";
var apiURL = "";
var PostCodeFinder = {
    findpostcode: function(authCode, postcode) {
		getAPIURL();
        apiURL= mainURL + "?authCode=" + authCode + "&rqType=findpostcode&postcode=" + postcode;
        return callAPI(apiURL);
    },
    getpostcodes: function(authCode, postcode) {
        apiURL = mainURL + "?authCode=" + authCode + "&rqType=getpostcode&postcode=" + postcode;
        return callAPI(apiURL);
    },
    searchpostcode: function(authCode, postcode) {
        apiURL = mainURL + "?authCode=" + authCode + "&rqType=searchpostcode&postcode=" + postcode; 
        return callAPI(apiURL);
    },
    checkcredit: function(authCode) {
        apiURL = mainURL + "?authCode=" + authCode + "&rqType=checkcredit";
        return callAPI(apiURL);
    }
};
function callAPI(apiURL,methodType) {
    var returnData = "";
    $.ajax({
        //        processData: false,
        async:false,
        type: "GET",
        url: apiURL,
        dataType: "json",
        contentType: "application/json; charset=utf-8",
        success: function(data) {
            returnData =  data;
        },
        error: function(e) {
            
        }
    });
    return returnData;
}

function getAPIURL()
{
	$.ajax({
        async:false,
        type: "GET",
        url: 'lib/scripts/pas66/pas66API.js',
        dataType: "json",
        contentType: "application/json; charset=utf-8",
        success: function(data) {
            returnData =  data;
        },
        error: function(e) {
            
        }
    });
}


