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
 * @version     {version}
 */

/*** 共通定義 ***/
/* controllファイルへのパスを設定して下さい */
require_once( '../controll.php' );

/*** SSL設定有無 ***/
define( 'HTTPS', 'on' );

/*** パッケージの指定 ***/
define( 'PKG', MOD_DIR . '{ModName}' );
define( 'DISP_DIR', PKG . '/view/');

/*** プロセスインターフェースの実行 ***/
$interface = new ProcessInterface();
$interface->performProcess();

?>
