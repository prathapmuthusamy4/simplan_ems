<?php
/**
 * MasterCommand
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license
 * @package    Simplan.mod.common
 * @version    1.0
 */
class MasterCommand
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
    public function MasterCommand($obj)
    {
        $this->obj    = $obj;
        $this->logger = $obj->logger;
    }

    /**
     * 各テーブルのデータを取得する
     *
     * @access    public
     * @param     string    $tableName
     * @param     string    $colum
     * @param     string    $key
     * @param     string    $val
     * @return    string
     */
    function getOne($tableName, $colum, $key = "", $val = "")
    {
        // 検索条件
        $setParam = array();
        $setParam["f_del_flg"] = DEL_FLG_LIST_OFF; // 削除フラグ
        if (!is_empty($key) && !is_empty($val)) {
            $setParam[$key] = $val;
        }
        $res = $this->obj->execCommand($tableName, "one", $setParam);
        // check
        if ($res === false) {
            $this->obj->errorPage($this->obj->getMessage(STATUS_COMMON, "C_0009"));
            return;
        }
        return (isset($res[$colum])) ? $res[$colum] : NULL;
    }

    /**
     * 各テーブルのデータを取得する
     *
     * @access    public
     * @param     string    $tableName
     * @param     string    $key
     * @param     string    $val
     * @return    string
     */
    function getOneData($tableName, $key = "", $val = "")
    {
        // 検索条件
        $setParam = array();
        $setParam["f_del_flg"] = DEL_FLG_LIST_OFF; // 削除フラグ
        if (!is_empty($key) && !is_empty($val)) {
            $setParam[$key] = $val;
        }
        $res = $this->obj->execCommand($tableName, "one", $setParam);
        // check
        if ($res === false) {
            $this->obj->errorPage($this->obj->getMessage(STATUS_COMMON, "C_0009"));
            return;
        }
        return $res;
    }

    /**
     * 各テーブルのリストを取得する
     *
     * @access    public
     * @param     string    $tableName
     * @param     string    $key
     * @param     string    $val
     * @return    array     $list
     */
    function getListName($tableName, $key = "", $val = "")
    {
        // 検索条件
        $setParam = array();
        $setParam["f_del_flg"] = DEL_FLG_LIST_OFF; // 削除フラグ
                // $setParam["f_emp_status"] = ALLOW_STATUS_ACTIVE;

        if (!is_empty($key) && !is_empty($val)) {
            $setParam[$key] = $val;
        }
        $res = $this->obj->execCommand($tableName, "list", $setParam, RECODE_TYPE_LIST);
        // check
        if ($res === false) {
            $this->obj->errorPage($this->obj->getMessage(STATUS_COMMON, "C_0009"));
            return;
        }
        $list = array();
        for ($i = 0; $i < count($res); $i++) {
            $v         = $res[$i];
            $id        = $v["id"];
            $name      = $v["name"];
            $list[$name] = $name;
        }
        return $list;
    }

    /**
     * 各テーブルのリストを取得する
     *
     * @access    public
     * @param     string    $tableName
     * @param     string    $key
     * @param     string    $val
     * @return    array     $list
     */
    function getList($tableName, $key = "", $val = "")
    {
        // 検索条件
        $setParam = array();
        $setParam["f_del_flg"] = DEL_FLG_LIST_OFF; // 削除フラグ
        if (!is_empty($key) && !is_empty($val)) {
            $setParam[$key] = $val;
        }
        $res = $this->obj->execCommand($tableName, "list", $setParam, RECODE_TYPE_LIST);
        // check
        if ($res === false) {
            $this->obj->errorPage($this->obj->getMessage(STATUS_COMMON, "C_0009"));
            return;
        }
        $list = array();
        for ($i = 0; $i < count($res); $i++) {
            $v         = $res[$i];
            $id        = $v["id"];
            $name      = $v["name"];
            $list[$id] = $name;
        }
        return $list;
    }

    /**
     * 各テーブルのリストを取得する
     *
     * @access    public
     * @param     string    $tableName
     * @param     string    $key
     * @param     string    $val
     * @return    array     $list
     */
    function getNoList($table, $key = "", $val = "")
    {
        // 検索条件
        $setParam = array();
        $setParam["f_del_flg"] = DEL_FLG_LIST_OFF; // 削除フラグ
        if (!is_empty($key) && !is_empty($val)) {
            $setParam[$key] = $val;
        }
        $res = $this->obj->execCommand($table, "list", $setParam, RECODE_TYPE_LIST);
        // check
        if ($res === false) {
            $this->obj->errorPage($this->obj->getMessage(STATUS_COMMON, "C_0009"));
            return;
        }
        $list = array();
        for ($i = 0; $i < count($res); $i++) {
            $v         = $res[$i];
            $no        = $v["no"];
            $name      = $v["name"];
            $list[$no] = $name;
        }
        return $list;
    }

    /**
     * 各テーブルのリストを取得する
     *
     * @access    public
     * @param     string    $tableName
     * @param     string    $key
     * @param     string    $val
     * @return    array     $list
     */
    function getCodeList($tableName, $key = "", $val = "")
    {
        // 検索条件
        $setParam = array();
        $setParam["f_del_flg"] = DEL_FLG_LIST_OFF; // 削除フラグ
        if (!is_empty($key) && !is_empty($val)) {
            $setParam[$key] = $val;
        }
        $res = $this->obj->execCommand($tableName, "list", $setParam, RECODE_TYPE_LIST);
        // check
        if ($res === false) {
            $this->obj->errorPage($this->obj->getMessage(STATUS_COMMON, "C_0009"));
            return;
        }
        $list = array();
        for ($i = 0; $i < count($res); $i++) {
            $v         = $res[$i];
            $id        = $v["id"];
            $code      = $v["code"];
            $name      = $v["name"];
            $list[$id] = "{$code} {$name}";
        }
        return $list;
    }

    /**
     * 銀行マスタ（本店）リスト得する
     *
     * @access    public
     * @return    array     $list
     */
    function getBankList()
    {
        $tableName = "m_bank";
        $setParam  = array();
        $setParam["f_del_flg"]  = DEL_FLG_LIST_OFF; // 削除フラグ
        $setParam["f_category"] = STATUS_BRANCH_KBN_HONTEN;
        $res = $this->obj->execCommand($tableName, "list", $setParam, RECODE_TYPE_LIST);
        // check
        if ($res === false) {
            $this->obj->errorPage($this->obj->getMessage(STATUS_COMMON, "C_0009"));
            return;
        }
        $list = array();
        for ($i=0; $i<count($res); $i++) {
            $v    = $res[$i];
            $code = $v["bank_code"];
            $name = $v["name"];
            $list[$code] = $name;
        }
        return $list;
    }

    /**
     * 銀行マスタ（支店）リスト得する
     *
     * @access    public
     * @return    array     $list
     */
    function getBankBranchList($bankCode)
    {
        $list = array();
        if (is_empty($bankCode)) {
            return $list;
        }
        $tableName = "m_bank";
        $setParam  = array();
        $setParam["f_del_flg"]  = DEL_FLG_LIST_OFF; // 削除フラグ
        $setParam["f_category"] = STATUS_BRANCH_KBN_SHITEN;
        $setParam["f_bank_code"] = $bankCode;
        $res = $this->obj->execCommand($tableName, "list", $setParam, RECODE_TYPE_LIST);
        // check
        if ($res === false) {
            $this->obj->errorPage($this->obj->getMessage(STATUS_COMMON, "C_0009"));
            return;
        }
        for ($i=0; $i<count($res); $i++) {
            $v    = $res[$i];
            $code = $v["branch_code"];
            $name = $v["name"];
            $list[$code] = $name;
        }
        return $list;
    }

    /**
     * 各マスタのリストデータを取得する
     *
     * @access    public
     * @param     string    $table    テーブル名
     * @return    array     $list     リスト
     */
    function getListData($table, $key="", $val="")
    {
        // 検索条件
        $setParam = array();
        $setParam['f_del_flg'] = DEL_FLG_LIST_OFF;  // 削除フラグ
        if (!is_empty($key) && !is_empty($val)) {
            $setParam[$key] = $val;
        }

        $res = $this->obj->execCommand($table, 'lists', $setParam, RECODE_TYPE_LIST);
        // check
        if ($res === false) {
            $this->obj->errorPage($this->obj->getMessage(STATUS_COMMON, "C_0009"));
            return;
        }

        return $res;
    }

    /**
     * 各マスタのリストデータを取得する
     *
     * @access    public
     * @param     string    $table    テーブル名
     * @return    array     $list     リスト
     */
    function getSelectListData($table_name, $sql='lists', $where=array())
    {
        $res = array();
        // チェック
        if (is_empty($table_name) || is_empty($sql)) {
            return $res;
        }
        // 検索条件
        $set_param = array();
        $set_param['f_del_flg'] = DEL_FLG_LIST_OFF;
        foreach ((array)$where as $key => $val) {
            $set_param[$key] = $val;
        }
        $res = $this->obj->execCommand($table_name, $sql, $set_param, RECODE_TYPE_LIST);
        // チェック
        if ($res === false) {
            $this->obj->errorPage($this->obj->getMessage(STATUS_COMMON, "C_0009"));
            return;
        }

        return $res;
    }

    /**
     * 各マスタのリストデータを取得する
     *
     * @access    public
     * @param     string    $table    テーブル名
     * @return    array     $list     リスト
     */
    function getSelectOneData($table_name, $sql='ones', $where=array())
    {
        $res = array();
        // チェック
        if (is_empty($table_name) || is_empty($sql)) {
            return $res;
        }
        // 検索条件
        $set_param = array();
        $set_param['f_del_flg'] = DEL_FLG_LIST_OFF;
        foreach ((array)$where as $key => $val) {
            $set_param[$key] = $val;
        }
        $res = $this->obj->execCommand($table_name, $sql, $set_param);
        // チェック
        if ($res === false) {
            $this->obj->errorPage($this->obj->getMessage(STATUS_COMMON, "C_0009"));
            return;
        }

        return $res;
    }

    /**
     * 各テーブルのリストを取得する
     *
     * @access    public
     * @param     string    $tableName
     * @param     array     $where
     * @return    array     $list
     */
    function getListOfKeyWithCode($table_name, $where=array())
    {
        // 検索条件
        $set_param = array();
        $set_param['f_del_flg'] = DEL_FLG_LIST_OFF;
        foreach ((array)$where as $key => $val) {
            $set_param[$key] = $val;
        }
        $res = $this->obj->execCommand($table_name, 'code_list', $set_param, RECODE_TYPE_LIST);
        // check
        if ($res === false) {
            $this->obj->errorPage($this->obj->getMessage(STATUS_COMMON, 'C_0009'));
            return;
        }
        $list = array();
        foreach ((array)$res as $val) {
            $id = $val['id'];
            $cd = $val['code'];
            $list[$cd] = $id;
        }
        return $list;
    }

    /**
     * 各テーブルのリストを取得する
     *
     * @access    public
     * @param     string    $table
     * @param     string    $flg
     * @param     string    $key
     * @param     string    $val
     * @return    array     $list
     */
    function getListOfCode($table, $flg=false, $key='', $val='')
    {
        // 検索条件
        $setParam = array();
        $setParam['f_del_flg'] = DEL_FLG_LIST_OFF;
        if (!is_empty($key) && !is_empty($val)) {
            $setParam[$key] = $val;
        }
        $res = $this->obj->execCommand($table, 'list', $setParam, RECODE_TYPE_LIST);
        // check
        if ($res === false) {
            $this->obj->errorPage($this->obj->getMessage(STATUS_COMMON, "C_0009"));
            return;
        }
        $list = array();
        for ($i = 0; $i < count($res); $i++) {
            $v    = $res[$i];
            $code = $v['code'];
            $name = $v['name'];
            $list[$code] = $name;
            if ($flg === true) {
                $list[$code] = "{$code} {$name}";
            }
        }
        return $list;
    }
}
?>