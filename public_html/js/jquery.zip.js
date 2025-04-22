var datetime = new Date().getTime();
$(function() {
    // 郵便番号検索ボタンクリック
    $(".zip_button").click(function() {
        var id = $(this).attr("id");
        var zip1 = $("#f_" + id + "zip_cd1").val();
        var zip2 = $("#f_" + id + "zip_cd2").val();
        if (zip1 == "" || zip2 == "") {
            return;
        }
        $.getJSON(
            "ajax.php",
            {"prc": "zip", "zip1": zip1, "zip2": zip2},
            function(data) {
                $("#f_" + id + "prefecture_id").val(data["f_prefecture_id"]);
                $("#f_" + id + "address1").val(data["f_address1"]);
            }
        );
    });

    // 郵便番号検索ボタンクリック
    $(".yubin_no_button").click(function() {
        var id = $(this).attr("id");
        var zip1 = $("#f_" + id + "yubin_no1").val();
        var zip2 = $("#f_" + id + "yubin_no2").val();
        if (zip1 == "" || zip2 == "") {
            return;
        }
        $.getJSON(
            "ajax.php",
            {"prc": "zip", "zip1": zip1, "zip2": zip2},
            function(data) {
                $("#f_" + id + "prefecture_id").val(data["f_prefecture_id"]);
                $("#f_" + id + "jusho1").val(data["f_address1"]);
            }
        );
    });

    // 郵便番号検索ボタンクリック【ハイフンなし】
    $(".zip_no_hypen_button").click(function() {
        var id = $(this).attr("id");
        var zip = $("#f_" + id + "zip_cd").val();
        if (zip == "") {
            return;
        }
        $.getJSON(
            "ajax.php",
            {"prc": "zip", "cmd": "no_hypen", "zip": zip},
            function(data) {
                $("#f_" + id + "prefecture_id").val(data["f_prefecture_id"]);
                $("#f_" + id + "address1").val(data["f_address1"]);
            }
        );
    });

    // 郵便番号検索ボタンクリック【ハイフンなし】
    $(".yubin_no_hyphen_button").click(function() {
        var id = $(this).attr("id");
        var zip = $("#f_" + id + "yubin_no").val();
        if (zip == "") {
            return;
        }
        $.getJSON(
            "ajax.php",
            {"prc": "zip", "cmd": "no_hypen", "zip": zip},
            function(data) {
                $("#f_" + id + "prefecture_id").val(data["f_prefecture_id"]);
                $("#f_" + id + "jusho1").val(data["f_address1"]);
            }
        );
    });
});