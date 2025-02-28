<?php

// コマンドライン処理（タイプ）一覧
define("CIS_CLI_PROCESS_SURVEILLANCE",          "surveillance");
define("CIS_CLI_PROCESS_PRICE_CALCULATION",     "price_calcualtion");
define("CIS_CLI_PROCESS_UPDATE_INVOICE_FLG",    "update_invoice_flg");
define("CIS_CLI_PROCESS_PRICE_CALCULATION_LOG", "price_calcualtion_log");
define("CIS_CLI_PROCESS_TYPE_LIST",
       serialize(array(CIS_CLI_PROCESS_SURVEILLANCE          => "CLI監視",
                       CIS_CLI_PROCESS_PRICE_CALCULATION     => "料金計算",
                       CIS_CLI_PROCESS_UPDATE_INVOICE_FLG    => "請求書フラグ更新",
                       CIS_CLI_PROCESS_PRICE_CALCULATION_LOG => "料金計算ログ",
                       )));


// 確定値XMLの時間データカラム名
define("FIX_VALUE_XML_COLUMN_NAME_0000", "0");
define("FIX_VALUE_XML_COLUMN_NAME_0030", "1");
define("FIX_VALUE_XML_COLUMN_NAME_0100", "2");
define("FIX_VALUE_XML_COLUMN_NAME_0130", "3");
define("FIX_VALUE_XML_COLUMN_NAME_0200", "4");
define("FIX_VALUE_XML_COLUMN_NAME_0230", "5");
define("FIX_VALUE_XML_COLUMN_NAME_0300", "6");
define("FIX_VALUE_XML_COLUMN_NAME_0330", "7");
define("FIX_VALUE_XML_COLUMN_NAME_0400", "8");
define("FIX_VALUE_XML_COLUMN_NAME_0430", "9");
define("FIX_VALUE_XML_COLUMN_NAME_0500", "10");
define("FIX_VALUE_XML_COLUMN_NAME_0530", "11");
define("FIX_VALUE_XML_COLUMN_NAME_0600", "12");
define("FIX_VALUE_XML_COLUMN_NAME_0630", "13");
define("FIX_VALUE_XML_COLUMN_NAME_0700", "14");
define("FIX_VALUE_XML_COLUMN_NAME_0730", "15");
define("FIX_VALUE_XML_COLUMN_NAME_0800", "16");
define("FIX_VALUE_XML_COLUMN_NAME_0830", "17");
define("FIX_VALUE_XML_COLUMN_NAME_0900", "18");
define("FIX_VALUE_XML_COLUMN_NAME_0930", "19");
define("FIX_VALUE_XML_COLUMN_NAME_1000", "20");
define("FIX_VALUE_XML_COLUMN_NAME_1030", "21");
define("FIX_VALUE_XML_COLUMN_NAME_1100", "22");
define("FIX_VALUE_XML_COLUMN_NAME_1130", "23");
define("FIX_VALUE_XML_COLUMN_NAME_1200", "24");
define("FIX_VALUE_XML_COLUMN_NAME_1230", "25");
define("FIX_VALUE_XML_COLUMN_NAME_1300", "26");
define("FIX_VALUE_XML_COLUMN_NAME_1330", "27");
define("FIX_VALUE_XML_COLUMN_NAME_1400", "28");
define("FIX_VALUE_XML_COLUMN_NAME_1430", "29");
define("FIX_VALUE_XML_COLUMN_NAME_1500", "30");
define("FIX_VALUE_XML_COLUMN_NAME_1530", "31");
define("FIX_VALUE_XML_COLUMN_NAME_1600", "32");
define("FIX_VALUE_XML_COLUMN_NAME_1630", "33");
define("FIX_VALUE_XML_COLUMN_NAME_1700", "34");
define("FIX_VALUE_XML_COLUMN_NAME_1730", "35");
define("FIX_VALUE_XML_COLUMN_NAME_1800", "36");
define("FIX_VALUE_XML_COLUMN_NAME_1830", "37");
define("FIX_VALUE_XML_COLUMN_NAME_1900", "38");
define("FIX_VALUE_XML_COLUMN_NAME_1930", "39");
define("FIX_VALUE_XML_COLUMN_NAME_2000", "40");
define("FIX_VALUE_XML_COLUMN_NAME_2030", "41");
define("FIX_VALUE_XML_COLUMN_NAME_2100", "42");
define("FIX_VALUE_XML_COLUMN_NAME_2130", "43");
define("FIX_VALUE_XML_COLUMN_NAME_2200", "44");
define("FIX_VALUE_XML_COLUMN_NAME_2230", "45");
define("FIX_VALUE_XML_COLUMN_NAME_2300", "46");
define("FIX_VALUE_XML_COLUMN_NAME_2330", "47");
define("FIX_VALUE_XML_COLUMN_NAME_LIST",
       serialize(array(FIX_VALUE_XML_COLUMN_NAME_0000 => "0000",
                       FIX_VALUE_XML_COLUMN_NAME_0030 => "0030",
                       FIX_VALUE_XML_COLUMN_NAME_0100 => "0100",
                       FIX_VALUE_XML_COLUMN_NAME_0130 => "0130",
                       FIX_VALUE_XML_COLUMN_NAME_0200 => "0200",
                       FIX_VALUE_XML_COLUMN_NAME_0230 => "0230",
                       FIX_VALUE_XML_COLUMN_NAME_0300 => "0300",
                       FIX_VALUE_XML_COLUMN_NAME_0330 => "0330",
                       FIX_VALUE_XML_COLUMN_NAME_0400 => "0400",
                       FIX_VALUE_XML_COLUMN_NAME_0430 => "0430",
                       FIX_VALUE_XML_COLUMN_NAME_0500 => "0500",
                       FIX_VALUE_XML_COLUMN_NAME_0530 => "0530",
                       FIX_VALUE_XML_COLUMN_NAME_0600 => "0600",
                       FIX_VALUE_XML_COLUMN_NAME_0630 => "0630",
                       FIX_VALUE_XML_COLUMN_NAME_0700 => "0700",
                       FIX_VALUE_XML_COLUMN_NAME_0730 => "0730",
                       FIX_VALUE_XML_COLUMN_NAME_0800 => "0800",
                       FIX_VALUE_XML_COLUMN_NAME_0830 => "0830",
                       FIX_VALUE_XML_COLUMN_NAME_0900 => "0900",
                       FIX_VALUE_XML_COLUMN_NAME_0930 => "0930",
                       FIX_VALUE_XML_COLUMN_NAME_1000 => "1000",
                       FIX_VALUE_XML_COLUMN_NAME_1030 => "1030",
                       FIX_VALUE_XML_COLUMN_NAME_1100 => "1100",
                       FIX_VALUE_XML_COLUMN_NAME_1130 => "1130",
                       FIX_VALUE_XML_COLUMN_NAME_1200 => "1200",
                       FIX_VALUE_XML_COLUMN_NAME_1230 => "1230",
                       FIX_VALUE_XML_COLUMN_NAME_1300 => "1300",
                       FIX_VALUE_XML_COLUMN_NAME_1330 => "1330",
                       FIX_VALUE_XML_COLUMN_NAME_1400 => "1400",
                       FIX_VALUE_XML_COLUMN_NAME_1430 => "1430",
                       FIX_VALUE_XML_COLUMN_NAME_1500 => "1500",
                       FIX_VALUE_XML_COLUMN_NAME_1530 => "1530",
                       FIX_VALUE_XML_COLUMN_NAME_1600 => "1600",
                       FIX_VALUE_XML_COLUMN_NAME_1630 => "1630",
                       FIX_VALUE_XML_COLUMN_NAME_1700 => "1700",
                       FIX_VALUE_XML_COLUMN_NAME_1730 => "1730",
                       FIX_VALUE_XML_COLUMN_NAME_1800 => "1800",
                       FIX_VALUE_XML_COLUMN_NAME_1830 => "1830",
                       FIX_VALUE_XML_COLUMN_NAME_1900 => "1900",
                       FIX_VALUE_XML_COLUMN_NAME_1930 => "1930",
                       FIX_VALUE_XML_COLUMN_NAME_2000 => "2000",
                       FIX_VALUE_XML_COLUMN_NAME_2030 => "2030",
                       FIX_VALUE_XML_COLUMN_NAME_2100 => "2100",
                       FIX_VALUE_XML_COLUMN_NAME_2130 => "2130",
                       FIX_VALUE_XML_COLUMN_NAME_2200 => "2200",
                       FIX_VALUE_XML_COLUMN_NAME_2230 => "2230",
                       FIX_VALUE_XML_COLUMN_NAME_2300 => "2300",
                       FIX_VALUE_XML_COLUMN_NAME_2330 => "2330",
                       )));

// 速報値XMLの時間データカラム名
define("QUICK_VALUE_XML_COLUMN_NAME_0000", "01");
define("QUICK_VALUE_XML_COLUMN_NAME_0030", "02");
define("QUICK_VALUE_XML_COLUMN_NAME_0100", "03");
define("QUICK_VALUE_XML_COLUMN_NAME_0130", "04");
define("QUICK_VALUE_XML_COLUMN_NAME_0200", "05");
define("QUICK_VALUE_XML_COLUMN_NAME_0230", "06");
define("QUICK_VALUE_XML_COLUMN_NAME_0300", "07");
define("QUICK_VALUE_XML_COLUMN_NAME_0330", "08");
define("QUICK_VALUE_XML_COLUMN_NAME_0400", "09");
define("QUICK_VALUE_XML_COLUMN_NAME_0430", "10");
define("QUICK_VALUE_XML_COLUMN_NAME_0500", "11");
define("QUICK_VALUE_XML_COLUMN_NAME_0530", "12");
define("QUICK_VALUE_XML_COLUMN_NAME_0600", "13");
define("QUICK_VALUE_XML_COLUMN_NAME_0630", "14");
define("QUICK_VALUE_XML_COLUMN_NAME_0700", "15");
define("QUICK_VALUE_XML_COLUMN_NAME_0730", "16");
define("QUICK_VALUE_XML_COLUMN_NAME_0800", "17");
define("QUICK_VALUE_XML_COLUMN_NAME_0830", "18");
define("QUICK_VALUE_XML_COLUMN_NAME_0900", "19");
define("QUICK_VALUE_XML_COLUMN_NAME_0930", "20");
define("QUICK_VALUE_XML_COLUMN_NAME_1000", "21");
define("QUICK_VALUE_XML_COLUMN_NAME_1030", "22");
define("QUICK_VALUE_XML_COLUMN_NAME_1100", "23");
define("QUICK_VALUE_XML_COLUMN_NAME_1130", "24");
define("QUICK_VALUE_XML_COLUMN_NAME_1200", "25");
define("QUICK_VALUE_XML_COLUMN_NAME_1230", "26");
define("QUICK_VALUE_XML_COLUMN_NAME_1300", "27");
define("QUICK_VALUE_XML_COLUMN_NAME_1330", "28");
define("QUICK_VALUE_XML_COLUMN_NAME_1400", "29");
define("QUICK_VALUE_XML_COLUMN_NAME_1430", "30");
define("QUICK_VALUE_XML_COLUMN_NAME_1500", "31");
define("QUICK_VALUE_XML_COLUMN_NAME_1530", "32");
define("QUICK_VALUE_XML_COLUMN_NAME_1600", "33");
define("QUICK_VALUE_XML_COLUMN_NAME_1630", "34");
define("QUICK_VALUE_XML_COLUMN_NAME_1700", "35");
define("QUICK_VALUE_XML_COLUMN_NAME_1730", "36");
define("QUICK_VALUE_XML_COLUMN_NAME_1800", "37");
define("QUICK_VALUE_XML_COLUMN_NAME_1830", "38");
define("QUICK_VALUE_XML_COLUMN_NAME_1900", "39");
define("QUICK_VALUE_XML_COLUMN_NAME_1930", "40");
define("QUICK_VALUE_XML_COLUMN_NAME_2000", "41");
define("QUICK_VALUE_XML_COLUMN_NAME_2030", "42");
define("QUICK_VALUE_XML_COLUMN_NAME_2100", "43");
define("QUICK_VALUE_XML_COLUMN_NAME_2130", "44");
define("QUICK_VALUE_XML_COLUMN_NAME_2200", "45");
define("QUICK_VALUE_XML_COLUMN_NAME_2230", "46");
define("QUICK_VALUE_XML_COLUMN_NAME_2300", "47");
define("QUICK_VALUE_XML_COLUMN_NAME_2330", "48");
define("QUICK_VALUE_XML_COLUMN_NAME_LIST",
       serialize(array(QUICK_VALUE_XML_COLUMN_NAME_0000 => "0000",
                       QUICK_VALUE_XML_COLUMN_NAME_0030 => "0030",
                       QUICK_VALUE_XML_COLUMN_NAME_0100 => "0100",
                       QUICK_VALUE_XML_COLUMN_NAME_0130 => "0130",
                       QUICK_VALUE_XML_COLUMN_NAME_0200 => "0200",
                       QUICK_VALUE_XML_COLUMN_NAME_0230 => "0230",
                       QUICK_VALUE_XML_COLUMN_NAME_0300 => "0300",
                       QUICK_VALUE_XML_COLUMN_NAME_0330 => "0330",
                       QUICK_VALUE_XML_COLUMN_NAME_0400 => "0400",
                       QUICK_VALUE_XML_COLUMN_NAME_0430 => "0430",
                       QUICK_VALUE_XML_COLUMN_NAME_0500 => "0500",
                       QUICK_VALUE_XML_COLUMN_NAME_0530 => "0530",
                       QUICK_VALUE_XML_COLUMN_NAME_0600 => "0600",
                       QUICK_VALUE_XML_COLUMN_NAME_0630 => "0630",
                       QUICK_VALUE_XML_COLUMN_NAME_0700 => "0700",
                       QUICK_VALUE_XML_COLUMN_NAME_0730 => "0730",
                       QUICK_VALUE_XML_COLUMN_NAME_0800 => "0800",
                       QUICK_VALUE_XML_COLUMN_NAME_0830 => "0830",
                       QUICK_VALUE_XML_COLUMN_NAME_0900 => "0900",
                       QUICK_VALUE_XML_COLUMN_NAME_0930 => "0930",
                       QUICK_VALUE_XML_COLUMN_NAME_1000 => "1000",
                       QUICK_VALUE_XML_COLUMN_NAME_1030 => "1030",
                       QUICK_VALUE_XML_COLUMN_NAME_1100 => "1100",
                       QUICK_VALUE_XML_COLUMN_NAME_1130 => "1130",
                       QUICK_VALUE_XML_COLUMN_NAME_1200 => "1200",
                       QUICK_VALUE_XML_COLUMN_NAME_1230 => "1230",
                       QUICK_VALUE_XML_COLUMN_NAME_1300 => "1300",
                       QUICK_VALUE_XML_COLUMN_NAME_1330 => "1330",
                       QUICK_VALUE_XML_COLUMN_NAME_1400 => "1400",
                       QUICK_VALUE_XML_COLUMN_NAME_1430 => "1430",
                       QUICK_VALUE_XML_COLUMN_NAME_1500 => "1500",
                       QUICK_VALUE_XML_COLUMN_NAME_1530 => "1530",
                       QUICK_VALUE_XML_COLUMN_NAME_1600 => "1600",
                       QUICK_VALUE_XML_COLUMN_NAME_1630 => "1630",
                       QUICK_VALUE_XML_COLUMN_NAME_1700 => "1700",
                       QUICK_VALUE_XML_COLUMN_NAME_1730 => "1730",
                       QUICK_VALUE_XML_COLUMN_NAME_1800 => "1800",
                       QUICK_VALUE_XML_COLUMN_NAME_1830 => "1830",
                       QUICK_VALUE_XML_COLUMN_NAME_1900 => "1900",
                       QUICK_VALUE_XML_COLUMN_NAME_1930 => "1930",
                       QUICK_VALUE_XML_COLUMN_NAME_2000 => "2000",
                       QUICK_VALUE_XML_COLUMN_NAME_2030 => "2030",
                       QUICK_VALUE_XML_COLUMN_NAME_2100 => "2100",
                       QUICK_VALUE_XML_COLUMN_NAME_2130 => "2130",
                       QUICK_VALUE_XML_COLUMN_NAME_2200 => "2200",
                       QUICK_VALUE_XML_COLUMN_NAME_2230 => "2230",
                       QUICK_VALUE_XML_COLUMN_NAME_2300 => "2300",
                       QUICK_VALUE_XML_COLUMN_NAME_2330 => "2330",
                       )));

// 電力メッセージ情報コード
define("QUICK_VALUE_HIGH_INFORMATION_CODE",   "0110");
define("QUICK_VALUE_LOW_INFORMATION_CODE",    "1110");
define("DAILY_VALUE_HIGH_INFORMATION_CODE",   "0120");
define("DAILY_VALUE_LOW_INFORMATION_CODE",    "1120");
define("MONTHLY_VALUE_HIGH_INFORMATION_CODE", "1210");
define("MONTHLY_VALUE_LOW_INFORMATION_CODE",  "1220");
define("POWER_VALUE_INFORMATION_CODE_LIST",
       serialize(array(QUICK_VALUE_HIGH_INFORMATION_CODE   => "特高・高圧30分電力量メッセージ",
                       QUICK_VALUE_LOW_INFORMATION_CODE    => "低圧30分電力量メッセージ",
                       DAILY_VALUE_HIGH_INFORMATION_CODE   => "特高・高圧日毎30分電力量メッセージ",
                       DAILY_VALUE_LOW_INFORMATION_CODE    => "低圧日毎30分電力量メッセージ",
                       MONTHLY_VALUE_HIGH_INFORMATION_CODE => "特高・高圧月間確定使用量メッセージ",
                       MONTHLY_VALUE_LOW_INFORMATION_CODE  => "低圧月間確定使用量メッセージ",
                       )));

// 提供可否コード
define("OFFER_PROPRIETY_CODE_OK", "0");
define("OFFER_PROPRIETY_CODE_NG", "1");
define("OFFER_PROPRIETY_CODE_LIST",
       serialize(array(OFFER_PROPRIETY_CODE_OK => "可",
                       OFFER_PROPRIETY_CODE_NG => "否",
                       )));

// 更新コード
define("UPDATE_CODE_OFF", "0");
define("UPDATE_CODE_ON", "1");
define("UPDATE_CODE_LIST",
       serialize(array(UPDATE_CODE_OFF => "新規データ",
                       UPDATE_CODE_ON  => "更新データ",
                       )));

?>