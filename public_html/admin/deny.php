<?php
/**
 * Simplan - PHP Framework
 *
 * PHP versions 4 and 5
 *
 * @package     Simplan
 * @access      public
 * @author      Toru Yoshikawa <ruu@simplan.jp>
 * @copyright   2007 The Simplan Project
 * @version     $Id$
 */

/*** 共通定義 ***/
require_once("../define.php");

/*** SSL設定有無 ***/
define("HTTPS", "off");

/*** パッケージの指定 ***/
define("PKG", MOD_DIR . "admin/static/");
define("DISP_DIR", HTML_DIR . "admin/deny/");

/*** プロセスインターフェースの実行 ***/
$interface = new ProcessInterface();
$interface->performProcess();
?>