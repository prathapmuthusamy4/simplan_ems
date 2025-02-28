<?php

/**
 * divyaDetailProcess
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license
 * @package    Simplan
 * @version    1.0
 */

include_once("indexCommon.php");
class detailProcess extends indexCommon
{
    /**
     * 初期設定
     *
     * @access    public
     * @return    array    コマンドリスト
     */
    function initProc()
    {
        $this->table_name   = 'm_addemployee';
        $this->session_name = USER_DETAIL_LIST_SESSION;
        $this->display      = 'detail.tpl';
        return array(
            'default' => 'executeDefault',
            'confirm' => 'executeConfirm',
            'reload'  => 'executeReload'
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
            "f_emp_id"                    => "",
            "f_name"                      => "",
            "f_gender"                    => "",
            "f_date_of_birth"             => "",
            "f_mobile_number"             => "",
            "f_office_email"              => "",

            "f_job_title"                 => "",
            "f_category"                  => "",

            "disp_status"                 => unserialize(ALLOW_STATUS_LIST),
            "disp_gender"                 => unserialize(ALLOW_GENDER_LIST),
            "disp_country"                => unserialize(ALLOW_COUNTRY_LIST),
            "disp_emp_status"             => unserialize(ALLOW_EMP_STATUS_LIST),
            'disp_blood_group'            => unserialize(STATUS_DISP_BLOOD_LIST),
            'disp_education'              => unserialize(ALLOW_EDUCATION_LIST),
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
            'system' => ''
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
        // session set
        $this->setSession($input, $this->param);
        return $success = true;
    }

    /**
     * 確認処理
     *
     * @access    public
     * @param     array    $input   入力値
     * @return    bool
     */
    function executeDetail($input)
    {  
        $success = false;
        // session clear
        $this->clearSession();
        // select
        if (!$this->select($input, $this->param)) {
            return $success;
        }
        // サムネイル画像をセット
        $this->setThumbnailImageName($this->param);
        // copy image
        $this->setCopyFile($this->param);
        // session
        $this->setSession($input, $this->param);
        return $success = true;
    }
}
?>
