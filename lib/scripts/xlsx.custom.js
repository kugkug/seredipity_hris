function to_json(workbook) {
    var result = {};

    workbook.SheetNames.forEach(function (sheetName) {
        var roa = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
        if (roa.length > 0) {
            result[sheetName] = roa;
        }
    });

    return result;
}

function process_wb(wb, format) {
    var output = "";
    switch (format) {
        case "json":
            output = to_json(wb); // JSON.stringify(to_json(wb), 2, 2);
            break;
        case "form":
            output = to_formulae(wb);
            break;
        case "header":
            output = get_header_row(wb);
            break;
        default:
            output = to_csv(wb);
            break;
    }
    return output;
}

function get_header_row(workbook) {
    var result = [];
    var sheet = "";

    for(var sheetName in workbook.Sheets) {
        sheet = workbook.Sheets[sheetName];
        var headers = {};
        var range = XLSX.utils.decode_range(sheet['!ref']);
        var C, R = range.s.r; /* start in the first row */

        for(C = range.s.c; C <= range.e.c; ++C) {
            var cellLoc = XLSX.utils.encode_cell({c:C, r:R});
            var cell = sheet[cellLoc] /* find the cell in the first row */
            hdr = (cell && cell.t) ? XLSX.utils.format_cell(cell) : "";
            headers[cellLoc.replace(/\d/g, "")] = hdr;
        }

        result[sheetName] = headers;
        headers = {};
    }

    return result;
}