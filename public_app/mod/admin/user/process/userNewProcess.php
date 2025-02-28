<?php
/**
 * userNewProcess
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license
 * @package    Simplan
 * @version    1.0
 */
include_once("userCommon.php");
class userNewProcess extends userCommon
{
    /**
     * 初期設定
     *
     * @access    public
     * @return    array    コマンドリスト
     */
    function initProc()
    {
        $this->table_name   = "m_user";
        $this->session_name = ADMIN_USER_NEW_SESSION;
        $this->display      = "new.tpl";
        return array(
                     "confirm" => "executeConfirm",
                     "regist"  => "executeRegist",
                     "back"    => "executeBack",
                     "default" => "executeDefault",
                    );
    }

    /**
     * 表示パラメータ初期化
     *
     * @access    public
     * @return    array    出力パラメータ
     */
    function initParam()
    {
        // init
        $param = array(
                       "f_user_id"        => "",
                       "f_surname"        => "",
                       "f_surname_kana"   => "",
                       "f_mailaddress"    => "",
                       "f_login_id"       => "",
                       "f_password"       => "",
                       "f_password_conf"  => "",
                       "errmsg"           => $this->initErrmsg(),
                       "disp_type"        => DISP_TYPE_NEW,
                      );
        return $param;
    }

    /**
     * エラーメッセージ初期化
     *
     * @access    public
     * @return    array    エラーメッセージ
     */
    function initErrmsg()
    {
        // init
        $errmsg = array(
                        "f_surname"        => "",
                        "f_surname_kana"   => "",
                        "f_mailaddress"    => "",
                        "f_login_id"       => "",
                        "f_password"       => "",
                        "f_password_conf"  => "",
                        "system"           => "",
                       );
        return $errmsg;
    }

    /**
     * デフォルト処理
     *
     * @access    public
     * @param     array    $input   入力値
     * @return    bool
     */
    function executeDefault($input)
    {
        $success = false;
        // ワンタイムチケットを発行する
        $this->makeOnetimeTicket();
        // session clear
        $this->clearSession();
        // session set
        $this->setSession($input, $this->param);
        return $success = true;
    }

    /**
     * バック処理
     *
     * @access    public
     * @param     array    $input   入力値
     * @return    bool
     */
    function executeBack($input)
    {
        $success = false;
        // ワンタイムチケットチェック
        $this->isOnetimeTicket($input);
        // get session
        $this->setParamFromSession($this->param);
        return $success = true;
    }

    /**
     * 登録処理
     *
     * @access    public
     * @param     array    $input   入力値
     * @return    bool
     */
    function executeRegist($input)
    {
        $success = false;
        // ワンタイムチケットチェック
        $this->isOnetimeTicket($input);
        $this->display = "new_c.tpl";
        if (!isset($_SESSION[$this->session_name])) {
            $this->errorPage($this->getMessage(STATUS_COMMON, "C_0002"));
            return $success;
        }
        // get session from param
        $this->setParamFromSession($this->param);
        // start
        $this->begin();
        if (!$this->regist($this->param)) {
            // rollback
            $this->rollback();
            $this->errorPage($this->getMessage(STATUS_COMMON, "C_0003"));
            $this->clearSession();
            unset($_SESSION[$this->session_name]);
            return $success;
        }
        // commit
        $this->commit();
        // clear session
        $this->clearSession();
        unset($_SESSION[$this->session_name]);
        $this->display = "new_e.tpl";
        return $success = true;
    }

    /**
     * DB登録
     *
     * @access    public
     * @param     array    $param   出力値
     * @return    bool
     */
    function regist(&$param)
    {
        $success = false;
        // 現在日付
        $curtime = date("YmdHis", time());
        // 登録データ生成
        $setParam = array();
        $setParam = array();
        $setParam["f_surname"]        = $param["f_surname"];
        $setParam["f_surname_kana"]   = $param["f_surname_kana"];
        $setParam["f_mailaddress"]    = $param["f_mailaddress"];
        $setParam["f_login_id"]       = $param["f_login_id"];
        $setParam["f_password"]       = StretchedPassword::get_stretched_password($this->getSiteValue("SITE", "cis_login_encrypt_key"), $param["f_password"]);
        $setParam["f_del_flg"]        = DEL_FLG_LIST_OFF;
        $setParam["f_reg_account"]    = $_SESSION[ADMIN_SESSION]["f_admin_id"];
        $setParam["f_reg_time"]       = $curtime;
        $setParam["f_upd_account"]    = $_SESSION[ADMIN_SESSION]["f_admin_id"];
        $setParam["f_upd_time"]       = $curtime;
        // exec
        $sql = HandQuery::Insert($this->table_name, $setParam);
        $res = parent::execQuery($sql);
        // check
        if ($res === false) {
            $this->logger->error("Insert " . $this->table_name . " ... NG");
            return $success;
        }
        $this->logger->debug("Insert " . $this->table_name . " ... OK");
        $param["f_admin_id"] = $this->getInsertID();
        return $success = true;
    }

    /**
     * 確認処理
     *
     * @access    public
     * @param     array    $input   入力値
     * @return    bool
     */
    function executeConfirm($input)
    {
        $success = false;
        // ワンタイムチケットチェック
        $this->isOnetimeTicket($input);
        $this->display = "new_c.tpl";
        if (!isset($_SESSION[$this->session_name])) {
            $this->errorPage($this->getMessage(STATUS_COMMON, "C_0002"));
            return $success;
        }
        // set
        $this->setParamFromSession($this->param);
        $this->setInputData($input, $this->param);
        // check input
        if (!$this->inputCheck($input, $this->param)) {
            $this->display = "new.tpl";
            return $success;
        }
        // session
        $this->setSession($input, $this->param);
        return $success = true;
    }
}
?>