<?php

// define
define("COM_DIR", MOD_DIR . "common/");
define("FW_DIR", LIB_DIR . "Simplan/");

/*----------------------------------------*
 * include
 *----------------------------------------*/
include_once(COM_DIR . "userProcess.php");
include_once(COM_DIR . "userErrorPage.php");     // エラー画面生成ファイル
include_once(COM_DIR . "commonTypes.php");        // 共通定義ファイル
include_once(COM_DIR . "csvDefine.php");
include_once(COM_DIR . "MasterCommand.php");
include_once(COM_DIR . "CommonCommand.php");
include_once(COM_DIR . "StretchedPassword.php");
include_once(COM_DIR . "OnetimeTicket.php");
include_once(COM_DIR . "operateJpeg.php");
include_once(COM_DIR . "vitalInfoExcel.php");
include_once(FW_DIR  . "class/FormCheckEx.php");



/*----------------------------------------*
 * define
 *----------------------------------------*/

//*** DISP TYPE ***//
define("DISP_TYPE_NEW",    "new");
define("DISP_TYPE_EDIT",   "edit");
define("DISP_TYPE_DEL",    "del");
define("DISP_TYPE_DETAIL", "detail");
define("DISP_TYPE_CSV",    "csv");
define("DISP_TYPE_LIST",   "list");

//*** SESSION NAME ***//
// session name
define("USER_SESSION", "sample_UserSession");

// ワンタイムチケット
define("ONETIME_TICKET_SESSION", USER_SESSION . "OnetimeTicket");

// ログイン・トップ管理
define("USER_INDEX_SESSION", USER_SESSION . "Index");

// PASS CHANGE
define("USER_PASSCHANGE_SESSION", USER_SESSION . "PassChange");

// Normal
define("USER_NORMAL_LIST_SESSION", USER_SESSION . "NormalList");
define("USER_NORMAL_NEW_SESSION",  USER_SESSION . "NormalNew");
define("USER_NORMAL_EDIT_SESSION", USER_SESSION . "NormalEdit");
define("USER_NORMAL_DEL_SESSION",  USER_SESSION . "NormalDel");

// 画像
define("USER_IMAGE_ONE_LIST_SESSION", USER_SESSION . "ImageOneList");
define("USER_IMAGE_ONE_NEW_SESSION",  USER_SESSION . "ImageOneNew");
define("USER_IMAGE_ONE_EDIT_SESSION", USER_SESSION . "ImageOneEdit");
define("USER_IMAGE_ONE_DEL_SESSION",  USER_SESSION . "ImageOneDel");

// 画像
define("USER_IMAGE_MUL_LIST_SESSION", USER_SESSION . "ImageMulList");
define("USER_IMAGE_MUL_NEW_SESSION",  USER_SESSION . "ImageMulNew");
define("USER_IMAGE_MUL_EDIT_SESSION", USER_SESSION . "ImageMulEdit");
define("USER_IMAGE_MUL_DEL_SESSION",  USER_SESSION . "ImageMulDel");

// Files
define("USER_FILES_LIST_SESSION", USER_SESSION . "FilesList");
define("USER_FILES_NEW_SESSION",  USER_SESSION . "FilesNew");
define("USER_FILES_EDIT_SESSION", USER_SESSION . "FilesEdit");
define("USER_FILES_DEL_SESSION",  USER_SESSION . "FilesDel");

// Customer
define("USER_CUSTOMER_LIST_SESSION",   USER_SESSION . "CustomerList");
define("USER_CUSTOMER_NEW_SESSION",    USER_SESSION . "CustomerNew");
define("USER_CUSTOMER_EDIT_SESSION",   USER_SESSION . "CustomerEdit");
define("USER_CUSTOMER_DEL_SESSION",    USER_SESSION . "CustomerDel");
define("USER_CUSTOMER_DETAIL_SESSION", USER_SESSION . "CustomerDetail");

// Divya
define("USER_DIVYA_LIST_SESSION",   USER_SESSION . "DivyaList");
define("USER_DIVYA_NEW_SESSION",    USER_SESSION . "DivyaNew");
define("USER_DIVYA_EDIT_SESSION",   USER_SESSION . "DivyaEdit");
define("USER_DIVYA_DEL_SESSION",    USER_SESSION . "DivyaDel");
define("USER_DIVYA_DETAIL_SESSION", USER_SESSION . "DivyaDetail");


// priya
define("USER_PRIYA_LIST_SESSION",   USER_SESSION . "PriyaList");
define("USER_PRIYA_NEW_SESSION",    USER_SESSION . "PriyaNew");
define("USER_PRIYA_EDIT_SESSION",   USER_SESSION . "PriyaEdit");
define("USER_PRIYA_DEL_SESSION",    USER_SESSION . "PriyaDel");
define("USER_PRIYA_DETAIL_SESSION", USER_SESSION . "PriyaDetail");

// Client
define("USER_CLIENT_LIST_SESSION", USER_SESSION . "clientList");
define("USER_CLIENT_NEW_SESSION",  USER_SESSION . "clientNew");
define("USER_CLIENT_EDIT_SESSION", USER_SESSION . "clientEdit");
define("USER_CLIENT_DEL_SESSION",  USER_SESSION . "clientDel");

// attendance
define("USER_ATTENDANCE_LIST_SESSION", USER_SESSION . "AttendanceList");
define("USER_ATTENDANCE_NEW_SESSION", USER_SESSION . "AttendanceNew");


// user
define("USER_DETAIL_LIST_SESSION", USER_SESSION . "detailProcess");



?>
