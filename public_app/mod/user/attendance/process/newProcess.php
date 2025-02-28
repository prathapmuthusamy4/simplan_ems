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
        $this->table_name   = "t_user_attendance";
        $this->session_name = USER_ATTENDANCE_NEW_SESSION;
        $this->display      = "new.tpl";
        date_default_timezone_set('Asia/Kolkata');
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
            "f_emp_id"       => "",
            "f_name"         => "",
            "f_date"         => date("d-m-Y"),
            "f_start_date"   => "",
            "f_end_date"     => "",
            "f_time"         => date('H:i A'),
            "f_status"       => "",
            "f_leave_reason" => "",
            "f_leave_type"   => "",
            "list_count"     => "",
            "disp_attendance" => unserialize(USER_ATTENDANCE_LIST),
            "disp_leave_kbn" => unserialize(ADMIN_LEAVE_KBN_LIST),
            
            // "disp_name"      => $this->master->getListName("m_employe"),
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
            "f_emp_id"       => "",
            "f_name"         => "",
            "f_start_date"   => "",
            "f_end_date"     => "",
            "f_time"         => "",
            "f_status"       => "",
            "f_leave_reason" => "",
            "f_date"         => "",
            "f_leave_type"   => "",
            "list_count"     => "",
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
        // print_r($_SESSION[USER_SESSION]);exit;
        $this->param["f_emp_id"] = $_SESSION[USER_SESSION]["f_login_id"];
        $this->param["f_name"] = $_SESSION[USER_SESSION]["f_name"];

        $success = false;
        // ワンタイムチケットを発行する
        $this->makeOnetimeTicket();
        // session clear
        $this->clearSession();
        // session set
        $this->searchDetail($input, $this->param);
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
        // print_r($this->param);exit;

        // check input
        if (!$this->inputCheck($input, $this->param)) {
            $this->display = "new.tpl";
            return $success;
        }
        // if (($this->param['f_status'] == 2) && empty($this->param['f_leave_type']) ) {
        //     $this->param['errmsg']['f_leave_type'] = "please select the leave type";
        //     // print_r($this->errmsg);exit;
        //     $this->display = "new.tpl";
        //     return $success;
        // }
        // if ($this->param['f_leave_type'] != 4) {
        //     $this->param['f_leave_reason'] = "";
        // }
        // if ($this->param['f_status'] ==1) {
        //     $this->param['f_leave_type'] = "";
        // }

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
        // print_r($_SESSION[USER_SESSION]);exit;
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
        // print_r($this->param);exit;

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
        // print_r($param['f_date']);exit;
        $success = false;
        // 現在日付
        $curtime = date("YmdHis", time());
        $curdate = date('Y-m-d');
        // 登録データ生成
        $set_param = array();

        $set_param["f_emp_id"]       = $param["f_emp_id"];
        $set_param["f_name"]         = $param["f_name"];
        $set_param["f_date"]         = $param["f_date"];
        $set_param["f_start_date"]   = $param["f_start_date"];
        $set_param["f_end_date"]     = $param["f_end_date"];
        $set_param["f_status"]       = $param["f_status"];
        $set_param["f_leave_type"]   = $param["f_leave_type"];
        $set_param["f_leave_reason"] = $param["f_leave_reason"];
        $set_param["f_date"]         = $curdate;
        $set_param["f_time"]         = $param["f_time"];

        // $set_param["f_leave_reason"]  = $param["f_leave_reason"];
        // $set_param["f_date"]          = $param["f_date"];
        $set_param["f_del_flg"]       = DEL_FLG_LIST_OFF;
        $set_param["f_reg_account"]   = $_SESSION[USER_SESSION]["f_login_id"];
        $set_param["f_reg_time"]      = $curtime;
        $set_param["f_upd_account"]   = $_SESSION[USER_SESSION]["f_login_id"];
        $set_param["f_upd_time"]      = $curtime;
        // print_r($set_param);exit;
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

            /**
     * 検索処理
     *
     * @access    public
     * @param     array    $input   入力値
     * @return    bool
     */
    function searchDetail($input, &$param)
    {
        // $this->param["f_login_id"] = $_SESSION[USER_SESSION]["f_login_id"];
        $success = false;
        $cur_date = date('Y-m-d');
        // table name
        $table_name = 't_user_attendance';
        // set param
        $setParam = array();
        $setParam["where"]["f_del_flg"] = DEL_FLG_LIST_OFF;
        $setParam["where"]["f_emp_id"]  = $this->param["f_emp_id"];
        $setParam["where"]["f_date"]    = $cur_date;
        // get count
        $res = parent::execCommand($table_name, "select_user_count", $setParam);
        // check
        if ($res === false) {
            $this->logger->error($this->table_name . " select_user ... NG");
            $this->errorPage($this->getMessage(STATUS_COMMON, "C_0007"));
            return;
        }

        // set
        // print_r($res);exit;
        $param["list_count"] = $res;
        // print_r($this->param["list_count"] );exit;
        $this->setSession($input, $this->param);
        return $success = true;
    }
}
?>
