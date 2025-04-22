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

include_once("addEmployeeCommon.php");

class editProcess extends addEmployeeCommon
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
            "f_employee_id"               => "",
            "f_emp_id"                    => "",
            "f_name"                      => "",
            "f_aadhar_number"             => "",
            "f_pan_number"                => "",
            "f_passport"                  => "",
            "f_expiry_date"               => "",
            "f_issue_date"                => "",
            "f_gender"                    => "",
            "f_date_of_birth"             => "",
            "f_age"                       => "",
            "f_blood_group"               => "",
            "f_status"                    => "",
            "f_address1"                  => "",
            "f_address2"                  => "",
            "f_city"                      => "",
            "f_state"                     => "",
            "f_pincode"                   => "",
            "f_country"                   => "",
            "f_mobile_number"             => "",
            "f_office_telephone_number"   => "",
            "f_office_email"              => "",
            "f_personal_mail"             => "",
            "f_relation_name"             => "",
            "f_relationship"              => "",
            "f_occupation"                => "",
            "f_address"                   => "",
            "f_phone_number"              => "",
            "f_job_title"                 => "",
            "f_emp_status"                => "",
            "f_category"                  => "",
            "f_join_date"                 => "",
            "f_relive_date"               => "",
            "f_location"                  => "",
            "f_upd_time"                  => "",
            "f_experience"                => "",
            "f_education_ug"              => "",
            "f_degree_ug"                 => "",
            "f_university_ug"             => "",
            "f_education_pg"              => "",
            "f_degree_pg"                 => "",
            "f_university_pg"             => "",
            "f_additional_skill"          => "",
            "f_language"                  => array(),
            "f_others"                    => "",
            "f_jlpt"                      => "",
            "f_bank_name"                 => "",
            "f_bank_branch"               => "",
            "f_acc_no"                    => "",
            "f_ifsc_code"                 => "",
            'disp_gender'                 => unserialize(ALLOW_GENDER_LIST),
            'disp_status'                 => unserialize(ALLOW_STATUS_LIST),
            'disp_country'                => unserialize(ALLOW_COUNTRY_LIST),
            'disp_emp_status'             => unserialize(ALLOW_EMP_STATUS_LIST),
            'disp_blood_group'            => unserialize(STATUS_DISP_BLOOD_LIST),
            'disp_education_ug'           => unserialize(ALLOW_EDUCATION_UG_LIST),
            'disp_education_pg'           => unserialize(ALLOW_EDUCATION_PG_LIST),
            'disp_language'               => unserialize(ALLOW_LANGUAGE_LIST),
            'disp_jlpt'                   => unserialize(ALLOW_JLPT_LIST),
            /*image*/
            'f_image'                     => '',
            'f_old_image'                 => '',    
            'f_thumb'                     => '',
            'tmp_f_image'                 => '',
            'tmp_f_image_del'             => '',
            'image_picture'               => '',
            'del_check'                   => '',
            'copy_image'                  => '',
            'dir_tmp'                     => $this->img_obj->getTempDir(),
            'dir_img'                     => $this->img_obj->getFileDir(),
            'url_tmp'                     => $this->img_obj->getIniSiteValue('img_temp_dir_profile_photo'),
            'url_img'                     => $this->img_obj->getIniSiteValue('img_dir_profile_photo'),
            "errmsg"                      => $this->initErrmsg(),
            "disp_type"                   => DISP_TYPE_EDIT,
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
            "f_aadhar_number"             => "",
            "f_pan_number"                => "",
            "f_passport"                  => "",
            "f_expiry_date"               => "",
            "f_issue_date"                => "",
            "f_gender"                    => "",
            "f_date_of_birth"             => "",
            "f_age"                       => "",
            "f_blood_group"               => "",
            "f_status"                    => "",
            "f_address1"                  => "",
            "f_address2"                  => "",
            "f_city"                      => "",
            "f_state"                     => "",
            "f_pincode"                   => "",
            "f_country"                   => "",
            "f_mobile_number"             => "",
            "f_office_telephone_number"   => "",
            "f_office_email"              => "",
            "f_personal_mail"             => "",
            "f_relation_name"             => "",
            "f_relationship"              => "",
            "f_occupation"                => "",
            "f_address"                   => "",
            "f_phone_number"              => "",
            "f_job_title"                 => "",
            "f_emp_status"                => "",
            "f_category"                  => "",
            "f_join_date"                 => "",
            "f_relive_date"               => "",
            "f_location"                  => "",
            "f_experience"                => "",
            "f_education_ug"              => "",
            "f_degree_ug"                 => "",
            "f_university_ug"             => "",
            "f_education_pg"              => "",
            "f_degree_pg"                 => "",
            "f_university_pg"             => "",
            "f_additional_skill"          => "",
            "f_language"                  => "",
            "f_others"                    => "",
            "f_jlpt"                      => "",
            'f_image'                     => '',
            'tmp_f_image'                 => '',
            "f_bank_name"                 => "",
            "f_bank_branch"               => "",
            "f_acc_no"                    => "",
            "f_ifsc_code"                 => "",
            "system"                      => "",
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
        $this->param['f_language'] = t_explode($this->param['f_language'], ",");
        // サムネイル画像をセット
        $this->setThumbnailImageName($this->param);
        // copy image
        $this->setCopyFile($this->param);
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
        $this->setCheckBox($this->param, $input, 'tmp_f_image_del', 'del_check'); // 画像削除フラグ
        // 画像ファイルのチェック
        $check_img = $this->uploadImageCheck($input, $this->param);
        // 画像ファイルがOKならテンポラリに一旦設置
        if ($check_img === false) {
            $this->setUploadImage($this->param);
        }
        // ファイル調整
        $this->setAdjustImage($this->param);
        $this->param['f_language'] = (isset($input['f_language'])) ? $input['f_language'] : NULL;
        // check input
        $query_name = 'get_edit_check';
        if ((!$this->inputCheck($input, $this->param)) || (!$this->checkInputData($input, $query_name))) {
            $this->display = "edit.tpl";
            return $success;
        }
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
        $this->display = "edit_c.tpl";
        // get session from param
        $this->setParamFromSession($this->param);
        if ($this->param['f_age'] < 18) {
            $this->display = "edit_c.tpl";
            $this->param['errmsg']['f_age'] = 'You are not eligible';
            return $success;
        }
        // check
        $cur_update = $this->getUpdateDate($this->param["f_employee_id"]);
        if ($cur_update != $this->param["f_upd_time"]) {
            $this->errorPage($this->getMessage(STATUS_COMMON, "C_0002"));
            return $success;
        }
        // start
        $this->begin();
        if (!$this->update($this->param) || !$this->upadateId($this->param)) {
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
        // image info
        $image = $this->makeImageFileName();
        // 更新データ生成
        $set_param = array();
        $set_param["f_emp_id"]                    = $param["f_emp_id"];
        $set_param["f_name"]                      = $param["f_name"];
        $set_param["f_aadhar_number"]             = $param["f_aadhar_number"];
        $set_param["f_pan_number"]                = $param["f_pan_number"];
        $set_param["f_passport"]                  = $param["f_passport"];
        $set_param["f_expiry_date"]               = $param["f_expiry_date"];
        $set_param["f_issue_date"]                = $param["f_issue_date"];
        $set_param["f_gender"]                    = $param["f_gender"];
        $set_param["f_date_of_birth"]             = $param["f_date_of_birth"];
        $set_param["f_age"]                       = $param["f_age"];
        $set_param["f_blood_group"]               = $param["f_blood_group"];
        $set_param["f_status"]                    = $param["f_status"];
        $set_param["f_address1"]                  = $param["f_address1"];
        $set_param["f_address2"]                  = $param["f_address2"];
        $set_param["f_city"]                      = $param["f_city"];
        $set_param["f_state"]                     = $param["f_state"];
        $set_param["f_pincode"]                   = $param["f_pincode"];
        $set_param["f_country"]                   = $param["f_country"];
        $set_param["f_mobile_number"]             = $param["f_mobile_number"];
        $set_param["f_office_telephone_number"]   = $param["f_office_telephone_number"];
        $set_param["f_office_email"]              = $param["f_office_email"];
        $set_param["f_personal_mail"]             = $param["f_personal_mail"];
        $set_param["f_relation_name"]             = $param["f_relation_name"];
        $set_param["f_relationship"]              = $param["f_relationship"];
        $set_param["f_occupation"]                = $param["f_occupation"];
        $set_param["f_address"]                   = $param["f_address"];
        $set_param["f_phone_number"]              = $param["f_phone_number"];
        $set_param["f_job_title"]                 = $param["f_job_title"];
        $set_param["f_emp_status"]                = $param["f_emp_status"];
        $set_param["f_category"]                  = $param["f_category"];
        $set_param["f_join_date"]                 = $param["f_join_date"];
        $set_param["f_relive_date"]               = $param["f_relive_date"];
        $set_param["f_location"]                  = $param["f_location"];
        $set_param['f_image']                     = $image['image'];
        $set_param["f_experience"]                = $param["f_experience"];
        $set_param["f_education_ug"]              = $param["f_education_ug"];
        $set_param["f_degree_ug"]                 = $param["f_degree_ug"];
        $set_param["f_university_ug"]             = $param["f_university_ug"];
        $set_param["f_education_pg"]              = $param["f_education_pg"];
        $set_param["f_degree_pg"]                 = $param["f_degree_pg"];
        $set_param["f_university_pg"]             = $param["f_university_pg"];
        $set_param["f_additional_skill"]          = $param["f_additional_skill"];
        $set_param["f_language"]                  = t_implode($param["f_language"], ",");
        $set_param["f_others"]                    = $param["f_others"];
        $set_param["f_jlpt"]                      = $param["f_jlpt"];
        $set_param["f_bank_name"]                 = $param["f_bank_name"];
        $set_param["f_bank_branch"]               = $param["f_bank_branch"];
        $set_param["f_acc_no"]                    = $param["f_acc_no"];
        $set_param["f_ifsc_code"]                 = $param["f_ifsc_code"];
        $set_param["f_reg_account"]               = $_SESSION[ADMIN_SESSION]["f_admin_id"];
        $set_param["f_reg_time"]                  = $curtime;
        $set_param["f_upd_account"]               = $_SESSION[ADMIN_SESSION]["f_admin_id"];
        $set_param["f_upd_time"]                  = $curtime;
        // exec
        $sql = HandQuery::UpdateKey($this->table_name, $set_param, $this->makeUpdateKey($param));
        $res = parent::execQuery($sql);
        // check
        if ($res === false) {
            $this->logger->error("Update " . $this->table_name . " ... NG");
            return $success;
        }
        // Handle Image File
        $this->handleImageFile($image);
        $this->logger->debug("Update " . $this->table_name . " ... OK");
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
        $image = $this->makeImageFileName();
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
        $this->handleImageFile($image);
        $this->logger->debug("Insert " . 'm_user' . " ... OK");
        return $success = true;
    }
}
?>
