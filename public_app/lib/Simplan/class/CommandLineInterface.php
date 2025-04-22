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
 * コマンドラインインターフェースクラス
 * [note] プロセスを呼び出す
 *
 * @author     Toru Yoshikawa <t-yoshikawa@threet.co.jp>
 * @access     public
 * @package    Simplan
 */
class CommandLineInterface
{

    //*** 変数宣言 ***//
    var $logger;                // システムロガー
    /**
     * コンストラクタ
     *
     * @access    public
     * @return    void
     */
    function CommandLineInterface()
    {
        // システムロガーの生成
        $this->logger = new SystemCliLog();
    }

    /**
     * プロセス実行メソッド
     *
     * @access    public
     * @return    void
     */
    function run()
    {
        Global  $argc;
        Global  $argv;
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
        $this->logger->debug("* COMMAND LINE MODE *");
        $this->logger->debug("DEF_PROCESS > " . DEF_PROCESS);

        $input = array();
        $input[DEF_PROCESS] = '';

        /*--------------------*
         * PARAMETER DATA
         *--------------------*/
        if ( $argc > 0 ) {
            foreach( $argv as $parameter ){
                if ( ( $tmp = explode('=', $parameter) ) && count($tmp) > 1 ) {
                    $input[$tmp[0]] = $tmp[1];
                    $this->logger->debug("PARAMETER DATA > [{$tmp[0]}] : <{$tmp[1]}>");
                } else {
                    $input[$parameter] = true;
                    $this->logger->debug("PARAMETER DATA > [{$parameter}] : on");
                }
            }
        }

        /*--------------------*
         * プロセス指定チェック
         *--------------------*/
        if (!$input[DEF_PROCESS]) {
            $this->logger->debug("No find process");
            //*** デフォルトプロセス設定 ***//
            $systemReader = new SimplanIniReader(ETC_DIR . "system.ini");
            $input[DEF_PROCESS] = $systemReader->getValue("BASE", 'default_cliprocess');
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
            $this->logger->error("CommandLineInterface::run > process file not found [ {$name} ]");
            exit();
        }
        include_once($path);
        $this->logger->info("Include File [{$path}]... OK");

        //*** クラス有無チェック ***//
        if (!class_exists($name)) {
            $this->logger->info("Class Exists [{$name}] ... NG");
            //*** ERRORレベルログの出力 ***//
            $this->logger->error("CommandLineProcessInterface::run > class not found [ {$name} ]");
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
