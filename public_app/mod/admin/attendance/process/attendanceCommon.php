<?php
/**
 *  attendanceCommon.php
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license
 * @package    Simplan
 * @version    1.0
 */
include_once(MOD_DIR . "/adminmod.php");
class attendanceCommon extends adminProcess
{
    var $error_info;
    var $table_name;
    var $app_name;
    var $check_file;
    var $page_record;

    /**
     * コンストラクタ
     *
     * @access    public
     * @param     object   ロガー
     */
    function attendanceCommon($logger)
    {
        parent::adminProcess($logger);

        $this->app_name   = $this->getMessage("SITE", "site_admin_attendance_title");
        $this->master     = new MasterCommand($this);
        $this->check_file = "input.check";
        $this->error_info = array(
            "pg_name"   => get_class($this),
            "func_name" => "",
            "msg"       => "",
        );
    }

    /**
     * 検索条件を生成する
     *
     * @access    public
     * @param     array   $param   出力情報
     * @return    array            検索条件
     */
    function makeSearchParam($param)
    {
        $where = array();
        // 削除フラグ
        $where["f_del_flg"] = DEL_FLG_LIST_OFF;
        // Name
        if (!is_empty($param["f_name"])) {
            $where["f_name"] = $param["f_name"];
        }
        // Start Date
        if (!is_empty($param["f_start_date"])) {
            $where["f_start_date"] = $param["f_start_date"];
        }
         //End Date
         if (!is_empty($param["f_end_date"])) {
            $where["f_end_date"] = $param["f_end_date"];
        }
        //Atendance Status
        if (!is_empty($param["f_status"])) {
        $where["f_status"] = $param["f_status"];
        }
        return $where;
    }

    /**
     * WHERE句を生成する
     *
     * @access    public
     * @param     string   $id   管理者ID
     * @return    array          検索条件
     */
    function makeWhereParam($id)
    {
        $where = array();
        // 削除フラグ
        $where["f_del_flg"] = DEL_FLG_LIST_OFF;
        // 管理者ID
        if (!is_empty($id)) {
            $where["f_attendance_id"] = $id;
        }
        return $where;
    }

    /**
     * 更新条件を生成する
     *
     * @access    public
     * @param     array   $param   出力情報
     * @return    array            更新条件
     */
    function makeUpdateKey($param)
    {
        $key = array("f_attendance_id" => $param["f_attendance_id"]);
        return $key;
    }

    /**
     * 入力をチェックする
     *
     * @access    public
     * @param     array   $input   入力情報
     * @param     array   $param   出力情報
     * @return    bool
     */
   function inputCheck($input, &$param)
    {
        $errList = parent::checkInput("input.check", $input);

        // leave reason
        if ((isset($input['f_leave_type'])) && $input['f_leave_type'] == ADMIN_LEAVE_KBN_OTHER) {
            if(is_empty($input['f_leave_reason'])) {
                $msg = $this->getMessage(STATUS_ADMIN, "A_0001");
                $errList['f_leave_reason'] = sprintf($msg, 'Leave Reason');
            }
        }
        /********************
         * judge
         ********************/
        if (sizeof($errList) > 0) {
            foreach ($errList as $key => $value) {
                $param["errmsg"][$key] = $value;
            }
            return false;
        }
        return true;
    }

    /**
     * エラーページ設定
     *
     * @access    public
     * @param     string   $msg   メッセージ
     */
    function errorPage($msg)
    {
        // object
        $error = $this->getErrorObject();
        // set
        $error->setContent($this->app_name);
        $error->setMessage($msg);
        $error->setUrl("attendance.php");
        $error->setProcess("");
        $error->setCmd("");
        $error->setName($this->app_name . "一覧");
        // 表示
        $error->forwardPage();
        return;
    }
}
?>
