<?php

// define
define("COM_DIR", MOD_DIR . "common/");
define("FW_DIR", LIB_DIR . "Simplan/");

/*----------------------------------------*
 * include
 *----------------------------------------*/
include_once(COM_DIR . "adminProcess.php");
include_once(COM_DIR . "adminErrorPage.php");     // エラー画面生成ファイル
include_once(COM_DIR . "commonTypes.php");        // 共通定義ファイル
include_once(COM_DIR . "csvDefine.php");
include_once(COM_DIR . "importDefine.php");
include_once(COM_DIR . "MasterCommand.php");
include_once(COM_DIR . "CommonCommand.php");
include_once(COM_DIR . "EraCommand.php");
include_once(COM_DIR . "HierarchyCommand.php");
include_once(COM_DIR . "SequenceCommand.php");
include_once(COM_DIR . "operateJpeg.php");
include_once(COM_DIR . "AuthCheck.php");
include_once(COM_DIR . "StretchedPassword.php");
include_once(COM_DIR . "OnetimeTicket.php");
include_once(FW_DIR  . "class/FormCheckEx.php");

/*----------------------------------------*
 * define
 *----------------------------------------*/
//*** DISP TYPE ***//
define("DISP_TYPE_LIST",    "list");
define("DISP_TYPE_NEW",     "new");
define("DISP_TYPE_EDIT",    "edit");
define("DISP_TYPE_DEL",     "del");
define("DISP_TYPE_DETAIL",  "detail");
define("DISP_TYPE_CSV",     "csv");
define("DISP_TYPE_HISTORY", "history");
define("DISP_TYPE_COPY",    "copy");
define("DISP_TYPE_IMAGE",   "image");

//*** SESSION NAME ***//
// session name
define("ADMIN_SESSION", "sample_AdminSession");

// ワンタイムチケット
define("ONETIME_TICKET_SESSION", ADMIN_SESSION . "OnetimeTicket");

// ログイン・トップ管理
define("ADMIN_INDEX_SESSION", ADMIN_SESSION . "Index");

// サイト管理
define("ADMIN_SITE_EDIT_SESSION", ADMIN_SESSION . "SiteEdit");

// 管理者情報管理
define("ADMIN_ACCOUNT_LIST_SESSION", ADMIN_SESSION . "AccountList");
define("ADMIN_ACCOUNT_NEW_SESSION",  ADMIN_SESSION . "AccountNew");
define("ADMIN_ACCOUNT_EDIT_SESSION", ADMIN_SESSION . "AccountEdit");
define("ADMIN_ACCOUNT_DEL_SESSION",  ADMIN_SESSION . "AccountDel");

// Add Employee
define("ADMIN_ADD_EMPLOYEE_LIST_SESSION", ADMIN_SESSION . "AddemployeeList");
define("ADMIN_ADD_EMPLOYEE_NEW_SESSION",  ADMIN_SESSION . "AddemployeeNew");
define("ADMIN_ADD_EMPLOYEE_EDIT_SESSION", ADMIN_SESSION . "AddemployeeEdit");
define("ADMIN_ADD_EMPLOYEE_DEL_SESSION",  ADMIN_SESSION . "AddemployeeDel");
define("ADMIN_ADD_EMPLOYEE_DETAIL_SESSION",  ADMIN_SESSION . "AddemployeeDetail");

// Attendance
define("ADMIN_ATTENDANCE_LIST_SESSION", ADMIN_SESSION . "AttendanceList");
define("ADMIN_ATTENDANCE_NEW_SESSION",  ADMIN_SESSION . "AttendanceNew");
define("ADMIN_ATTENDANCE_EDIT_SESSION", ADMIN_SESSION . "AttendanceEdit");
define("ADMIN_ATTENDANCE_DEL_SESSION",  ADMIN_SESSION . "AttendanceDel");

// Salary
define("ADMIN_SALARY_LIST_SESSION", ADMIN_SESSION . "SalaryList");
define("ADMIN_SALARY_NEW_SESSION",  ADMIN_SESSION . "SalaryNew");
define("ADMIN_SALARY_EDIT_SESSION", ADMIN_SESSION . "SalaryEdit");
define("ADMIN_SALARY_DEL_SESSION",  ADMIN_SESSION . "SalaryDel");
?>
