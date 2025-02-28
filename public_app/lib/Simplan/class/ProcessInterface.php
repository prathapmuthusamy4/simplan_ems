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

/**
 * プロセスインターフェースクラス
 * [note] プロセスを呼び出す
 *
 * @author     Toru Yoshikawa <t-yoshikawa@threet.co.jp>
 * @access     public
 * @package    Simplan
 */
class ProcessInterface
{

    //*** 変数宣言 ***//
    var $logger;                // システムロガー

    /**
     * コンストラクタ
     *
     * @access    public
     * @return    void
     */
    function __construct()
    {
        // システムロガーの生成
        $this->logger = new SystemLog();
    }

    /**
     * プロセス実行メソッド
     *
     * @access    public
     * @return    void
     */
    function performProcess ()
    {
        if (phpversion() >= 5) {
            date_default_timezone_set('Asia/Tokyo');
        }
        $this->logger->info("* ------------------------------------------------------------ *");
        $this->logger->info("* Simplan Framework - PHP Web Application Framework");
        $this->logger->info("* ");
        $this->logger->info("* Version : " . SIMPLAN_VERSION);
        $this->logger->info("* Copyright(c) 2003-" . date('Y') . " THREET CO.,LTD. All Rights Reserved.");
        $this->logger->info("* http://www.threet.co.jp");
        $this->logger->info("* ------------------------------------------------------------ *");
        $this->logger->debug("HTTP_REFERER > " . t_server('HTTP_REFERER'));
        $this->logger->debug("SCRIPT_URI > " . t_server('SCRIPT_URI'));
        $this->logger->debug("REQUEST_URI > " . t_server('REQUEST_URI'));
        $this->logger->debug("HTTPS > " . t_server('HTTPS'));
        $this->logger->debug("HTTPS MODE > " . HTTPS);
        $this->logger->debug("DEF_COMMAND > " . DEF_COMMAND);
        $this->logger->debug("DEF_PROCESS > " . DEF_PROCESS);

        $input = array();
        $input[DEF_COMMAND] = '';
        $input[DEF_PROCESS] = '';

        /*--------------------*
         * GET/POST DATA
         *--------------------*/
        foreach ($_POST as $n => $v) {          // POST
            $input[$n] = $v;
            $val = $v;
            if (is_array($v)) {
                $val = "array";
            }
            $this->logger->debug("POST DATA > [{$n}] : <{$val}>");
        }
        foreach ($_GET as $n => $v) {           // GET（GETはなるべく使わない）
            $input[$n] = $v;
            $val = $v;
            if (is_array($v)) {
                $val = "array";
            }
            $this->logger->debug("GET DATA > [{$n}] : <{$val}>");
        }

        /*--------------------*
         * SESSION
         *--------------------*/
        session_cache_limiter('none');
        session_start();
        $this->logger->debug("SESSION start ... OK");

        //*** SSL対応 ***//
        if (HTTPS === "manual") {
            $this->logger->debug("manual mode");
        } else {
            if (HTTPS === 'on' && !isset($_SERVER['HTTPS'])) {
                //*** データをセッションに隔離 ***//
                $_SESSION['ssl_data'] = $input;
                $this->logger->info("Location  to SSL page");
                header("Location:" . "https://" . $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
                exit();
            } else if (HTTPS === 'off' && isset($_SERVER['HTTPS'])) {
                //*** データをセッションに隔離 ***//
                $_SESSION['ssl_data'] = $input;
                $this->logger->info("Location to NON SSL page");
                header("Location:" . "http://" . $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
                exit();
            }

            //*** SSL対応時に隔離したデータ復元 ***//
            if (isset($_SESSION['ssl_data'])) {
                $input = $_SESSION['ssl_data'];
                unset($_SESSION['ssl_data']);
            }
        }

        /*--------------------*
         * プロセス指定チェック
         *--------------------*/
        if (!$input[DEF_PROCESS]) {
            //*** デフォルトプロセス設定 ***//
            $systemReader = new SimplanIniReader(ETC_DIR . "system.ini");
            $input[DEF_PROCESS] = $systemReader->getValue("BASE", 'default_process');
        }
        $this->logger->info("Process set [{$input[DEF_PROCESS]}] ... OK");

        // プロセスクラス名の取得
        $reader = new SimplanIniReader(PKG . 'process.properties', false);
        $name = $reader->getSection($input[DEF_PROCESS]);

        //*** プロパティ取得判定 ***//
        if (!$name) {
            $name = "indexProcess";
        }
        $this->logger->info("Process Name [{$name}] ... OK");

        // 指定プロセスファイルチェック
        $path = PKG . "process/{$name}.php";
        if (!file_exists($path)) {
            $this->logger->info("Include File [{$path}] ... NG");
            $this->logger->error("ProcessInterface::performProcess > process file not found [ {$name} ]");
            trigger_error ("ProcessInterface::performProcess > process file not found [ {$name} ]", E_USER_ERROR);
        }
        include_once($path);
        $this->logger->info("Include File [{$path}]... OK");

        //*** クラス有無チェック ***//
        if (!class_exists($name)) {
            $this->logger->info("Class Exists [{$name}] ... NG");
            //*** ERRORレベルログの出力 ***//
            $this->logger->error("ProcessInterface::performProcess > class not found [ {$name} ]");
            trigger_error ("ProcessInterface::performProcess > class not found [ {$name} ]", E_USER_ERROR);
        }
        $this->logger->info("Class Exists [{$name}] ... OK");

        /*--------------------*
         * ロジックスタート
         *--------------------*/
        $process = new ${'name'}($this->logger);
        $process->init($input);

        exit();
    }
}

?>
