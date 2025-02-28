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

include_once("accountCommon.php");

class delProcess extends accountCommon
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
        $this->session_name = ADMIN_ACCOUNT_DEL_SESSION;
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
            "f_admin_id"       => "",
            "f_name"           => "",
            "f_mailaddress"    => "",
            "f_id"             => "",
            "f_password"       => "",
            "f_admin_kbn"      => "",
            "f_upd_time"       => "",
            'disp_admin_kbn'   => unserialize(ADMIN_KBN_LIST),
            "errmsg"           => $this->initErrmsg(),
            "disp_type"        => DISP_TYPE_DEL,
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
            "system" => "",
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
        $cur_update = $this->getUpdateDate($this->param["f_admin_id"]);
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
        $this->logger->debug("Delete " . $this->table_name . " ... OK");
        return $success = true;
    }
}
?>