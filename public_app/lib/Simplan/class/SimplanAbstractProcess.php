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
 * プロセス基底クラス
 *
 * @author     Toru Yoshikawa <t-yoshikawa@threet.co.jp>
 * @access     public
 * @package    Simplan
 */
class SimplanAbstractProcess
{

    //*** 変数宣言 ***//
    var $logger;     // システムロガー
    var $connect;    // DBコネクション
    var $smarty;     // Smarty
    var $sdb;        // sDB
    var $lang;       // language
    var $sitekbn;    // サイト区分
    var $message;    // message ini object
    var $site;       // site ini object
    var $system;     // system ini object

    /**
     * コンストラクタ
     *
     * @access    public
     * @param     Object   $logger   (SystemLog)システムロガー
     */
    function __construct($logger)
    {
        //Loggerの取得
        $this->logger = $logger;

        // init
        $this->site = null;
        $this->system = null;
        $this->message = null;
        $this->setLanguage("ja"); // set the default language
        $this->setSiteKbn("def");  // set the default site kbn

        // SimplanSmartyの初期化
        $this->smarty = new SimplanSmarty();
        $this->setSmarty();

        //sDBの生成
        $this->sdb = new WideDB_SimplanInterface( $logger );

    }

    /**
     * 入力チェック
     *
     * @access    public
     * @param     String   $define     入力チェック定義ファイル名
     * @param     Array    $input      コマンド実行時引数
     * @return    Array    $errList    エラーメッセージリスト
     */
    function checkInput ($define, &$input)
    {
        //*** エラーチェックリストの初期化 ***//
        $errList = array();
        foreach ($input as $n => $v) {
            $errList[$n . '_err'] = '';
        }

        //*** エラーチェッククラスの生成 ***//
        $checker = new FormCheck($define);

        //*** チェック実行 ***//
        $errTmp = $checker->check($input);

        //*** エラー判定 ***//
        if (sizeof($errTmp) > 0) {
            //*** エラーメッセージ出力設定 ***//
            foreach ($errTmp as $n => $v) {
                $errList[$n] = $errTmp[$n];
            }
        } else {
            $errList = array();
        }

        return $errList;
    }

    /**
     * セッションクリアメソッド
     *
     * @access    public
     * @param     Array    $without    クリア除外項目
     */
    function clearSession()
    {
        //*** SESSIONの要素をクリアしていく ***//
        foreach ($_SESSION as $n => $v) {
            $flg = 0;

            //*** 除外項目判定 ***//
            if (is_array($without)) {
                for ($idx = 0; $idx < sizeof($without); $idx++) {
                    if ($without[$idx] == $n) {
                        $flg = 1;
                        break;
                    }
                }
            } else {
                if ($without == $n) {
                    $flg = 1;
                }
            }

            //*** 除外項目以外であればクリア ***//
            if ($flg == 0) {
                unset($_SESSION[$n]);
            }
        }
    }

    /**
     * コマンド実行メソッド
     *
     * @access    public
     * @param     String   $cmd    コマンドキー
     * @param     Array    $input  コマンド実行時引数
     * @return    Object   $rslt   コマンド実行結果(CommandMessage)
     */
    function execCommand( $mod, $cmd, $input, $type = 0 )
    {
        $path = "{$mod}/{$cmd}";
        $obj = new AbstractCommand( $this->logger, $this->sdb );
        $obj->param = $input;

        return $obj->executeSql( $path, $type );
    }

    /**
     * クエリー実行メソッド
     *
     * @access    public
     * @param     String   $cmd    コマンドキー
     * @param     Array    $input  コマンド実行時引数
     * @return    Object   $rslt   コマンド実行結果(CommandMessage)
     */
    function execQuery( $query, $type = 0, $flg = false )
    {
        $obj = new AbstractCommand( $this->logger, $this->sdb );
        $ret = $obj->execQuery( $query, $type );

        if( $ret === false ){
            if( $flg ) {
                return false;
            }
            $msg = "execQuery > Query is  error.\n". $this->sdb->except->GetMsg();
            $this->logger->error( $msg );
            //trigger_error( $msg, E_USER_ERROR );
            return false;
        }

        return $ret;
    }

    /**
     * 画像コピー
     *
     * @access    public
     * @param     String   $srcFileName    操作する元画像ファイル名
     * @param     String   $destFileName   操作後の保存画像ファイル名
     * @param     String   $width          操作後の幅
     * @param     String   $height         操作後の高さ
     * @param     String   $mode           WIDTH  ：横幅を基準にサイズ調整
     *                                     HEIGHT ：高さを基準にサイズ調整
     *                                     CERTAIN：横幅、高さの比率を無視
     *                                     AUTO   ：自動調整
     *                                     （サイズの大きい方を基準に縮小）
     * @param     Boolean  $expansion      拡大ON・OFFフラグ
     */
    function createImage (
                          $srcFileName,
                          $destFileName,
                          $width,
                          $height,
                          $mode,
                          $expansion
                          )
    {
        //*** エラーチェッククラスの生成 ***//
        $ic = new SimplanImageControl( $srcFileName, $destFileName, $width, $height, $mode, $expansion );
        $ic->createImage();

    }

    /**
     * freezeZip
     *
     * @access    public
     * @param     String   $srcFileName    圧縮対象ファイル
     * @param     String   $freezeFileName 圧縮時のファイル名
     * @return    String   $rslt           コマンド実行結果
     */
    function freezeZip( $srcFileName, $freezeFileName ) {
        return SimplanZip::freezeZip( $srcFileName, $freezeFilename );
    }

    /**
     * extractZip
     *
     * @access    public
     * @param     String   $srcFileName    解凍対象ファイル
     * @return    String                   実行結果
     */
    function extractZip( $srcFileName ) {
        return SimplanZip::extractZip( $srcFileName );
    }

    /**
     * メール送信処理
     *
     * @access    public
     * @param string $id テンプレートID
     * @param string $to 宛先
     * @param string $name 宛先氏名
     * @param string $param 変数
     * @return boolean
     */
    function sendMail($id, $to, $name, $param)
    {
        $success = false;

        // instance
        $mail = new SimplanMail($this->logger, $this->getLanguage());

        /*---------------*
         * SMTP認証
         *---------------*/
        if ($this->_b('MAIL', 'mail_smtp_is')) {
            $this->logger->debug("Send mail ... SMTP Sending");
            $mail->IsSMTP();
            $mail->SMTPAuth = $this->_b('MAIL', 'mail_smtp_auth');
            $mail->Host = $this->_b('MAIL', 'mail_smtp_host');
            $mail->Username = $this->_b('MAIL', 'mail_smtp_username');
            $mail->Password = $this->_b('MAIL', 'mail_smtp_password');
            $sec = $this->_b('MAIL', 'mail_smtp_secure');
            if (!is_empty($sec)) {
                $mail->SMTPSecure = $sec;
            }
            $port = $this->_b('MAIL', 'mail_smtp_port');
            if (!is_empty($port)) {
                $mail->Port = $port;
            }
        }

        /*---------------*
         * 設定
         *---------------*/
        $prefix = $this->_s('BASE', 'mail_name_prefix'); // 敬称
        // 宛先
        $mail->AddTo($to, $name . $prefix);
        // 返信先
        $mail->AddReplyTo($this->_s('BASE', 'mail_sender_address'),
                          $this->_s('BASE', 'mail_sender_name'));
        // BCC先
        $bcc = explode(",", $this->_s('BASE', 'mail_bcc'));
        // add bcc
        for ($i=0; $i<sizeof($bcc); $i++) {
            $bcc_to = trim($bcc[$i]);
            $mail->AddBCC($bcc_to);
        }
        // FROM先
        $mail->setFrom($this->_s('BASE', 'mail_sender_address'),
                       $this->_s('BASE', 'mail_sender_name'));
        // メールタイトル
        $mail->setSubject( $this->_s('BASE', "mail_head_title") . $this->_m('MAIL', "{$id}_title") );
        // メール本文
        $body = $mail->makeBody($id, $param, $this->site);
        $mail->setBody($body);
        /*---------------*
         * 送信
         *---------------*/
        if ($mail->send()) {
            $this->logger->debug("Send mail ... OK");
            $success = true;
        } else {
            $this->logger->debug("Send mail ... NG");
            $this->logger->debug($mail->ErrorInfo);
        }

        return $success;
    }

    /**
     * メール送信処理
     *
     * @access    public
     * @param string $id テンプレートID
     * @param string $to 宛先
     * @param string $name 宛先氏名
     * @param string $param 変数
     * @return boolean
     */
    function sendMailSubject($id, $to, $name, $param, $subject)
    {
        $success = false;

        // instance
        $mail = new SimplanMail($this->logger, $this->getLanguage());

        /*---------------*
         * SMTP認証
         *---------------*/
        if ($this->_b('MAIL', 'mail_smtp_is')) {
            $this->logger->debug("Send mail ... SMTP Sending");
            $mail->IsSMTP();
            $mail->SMTPAuth = $this->_b('MAIL', 'mail_smtp_auth');
            $mail->Host = $this->_b('MAIL', 'mail_smtp_host');
            $mail->Username = $this->_b('MAIL', 'mail_smtp_username');
            $mail->Password = $this->_b('MAIL', 'mail_smtp_password');
            $sec = $this->_b('MAIL', 'mail_smtp_secure');
            if (!is_empty($sec)) {
                $mail->SMTPSecure = $sec;
            }
            $port = $this->_b('MAIL', 'mail_smtp_port');
            if (!is_empty($port)) {
                $mail->Port = $port;
            }
        }

        /*---------------*
         * 設定
         *---------------*/
        $prefix = $this->_s('BASE', 'mail_name_prefix'); // 敬称
        // 宛先
        $mail->AddTo($to, $name . $prefix);
        // 返信先
        $mail->AddReplyTo($this->_s('BASE', 'mail_sender_address'),
                          $this->_s('BASE', 'mail_sender_name'));
        // BCC先
        $bcc = explode(",", $this->_s('BASE', 'mail_bcc'));
        // add bcc
        for ($i=0; $i<sizeof($bcc); $i++) {
            $bcc_to = trim($bcc[$i]);
            $mail->AddBCC($bcc_to);
        }
        // FROM先
        $mail->setFrom($this->_s('BASE', 'mail_sender_address'),
                       $this->_s('BASE', 'mail_sender_name'));
        // メールタイトル
        $mail->setSubject($subject);
        // メール本文
        $body = $mail->makeBody($id, $param, $this->site);
        $mail->setBody($body);
        /*---------------*
         * 送信
         *---------------*/
        if ($mail->send()) {
            $this->logger->debug("Send mail ... OK");
            $success = true;
        } else {
            $this->logger->debug("Send mail ... NG");
            $this->logger->debug($mail->ErrorInfo);
        }

        return $success;
    }

    /**
     * 管理者宛メール送信処理
     *
     * @access    public
     * @param string $id テンプレートID
     * @param string $to 宛先
     * @param string $name 宛先氏名
     * @param string $param 変数
     * @return boolean
     */
    function sendMailToAdmin($id, $param)
    {
        $this->logger->debug("Entering sendMailToAdmin ... ");

        // メールアドレス
        $to = $this->getSiteValue('BASE', 'mail_admin_address');

        // 宛先氏名
        $name = $this->getSiteValue('BASE', 'mail_admin_name');

        return $this->sendMail($id, $to, $name, $param);
    }

    /**
     * 管理者宛メール送信処理
     *
     * @access    public
     * @param string $id テンプレートID
     * @param string $to 宛先
     * @param string $name 宛先氏名
     * @param string $param 変数
     * @return boolean
     */
    function sendMailSubjectToAdmin($id, $param, $subject)
    {
        $this->logger->debug("Entering sendMailToAdmin ... ");

        // メールアドレス
        $to = $this->getSiteValue('BASE', 'mail_admin_address');

        // 宛先氏名
        $name = $this->getSiteValue('BASE', 'mail_admin_name');

        return $this->sendMailSubject($id, $to, $name, $param, $subject);
    }

    /**
     * 着信メール送信処理
     *
     * @access    public
     * @param string $id テンプレートID
     * @param string $param 変数
     * @return boolean
     */
    function sendMailIncoming($id, $param)
    {
        $success = false;
        $this->logger->debug("Entering sendMailIncoming ... ");

        // メールアドレス
        $tos = explode(",", $this->getSiteValue('BASE', 'mail_incoming_address'));
        // 宛先氏名
        $names = explode(",", $this->getSiteValue('BASE', 'mail_incoming_name'));

        // 各宛先の送信
        for($i = 0; $i < sizeof($tos); $i++) {
            $to = trim($tos[$i]);
            $name = (isset($names[$i])) ? trim($names[$i]) : "";
            if (!$this->sendMail($id, $to, $name, $param)) {
                return $success;
            }
        }

        return $success = true;
    }

    /**
     * DB接続
     *
     * @access    public
     * @return    Object   DBConnection
     */
    function getConnection()
    {
        if( $this->sdb->Connect() == false ) return false;
        // カレントの db を指定
        if ( $this->sdb->Ready()  == false ) return false;
        $this->logger->debug('DB Connect ... OK');
        return $this->sdb->connect->Get();
    }

    /**
     * DBクローズ
     *
     * @access    public
     */
    function getDisConnection()
    {
        $this->sdb->DisConnect();
        $this->logger->debug('DB Connect Close ... OK');
        return;
    }

    /**
     * DBトランザクション開始
     *
     * @access    public
     */
    function begin()
    {
        $this->logger->debug('DB Start Transaction ... OK');
        return $this->sdb->Begin(false);
    }

    /**
     * DBコミット
     *
     * @access    public
     */
    function commit()
    {
        $this->logger->debug('DB Commit ... OK');
        return $this->sdb->Commit(false);
    }

    function getInsertID(){
        return $this->sdb->getInsertID();
    }

    function getAutoIncrement($table){
        return $this->sdb->getAutoIncrement($table);
    }

    function AlterAutoIncrement($table, $id){
        return $this->sdb->AlterAutoIncrement($table, $id);
    }

    function get_mysql_version()
    {
        return $this->sdb->get_mysql_version();
    }

    /**
     * DBロールバック
     *
     * @access    public
     */
    function rollback()
    {
        $this->logger->debug('DB Rollback ... OK');
        return $this->sdb->RollBack(false);
    }

    /**
     * 前処理
     *
     * @access    public
     * @param     Array    $input  入力値
     */
    function precute($input)
    {
        // none
    }

    /**
     * 主処理
     *
     * @access    public
     * @param     Array    $input  入力値
     */
    function execute($input)
    {
        // none
    }

    /**
     * 後処理
     *
     * @access    public
     * @param     Array    $input  入力値
     */
    function postcute($input)
    {
        // none
    }

    /**
     * 総処理
     *
     * @access    public
     * @param     Array    $input  入力値
     */
    function init($input)
    {
        // DBコネクション
        $this->connect = $this->getConnection();

        // INITファイル読込み
        $this->message = $this->getMessageIni();
        $this->site = $this->getSiteIni();
        $this->system = $this->getSystemIni();

        // 前処理
        $this->logger->debug("Entering precute ...");
        $this->precute($input);

        // 主処理
        $this->logger->debug("Entering execute ...");
        $this->execute($input);

        // 後処理
        $this->logger->debug("Entering postcute ...");
        $this->postcute($input);

        // DBクローズ
        $this->getDisConnection();
    }

    /**
     * Smarty取得 抽象メソッド
     *
     * @access    abstract
     */
    function getSmartyCommon()
    {
        $common = array();
        // サイト情報設定
        $common = $this->getSiteSection('BASE');
        // 基本情報設定
        $common['simplan_version'] = SIMPLAN_VERSION;
        $common['simplan_link'] = "Based on <a href=\"http://www.threet.co.jp/simplan/\" target=\"_blank\" title=\"Simplan Framework\" style=\"text-decoration:none;color:#C0C0C0\">Simplan Framework</a> Version {$common['simplan_version']}";
        $common['produce_link'] = "by <a href=\"http://www.threet.co.jp\" target=\"_blank\" title=\"株式会社スリート\" style=\"text-decoration:none;color:#C0C0C0\">THREET</a>";
        $common['simplan_logo'] = "{$common['simplan_link']} {$common['produce_link']}";
        $common['copylight'] = $common['simplan_link'];

        return $common;
    }

    /**
     * Smarty取得 抽象メソッド
     *
     * @access    abstract
     */
    function userLoginCheckCommon()
    {
        return array();
    }

    /**
     * Smarty取得 抽象メソッド
     *
     * @access    abstract
     */
    function adminLoginCheckCommon()
    {
        return array();
    }

    /**
     * Smarty設定
     *
     * @access    abstract
     */
    function setSmarty()
    {
        $this->smarty->plugins_dir = array('plugins', SIMPLAN_BASE . '/class/SmartyPlugins');
        $this->smarty->assign('user_login',  $this->userLoginCheckCommon());
        $this->smarty->assign('admin_login', $this->adminLoginCheckCommon());
        $this->smarty->assign('common', $this->getSmartyCommon());

        return;
    }

    /**
     * Smartyプラグイン処理
     *
     * @access    abstract
     * @param     String     $path  プラグインパス
     */
    function setSmartyPlugins($path)
    {
        $this->smarty->plugins_dir[] = $path;
    }

    /**
     * 表示処理
     *
     * @access    abstract
     * @param     String     $template  テンプレート名
     * @param     Array      $param     パラメータ
     */
    function view($template, $param)
    {
        $this->smarty->assign('param', $param);
        $this->smarty->load_filter('output', 'trimwhitespace'); // 空白除去
        $this->smarty->display($template);
    }

   /**
     * DBエラー処理
     *
     * @access    public
     * @param     DBException
     */
    function onErrDB( $except )
    {
        $this->logger->error( $head.$except->GetMsg() );
        trigger_error( $head.$except->GetMsg() );
        return true;
    }

    /**
     * 言語設定
     *
     * @access public
     * @param string $lang
     * @return void
     */
    function setLanguage($lang)
    {
        // check
        if (is_empty($lang)) {
            $this->lang = "ja"; // default language
        }

        $this->lang = $lang;
    }

    /**
     * 言語取得
     *
     * @access public
     * @return string language
     */
    function getLanguage()
    {
        return $this->lang;
    }

    /**
     * サイト区分設定
     *
     * @access public
     * @param string $kbn
     * @return void
     */
    function setSiteKbn($kbn)
    {
        // check
        if (is_empty($kbn)) {
            $this->sitekbn = "def"; // default kbn
        }

        $this->sitekbn = $kbn;
    }

    /**
     * サイト区分取得
     *
     * @access public
     * @return string sitekbn
     */
    function getSiteKbn()
    {
        return $this->sitekbn;
    }


    /**
     * INIファイル取得
     *
     * @access  public
     * @param   string  $val     ファイル名
     * @return  array   $prop    メッセージ情報
     */
    function getIni($file)
    { 
        $ini = null;
        if (!is_empty($file)) {
            $ini = new SimplanIniReader($file, true); 
        }

        return $ini;
    }

    /**
     * メッセージプロパティ取得
     *
     * @access  public
     * @return  array   $prop     メッセージ情報
     */
    function getMessageIni()
    {
        $lang = $this->getLanguage();
        return $this->getIni(ETC_DIR . "language/message.ini.{$lang}");
    }

    /**
     * メッセージ取得
     *
     * @access  public
     * @param   string   $section
     * @param   string   $id
     * @return  string   $msg     メッセージ
     */
    function getMessage($section, $id)
    {
        $obj = $this->message;

        // check
        if (!is_object($obj)) {
            $obj = $this->getMessageIni();
        }

        return $obj->getValue($section, $id);
    }

    /**
     * メッセージ取得
     * [note] getMessage 簡易アクセス
     *
     * @access  public
     * @param   string   $entry
     * @param   string   $mid
     * @return  string   $msg     メッセージ
     */
    function _m($section, $id)
    {
        return $this->getMessage($section, $id);
    }

    /**
     * Siteプロパティ取得
     *
     * @access  public
     * @return  array   $prop     プロパティ情報
     */
    function getSiteIni()
    { 
        $kbn = $this->getSiteKbn(); 
        $lang = $this->getLanguage(); 

        return $this->getIni(ETC_DIR . "language/{$kbn}_site.ini.{$lang}");
    }

    /**
     * サイト情報取得
     *
     * @access  public
     * @param   string   $entry
     * @param   string   $mid
     * @return  string   $msg     メッセージ
     */
    function getSiteValue($section, $id)
    { 
        $obj = $this->site; 

        // check
        if (!is_object($obj)) {
            $obj = $this->getSiteIni();
        }

        return $obj->getValue($section, $id);
    }

    /**
     * サイト情報取得
     *
     * @access  public
     * @param   string   $section
     * @return  array
     */
    function getSiteSection($section)
    {
        $obj = $this->site;

        // check
        if (!is_object($obj)) {
            $obj = $this->getSiteIni();
        }

        return $obj->getSection($section);
    }
    /**
     * サイト情報取得
     * [note] getSiteValue 簡易アクセス
     *
     * @access  public
     * @param   string   $entry
     * @param   string   $mid
     * @return  string   $msg     メッセージ
     */
    function _s($section, $id)
    {
        return $this->getSiteValue($section, $id);
    }

    /**
     * Systemプロパティ取得
     *
     * @access  public
     * @return  array   $prop     プロパティ情報
     */
    function getSystemIni()
    {
        return $this->getIni(ETC_DIR . "system.ini");
    }

    /**
     * システム情報取得
     *
     * @access  public
     * @param   string   $entry
     * @param   string   $mid
     * @return  string   $msg     メッセージ
     */
    function getSystemValue($section, $id)
    {
        $obj = $this->system;

        // check
        if (!is_object($obj)) {
            $obj = $this->getSystemIni();
        }

        return $obj->getValue($section, $id);
    }

    /**
     * システム情報取得
     * [note] getSystemValue 簡易アクセス
     *
     * @access  public
     * @param   string   $entry
     * @param   string   $mid
     * @return  string   $msg     メッセージ
     */
    function _b($section, $id)
    {
        return $this->getSystemValue($section, $id);
    }

}
?>