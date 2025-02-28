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

include_once("salaryCommon.php");

class newProcess extends salaryCommon
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
        $this->session_name = ADMIN_ADD_EMPLOYEE_EDIT_SESSION;
        $this->display      = "new.tpl";
        return array(
            "confirm" => "executeConfirm",
            "search"  => "executeSearch",
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
            "f_employee_id"               => "",
            "f_emp_id"                    => "",
            "f_name"                      => "",
            // "f_aadhar_number"             => "",
            // "f_pan_number"                => "",
            // "f_passport"                  => "",
            // "f_expiry_date"               => "",
            // "f_issue_date"                => "",
            // "f_gender"                    => "",
            // "f_date_of_birth"             => "",
            // "f_age"                       => "",
            // "f_blood_group"               => "",
            // "f_status"                    => "",
            // "f_address1"                  => "",
            // "f_address2"                  => "",
            // "f_city"                      => "",
            // "f_state"                     => "",
            // "f_pincode"                   => "",
            // "f_country"                   => "",
            // "f_mobile_number"             => "",
            // "f_office_telephone_number"   => "",
            // "f_office_email"              => "",
            // "f_personal_mail"             => "",
            // "f_relation_name"             => "",
            // "f_relationship"              => "",
            // "f_occupation"                => "",
            // "f_address"                   => "",
            // "f_phone_number"              => "",
            "f_job_title"                 => "",
            // "f_emp_status"                => "",
            "f_category"                  => "",
            "f_join_date"                 => "",
            // "f_relive_date"               => "",
            "f_location"                  => "",
            "f_upd_time"                  => "",
            // "f_experience"                => "",
            // "f_education_ug"              => "",
            // "f_degree_ug"                 => "",
            // "f_university_ug"             => "",
            // "f_education_pg"              => "",
            // "f_degree_pg"                 => "",
            // "f_university_pg"             => "",
            // "f_additional_skill"          => "",
            // "f_language"                  => array(),
            // "f_others"                    => "",
            // "f_jlpt"                      => "",
            // 'disp_gender'                 => unserialize(ALLOW_GENDER_LIST),
            // 'disp_status'                 => unserialize(ALLOW_STATUS_LIST),
            // 'disp_country'                => unserialize(ALLOW_COUNTRY_LIST),
            // 'disp_emp_status'             => unserialize(ALLOW_EMP_STATUS_LIST),
            // 'disp_blood_group'            => unserialize(STATUS_DISP_BLOOD_LIST),
            // 'disp_education_ug'           => unserialize(ALLOW_EDUCATION_UG_LIST),
            // 'disp_education_pg'           => unserialize(ALLOW_EDUCATION_PG_LIST),
            // 'disp_language'               => unserialize(ALLOW_LANGUAGE_LIST),
            // 'disp_jlpt'                   => unserialize(ALLOW_JLPT_LIST),
            // /*image*/
            // 'f_image'                     => '',
            // 'f_old_image'                 => '',
            // 'f_thumb'                     => '',
            // 'tmp_f_image'                 => '',
            // 'tmp_f_image_del'             => '',
            // 'image_picture'               => '',
            // 'del_check'                   => '',
            // 'copy_image'                  => '',
            // 'dir_tmp'                     => $this->img_obj->getTempDir(),
            // 'dir_img'                     => $this->img_obj->getFileDir(),
            // 'url_tmp'                     => $this->img_obj->getIniSiteValue('img_temp_dir_profile_photo'),
            // 'url_img'                     => $this->img_obj->getIniSiteValue('img_dir_profile_photo'),
            "errmsg"                      => $this->initErrmsg(),
            // "disp_type"                   => DISP_TYPE_EDIT,
            "f_salary_id"                 => "",
            "f_acc_no"                    => "",
            "f_bank_name"                 => "",
            "salary_month_search"          =>date("Y/m"),
            'f_salary_month'              => date("Y/m"),
            'f_no_of_working_days'        => "",
            'f_no_of_present_days'        => "",

            'f_basic_salary'              => "",
            'f_hra'                       => "",
            'f_medical'                   => "",
            'f_conveyance'                => "",
            'f_other_earnings'            => "",
            'f_total_earnings'            => "",
            'f_net_payable'               => "",

            'f_pf'                        => "",
            'f_tax'                       => "",
            'f_advance'                   => "",
            'f_loan'                      => "",
            'f_other_deduction'           => "",
            'f_total_deduction'           => "",
            'f_leave_allowed'             => "",
            'f_leave_taken'               => "",
            'f_leave_balance'             => "",


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
            "f_employee_id"               => "",
            "f_emp_id"                    => "",
            "f_name"                      => "",
            // "f_aadhar_number"             => "",
            // "f_pan_number"                => "",
            // "f_passport"                  => "",
            // "f_expiry_date"               => "",
            // "f_issue_date"                => "",
            // "f_gender"                    => "",
            // "f_date_of_birth"             => "",
            // "f_age"                       => "",
            // "f_blood_group"               => "",
            // "f_status"                    => "",
            // "f_address1"                  => "",
            // "f_address2"                  => "",
            // "f_city"                      => "",
            // "f_state"                     => "",
            // "f_pincode"                   => "",
            // "f_country"                   => "",
            // "f_mobile_number"             => "",
            // "f_office_telephone_number"   => "",
            // "f_office_email"              => "",
            // "f_personal_mail"             => "",
            // "f_relation_name"             => "",
            // "f_relationship"              => "",
            // "f_occupation"                => "",
            // "f_address"                   => "",
            // "f_phone_number"              => "",
            "f_job_title"                 => "",
            // "f_emp_status"                => "",
            "f_category"                  => "",
            "f_join_date"                 => "",
            // "f_relive_date"               => "",
            "f_location"                  => "",
            // "f_experience"                => "",
            // "f_education_ug"              => "",
            // "f_degree_ug"                 => "",
            // "f_university_ug"             => "",
            // "f_education_pg"              => "",
            // "f_degree_pg"                 => "",
            // "f_university_pg"             => "",
            // "f_additional_skill"          => "",
            // "f_language"                  => "",
            // "f_others"                    => "",
            // "f_jlpt"                      => "",
            // 'f_image'                     => '',
            // 'tmp_f_image'                 => '',
            // "system"                      => "",
            "salary_month_search"          =>"",
            "f_salary_id"                 => "",

            "f_acc_no"                    => "",
            "f_bank_name"                 => "",
            'f_salary_month'              => "",
            'f_no_of_working_days'        => "",
            'f_no_of_present_days'        => "",

            'f_basic_salary'              => "",
            'f_hra'                       => "",
            'f_medical'                   => "",
            'f_conveyance'                => "",
            'f_other_earnings'            => "",
            'f_total_earnings'            => "",
            'f_net_payable'               => "",


            'f_pf'                        => "",
            'f_tax'                       => "",
            'f_advance'                   => "",
            'f_loan'                      => "",
            'f_other_deduction'           => "",
            'f_total_deduction'           => "",
            'f_leave_allowed'             => "",
            'f_leave_taken'               => "",
            'f_leave_balance'             => "",

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
        if ((!$this->select($input, $this->param))){
            return $success;
        }
        if ((!$this->selectSalary($input, $this->param ))) {
            return $success;
        }


        // $this->param['f_language'] = t_explode($this->param['f_language'], ",");
        // サムネイル画像をセット
        // $this->setThumbnailImageName($this->param);
        // copy image
        // $this->setCopyFile($this->param);
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
        // $this->setInputData($input, $this->param);
        // list
        // $this->searchData($this->param);
        // $this->passportCheck($this->param);
        $this->isOnetimeTicket($input);

        $this->setParamFromSession($this->param);
        $this->setInputData($input, $this->param);
        $table_name = "t_salary";
        $where = [];
        $where["f_salary_month"] = $input['salary_month_search'];
        // 削除フラグ
        $where["f_del_flg"] = DEL_FLG_LIST_OFF;
        // 管理者ID
            $where["f_employee_id"] = $input['sid'];
        $set_param['where'] = $where;
        $res = parent::execCommand($table_name, "select_one", $set_param);

        // if ((!$this->selectSalary($input, $this->param ))) {
        //     return $success;
        // }
        
        foreach($this->param as $key => $value) {
            if (array_key_exists($key, $res)) {
                $this->param[$key] = $res[$key];
            }
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
        // $in1 = $this->setParamFromSession($this->param);
        // print_r($input);exit;
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

        // $this->employeeAge($input);
        // $this->setCheckBox($this->param, $input, 'tmp_f_image_del', 'del_check'); // 画像削除フラグ
        // 画像ファイルのチェック
        // $check_img = $this->uploadImageCheck($input, $this->param);
        // 画像ファイルがOKならテンポラリに一旦設置
        // if ($check_img === false) {
        //     $this->setUploadImage($this->param);
        // }
        // ファイル調整
        // $this->setAdjustImage($this->param);
        // $this->param['f_language'] = (isset($input['f_language'])) ? $input['f_language'] : NULL;


        // check input
        // $query_name = 'get_edit_check';
        // if ((!$this->inputCheck($input, $this->param)) || (!$this->checkInputData($input, $query_name))) {
        //     $this->display = "new.tpl";
        //     return $success;
        // }
         // session
        $this->setSession($input, $this->param);
        $success = true;
        return $success;
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
        $this->display = "new_c.tpl";
        // get session from param
        $this->setParamFromSession($this->param);
        // if ($this->param['f_age'] < 18) {
        //     $this->display = "new_c.tpl";
        //     $this->param['errmsg']['f_age'] = 'You are not eligible';
        //     return $success;
        // }
        // check
        // $cur_update = $this->getUpdateDate($this->param["f_employee_id"]);
        // if ($cur_update != $this->param["f_upd_time"]) {
        //     $this->errorPage($this->getMessage(STATUS_COMMON, "C_0002"));
        //     return $success;
        // }
        // start
        $this->begin();
        // if (!$this->regist($this->param) || !$this->upadateId($this->param)) {
        if (!$this->regist($this->param)) {
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
        $this->display = "new_e.tpl";
        return $success = true;
    }

    /**
     * DB更新
     *
     * @access    public
     * @param     array    $param   出力値
     * @return    bool
     */
    function regist($param)
    {
        $success = false;
        $curtime = date("YmdHis", time());
        // 更新データ生成
        $set_param = [];
        $set_param["f_employee_id"]               = $param["f_employee_id"];
        // $set_param["f_name"]                      = $param["f_name"];
        // $set_param["f_job_title"]                 = $param["f_job_title"];
        // $set_param["f_category"]                  = $param["f_category"];
        // $set_param["f_join_date"]                 = $param["f_join_date"];
        // $set_param["f_location"]                  = $param["f_location"];
        // $set_param["f_acc_no"]                    = $param["f_acc_no"];
        // $set_param["f_bank_name"]                 = $param["f_bank_name"];
        $set_param["f_salary_month"]              = $param["f_salary_month"];
        $set_param["f_no_of_working_days"]        = $param["f_no_of_working_days"];
        $set_param["f_no_of_present_days"]        = $param["f_no_of_present_days"];
        $set_param["f_basic_salary"]              = $param["f_basic_salary"];
        $set_param["f_hra"]                       = $param["f_hra"];
        $set_param["f_medical"]                   = $param["f_medical"];
        $set_param["f_conveyance"]                = $param["f_conveyance"];
        $set_param["f_other_earnings"]            = $param["f_other_earnings"];
        $set_param["f_total_earnings"]            = $param["f_total_earnings"];
        $set_param["f_net_payable"]               = $param["f_net_payable"];
        $set_param["f_pf"]                        = $param["f_pf"];
        $set_param["f_tax"]                       = $param["f_tax"];
        $set_param["f_advance"]                   = $param["f_advance"];
        $set_param["f_loan"]                      = $param["f_loan"];
        $set_param["f_other_deduction"]           = $param["f_other_deduction"];
        $set_param["f_total_deduction"]           = $param["f_total_deduction"];
        $set_param["f_leave_allowed"]             = $param["f_leave_allowed"];
        $set_param["f_leave_taken"]               = $param["f_leave_taken"];
        $set_param["f_leave_balance"]             = $param["f_leave_balance"];

        $set_param["f_reg_account"]               = $_SESSION[ADMIN_SESSION]["f_admin_id"];
        $set_param["f_reg_time"]                  = $curtime;
        $set_param["f_upd_account"]               = $_SESSION[ADMIN_SESSION]["f_admin_id"];
        $set_param["f_upd_time"]                  = $curtime;
        // exec
        $table_name = 't_salary';
        $where_param = $this->makeUpdateKey($param);
        $set_param1 = [];
        $set_param1['where'] = $where_param;
        
        // update
        $res = parent::execCommand($table_name, "select_one", $set_param1);

        if (!empty($res)) {
            $where_param = $this->makeUpdateKey($param);
            $sql = HandQuery::UpdateKey($table_name, $set_param, $where_param);
            $res = parent::execQuery($sql);
         
        // insert new record
        } else {
            $sql = HandQuery::Insert($table_name, $set_param);
            $res = parent::execQuery($sql);
        }
        // check
        if ($res === false) {
            $this->logger->error("regist " . $table_name . " ... NG");
            return $success;
        }
        // Handle Image File
        // $this->handleImageFile($image);
        $this->logger->debug("regist " . $table_name . " ... OK");
        return $success = true;
    }

    /**
     * DB登録
     *
     * @access    public
     * @param     array    $param   出力値
     * @return    bool
     */
    function upadateId(&$param)
    {
        $success = false;
        // 現在日付
        $curtime = date("YmdHis", time());
        // image info
        // $image = $this->makeImageFileName();
        // 登録データ生成
        $set_param = array();
        $set_param["f_login_id"]                  = $param["f_emp_id"];
        $set_param["f_name"]                      = $param["f_name"];
        $set_param["f_password"]                  = str_replace("/","",$param["f_date_of_birth"]);
        $set_param["f_mailaddress"]               = $param["f_office_email"];
        $set_param["f_reg_account"]               = $_SESSION[ADMIN_SESSION]["f_admin_id"];
        $set_param["f_reg_time"]                  = $curtime;
        $set_param["f_upd_account"]               = $_SESSION[ADMIN_SESSION]["f_admin_id"];
        $set_param["f_upd_time"]                  = $curtime;
         // exec
        $sql = HandQuery::Insert('m_user', $set_param);
        $res = parent::execQuery($sql);
        // check
        if ($res === false) {
            $this->logger->error("Insert " . 'm_user' . " ... NG");
            return $success;
        }
        // Handle Image File
        // $this->handleImageFile($image);

        $this->logger->debug("Insert " . 'm_user' . " ... OK");
        return $success = true;
    }


    /**
     * WHERE句を生成する
     *
     * @access    public
     * @param     string   $id   管理者ID
     * @return    array          検索条件
     */
    function makeSalaryWhereParam($id)
    {
        $where = array();
        $where["f_salary_month"] = date("Y/m");
        // 削除フラグ
        $where["f_del_flg"] = DEL_FLG_LIST_OFF;
        // 管理者ID
        if (!is_empty($id)) {
            $where["f_employee_id"] = $id;
        }
        return $where;
    }

    /**
     * データを取得する
     *
     * @access    public
     * @param     string   $id    対象ID
     * @pram      array    $res   対象データ
     */
    function getSalaryData($id)
    {
        $success = false;
        $table_name = "t_salary";
        // 検索条件
        $setParam = array();
        $setParam["where"] = $this->makeSalaryWhereParam($id);


        $res = parent::execCommand($table_name, "select_one", $setParam);
        // check
        if ($res === false) {
            $this->logger->error($this->table_name . " select_one ... NG");
            $this->errorPage($this->getMessage(STATUS_COMMON, "C_0009"));
            return $success;
        }
        return $res;
    }


    /**
     * データ取得
     *
     * @access    public
     * @param     array   $input
     * @param     array   $param
     * @return    bool
     */
    function selectSalary($input, &$param)
    {
        $success = false;
        // check
        if (!isset($input["sid"]) || is_empty($input["sid"])) {
            $this->errorPage($this->getMessage(STATUS_COMMON, "C_0009"));
            return $success;
        }
        // set
        $res = $this->getSalaryData($input["sid"]);
        // print_r($res);exit;
        foreach($param as $key => $value) {
            if (array_key_exists($key, $res)) {
                $param[$key] = $res[$key];
            }
        }

        return $success = true;
    }
}
?>
