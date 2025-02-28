<?php 
include_once("TemplateProcess.php");

/**
 *  ユーザプロセス共通クラス
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license
 * @package    Simplan
 * @version    1.0
 */
class userProcess extends TemplateProcess
{
    /**
     * delフラグOFF
     * @var string
     */
    const DEL_FLG_LIST_OFF = '0';

    var $message;
    /* ワンタイムチケット */
    var $onetime_ticket = "";
    /**
     * コンストラクタ
     *
     * @access    public
     */
    function __construct($logger)
    {
        parent::__construct($logger);
    }

    /**
     * getSmartyCommon
     *
     * @access    public
     */
    function getSmartyCommon()
    {
        // get parent common param
        $common = parent::getSmartyCommon();

        // add set
        $common["head_tpl"]  = "file:" . HTML_DIR . "user_head.tpl";
        $common["menu_tpl"]  = "file:" . HTML_DIR . "user_menu.tpl";
        $common["foot_tpl"]  = "file:" . HTML_DIR . "user_foot.tpl";
        return $common;
    }

    /**
     * userLoginCheckCommon
     *
     * @access    public
     */
    function userLoginCheckCommon()
    {
        // 初期化
        $var = array(
                     "login_check"    => false,
                     "f_user_id"      => "",
                     "f_name"      => "",
                     "f_mailaddress"  => "",
                    );

        // セッションチェック
        if (isset($_SESSION[USER_SESSION]) && sizeof($_SESSION[USER_SESSION]) > 0) {
            $tmp = $_SESSION[USER_SESSION];
            // セッション情報をセット
            $var = array(
                         "login_check"   => true, // ログインチェック
                         "f_user_id"     => $tmp["f_user_id"],       // 管理者ID
                         "f_name"     => $tmp["f_name"],        // 管理者名（姓）
                         "f_mailaddress" => $tmp["f_mailaddress"],    // メールアドレス
                        );
        }

        return $var;
    }

    /**
     * getErrorObject
     *
     * @access  public
     */
    function getErrorObject()
    {
        $obj = new userErrorPage($this->logger, $this->smarty);
        return $obj;
    }

    /**
     * 前処理
     *
     * @access  public
     * @param   array   $input
     */
    function precute($input)
    {
        // ログインチェック
        if (!$this->isLogin()) {
            header("Location: index.php?cmd=timeout");
            exit;
        }
        $this->base_precute($input);
        return true;
    }

    /**
     * 後処理
     *
     * @access  public
     * @param   array   $input
     */
    function postcute($input)
    {
        // 画面タイトルをセット
        $this->param["title"] = $this->app_name;
        // ログイン情報をセット
        $this->param["logininfo"] = $this->userLoginCheckCommon();
        // ワンタイムチケットをセット
        $this->smarty->assign("onetime_ticket", $this->onetime_ticket);
        parent::base_postcute($input, STATUS_USER);
        parent::postcute($input);
        return;
    }

    /**
     * ログイン処理
     *
     * @access  public
     * @param   string   $id    ID
     * @param   string   $pwd   パスワード
     * @return  bool
     */
    function Login($id, $pwd)
    {
        $success = false;
        if (is_empty($id) || is_empty($pwd)) {
            return $success;
        }
        $setParam = array();
        $setParam["f_login_id"] = $id;
        // $setParam["f_password"] = StretchedPassword::get_stretched_password($this->getSiteValue("SITE", "cis_login_encrypt_key"), $pwd);
        $setParam["f_password"] = $pwd;
        $setParam["f_del_flg"] = self::DEL_FLG_LIST_OFF;

        $res = parent::execCommand("m_user", "login", $setParam);
        // check
        if ($res === false) {
            $this->logger->error("m_user login ... NG");
            $this->errorPage($this->getMessage(STATUS_COMMON, "C_0009"));
            return $success;
        }
        if (count($res) <= 0) {
            return $success;
        }
        $_SESSION[USER_SESSION] = $res;
        return $success = true;
    }

    /**
     * ログインチェック処理
     *
     * @access  public
     * @return  bool
     */
    function isLogin()
    {
        $success = false;

        // ログイン情報保持配列がセットされていない場合
        if (!isset($_SESSION[USER_SESSION]) || sizeof($_SESSION[USER_SESSION]) <= 0) {
            $this->logger->info("Session connection is NG ...");
            return $success;
        }

        $setParam = array();
        $setParam["f_user_id"] = $_SESSION[USER_SESSION]["f_user_id"];

        if (!parent::is_Login("m_user", $setParam)) {
            $this->logger->info("Session connection is NG ...");
            return $success;
        }

        $this->logger->info("Session connection is OK ...");
        return $success = true;
    }

    /**
     * ワンタイムチケットを発行する
     *
     * @access  public
     * @return  void
     */
    function makeOnetimeTicket()
    {
        $this->onetime_ticket = OnetimeTicket::make_onetime_ticket();
        return;
    }

    /**
     * ワンタイムチケットをチェックする
     *
     * @access  public
     * @param   array
     * @return  void
     */
    function isOnetimeTicket($input)
    {
        $ticket = (isset($input["onetime_ticket"])) ? $input["onetime_ticket"] : "";
        // ワンタイムチケットチェック
        if (!OnetimeTicket::check_onetime_ticket($ticket)) {
            header("Location: csrf.php");
            exit();
        }
        $this->onetime_ticket = $input["onetime_ticket"];
        return;
    }

    /**
     * チェックボックス値をセットする
     *
     * @access    public
     * @param     array   $param
     * @param     array   $input
     * @param     string  $key
     */
    function setCheckBox(&$param, $input, $key, $chk = "")
    {
        $param[$key] = (isset($input[$key])) ? $input[$key] : "";
        if (isset($param[$chk]) && !is_empty($chk)) {
            $param[$chk] = (isset($input[$key])) ? "checked" : "";
        }
    }

    /**
     * チェックボックス値をセットする
     *
     * @access    public
     * @param     array   $param
     * @param     array   $input
     * @param     string  $key
     */
    function setCheckBoxies(&$param, $input, $key, $chk, $num)
    {
        for ($i=1; $i<=$num; $i++) {
            $k = $key . $i;
            $c = $chk . $i;
            $param[$k]   = (isset($input[$k])) ? $input[$k] : "";
            if (!is_empty($c) && isset($param[$c])) {
                $param[$c] = (isset($input[$k])) ? "checked"  : "";
            }
        }
    }

    /**
     * チェックボックス値をセットする
     *
     * @access    public
     * @param     array   $param
     * @param     array   $input
     * @param     string  $key
     */
    function setCheckBoxArray(&$param, $input, $key, $tar)
    {
        foreach ($tar as $k => $v) {
            $param[$key][$k] = (isset($input[$key][$k])) ? $input[$key][$k] : "";
        }
    }

    /**
     * zip, tel, faxデータをセットする
     *
     * @access    public
     * @param     array   $param
     * @param     string  $key
     */
    public function setParamFromExplode(&$param, $key)
    {
        // zip, tel, fax
        if (!is_empty($param["{$key}"])) {
            $tmp = t_explode($param["{$key}"], "-");
            for ($i=0; $i<count($tmp); $i++) {
                $idx = $i+1;
                $param["{$key}{$idx}"] = $tmp[$i];
            }
        }
    }

    /**
     * 履歴テーブル登録処理
     *
     * @access    public
     * @param     string    $action
     * @return    bool
     */
    function regist_history($param)
    {
        $success    = false;
        $table_name = "t_history";
        $curtime    = date("YmdHis", time());
        $user_id = NULL;
        if (isset($_SESSION[USER_SESSION])) {
            $user_id = $_SESSION[USER_SESSION]["f_user_id"];
        }
        // 登録データ生成
        $setParam = array();
        $setParam["f_user_id"]       = $user_id;
        $setParam["f_datetime"]      = $curtime;
        //$setParam["f_action"]        = $action;
        $setParam["f_del_flg"]       = DEL_FLG_LIST_OFF;
        $setParam["f_reg_account"]   = $user_id;
        $setParam["f_reg_time"]      = $curtime;
        $setParam["f_upd_account"]   = $user_id;
        $setParam["f_upd_time"]      = $curtime;
        // exec
        $sql = HandQuery::Insert($table_name, $setParam);
        $res = parent::execQuery($sql);
        // check
        if ($res === false) {
            $this->logger->error("Insert {$table_name} ... NG");
            return $success;
        }
        $this->logger->debug("Insert {$table_name} ... OK");
        return $success = true;
    }
}
?>
