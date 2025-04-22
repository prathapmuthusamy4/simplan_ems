<?php
/**
 *  userCommon.php
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license
 * @package    Simplan
 * @version    1.0
 */
include_once(MOD_DIR . "/adminmod.php");
class userCommon extends adminProcess
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
    function userCommon($logger)
    {
        parent::adminProcess($logger);

        $this->app_name   = $this->getMessage("SITE", "site_admin_user_title");
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
        // 名前
        if (!is_empty($param["f_name"])) {
            $where["f_name"] = $param["f_name"];
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
            $where["f_user_id"] = $id;
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
        $key = array("f_user_id" => $param["f_user_id"]);
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
        $check = ($param["disp_type"] == DISP_TYPE_NEW) ? "new" : "edit";
        $errList = parent::checkInput("input_{$check}.check", $input);

        // パスワードとパスワード確認の一致
        if (is_empty(t_array_value("f_password", $errList)) && is_empty(t_array_value("f_password_conf", $errList))) {
            if ($input["f_password"] != $input["f_password_conf"]) {
                $errList["f_password_conf"] = $this->getMessage(STATUS_COMMON, "C_0010");
            }
        }
        // $com = new CommonCommand($this);
        // // duplicate id
        // if (is_empty(t_array_value("f_login_id", $errList))) {
        //     if (!$com->dup_id($this->table_name, $input["f_login_id"], $param["f_user_id"])) {
        //         $errList["f_login_id"] = $this->getMessage(STATUS_COMMON, "C_0011");
        //     }
        // }
        // // duplicate mail
        // if (is_empty(t_array_value("f_mailaddress", $errList)) && !is_empty($input["f_mailaddress"])) {
        //     if (!$com->dup_mail($this->table_name, $input["f_mailaddress"], $param["f_user_id"])) {
        //         $msg = $this->getMessage(STATUS_COMMON, "C_0024");
        //         $errList['f_mailaddress'] = sprintf($msg, 'メールアドレス');
        //     }
        // }
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
        $error->setUrl("user.php");
        $error->setProcess("");
        $error->setCmd("");
        $error->setName($this->app_name . "一覧");
        // 表示
        $error->forwardPage();
        return;
    }
}
?>