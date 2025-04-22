<?php

/**
 *  addEmployee.php
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license
 * @package    Simplan
 * @version    1.0
 */

include_once(MOD_DIR . "/adminmod.php");

class salaryCommon extends adminProcess
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
    function salaryCommon($logger)
    {
        parent::adminProcess($logger);

        $this->app_name   = $this->getMessage("SITE", "site_admin_account_title");
        $this->img_obj    = new SimplanOperateFile($this->logger, $this->getSiteIni(), 'profile_photo');
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
        // 管理者区分
        if (!is_empty($param["f_emp_id"])) {
            $where["f_emp_id"] = $param["f_emp_id"];
        }
        // 管理者区分
        if (!is_empty($param["f_emp_status"])) {
            $where["f_emp_status"] = $param["f_emp_status"];
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
            $where["f_employee_id"] = $id;
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
        $key = array("f_employee_id" => $param["f_employee_id"],
                    "f_salary_month" => $param["f_salary_month"],
                    "f_del_flg"      => DEL_FLG_LIST_OFF,
                    );
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
     * アップロードファイルをチェックする
     *
     * @access    public
     * @param     array   $input   入力情報
     * @param     array   $param   出力情報
     * @return    bool
     */
    function uploadImageCheck($input, &$param)
    {
        $errList = array();
        // エラーフラグ
        $err_flg = false;
        // maxファイルサイズ（2MB制限）
        $max = $this->getSiteValue('SITE', 'img_max_size');
        // 拡張子
        $types = array('JPG', 'PNG', 'GIF');
        // 画像チェック
        if (isset($_FILES['tmp_f_image']) && $_FILES['tmp_f_image']['size'] > 0) {
            $upimg = $_FILES['tmp_f_image'];
            // ファイルサイズチェック
            if ($upimg['size'] > $max) {
                $msg = $this->getMessage(STATUS_ADMIN, 'A_0014');
                $errList['f_image'] = sprintf($msg, '画像', ($max / 1024 / 1024));
                $err_flg = true;
            }
            // 拡張子チェック
            if (!$this->img_obj->isMimeType($upimg, $types)) {
                $msg = $this->getMessage(STATUS_ADMIN, 'A_0015');
                $errList['f_image'] = sprintf($msg, '画像', implode(',', $types));
                $err_flg = true;
            }
        }

        /********************
         * judge
         ********************/
        if (sizeof($errList) > 0) {
            foreach ($errList as $key => $value) {
                $param['errmsg'][$key] = $value;
            }
            $param['errflg'] = true;
        }
        return $err_flg;
    }

    /**
     * サムネイル画像名をセット
     *
     * @access    public
     * @param     array   $param
     * @param     int     $key
     */
    function setThumbnailImageName(&$param)
    {
        if (isset($param['f_image']) && preg_match("/^(.+)\.(.+)$/", $param['f_image'], $res)) {
            if (isset($res[1]) && !is_empty($res[1]) && isset($res[2]) && !is_empty($res[2])) {
                $param['f_thumb'] = $res[1] . '_thumb.' . $res[2];
            }
        }
        return;
    }

    /**
     * removeImageFile
     * ファイルを削除する
     *
     * @access public
     * @param string  $target
     * @return boolean OK:true , NG:false
     */
    function removeImageFile($param)
    {
        $img_path = $this->param['dir_img'];
        if (isset($param['f_image'])) {
            $src = $img_path . $param['f_image'];
            $this->img_obj->removeFile($src);
        }
        if (isset($param['f_thumb'])) {
            $src = $img_path . $param['f_thumb'];
            $this->img_obj->removeFile($src);
        }
        return;
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
        $error->setUrl("addEmployee.php");
        $error->setProcess("");
        $error->setCmd("");
        $error->setName($this->app_name . "一覧");
        // 表示
        $error->forwardPage();
        return;
    }
}
?>