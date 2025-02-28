<?php
    // echo 'prathap';exit;

/**
 *  indexProcess.php
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license
 * @package    Simplan
 * @version    1.0
 */
include_once("indexCommon.php");
class indexProcess extends indexCommon
{
    /**
     * 初期設定
     *
     * @access    public
     * @return    array    コマンドリスト
     */
    function initProc()
    {
        $this->table_name   = "m_user";
        $this->session_name = USER_INDEX_SESSION;
        $this->display      = "login.tpl";
        // cmd
        $cmd = array();
        $cmd["login"]       = "executeLogin";
        $cmd["logout"]      = "executeLogout";
        $cmd["timeout"]     = "executeTimeout";
        $cmd["default"]     = "executeDefault";
        $cmd["detail"]      = "executeDetail";
        $cmd["remind"]      = "executeRemind";
        $cmd["remind_comp"] = "executeRemindComp";
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
        return array(

                     "f_login_id"     => "",
                     "f_password"     => "",
                     "f_new_password" => "",
                     "f_mailaddress"   => "",
                     "errmsg"         => $this->initErrmsg(),


            "f_emp_id"                    => "",
            "f_name"                      => "",
            "f_aadhar_number"             => "",
            "f_pan_number"                => "",
            "f_passport"                  => "",
            "f_gender"                    => "",
            "f_date_of_birth"             => "",
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
            "f_education"                 => "",
            "f_degree"                    => "",
            "f_university"                => "",
            "f_additional_skill"          => "",
            "f_language"                  => "",
            "f_others"                    => "",
            "f_jlpt"                      => "",
            "f_image"                     => "",
            "f_thumb"                     => "",
            "tmp_f_image"                 => "",
            "tmp_f_image_del"             => "",
            "image_picture"               => "",
            "del_check"                   => "",
            "f_upd_time"                  => "",
                    
            "disp_status"                 => unserialize(ALLOW_STATUS_LIST),
            "disp_gender"                 => unserialize(ALLOW_GENDER_LIST),
            "disp_country"                => unserialize(ALLOW_COUNTRY_LIST),
            "disp_emp_status"             => unserialize(ALLOW_EMP_STATUS_LIST),
            'disp_blood_group'            => unserialize(STATUS_DISP_BLOOD_LIST),
        //  'disp_education'              => unserialize(ALLOW_EDUCATION_LIST),
            'disp_language'               => unserialize(ALLOW_LANGUAGE_LIST),
            'disp_jlpt'                   => unserialize(ALLOW_JLPT_LIST),
            // "dir_tmp"                     => $this->img_obj->getTempDir(),
            // "dir_img"                     => $this->img_obj->getFileDir(),
            // "url_tmp"                     => $this->img_obj->getIniSiteValue('img_temp_dir_profile_photo'),
            // "url_img"                     => $this->img_obj->getIniSiteValue('img_dir_profile_photo'),


                    );
    }

    /**
     * エラーメッセージ初期化
     *
     * @access    public
     * @return    array    エラーメッセージ
     */
    function initErrmsg()
    {
        return array(
                     "login"          => "",
                     "f_login_id"     => "",
                     "f_new_password" => "",
                     "f_mailaddress"  => "",
                     "system"         => "",
                    );
    }

    function precute($input)
    {
        parent::base_precute($input);
    }

    /**
     * デフォルト処理
     *
     * @access   public
     * @param    array    $input   入力情報
     * @return   bool
     */
    function executeDefault($input)
    {
        $success = false;
        $this->logger->debug("Entering execDefualt ...");
        $this->display = "login.tpl";

        // 既にログインしているかチェック
        if ($this->isLogin()) {
            // init index
            $this->init_index($this->param);
            $this->display = "top.tpl";
        }
        $this->searchDetail($input, $this->param);

        // session set
        $this->setSession($input, $this->param);

        return $success = true;
    }

        /**
     * executeDetail
     *
     * @access   public
     * @param    array    $input   入力情報
     * @return   bool
     */
    function executeDetail($input)
    {
        // print_r($input);exit;
        $success = false;
        $this->logger->debug("Entering execDetail ...");
        $this->display = "login.tpl";

        // 既にログインしているかチェック
        if ($this->isLogin()) {
            // init index
            $this->init_index($this->param);
            $this->display = "top.tpl";
        }
        $this->param["f_login_id"] = $_SESSION[USER_SESSION]["f_login_id"];
        $this->searchDetail($input, $this->param);

        // session set
        $this->setSession($input, $this->param);

        return $success = true;
    }
    /**
     * ログイン処理
     *
     * @access   public
     * @param    array    $input   入力情報
     * @return   bool
     */
    function executeLogin($input)
    {
        $success = false;
        $this->logger->debug("Entering executeLogin ...");
        $this->display = "login.tpl";

        // login
        if (parent::Login($input["f_login_id"], $input["f_password"])) {
            $this->param["f_login_id"] = $_SESSION[USER_SESSION]["f_login_id"];
            $this->searchDetail($input, $this->param);
        } else {
            $this->param["errmsg"]["login"] = $this->getMessage(STATUS_COMMON, "L_0001");
            return $success;
        }
        // 履歴テーブル登録処理（ログイン）
        $this->begin();
        if (!$this->regist_history(STATUS_ACTION_LOGIN)) {
            // rollback
            $this->rollback();
            $this->errorPage($this->getMessage(STATUS_COMMON, "C_0003"));
            $this->clearSession();
            unset($_SESSION[$this->session_name]);
            return $success;
        }


        // commit
        $this->commit();
        $this->smarty->assign("user_login", $this->userLoginCheckCommon());
        $this->display = "top.tpl";
        return $success = true;
    }

    function init_index(&$param)
    {
        // user id
        $param["f_user_id"] = $_SESSION[USER_SESSION]["f_login_id"];
        // $param['list']["f_name"] = $_SESSION[USER_SESSION]["f_name"];

        
    }

    /**
     * ログアウト処理
     *
     * @access   public
     * @param    array    $input   入力情報
     * @return   bool
     */
    function executeLogout($input)
    {
        $succee = false;
        $this->logger->debug("Entering executeLogout ...");
        // unset session
        $_SESSION[USER_SESSION] = NULL;
        unset($_SESSION[USER_SESSION]);

        $this->display = "login.tpl";
        return $success = true;
    }

    /**
     * タイムアウト処理
     *
     * @access   public
     * @param    array    $input   入力情報
     * @return   bool
     */
    function executeTimeout($input)
    {
        $success = false;
        $this->logger->debug("Entering executeTimeout ...");
        $this->param["errmsg"]["login"] = "セッションがタイムアウトしました。";
        // unset session
        $_SESSION[USER_SESSION] = NULL;
        unset($_SESSION[USER_SESSION]);

        $this->display = "login.tpl";
        return $success = true;
    }

    /**
     * 再発行処理
     *
     * @access   public
     * @param    array    $input   入力情報
     * @return   bool
     */
    function executeRemind($input)
    {
        $success = false;
        $this->logger->debug("Entering executeRemind ...");
        $this->display = "remind.tpl";

        return $success = true;
    }

    /**
     * リマインダーメール処理
     *
     * @access    public
     * @param     array    $input   入力値
     * @return    bool
     */
    function executeRemindComp($input)
    {   //print_r($input); exit;
        $success = false;
        $this->logger->debug('Entering executeRemindComp ...');
        $this->display = 'remind_e.tpl';
        // set
        $this->setParamFromSession($this->param);
        $this->setInputData($input, $this->param);
        // check input
        if (!$this->remindCheck($input, $this->param)) {
            $this->display = 'remind.tpl';
            return $success;
        }
        //print_r($this->param); exit;
        //echo $this->param["f_user_id"]; exit;
        //print_r($_SESSION); exit;
        // 管理情報
        $user_info = $this->param['user_info'];
        // 有効時間
        $datetime = new DateTime();
        $valid = $datetime->modify('+1 day')->format('YmdHis');
        // キー
        $ukey  = $this->make_key('t_password_remind', 30);

        //echo ">>>>"; exit;

        // start
        $this->begin();
        if (!$this->regist_password_remind($user_info, $ukey, $valid)) {
            // rollback
            $this->rollback();
            $this->errorPage($this->getMessage(STATUS_COMMON, 'C_0003'));
            $this->clearSession();
            unset($_SESSION[$this->session_name]);
            return $success;
        }
        // commit
        $this->commit();
        // ポータル利用メールを送信する
        $this->send_password_reissue_mail($user_info, $ukey);
        // clear session
        $this->clearSession();
        unset($_SESSION[$this->session_name]);
        $this->display = 'remind_e.tpl';

        return $success = true;
    }

    /**
     * パスワード再発行テーブル登録
     *
     * @access    public
     * @param     array    $param   出力値
     * @return    bool
     */
    function regist_password_remind($param, $ukey, $valid)
    {
        $success    = false;
        $table_name = 't_password_remind';
        $curtime    = date('YmdHis', time());
        // 削除条件
        $where = array();
        $where['f_user_id'] = $param['f_user_id'];
        // 削除処理
        $sql = HandQuery::DeleteKey($table_name, $where);
        $this->logger->debug($sql);
        $res = parent::execQuery($sql);
        // check
        if ($res === false) {
            $this->logger->error('Delete ' . $table_name . ' ... NG');
            return $success;
        }
        $this->logger->debug('Delete ' . $table_name . ' ... OK');
        // 登録データ生成
        $set_param = array();
        $set_param['f_user_id']   = $param['f_user_id'];
        $set_param['f_ref_key']    = $ukey;
        $set_param['f_valid_date'] = $valid;
        $set_param['f_del_flg']    = DEL_FLG_LIST_OFF;

        // exec
        $sql = HandQuery::Insert($table_name, $set_param);
        $res = parent::execQuery($sql);
        // check
        if ($res === false) {
            $this->logger->error('Insert ' . $table_name . ' ... NG');
            return $success;
        }
        $this->logger->debug('Insert ' . $table_name . ' ... OK');
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
        // print_r($this->param);exit;
        // $this->param["f_login_id"] = $_SESSION[USER_SESSION]["f_login_id"];
        // $this->param["f_login_id"] = $input['sid'];
        $success = false;
        // set input
        // $this->setInputData($input, $this->param);
        // list
        // $this->searchData($this->param);
        // session set

        $table_name = 'm_addemployee';
        $setParam = array();
        $setParam["where"]["f_del_flg"]  = DEL_FLG_LIST_OFF;                     // where
        $setParam["where"]["f_emp_id"]  = $this->param["f_emp_id"];                     // where
        // print_r($setParam);exit;

        // $dispCondition     = $this->makeDispCondition($setParam, $param["pno"]); // dispCondition
        // $setParam["limit"] = $this->makeLimitParam($dispCondition);              // limit
        // get list
        $res = parent::execCommand($table_name, "select_one", $setParam);

        // $res = parent::execCommand($table_name, "select_list", $setParam, RECODE_TYPE_LIST);
        // check
        if ($res === false) {
            $this->logger->error($this->table_name . " select_list ... NG");
            $this->errorPage($this->getMessage(STATUS_COMMON, "C_0007"));
            return;
        }
        // set
        $this->param["list"] = $res;
        // $param["page_info"] = $dispCondition;
        // print_r($param['list']);exit;

        // return;
    
        $this->setSession($input, $this->param);
        return $success = true;
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

}
?>
