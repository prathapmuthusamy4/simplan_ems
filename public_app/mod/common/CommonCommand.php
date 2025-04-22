<?php
/**
 * CommonCommand
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license
 * @package    Simplan.mod.common
 * @version    1.0
 */
class CommonCommand
{
    /* simplanAbstractProcess object */
    var $obj;
    /* logger */
    var $logger;

    /**
     * コンストラクタ
     *
     * @access    public
     * @param     obj
     * @return    void
     */
    public function CommonCommand($obj)
    {
        $this->obj    = $obj;
        $this->logger = $obj->logger;
    }

    /**
     * ID重複をチェックする
     *
     * @access    public
     * @param     string    $table_name
     * @param     string    $id
     * @param     stirng    $pid
     * @return    bool
     */
    function dup_id($table_name, $id, $pid = "")
    {
        if (is_empty($id)) {
            return false;
        }
        $setParam = array();
        $setParam["f_table_name"] = $table_name;      // テーブル名
        $setParam["f_tar"]        = $id;              // ID
        $setParam["f_id"]         = $pid;             // プライマリーキー
        $setParam["f_del_flg"]    = DEL_FLG_LIST_OFF; // 削除フラグ
        $res = $this->obj->execCommand($table_name, "dup_id", $setParam);
        // check
        if ($res === false) {
            $this->obj->errorPage($this->obj->getMessage(STATUS_COMMON, "C_0009"));
            return;
        }
        // set
        $count = (isset($res["count"])) ? $res["count"] : 0;
        if ($count > 0) {
            // 重複あり
            return false;
        }
        // 重複なし
        return true;
    }

    /**
     * メールアドレス重複をチェックする
     *
     * @access    public
     * @param     string    $table_name
     * @param     string    $mail
     * @param     stirng    $pid
     * @return    bool
     */
    function dup_mail($table_name, $mail, $pid = "")
    {
        if (is_empty($mail)) {
            return false;
        }
        $setParam = array();
        $setParam["f_table_name"]  = $table_name;      // テーブル名
        $setParam["f_mailaddress"] = $mail;            // メールアドレス
        $setParam["f_admin_id"]    = $pid;             // プライマリーキー
        $setParam["f_del_flg"]     = DEL_FLG_LIST_OFF; // 削除フラグ
        $res = $this->obj->execCommand($table_name, "dup_mail", $setParam);
        // check
        if ($res === false) {
            $this->obj->errorPage($this->obj->getMessage(STATUS_COMMON, "C_0009"));
            return;
        }
        // set
        $count = (isset($res["count"])) ? $res["count"] : 0;
        if ($count > 0) {
            // 重複あり
            return false;
        }
        // 重複なし
        return true;
    }

    /**
     * メールアドレス重複をチェックする
     *
     * @access    public
     * @param     string    $table_name
     * @param     string    $mail
     * @param     stirng    $pid
     * @return    bool
     */
    function dup_holiday($table_name, $holiday, $pid = "")
    {
        if (is_empty($holiday)) {
            return false;
        }
        $setParam = array();
        $setParam["f_table_name"]  = $table_name;      // テーブル名
        $setParam["f_holiday"]     = $holiday;            // メールアドレス
        $setParam["f_id"]          = $pid;             // プライマリーキー
        $setParam["f_del_flg"]     = DEL_FLG_LIST_OFF; // 削除フラグ
        $res = $this->obj->execCommand($table_name, "dup_holiday", $setParam);
        // check
        if ($res === false) {
            $this->obj->errorPage($this->obj->getMessage(STATUS_COMMON, "C_0009"));
            return;
        }
        // set
        $count = (isset($res["count"])) ? $res["count"] : 0;
        if ($count > 0) {
            // 重複あり
            return false;
        }
        // 重複なし
        return true;
    }

    /**
     * メールアドレス重複をチェックする
     *
     * @access    public
     * @param     string    $table_name
     * @param     string    $mail
     * @param     stirng    $pid
     * @return    bool
     */
    function dup_area_holiday($table_name, $holiday, $areaId, $pid = "")
    {
        if (is_empty($holiday)) {
            return false;
        }
        $setParam = array();
        $setParam["f_table_name"]  = $table_name;      // テーブル名
        $setParam["f_holiday"]     = $holiday;            // メールアドレス
        $setParam["f_area_id"]     = $areaId;
        $setParam["f_id"]          = $pid;             // プライマリーキー
        $setParam["f_del_flg"]     = DEL_FLG_LIST_OFF; // 削除フラグ
        $res = $this->obj->execCommand($table_name, "dup_holiday", $setParam);
        // check
        if ($res === false) {
            $this->obj->errorPage($this->obj->getMessage(STATUS_COMMON, "C_0009"));
            return;
        }
        // set
        $count = (isset($res["count"])) ? $res["count"] : 0;
        if ($count > 0) {
            // 重複あり
            return false;
        }
        // 重複なし
        return true;
    }

    /**
     * メールアドレス重複をチェックする
     *
     * @access    public
     * @param     string    $table_name
     * @param     string    $mail
     * @param     stirng    $pid
     * @return    bool
     */
    function dup_code($table_name, $code, $pid = "")
    {
        if (is_empty($code)) {
            return false;
        }
        $setParam = array();
        $setParam["f_table_name"]  = $table_name;      // テーブル名
        $setParam["f_code"]        = $code;            // メールアドレス
        $setParam["f_id"]          = $pid;             // プライマリーキー
        $setParam["f_del_flg"]     = DEL_FLG_LIST_OFF; // 削除フラグ
        $res = $this->obj->execCommand($table_name, "dup_code", $setParam);
        // check
        if ($res === false) {
            $this->obj->errorPage($this->obj->getMessage(STATUS_COMMON, "C_0009"));
            return;
        }
        // set
        $count = (isset($res["count"])) ? $res["count"] : 0;
        if ($count > 0) {
            // 重複あり
            return false;
        }
        // 重複なし
        return true;
    }

    /**
     * メールアドレス重複をチェックする
     *
     * @access    public
     * @param     string    $table_name
     * @param     string    $mail
     * @param     stirng    $pid
     * @return    bool
     */
    function dup_year($table_name, $year, $pid = "")
    {
        if (is_empty($year)) {
            return false;
        }
        $setParam = array();
        $setParam["f_table_name"]  = $table_name;      // テーブル名
        $setParam["f_year"]        = $year;            // メールアドレス
        $setParam["f_id"]          = $pid;             // プライマリーキー
        $setParam["f_del_flg"]     = DEL_FLG_LIST_OFF; // 削除フラグ
        $res = $this->obj->execCommand($table_name, "dup_year", $setParam);
        // check
        if ($res === false) {
            $this->obj->errorPage($this->obj->getMessage(STATUS_COMMON, "C_0009"));
            return;
        }
        // set
        $count = (isset($res["count"])) ? $res["count"] : 0;
        if ($count > 0) {
            // 重複あり
            return false;
        }
        // 重複なし
        return true;
    }

    /**
     * メールアドレス重複をチェックする
     *
     * @access    public
     * @param     string    $table_name
     * @param     string    $mail
     * @param     stirng    $pid
     * @return    bool
     */
    function dup_no($table_name, $no, $pid = "")
    {
        if (is_empty($no)) {
            return false;
        }
        $setParam = array();
        $setParam["f_table_name"]  = $table_name;      // テーブル名
        $setParam["f_no"]          = $no;            // メールアドレス
        $setParam["f_id"]          = $pid;             // プライマリーキー
        $setParam["f_del_flg"]     = DEL_FLG_LIST_OFF; // 削除フラグ
        $res = $this->obj->execCommand($table_name, "dup_no", $setParam);
        // check
        if ($res === false) {
            $this->obj->errorPage($this->obj->getMessage(STATUS_COMMON, "C_0009"));
            return;
        }
        // set
        $count = (isset($res["count"])) ? $res["count"] : 0;
        if ($count > 0) {
            // 重複あり
            return false;
        }
        // 重複なし
        return true;
    }

    /**
     * キーの重複をチェックする
     *
     * @access    public
     * @param     string    $table_name
     * @param     string    $key
     * @return    bool
     */
    function dup_key($table_name, $key)
    {
        if (is_empty($key)) {
            return false;
        }
        $setParam = array();
        $setParam["f_ref_key"] = $key; // キー
        $res = $this->obj->execCommand($table_name, "dup_key", $setParam);
        // check
        if ($res === false) {
            $this->obj->errorPage($this->obj->getMessage(STATUS_COMMON, "C_0009"));
            return;
        }
        // set
        $count = (isset($res["count"])) ? $res["count"] : 0;
        if ($count > 0) {
            // 重複あり
            return true;
        }
        // 重複なし
        return false;
    }

    /**
     * 請求書区分重複をチェックする
     *
     * @access    public
     * @param     string    $table_name
     * @param     string    $mail
     * @param     stirng    $pid
     * @return    bool
     */
    function dup_invoice($table_name, $invoice, $pid = "")
    {
        if (is_empty($invoice == COMPANY_PAYEE_INVOICE_KBN_ON)) {
            return true;
        }
        $setParam = array();
        $setParam["f_table_name"]  = $table_name;      // テーブル名
        $setParam["f_invoice_kbn"] = $invoice;            // メールアドレス
        $setParam["f_id"]          = $pid;             // プライマリーキー
        $setParam["f_del_flg"]     = DEL_FLG_LIST_OFF; // 削除フラグ
        $res = $this->obj->execCommand($table_name, "dup_invoice", $setParam);
        // check
        if ($res === false) {
            $this->obj->errorPage($this->obj->getMessage(STATUS_COMMON, "C_0009"));
            return;
        }
        // set
        $count = (isset($res["count"])) ? $res["count"] : 0;
        if ($count > 0) {
            // 重複あり
            return false;
        }
        // 重複なし
        return true;
    }

    /**
     * 仮パスワードの生成
     *
     * @access    public
     * @param     string    桁数
     * @return    string    仮パスワード
     */
    function makeTemporaryId($length = "8")
    {
        $string = array_merge(range("A", "Z"));
        $value  = NULL;
        for ($i=0; $i<$length; $i++) {
            $value .= $string[rand(0, count($string) - 1)];
        }
        // ランダム値のチェックを行う
        if (!$this->dupRandomValue($value)) {
            $value = $this->makeTemporaryId($length);
        }
        return $value;
    }

    /**
     * 仮パスワードの生成
     *
     * @access    public
     * @param     string    桁数
     * @return    string    仮パスワード
     */
    function makeTemporaryPassword($length = "8")
    {
        $string = array_merge(range("a", "z"), range("0", "9"), range("A", "Z"));
        $value  = NULL;
        for ($i=0; $i<$length; $i++) {
            $value .= $string[rand(0, count($string) - 1)];
        }
        // ランダム値のチェックを行う
        if (!$this->dupRandomValue($value)) {
            $value = $this->makeTemporaryPassword($length);
        }
        return $value;
    }

    /**
     * ランダム値重複をチェックする
     *
     * @access    public
     * @param     string    $value
     * @return    bool
     */
    function dupRandomValue($value)
    {
        if (is_empty($value)) {
            return false;
        }
        $tableName = "t_random_value";
        $setParam = array();
        $setParam["f_value"]   = $value;           // 値
        $setParam["f_del_flg"] = DEL_FLG_LIST_OFF; // 削除フラグ
        $res = $this->obj->execCommand($tableName, "dup_random_value", $setParam);
        // check
        if ($res === false) {
            $this->obj->errorPage($this->obj->getMessage(STATUS_COMMON, "C_0009"));
            return;
        }
        // set
        $count = (isset($res["count"])) ? $res["count"] : 0;
        if ($count > 0) {
            // 重複あり
            return false;
        }
        // 重複なし
        return true;
    }

    /**
     * 重複チェック（汎用）
     *
     * @access    public
     * @param     string    $table_name
     * @param     string    $no
     * @param     stirng    $pid
     * @return    bool
     */
    function dupUniqueItem($table_name, $item, $sql='dup_id', $where=array())
    {
        if (is_empty($table_name) || is_empty($item)) {
            return false;
        }
        $set_param = array();
        $set_param['item']      = $item;
        $set_param['f_del_flg'] = DEL_FLG_LIST_OFF;
        foreach ((array)$where as $key => $val) {
            // $key == 'primary_key'の値を設定した場合、対象を除外して検索する
            $set_param[$key] = $val;
        }
        $res = $this->obj->execCommand($table_name, $sql, $set_param);
        // check
        if ($res === false) {
            $this->obj->errorPage($this->obj->getMessage(STATUS_COMMON, "C_0009"));
            return;
        }
        // set
        $count = (isset($res["count"])) ? $res["count"] : 0;
        if ($count > 0) {
            // 重複あり
            return false;
        }
        // 重複なし
        return true;
    }
}
?>