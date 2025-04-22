<?php
/**
 * Simplan FW - PHP Web Application Framework
 *
 * Copyright(c) 2003-2010 THREET CO.,LTD. All Rights Reserved.
 *
 * http://www.threet.co.jp
 * http://www.simplan.jp
 *
 * PHP versions 4 and 5
 *
 * LICENSE: 
 * 
 * 
 * 
 * 
 *
 * @author     Toru Yoshikawa <t-yoshikawa@threet.co.jp>
 * @license
 * @package    Simplan
 * @copyright  2003-2010 The Simplan Project by THREET CO.,LTD.
 * @version    $Id: $
 */

/** Simplan (*currently*) depends on Smarty */

if (!defined('PATH_SEPARATOR')) {
    if (OS_WINDOWS) {
        /** include_path separator(Windows) */
        define('PATH_SEPARATOR', ';');
    } else {
        /** include_path separator(Unix) */
        define('PATH_SEPARATOR', ':');
    }
}
if (!defined('DIRECTORY_SEPARATOR')) {
    if (OS_WINDOWS) {
        /** directory separator(Windows) */
        define('DIRECTORY_SEPARATOR', '\\');
    } else {
        /** separator(Unix) */
        define('DIRECTORY_SEPARATOR', '/');
    }
}

/** バージョン定義 */
define('SIMPLAN_VERSION', '1.1.0');

/** Simplanベースディレクトリ定義 */
define('SIMPLAN_BASE', dirname(__FILE__));

// php ini
ini_set("magic_quotes_gpc", "off");

/** Include */

include_once(SIMPLAN_BASE . '/class/SimplanIniReader.php');
include_once(SIMPLAN_BASE . '/class/AbstractCommand.php');
include_once(SIMPLAN_BASE . '/class/SimplanAbstractProcess.php');
include_once(SIMPLAN_BASE . '/class/SimplanErrorHandler.php');
include_once(SIMPLAN_BASE . '/class/CommandInterface.php');
include_once(SIMPLAN_BASE . '/class/CommandLineInterface.php');
include_once(SIMPLAN_BASE . '/class/CommandMessage.php');
include_once(SIMPLAN_BASE . '/class/FormCheck.php');
include_once(SIMPLAN_BASE . '/class/FormCheckEx.php');
include_once(SIMPLAN_BASE . '/class/FormCheckEnglish.php');
include_once(SIMPLAN_BASE . '/class/SimplanImageControl.php');
include_once(SIMPLAN_BASE . '/class/ProcessInterface.php');
include_once(SIMPLAN_BASE . '/class/PropertyReader.php');
include_once(SIMPLAN_BASE . '/class/SystemLog.php');
include_once(SIMPLAN_BASE . '/class/SystemCliLog.php');
include_once(SIMPLAN_BASE . '/class/SimplanUtil.php');
include_once(SIMPLAN_BASE . '/class/SimplanLog.php');
include_once(SIMPLAN_BASE . '/class/DB/SimplanDBUtil.php');
include_once(SIMPLAN_BASE . '/class/SimplanSmarty.php');
include_once(SIMPLAN_BASE . '/class/SimplanMail.php');
include_once(SIMPLAN_BASE . '/class/SimplanZip.php');
include_once(SIMPLAN_BASE . '/class/SimplanMakeCsvFile.php');
include_once(SIMPLAN_BASE . '/class/SimplanMakeFile.php');
include_once(SIMPLAN_BASE . '/class/SimplanOperateFile.php');
include_once(SIMPLAN_BASE . '/class/SimplanUploadFile.php');
include_once(SIMPLAN_BASE . '/class/SimplanRemoveFile.php');
include_once(SIMPLAN_BASE . '/class/SimplanMobile.php');
include_once(SIMPLAN_BASE . '/class/SimplanSitemap.php');
include_once(SIMPLAN_BASE . '/class/SimplanRss.php');
include_once(SIMPLAN_BASE . '/class/DB/Sas.php');
include_once(SIMPLAN_BASE . '/class/WideDB/SimplanInterface.php' );
include_once(SIMPLAN_BASE . '/class/WideQuery/SimplanInterface.php' );
if (defined('E_STRICT') == false) {
    /** PHP 5との互換保持定義 */
    define('E_STRICT', 0);
}


// define
define('DEF_PROCESS', 'prc');
define('DEF_COMMAND', 'cmd');

// セーフモードかの判定
define('IS_SAFE_MODE', (get_cfg_var('safe_mode')));

/**
 *  Simplanフレームワーククラス
 *
 *  @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 *  @access     public
 *  @package    Simplan
 */
class Simplan
{
    //
}
?>