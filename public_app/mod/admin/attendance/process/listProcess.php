<?php

/**
 *  listProcess
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license
 * @package    Simplan
 * @version    1.0
 */

include_once("attendanceCommon.php");

class listProcess extends attendanceCommon
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
        $this->session_name = ADMIN_ATTENDANCE_LIST_SESSION;
        $this->page_record  = "attendance_page_record";
        $this->display      = "list.tpl";
        // cmd
        $cmd = array();
        $cmd["reload"]      = "executeReload";
        $cmd["change_page"] = "executeChangePage";
        $cmd["search"]      = "executeSearch";
        $cmd["default"]     = "executeDefault";
        return $cmd;
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
            "f_attendance_id"  => "",
            "f_name"           => "",
            "f_leave_type"     => "",
            "f_start_date"     => "",
            "f_end_date"       => "",
            "f_status"         => "",
            "attendance_count" => "",
            "list"             => array(),
            "disp_leave_kbn"   => unserialize(ADMIN_LEAVE_KBN_LIST),
            "disp_attendance"  => unserialize(ADMIN_ATTENDANCE_VIEW_LIST),
            "disp_name"        => $this->master->getListName("t_attendance"),
            "none"             => $this->getMessage(STATUS_COMMON, "C_0014"),
            "errmsg"           => $this->initErrmsg(),
            "pno"              => 1,
            "page_info"        => "",
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
            "system" => "",
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
        // session clear
        $this->clearSession();
        // list
        $this->searchData($this->param);
        // set
        $this->setSession($input, $this->param);
        $success = true;
        return $success;
    }

    /**
     * リロード処理
     *
     * @access    public
     * @param     array    $input   入力値
     * @return    bool
     */
    function executeReload($input)
    {
        $success = false;
        // get session
        $this->setParamFromSession($this->param);
        // list
        $this->searchData($this->param);
        // session set
        $this->setSession($input, $this->param);

        return $success = true;
    }

    /**
     * 改ページ処理
     *
     * @access    public
     * @param     array    $input   入力値
     * @return    bool
     */
    function executeChangepage($input)
    {
        $success = false;
        // get session
        $this->setParamFromSession($this->param);
        $this->param["pno"] = $input["pno"];
        // list
        $this->searchData($this->param);
        // session set
        $this->setSession($input, $this->param);

        return $success = true;
    }

    /**
     * 検索処理
     *
     * @access    public
     * @param     array    $input   入力値
     * @return    bool
     */
    function executeSearch($input)
    {
        $success = false;
        // set input
        $this->setInputData($input, $this->param);
        // list
        $this->searchData($this->param);
        // attendance count
        $this->param["attendance_count"] = count($this->param['list']);
        // session set
        $this->setSession($input, $this->param);
        return $success = true;
    }
}
?>
