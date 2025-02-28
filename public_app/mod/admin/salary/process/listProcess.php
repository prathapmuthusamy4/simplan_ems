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

include_once("salaryCommon.php");

class listProcess extends salaryCommon
{
    /**
     * 初期設定
     *
     * @access    public
     * @return    array    コマンドリスト
     */
    function initProc()
    {
        $this->table_name   = "m_addemployee";
        $this->session_name = ADMIN_SALARY_LIST_SESSION;
        $this->page_record  = "salary_page_record";
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
            "f_emp_id"        => "",
            "f_name"          => "",
            "f_image"         => "",
            "f_emp_status"    => "",
            'disp_emp_status' => unserialize(ALLOW_EMP_STATUS_LIST),
            'url_img'         => $this->img_obj->getIniSiteValue('img_dir_profile_photo'),
            "list"            => array(),
            "none"            => $this->getMessage(STATUS_COMMON, "C_0014"),
            "errmsg"          => $this->initErrmsg(),
            "pno"             => 1,
            "page_info"       => "",
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
            "f_emp_id"     => "",
            "f_name"       => "",
            "f_emp_status" => "",
            "system"       => "",
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
        // session set
        $this->setSession($input, $this->param);
        return $success = true;
    }
}
?>
