<?php

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
        $this->table_name   = "m_admin";
        $this->session_name = ADMIN_INDEX_SESSION;
        $this->display      = "login.tpl";
        // cmd
        $cmd = array();
        $cmd["login"]       = "executeLogin";
        $cmd["logout"]      = "executeLogout";
        $cmd["timeout"]     = "executeTimeout";
        $cmd["default"]     = "executeDefault";
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
                     "f_account"                => "",
                     "f_password"               => "",
                     "f_id"                     => "",
                     "f_new_password"           => "",
                     "f_admin_id"               => "",
                     "errmsg"                   => $this->initErrmsg(),
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
                     "f_id"           => "",
                     "f_new_password" => "",
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
        if (!parent::Login($input["f_id"], $input["f_password"])) {
            $this->param["errmsg"]["login"] = $this->getMessage(STATUS_COMMON, "L_0001");
            return $success;
        }
        $this->smarty->assign("admin_login", $this->adminLoginCheckCommon());

        // init index
        $this->init_index($this->param);
        $this->display = "top.tpl";
        return $success = true;
    }

    function init_index(&$param)
    {
        // admin id
        $param["f_admin_id"] = $_SESSION[ADMIN_SESSION]["f_admin_id"];
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
        $_SESSION[ADMIN_SESSION] = NULL;
        unset($_SESSION[ADMIN_SESSION]);

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
        $succee = false;
        $this->logger->debug("Entering executeTimeout ...");
        $this->param["errmsg"]["login"] = "セッションがタイムアウトしました。";
        // unset session
        $_SESSION[ADMIN_SESSION] = NULL;
        unset($_SESSION[ADMIN_SESSION]);

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
     * 再発行完了処理
     *
     * @access   public
     * @param    array    $input   入力情報
     * @return   bool
     */
    function executeRemindComp($input)
    {
        $success = false;
        $this->logger->debug("Entering executeRemindComp ...");
        $this->display = "remind_e.tpl";
        $this->setParamFromSession($this->param);
        $this->setInputData($input, $this->param);
        // check
        if (!$this->remindCheck($input, $this->param)) {
            $this->display = "remind.tpl";
            return $success;
        }
        // start
        $this->begin();
        if (!$this->updatePassword($this->param)) {
            // rollback
            $this->rollback();
            $this->errorPage($this->getMessage(STATUS_COMMON, "C_0004"));
            $this->clearSession();
            unset($_SESSION[$this->session_name]);
            return $success;
        }
        // commit
        $this->commit();
        return $success = true;
    }

    /**
     * DB更新
     *
     * @access    public
     * @param     array    $param   出力値
     * @return    bool
     */
    function updatePassword($param)
    {
        $success = false;
        // 現在日付
        $curtime = date("YmdHis", time());
        // 更新データ生成
        $setParam = array();
        $setParam["f_password"] = StretchedPassword::get_stretched_password($this->getSiteValue("SITE", "cis_login_encrypt_key"), $param["f_new_password"]);
        $setParam["f_upd_time"] = $curtime;
        $where = array();
        $where["f_id"] = $param["f_id"];
        // exec
        $sql = HandQuery::UpdateKey($this->table_name, $setParam, $where);
        $res = parent::execQuery($sql);
        // check
        if ($res === false) {
            $this->logger->error("Update " . $this->table_name . " ... NG");
            return $success;
        }
        $this->logger->debug("Update " . $this->table_name . " ... OK");
        return $success = true;
    }

}
?>