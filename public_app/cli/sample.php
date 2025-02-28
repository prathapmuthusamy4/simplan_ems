#! /usr/bin/php -q
<?php
/**
 * Simplan - PHP Framework
 *
 * PHP versions 4 and 5
 *
 * @package     Simplan
 * @access      public
 * @author      Toru Yoshikawa <ruu@simplan.jp>
 * @copyright   2012 The Simplan Project
 * @version     $Id$
 */

/*-----------------------------*
 * [Note]
 *   o #! /usr/bin/php のパスを確認してください。
 *   o 起動方法
 *     # php [this file name].php [RETURN]
 *------------------------------*/

/** 共通定義 **/
require_once(dirname(__FILE__) . '/define.php');

/** パッケージの指定 **/
define('PKG', MOD_DIR . 'cli/sample/');

/** プロセスインターフェースの実行 **/
$cli = new CommandLineInterface();
$cli->run();
?>