var date = new Date();
var timestamp = date.getTime();

function getAddress(action, prc, zip1, zip2, f_pref, f_town) {

    var val1 = zip1.replace(/^\s+|\s+$/g, "");
    var val2 = zip2.replace(/^\s+|\s+$/g, "");
    var zip  = zip1 + "-" + zip2;
    var chk = zip.match(/^\d{3}-\d{4}$/);

    if (zip.length != 8 || !chk) {
        return;
    }

    var xhr = newXMLHttpRequest();
    if (!xhr) return false;

    var cmd = "";
    var url = action + '?time=' + timestamp + '&prc=' + prc + '&cmd=' + cmd + '&sid=' + escape(zip);
    
    xhr.open('GET', url, true);
    xhr.onreadystatechange = function () {
        handle_setAddress(xhr, f_pref, f_town);
    };
    xhr.send(null);
    return true;

}

function handle_setAddress(xhr, f_pref, f_town)
{
    if (xhr.readyState == 4 && xhr.status == 200) {

        var data = eval("(" + xhr.responseText + ")");

        if (!data.f_prefecture_id || !data.f_town) {
            document.mainfrm.elements[f_pref].value = "";
            document.mainfrm.elements[f_town].value = "";
            return;
        }
        if (data.f_prefecture_id.length > 0 && data.f_town.length > 0) {
            document.mainfrm.elements[f_pref].value = data.f_prefecture_id;
            document.mainfrm.elements[f_town].value = data.f_town;
        }
    }
}

function get_lab(action, prc, val, f_online_date, f_online_date_cap) {

    if (val.length <= 0) {
        document.getElementById(f_online_date_cap).innerHTML = "";
        document.mainfrm.elements[f_online_date + "_y"].value = "";
        document.mainfrm.elements[f_online_date + "_m"].value = "";
        document.mainfrm.elements[f_online_date + "_d"].value = "";
        return;
    }
    var xhr = newXMLHttpRequest();
    if (!xhr) return false;

    var cmd = "";
    var url = action + '?time=' + timestamp + '&prc=' + prc + '&cmd=' + cmd + '&sid=' + escape(val);
    xhr.open('GET', url, true);
    xhr.onreadystatechange = function () {
        handle_set_lab_info(xhr, f_online_date, f_online_date_cap);
    };
    xhr.send(null);
    return true;

}

function handle_set_lab_info(xhr, f_online_date, f_online_date_cap)
{
    if (xhr.readyState == 4 && xhr.status == 200) {
        var data = eval("(" + xhr.responseText + ")");
        if (data.f_online_date_wareki && data.f_online_date_wareki.length > 0) {
            document.getElementById(f_online_date_cap).innerHTML = data.f_online_date_wareki;
            document.mainfrm.elements[f_online_date + "_y"].value = data.f_online_date_y;
            document.mainfrm.elements[f_online_date + "_m"].value = data.f_online_date_m;
            document.mainfrm.elements[f_online_date + "_d"].value = data.f_online_date_d;
        }
    }
}

function get_emp(action, prc, val, f_cellular, f_cellular_cap) {

    if (val.length <= 0) {
        document.getElementById(f_cellular_cap).innerHTML = "";
        document.mainfrm.elements[f_cellular].value = "";
        return;
    }
    var xhr = newXMLHttpRequest();
    if (!xhr) return false;

    var cmd = "";
    var url = action + '?time=' + timestamp + '&prc=' + prc + '&cmd=' + cmd + '&sid=' + escape(val);
    xhr.open('GET', url, true);
    xhr.onreadystatechange = function () {
        handle_set_emp_info(xhr, f_cellular, f_cellular_cap);
    };
    xhr.send(null);
    return true;

}

function handle_set_emp_info(xhr, f_cellular, f_cellular_cap)
{
    if (xhr.readyState == 4 && xhr.status == 200) {
        var data = eval("(" + xhr.responseText + ")");
        if (data.f_cellular && data.f_cellular.length > 0) {
            document.getElementById(f_cellular_cap).innerHTML = data.f_cellular;
            document.mainfrm.elements[f_cellular].value = data.f_cellular;
        }
    }
}

function get_rep_emp(action, prc, val, f_tel, f_fax) {

    if (val.length <= 0) {
        document.mainfrm.elements[f_tel].value = "";
        document.mainfrm.elements[f_fax].value = "";
        return;
    }
    var xhr = newXMLHttpRequest();
    if (!xhr) return false;

    var cmd = "";
    var url = action + '?time=' + timestamp + '&prc=' + prc + '&cmd=' + cmd + '&sid=' + escape(val);
    xhr.open('GET', url, true);
    xhr.onreadystatechange = function () {
        handle_set_rep_emp_info(xhr, f_tel, f_fax);
    };
    xhr.send(null);
    return true;

}

function handle_set_rep_emp_info(xhr, f_tel, f_fax)
{
    if (xhr.readyState == 4 && xhr.status == 200) {
        var data = eval("(" + xhr.responseText + ")");
        if (data.f_tel && data.f_tel.length > 0) {
            document.mainfrm.elements[f_tel].value = data.f_tel;
        }
        if (data.f_fax && data.f_fax.length > 0) {
            document.mainfrm.elements[f_fax].value = data.f_fax;
        }
    }
}

function get_bank(action, prc, val, f_tel) {

    if (val.length <= 0) {
        document.mainfrm.elements[f_tel].value = "";
        return;
    }
    var xhr = newXMLHttpRequest();
    if (!xhr) return false;

    var cmd = "";
    var url = action + '?time=' + timestamp + '&prc=' + prc + '&cmd=' + cmd + '&sid=' + escape(val);
    xhr.open('GET', url, true);
    xhr.onreadystatechange = function () {
        handle_set_bank_info(xhr, f_tel);
    };
    xhr.send(null);
    return true;

}

function handle_set_bank_info(xhr, f_tel)
{
    if (xhr.readyState == 4 && xhr.status == 200) {
        var data = eval("(" + xhr.responseText + ")");
        if (data.f_tel && data.f_tel.length > 0) {
            document.mainfrm.elements[f_tel].value = data.f_tel;
        }
    }
}

function get_bank_bu(action, prc, val, f_tel, f_fax) {

    if (val.length <= 0) {
        document.mainfrm.elements[f_tel].value = "";
        document.mainfrm.elements[f_fax].value = "";
        return;
    }
    var xhr = newXMLHttpRequest();
    if (!xhr) return false;

    var cmd = "";
    var url = action + '?time=' + timestamp + '&prc=' + prc + '&cmd=' + cmd + '&sid=' + escape(val);
    xhr.open('GET', url, true);
    xhr.onreadystatechange = function () {
        handle_set_bank_bu_info(xhr, f_tel, f_fax);
    };
    xhr.send(null);
    return true;

}

function handle_set_bank_bu_info(xhr, f_tel, f_fax)
{
    if (xhr.readyState == 4 && xhr.status == 200) {
        var data = eval("(" + xhr.responseText + ")");
        if (data.f_fax && data.f_fax.length > 0) {
            document.mainfrm.elements[f_tel].value = data.f_tel;
            document.mainfrm.elements[f_fax].value = data.f_fax;
        }
    }
}

function get_shop(action, prc, val, f_tel) {

    if (val.length <= 0) {
        document.mainfrm.elements[f_tel+"_1"].value = "";
        document.mainfrm.elements[f_tel+"_2"].value = "";
        document.mainfrm.elements[f_tel+"_3"].value = "";
        return;
    }
    var xhr = newXMLHttpRequest();
    if (!xhr) return false;

    var cmd = "";
    var url = action + '?time=' + timestamp + '&prc=' + prc + '&cmd=' + cmd + '&sid=' + escape(val);
    xhr.open('GET', url, true);
    xhr.onreadystatechange = function () {
        handle_set_shop_info(xhr, f_tel);
    };
    xhr.send(null);
    return true;

}

function handle_set_shop_info(xhr, f_tel)
{
    if (xhr.readyState == 4 && xhr.status == 200) {
        var data = eval("(" + xhr.responseText + ")");
        if (data.f_tel && data.f_tel.length > 0) {
            document.mainfrm.elements[f_tel+"_1"].value = data.f_tel_1;
            document.mainfrm.elements[f_tel+"_2"].value = data.f_tel_2;
            document.mainfrm.elements[f_tel+"_3"].value = data.f_tel_3;
        }
    }
}

function get_item_shop(action, prc, val, f_tel, f_tel_cap, f_fax, f_fax_cap) {

    if (val.length <= 0) {
        document.getElementById(f_tel_cap).innerHTML = "";
        document.getElementById(f_fax_cap).innerHTML = "";
        document.mainfrm.elements[f_tel].value = "";
        document.mainfrm.elements[f_fax].value = "";
        return;
    }
    var xhr = newXMLHttpRequest();
    if (!xhr) return false;

    var cmd = "";
    var url = action + '?time=' + timestamp + '&prc=' + prc + '&cmd=' + cmd + '&sid=' + escape(val);
    xhr.open('GET', url, true);
    xhr.onreadystatechange = function () {
        handle_set_item_shop_info(xhr, f_tel, f_tel_cap, f_fax, f_fax_cap);
    };
    xhr.send(null);
    return true;

}

function handle_set_item_shop_info(xhr, f_tel, f_tel_cap, f_fax, f_fax_cap)
{
    if (xhr.readyState == 4 && xhr.status == 200) {
        var data = eval("(" + xhr.responseText + ")");
        if (data.f_tel && data.f_tel.length > 0) {
            document.getElementById(f_tel_cap).innerHTML = data.f_tel;
            document.mainfrm.elements[f_tel].value = data.f_tel;
        }
        if (data.f_fax && data.f_fax.length > 0) {
            document.getElementById(f_fax_cap).innerHTML = data.f_fax;
            document.mainfrm.elements[f_fax].value = data.f_fax;
        }
    }
}