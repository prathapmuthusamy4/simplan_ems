<?php

/**
 * newProcess
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license
 * @package    Simplan
 * @version    1.0
 */

include_once("attendanceCommon.php");

class newProcess extends attendanceCommon
{
    /**
     * 初期設定
     *
     * @access    public
     * @return    array    コマンドリスト
     */
    function initProc()
    {
        $this->table_name   = "t_attendance";
        $this->session_name = ADMIN_ATTENDANCE_NEW_SESSION;
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
            "f_name"         => "",
            "f_leave_type"   => "",
            "f_leave_reason" => "",
            "f_date"         => date("Y/m/d"),
            "disp_leave_kbn" => unserialize(ADMIN_LEAVE_KBN_LIST),
            "disp_name"      => $this->master->getListName("m_employe"),
            "errmsg"         => $this->initErrmsg(),
            "disp_type"      => DISP_TYPE_NEW,
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
            "f_name"         => "",
            "f_leave_type"   => "",
            "f_leave_reason" => "",
            "f_date"         => "",
            "system"         => "",
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
        $set_param = array();
        $set_param["f_name"]          = $param["f_name"];
        $set_param["f_leave_type"]    = $param["f_leave_type"];
        $set_param["f_leave_reason"]  = $param["f_leave_reason"];
        $set_param["f_date"]          = $param["f_date"];
        $set_param["f_del_flg"]       = DEL_FLG_LIST_OFF;
        $set_param["f_reg_account"]   = $_SESSION[ADMIN_SESSION]["f_admin_id"];
        $set_param["f_reg_time"]      = $curtime;
        $set_param["f_upd_account"]   = $_SESSION[ADMIN_SESSION]["f_admin_id"];
        $set_param["f_upd_time"]      = $curtime;
        // exec
        $sql = HandQuery::Insert($this->table_name, $set_param);
        $res = parent::execQuery($sql);
        // check
        if ($res === false) {
            $this->logger->error("Insert " . $this->table_name . " ... NG");
            return $success;
        }
        $this->logger->debug("Insert " . $this->table_name . " ... OK");
        return $success = true;
    }
}
?>
