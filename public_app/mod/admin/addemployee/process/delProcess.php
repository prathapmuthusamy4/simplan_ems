<?php
/**
 *  delProcess
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license
 * @package    Simplan
 * @version
 */
include_once("addEmployeeCommon.php");
class delProcess extends addEmployeeCommon
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
        $this->session_name = ADMIN_ADD_EMPLOYEE_DEL_SESSION;
        $this->display      = "del_c.tpl";
        return array(
                     "confirm" => "executeConfirm",
                     "delete"  => "executeDelete",
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
                       "f_language"                  => array(),
                       "f_others"                    => "",
                       "f_jlpt"                      => "",
                       "f_bank_name"                 => "",
                       "f_bank_branch"               => "",
                       "f_acc_no"                    => "",
                       "f_ifsc_code"                 => "",
                       "f_upd_time"                  => "",
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
                       "f_image"                     => "",
                       "f_thumb"                     => "",
                       "tmp_f_image"                 => "",
                       "tmp_f_image_del"             => "",
                       "image_picture"               => "",
                       "del_check"                   => "",
                       "f_upd_time"                  => "",
                       "dir_tmp"                     => $this->img_obj->getTempDir(),
                       "dir_img"                     => $this->img_obj->getFileDir(),
                       "url_tmp"                     => $this->img_obj->getIniSiteValue('img_temp_dir_profile_photo'),
                       "url_img"                     => $this->img_obj->getIniSiteValue('img_dir_profile_photo'),
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
            "f_expiry_date" => "",
            "system"        => "",
        );
        return $errmsg;
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
        // ワンタイムチケットを発行する
        $this->makeOnetimeTicket();
        // session clear
        $this->clearSession();
        // select
        if(!$this->select($input, $this->param)) {
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
     * 削除処理
     *
     * @access    public
     * @param     array    $input   入力値
     * @return    bool
     */
    function executeDelete($input)
    {
        $success = false;
        // ワンタイムチケットチェック
        $this->isOnetimeTicket($input);
        $this->display = "del_c.tpl";
        // SESSIONからデータ取り出し
        $this->setParamFromSession($this->param);
        // check
        $cur_update = $this->getUpdateDate($this->param["f_employee_id"]);
        if ($cur_update != $this->param["f_upd_time"]) {
            $this->errorPage($this->getMessage(STATUS_COMMON, "C_0002"));
            return $success;
        }
        // トランザクション開始
        $this->begin();
        if (!$this->delete($this->param)) {
            // ロールバック
            $this->rollback();
            $this->errorPage($this->getMessage(STATUS_COMMON, "C_0004"));
            $this->clearSession();
            unset($_SESSION[$this->session_name]);
            return $success;
        }
        $this->commit();
        // SESSION 破棄
        $this->clearSession();
        unset($_SESSION[$this->session_name]);
        $this->display = "del_e.tpl";
        return $success = true;
    }

    /**
     * DB削除
     *
     * @access    public
     * @param     array    $param   出力値
     * @return    bool
     */
    function delete($param)
    {
        $success = false;
        $curtime = date("YmdHis", time());
        // 削除データ生成
        $setParam = array();
        $setParam["f_del_flg"]     = DEL_FLG_LIST_ON;
        $setParam["f_upd_account"] = $_SESSION[ADMIN_SESSION]["f_admin_id"];
        $setParam["f_upd_time"]    = $curtime;
        // exec
        $sql = HandQuery::UpdateKey($this->table_name, $setParam, $this->makeUpdateKey($param));
        $res = parent::execQuery($sql);
        // check
        if ($res === false) {
            $this->logger->error("Delete " . $this->table_name . " ... NG");
            return $success;
        }
        // remove image
        $this->removeImageFile($param);
        $this->logger->debug("Delete " . $this->table_name . " ... OK");
        return $success = true;
    }
}
?>