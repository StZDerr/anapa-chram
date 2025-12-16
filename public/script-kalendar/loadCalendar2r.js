var xmlHttp;
function loadCalendar2r(mm, dd, yy, dt, hh, ll, tt, ss) {
    xmlHttp = null;
    if (window.XMLHttpRequest) {
        // code for Firefox, Opera, IE7, etc.
        xmlHttp = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        // code for IE6, IE5
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    if (xmlHttp != null) {
        var par = "/script-kalendar/pppr.php";
        par =
            par +
            "?month=" +
            mm +
            "&today=" +
            dd +
            "&year=" +
            yy +
            "&dt=" +
            dt +
            "&header=" +
            hh +
            "&lives=" +
            ll +
            "&trp=" +
            tt +
            "&scripture=" +
            ss;
        par = par + "&sid=" + Math.random();

        xmlHttp.onreadystatechange = stateChanged2r;

        xmlHttp.open("GET", par, true);
        xmlHttp.send(null);
    } else {
        alert("Your browser does not support XMLHTTP.");
    }
}

function stateChanged2r() {
    if (xmlHttp.readyState == 4) {
        // 4 = "loaded"
        if (xmlHttp.status == 200) {
            // 200 = "OK"
            document.getElementById("T1R").innerHTML = xmlHttp.responseText;
        } else {
            alert("Problem retrieving data: " + xmlHttp.statusText);
        }
    }
}
