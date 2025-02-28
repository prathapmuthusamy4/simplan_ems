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
 * @create     2006/04/28
 * @version    0.9
 */

/*--------------------------------------------------*
 * エラーハンドラー
 *--------------------------------------------------*/
define("FATAL", E_USER_ERROR);
define("ERROR", E_USER_WARNING);
define("WARNING", E_USER_NOTICE);

/**
 * SimplanErrorHandler
 *  エラーハンドル
 *  error.phpに遷移
 *
 * @param int $errno エラー番号
 * @param string $errstr エラー文字列
 * @param string $errfile エラー発生ファイル
 * @papram int $errline エラー発生行
 */
function SimplanErrorHandler ($errno, $errstr, $errfile, $errline)
{

    /*--------------------*
     * システムプロパティよりログ設定取得 
     *--------------------*/
    $reader = new SimplanIniReader(ETC_DIR . "system.ini");
    $fSize = $reader->getValue('LOG', 'err_log_file_size');
    $fName = $reader->getValue('LOG', 'err_log_file_name');
    $backup = $reader->getValue('LOG', 'err_log_backup');
    $format = $reader->getValue('LOG', 'err_log_format');

    $file_path = LOG_DIR . $fName;

    /*--------------------*
     * ログファイルチェック
     *--------------------*/
    if (file_exists($file_path) && filesize($file_path) > $fSize) {
        // バックアップファイル名の設定
        $fhead = $fName;
        $fext = "";
        $pos = strpos($fhead, '.');
        // 拡張子有りならファイル名のみを取得
        if ($pos) {
            $fext = substr($fhead, $pos + 1);
            $fhead = substr($fhead, 0, $pos);
        }
        for ($idx = $backup; $idx > 1; $idx--) {
            $num = $idx - 1;
            $checkFile = LOG_DIR . $fhead . $num . '.' . $fext;
            if (file_exists($checkFile)) {
                $renameFile = LOG_DIR . $fhead . $idx . '.' . $fext;
                if (file_exists($renameFile)) {
                    unlink($renameFile);
                }
                rename($checkFile, $renameFile);
            }
        }
        $renameFile = LOG_DIR . $fhead . '1.' . $fext;
        rename($file_path, $renameFile);
    }

    /*--------------------*
     * ログ書込み
     *--------------------*/
    $fp = fopen($file_path, 'a');
    $logStr = date($format) . " >> $errno : $errstr [$errfile.$errline]\n";
    fwrite($fp, $logStr);
    fclose($fp);

    $_SESSION['error'] = $logStr;

    if (headers_sent()) {
        print $logStr;
    } else {
        header ('Location: error.php');
        unset($_SESSION['error']);
    }
    exit;
}

//*** エラーハンドラー登録 ***//
$isPHP5 = version_compare(PHP_VERSION, "5.0.0", ">=");
// 関数を登録する場合
if($isPHP5) {
  set_error_handler("SimplanErrorHandler", E_ALL);
} else {
  set_error_handler("SimplanErrorHandler");
}
?>