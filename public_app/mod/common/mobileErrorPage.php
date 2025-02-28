<?php
//******************************************************************************
// 機能名   ： エラーメッセージページクラス
// 作成日   ： 2007.01.09
//******************************************************************************

class mobileErrorPage
{
    var $error_content = "";
    var $error_message = "";
    var $back_page_url = "";
    var $back_page_process = "";
    var $back_page_cmd = "";
    var $back_page_name = "";
    var $logger;                // システムロガー
    var $smary;                 // Smarty

    //******************************************************************************
    // 関数名   ：  コンストラクタ
    // 機能名   ：  コンストラクタ
    // 引　数   ：  url
    // 戻り値   ：  none
    //******************************************************************************
    function mobileErrorPage($logger, $smarty)
    {
        // set
        $this->smarty = $smarty;
        $this->logger = $logger;
    }

    //******************************************************************************
    // 関数名   ：  setUrl
    // 機能名   ：  URLをセットする
    // 引　数   ：  $url
    // 戻り値   ：  なし
    //******************************************************************************
    function setUrl($url) {
        $this->back_page_url = $url;
    }

    //******************************************************************************
    // 関数名   ：  getUrl
    // 機能名   ：  URLを取得する
    // 引　数   ：  none
    // 戻り値   ：  url
    //******************************************************************************
    function getUrl() {
        return $this->back_page_url;
    }

    //******************************************************************************
    // 関数名   ：  setProcess
    // 機能名   ：  PROCESSをセットする
    // 引　数   ：  $process
    // 戻り値   ：  なし
    //******************************************************************************
    function setProcess($process) {
        $this->back_page_process = $process;
    }

    //******************************************************************************
    // 関数名   ：  getProcess
    // 機能名   ：  PROCESSを取得する
    // 引　数   ：  none
    // 戻り値   ：  process
    //******************************************************************************
    function getProcess() {
        return $this->back_page_process;
    }

    //******************************************************************************
    // 関数名   ：  setCmd
    // 機能名   ：  Cmdをセットする
    // 引　数   ：  $cmd
    // 戻り値   ：  なし
    //******************************************************************************
    function setCmd($cmd) {
        $this->back_page_cmd = $cmd;
    }

    //******************************************************************************
    // 関数名   ：  getCmd
    // 機能名   ：  CMDを取得する
    // 引　数   ：  none
    // 戻り値   ：  cmd
    //******************************************************************************
    function getCmd() {
        return $this->back_page_cmd;
    }

    //******************************************************************************
    // 関数名   ：  setName
    // 機能名   ：  Nameをセットする
    // 引　数   ：  $name
    // 戻り値   ：  なし
    //******************************************************************************
    function setName($name) {
        $this->back_page_name = $name;
    }

    //******************************************************************************
    // 関数名   ：  getName
    // 機能名   ：  NAMEを取得する
    // 引　数   ：  none
    // 戻り値   ：  name
    //******************************************************************************
    function getName() {
        return $this->back_page_name;
    }

    //******************************************************************************
    // 関数名   ：  setContent
    // 機能名   ：  CONTENTをセットする
    // 引　数   ：  $content
    // 戻り値   ：  なし
    //******************************************************************************
    function setContent($content) {
        $this->error_content = $content;
    }

    //******************************************************************************
    // 関数名   ：  getContent
    // 機能名   ：  CONTENTを取得する
    // 引　数   ：  none
    // 戻り値   ：  content
    //******************************************************************************
    function getContent() {
        return $this->error_content;
    }

    //******************************************************************************
    // 関数名   ：  setMessage
    // 機能名   ：  MESSAGEをセットする
    // 引　数   ：  $message
    // 戻り値   ：  なし
    //******************************************************************************
    function setMessage($message) {
        $this->error_message = $message;
    }

    //******************************************************************************
    // 関数名   ：  getMessage
    // 機能名   ：  MESSAGEを取得する
    // 引　数   ：  none
    // 戻り値   ：  message
    //******************************************************************************
    function getMessage() {
        return $this->error_message;
    }

    //******************************************************************************
    // 関数名   ：  forwardPage
    // 機能名   ：  エラーページを表示する。
    // 引　数   ：  なし
    // 戻り値   ：  なし
    //******************************************************************************
    function forwardPage () {

        // display
        $this->logger->debug("[ERROR_PAGE] エラー: " . $this->getContent());
        $this->logger->debug("[ERROR_PAGE] メッセージ: " . $this->getMessage());
        $this->logger->debug("[ERROR_PAGE] 名称: " . $this->getName());
        $this->logger->debug("[ERROR_PAGE] URL: " . $this->getUrl());
        $this->logger->debug("[ERROR_PAGE] PROCESS: " . $this->getProcess());
        $this->logger->debug("[ERROR_PAGE] CMD: " . $this->getCmd());

        //*** forward ***//
        $this->show();
        exit();
    }

    //******************************************************************************
    // 関数名   ：  forwardPage
    // 機能名   ：  エラーページを表示する。
    // 引　数   ：  なし
    // 戻り値   ：  なし
    //******************************************************************************
    function show() {

        $param = array(
                       'title' => 'エラー - み奈美亭',
                       'content' => $this->getContent(),
                       'message' => $this->getMessage(),
                       'url' => $this->getUrl(),
                       'process' => $this->getProcess(),
                       'cmd' => $this->getCmd(),
                       'name' => $this->getName(),
                       );
        $this->smarty->assign('param', $param);

        $errtpl = 'file:' . HTML_DIR . 'mobile_error.tpl';
        $output = $this->smarty->fetch($errtpl);
        $output = mb_convert_kana($output,"k","UTF-8");
        //SJISに変換
        $output = mb_convert_encoding($output,"SJIS","UTF-8");

        // out put
        ini_set("default_charset", 'SHIFT_JIS');
        echo($output);

        //return;
    }
}
?>