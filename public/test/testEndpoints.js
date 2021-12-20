/**
 * Change 
 * contentType: "application/vnd.api+json",
 * contentType: "application/json",
 * contentType: "application/xml",
 * contentType: "text/csv"
 */


/*********************************mmsi*****************************************/
function getMMSIRestData() {
    var uri = "http://127.0.0.1:8000/mmsi/311486000";
    $.ajax({
        url: uri,
        type: "GET",
        async: false,
        cache: false,
        // dataType: "json",
        contentType: "application/vnd.api+json",
        success: function (data) {
            console.log("Http 200 success at getMMSIRestData");
        },
        error: function (e) {
            console.log("Http error at getMMSIRestData: ", e);
        }
    });
    // console.log("data: " + data);
}

function getMultiMMSIRestData() {
    var url = "http://127.0.0.1:8000/mmsi/";

    $.ajax({
        url: url,
        type: "POST",
        async: false,
        cache: false,
        // contentType: "application/json",
        data: {
            para1: "311040700",
            para2: "311486000",
            para3: "247039300"
        },
        success: function () {
            console.log("Http 200 success at getMultiMMSIRestData");
        },
        error: function (e) {
            console.log("Http error at getMultiMMSIRestData(): ", e);
        }
    });
}

/*********************************timestamp************************************/

function getTimestampRestData() {
    var uri = "http://127.0.0.1:8000/time/1372700580";
    $.ajax({
        url: uri,
        type: "GET",
        async: true,
        cache: false,
        contentType: "application/json",
        success: function (data) {
            console.log("Http 200 success at getTimestampRestData");
        },
        error: function (e) {
            console.log("Http error at getTimestampRestData: ", e);
        }
    });
    // console.log("data: " + data);
}

function getTimeIntervalRestData() {
    var url = "http://127.0.0.1:8000/time/";

    $.ajax({
        url: url,
        type: "POST",
        async: false,
        cache: false,
        // contentType: "application/json",
        data: {
            timeFrom: "1372700340",
            timeTo: "1372700580"
        },
        success: function () {
            console.log("Http 200 success at getTimeIntervalRestData");
        },
        error: function (e) {
            console.log("Http error at getTimeIntervalRestData(): ", e);
        }
    });
}
/*********************************latitude*************************************/
function getLATRestData() {
    var uri = "http://127.0.0.1:8000/lat/42.75178";
    $.ajax({
        url: uri,
        type: "GET",
        async: false,
        cache: false,
        contentType: "application/json",
        success: function (data) {
            console.log("Http 200 success at getLATRestData");
        },
        error: function (e) {
            console.log("Http error at getLATRestData: ", e);
        }
    });
}

/*********************************longitude************************************/
function getLONRestData() {
    var uri = "http://127.0.0.1:8000/lon/11.00047";
    $.ajax({
        url: uri,
        type: "GET",
        async: false,
        cache: false,
        contentType: "application/json",
        success: function (data) {
            console.log("Http 200 success at getLONRestData");
        },
        error: function (e) {
            console.log("Http error at getLONRestData: ", e);
        }
    });
}