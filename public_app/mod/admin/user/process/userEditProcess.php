<?php
/**
 *  userEditProcess
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license
 * @package    Simplan
 * @version    1.0
 */
include_once("userCommon.php");
class userEditProcess extends userCommon
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
        $this->session_name = ADMIN_USER_EDIT_SESSION;
        $this->display      = "edit.tpl";
        return array(
                     "confirm" => "executeConfirm",
                     "update"  => "executeUpdate",
                     "default" => "executeDefault",
                     "back"    => "executeBack",
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
                       "f_upd_time"       => "",
                       "errmsg"           => $this->initErrmsg(),
                       "disp_type"        => DISP_TYPE_EDIT,
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
        // select
        if (!$this->select($input, $this->param)) {
            return $success;
        }
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
        $this->display = "edit_c.tpl";
        if (!isset($_SESSION[$this->session_name])) {
            $this->errorPage($this->getMessage(STATUS_COMMON, "C_0002"));
            return $success;
        }
        // set
        $this->setParamFromSession($this->param);
        $this->setInputData($input, $this->param);
        // check input
        if (!$this->inputCheck($input, $this->param)) {
            $this->display = "edit.tpl";
            return $success;
        }
        $this->setSession($input, $this->param);
        return $success = true;
    }

    /**
     * 更新処理
     *
     * @access    public
     * @param     array    $input   入力値
     * @return    bool
     */
    function executeUpdate($input)
    {
        $success = false;
        // ワンタイムチケットチェック
        $this->isOnetimeTicket($input);
        $this->display = "edit_c.tpl";
        // get session from param
        $this->setParamFromSession($this->param);
        // check
        $cur_update = $this->getUpdateDate($this->param["f_user_id"]);
        if ($cur_update != $this->param["f_upd_time"]) {
            $this->errorPage($this->getMessage(STATUS_COMMON, "C_0002"));
            return $success;
        }
        // start
        $this->begin();
        if (!$this->update($this->param)) {
            // rollback
            $this->rollback();
            $this->errorPage($this->getMessage(STATUS_COMMON, "C_0004"));
            $this->clearSession();
            unset($_SESSION[$this->session_name]);
            return $success;
        }
        // commit
        $this->commit();
        // clear session
        $this->clearSession();
        unset($_SESSION[$this->session_name]);
        $this->display = "edit_e.tpl";
        return $success = true;
    }

    /**
     * DB更新
     *
     * @access    public
     * @param     array    $param   出力値
     * @return    bool
     */
    function update($param)
    {
        $success = false;
        $curtime = date("YmdHis", time());
        // 更新データ生成
        $setParam = array();
        $setParam["f_surname"]        = $param["f_surname"];
        $setParam["f_surname_kana"]   = $param["f_surname_kana"];
        $setParam["f_mailaddress"]    = $param["f_mailaddress"];
        $setParam["f_login_id"]       = $param["f_login_id"];
        if (!is_empty($param["f_password"])) {
            $setParam["f_password"]   = StretchedPassword::get_stretched_password($this->getSiteValue("SITE", "cis_login_encrypt_key"), $param["f_password"]);
        }
        $setParam["f_upd_account"]    = $_SESSION[ADMIN_SESSION]["f_admin_id"];
        $setParam["f_upd_time"]       = $curtime;
        // exec
        $sql = HandQuery::UpdateKey($this->table_name, $setParam, $this->makeUpdateKey($param));
        $res = parent::execQuery($sql);
        // check
        if ($res === false) {
            $this->logger->error("Update " . $this->table_name . " ... NG");
            return $success;
        }
        $this->logger->debug("Update " . $this->table_name . " ... OK");
        return $success = true;
    }
}
?>