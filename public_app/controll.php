<?php  
/** アプリケーションベースディレクトリ */
define("BASE_DIR", dirname(__FILE__));

if (!defined("PATH_SEPARATOR")) {
    if (strtoupper(substr(PHP_OS, 0, 3)) !== "WIN") {
        define("PATH_SEPARATOR", ":");
    } else {
        define("PATH_SEPARATOR", ";");
    }
}

if (!defined("DIRECTORY_SEPARATOR")) {
    if (OS_WINDOWS) {
        /** directory separator(Windows) */
        define("DIRECTORY_SEPARATOR", "\\");
    } else {
        /** separator(Unix) */
        define("DIRECTORY_SEPARATOR", "/");
    }
}

// サイトファイル絶対パス
define("WWW_DIR",  URL_DIR . DIRECTORY_SEPARATOR);

// 各モジュール
define("BIN_DIR",  BASE_DIR . DIRECTORY_SEPARATOR . "bin" .  DIRECTORY_SEPARATOR);
define("ETC_DIR",  BASE_DIR . DIRECTORY_SEPARATOR . "etc" .  DIRECTORY_SEPARATOR);
define("LIB_DIR",  BASE_DIR . DIRECTORY_SEPARATOR . "lib" .  DIRECTORY_SEPARATOR);
define("LOG_DIR",  BASE_DIR . DIRECTORY_SEPARATOR . "log" .  DIRECTORY_SEPARATOR);
define("MOD_DIR",  BASE_DIR . DIRECTORY_SEPARATOR . "mod" .  DIRECTORY_SEPARATOR);
define("TMP_DIR",  BASE_DIR . DIRECTORY_SEPARATOR . "tmp" .  DIRECTORY_SEPARATOR);
define("HTML_DIR", BASE_DIR . DIRECTORY_SEPARATOR . "html" . DIRECTORY_SEPARATOR);
define("CLI_DIR",  BASE_DIR . DIRECTORY_SEPARATOR . "cli" .  DIRECTORY_SEPARATOR);
define("SAS_DIR",  BASE_DIR . DIRECTORY_SEPARATOR . "sas" .  DIRECTORY_SEPARATOR);
define("MANE_DIR", SAS_DIR  . "manager" . DIRECTORY_SEPARATOR);
define("SKL_DIR",  BASE_DIR . DIRECTORY_SEPARATOR . "skl" .  DIRECTORY_SEPARATOR);
define("DATA_DIR", BASE_DIR . DIRECTORY_SEPARATOR . "data".  DIRECTORY_SEPARATOR);

//SQL関連
define("SQL_TMP_DIR",  TMP_DIR . "sql" . DIRECTORY_SEPARATOR);
define("SQL_DISP_DIR", MANE_DIR);

// 共通テンプレート
define("TPL_DIR", MOD_DIR . "template" . DIRECTORY_SEPARATOR);

// include_pathの設定
$_lib_path = array(LIB_DIR);
$_path_array = explode(PATH_SEPARATOR, ini_get("include_path"));
$include_path = array_diff(array_merge($_path_array, $_lib_path), array("")); // 空削って結合

// set
ini_set("include_path", implode(PATH_SEPARATOR, $include_path));

/** ライブラリのインクルード **/
include_once("Smarty"   . DIRECTORY_SEPARATOR . "Smarty.class.php");

// print_r("Simplan"  . DIRECTORY_SEPARATOR . "Simplan.php");exit;
include_once("Simplan"  . DIRECTORY_SEPARATOR . "Simplan.php");
include_once("Excel"    . DIRECTORY_SEPARATOR . "PHPExcel.php");
include_once("Excel"    . DIRECTORY_SEPARATOR . "PHPExcel/IOFactory.php");


?>