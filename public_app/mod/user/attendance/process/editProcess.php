<?php

/**
 *  editProcess
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license
 * @package    Simplan
 * @version    1.0
 */

include_once("attendanceCommon.php");

class editProcess extends attendanceCommon
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
        $this->session_name = ADMIN_ATTENDANCE_EDIT_SESSION;
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
            "f_attendance_id" => "",
            "f_name"          => "",
            "f_leave_type"    => "",
            "f_leave_reason"  => "",
            "f_date"          => "",
            "f_upd_time"      => "",
            'disp_leave_kbn'  => unserialize(ADMIN_LEAVE_KBN_LIST),
            "disp_name"       => $this->master->getListName("m_employe"),
            "errmsg"          => $this->initErrmsg(),
            "disp_type"       => DISP_TYPE_EDIT,
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
        $cur_update = $this->getUpdateDate($this->param["f_attendance_id"]);
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
        $set_param = array();
        $set_param["f_name"]         = $param["f_name"];
        $set_param["f_leave_type"]   = $param["f_leave_type"];
        $set_param["f_leave_reason"] = $param["f_leave_reason"];
        $set_param["f_date"]         = $param["f_date"];
        $set_param["f_upd_account"]  = $_SESSION[ADMIN_SESSION]["f_admin_id"];
        $set_param["f_upd_time"]     = $curtime;
        // exec
        $sql = HandQuery::UpdateKey($this->table_name, $set_param, $this->makeUpdateKey($param));
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