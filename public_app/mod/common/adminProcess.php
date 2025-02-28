<?php
include_once("TemplateProcess.php");
/**
 * adminProcess
 * 管理者共通プロセス
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license
 * @package    Simplan
 * @version    1.0
 */
class adminProcess extends TemplateProcess
{
    /* メッセージ */
    var $message;
    /* ワンタイムチケット */
    var $onetime_ticket = "";

    /**
     * 削除フラグ
     * 0 : 未削除, 1 : 削除済み
     */
    const DEL_FLG_OFF = '0';

    /**
     * コンストラクタ
     *
     * @access    public
     * @param     $logger  ロガー
     */
    function adminProcess($logger)
    {
        parent::baseProcess($logger);
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
        $common["head_tpl"] = "file:" . HTML_DIR . "admin_head.tpl";
        $common["menu_tpl"] = "file:" . HTML_DIR . "admin_menu.tpl";
        $common["foot_tpl"] = "file:" . HTML_DIR . "admin_foot.tpl";
        $common["popup_head_tpl"] = "file:" . HTML_DIR . "admin_popup_head.tpl";
        $common["popup_foot_tpl"] = "file:" . HTML_DIR . "admin_popup_foot.tpl";
        return $common;
    }

    /**
     * adminLoginCheckCommon
     *
     * @access    public
     */
    function adminLoginCheckCommon()
    {
        // 初期化
        $var = array(
            "login_check"   => false,
            "f_admin_id"    => "",
            "f_name"        => "",
            "f_mailaddress" => "",
            "f_admin_kbn"   => "",
            "f_auth"        => "",
            "f_auth_value"  => "",
        );

        // セッションチェック
        if (isset($_SESSION[ADMIN_SESSION]) && sizeof($_SESSION[ADMIN_SESSION]) > 0) {
            $tmp = $_SESSION[ADMIN_SESSION];
            // セッション情報をセット
            $var = array(
                "login_check"   => true,                     // ログインチェック
                "f_admin_id"    => $tmp["f_admin_id"],       // 管理者ID
                "f_name"        => $tmp["f_name"],           // 主催者名
                "f_mailaddress" => $tmp["f_mailaddress"],    // メールアドレス
                "f_admin_kbn"   => $tmp["f_admin_kbn"],      // 管理者区分
                "f_auth"        => $tmp["f_auth"],
                "f_auth_value"  => $tmp["f_auth_value"],
            );
        }
        return $var;
    }

    /**
     * adminAuthCheckCommon
     *
     * @access    public
     */
    function adminAuthCheckCommon()
    {
        // 初期化
        $auth = array(
            "auth_1"  => "",
            "auth_2"  => "",
            "auth_4"  => "",
            "auth_8"  => "",
            "auth_16" => "",
            "auth_32" => "",
            "auth_64" => ""
        );
        // セッションチェック
        if (isset($_SESSION[ADMIN_SESSION]) && sizeof($_SESSION[ADMIN_SESSION]) > 0) {
            // セッション情報をセット
            $authChk = new AuthCheck();
            $auth_val = $_SESSION[ADMIN_SESSION]["f_auth"];
            $auth = array(
                "auth_1"  => $authChk->is_auth_1($auth_val),
                "auth_2"  => $authChk->is_auth_2($auth_val),
                "auth_4"  => $authChk->is_auth_4($auth_val),
                "auth_8"  => $authChk->is_auth_8($auth_val),
                "auth_16" => $authChk->is_auth_16($auth_val),
                "auth_32" => $authChk->is_auth_32($auth_val),
                "auth_64" => $authChk->is_auth_64($auth_val)
            );
        }
        return $auth;
    }

    /**
     * getErrorObject
     *
     * @access  public
     */
    function getErrorObject()
    {
        $obj = new adminErrorPage($this->logger, $this->smarty);
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
        // 権限チェック
        // if (!$this->isAuth($input)) {
        //     $page = $_SERVER["PHP_SELF"]; // page name
        //     header("Location: deny.php");
        //     exit();
        // }
        parent::base_precute($input);
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
        $this->param["logininfo"] = $this->adminLoginCheckCommon();
        // 権限情報をセット
        $this->param["admin_auth"] = $this->adminAuthCheckCommon();
        // ワンタイムチケットをセット
        $this->smarty->assign("onetime_ticket", $this->onetime_ticket);
        parent::base_postcute($input, STATUS_ADMIN);
        parent::postcute($input);
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
        $set_param = [];
        $set_param["f_id"]       = $id;
        $set_param["f_password"] = StretchedPassword::get_stretched_password($this->getSiteValue("SITE", "cis_login_encrypt_key"), $pwd);
        $set_param['f_del_flg']    = self::DEL_FLG_OFF;
        // print_r($set_param);exit;

        $res = parent::execCommand("m_admin", "login", $set_param);
        // print_r($res);exit;

        // check
        if ($res === false) {
            echo 'admin_login_fails';exit;
            $this->logger->error("m_admin login ... NG");
            $this->errorPage($this->getMessage(STATUS_COMMON, "C_0009"));
            return $success;
        }
        if (count($res) <= 0) {
            // echo '2';exit;

            return $success;
        }
        $_SESSION[ADMIN_SESSION] = $res;
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
        if (!isset($_SESSION[ADMIN_SESSION]) || sizeof($_SESSION[ADMIN_SESSION]) <= 0) {
            $this->logger->info("Session connection is NG ...");
            return $success;
        }

        $setParam = array();
        $setParam["f_admin_id"] = $_SESSION[ADMIN_SESSION]["f_admin_id"];
        if (!parent::is_Login("m_admin", $setParam)) {
            $this->logger->info("Session connection is NG ...");
            return $success;
        }

        $this->logger->info("Session connection is OK ...");
        return $success = true;
    }

    /**
     * 権限チェック処理
     *
     * @access  public
     * @return  bool
     */
    function isAuth($input)
    {
        $success = false;
        $this->logger->info("Auth CHECK ...");
        $authChk  = new AuthCheck();
        $page     = $_SERVER["PHP_SELF"];               // page name
        $prc      = $input["prc"];                      // prc
        $auth_val = $_SESSION[ADMIN_SESSION]["f_auth"]; // auth val
        //ACCESS CHECK
        $success = $authChk->page_check($page, $prc, $auth_val);
        return $success;
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
     * 年月日の日付を結合する
     *
     * @access    public
     * @param     array   $param
     * @param     string  $key
     */
    public function getDateByKey($param, $key)
    {
        $date = NULL;
        if (!is_empty($param["{$key}_y"]) && !is_empty($param["{$key}_m"]) && !is_empty($param["{$key}_d"])) {
            $date = date("Ymd", SimplanUtil::makeDateByKey($key, $param));
        }
        return $date;
    }
}
/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>