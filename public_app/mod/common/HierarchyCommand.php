<?php
/**
 * HierarchyCommand
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license
 * @package    Simplan.mod.common
 * @version    1.0
 */
define("DEPTH_OF_HIERARCHY", 3);
class HierarchyCommand
{
    /* simplanAbstractProcess object */
    private $obj;
    /* logger */
    private $logger;
    /* */
    private $tableName;

    /**
     * コンストラクタ
     *
     * @access    public
     * @param     obj
     * @return    void
     */
    public function HierarchyCommand($obj)
    {
        $this->obj       = $obj;
        $this->logger    = $obj->logger;
        $this->tableName = "t_customer";
    }

    /**
     * 選択可能な親階層リストを取得する
     *
     * @access    public
     * @return    array
     */
    function getParentList($exceptId = "")
    {
        // 検索条件
        $setParam = array();
        $setParam["f_del_flg"]   = DEL_FLG_LIST_OFF; // 削除フラグ
        $setParam["f_except_id"] = $exceptId;
        $res = $this->obj->execCommand($this->tableName, "parent_list", $setParam, RECODE_TYPE_LIST);
        // check
        if ($res === false) {
            $this->obj->errorPage($this->obj->getMessage(STATUS_COMMON, "C_0009"));
            return;
        }
        $list = array();
        for ($i=0; $i<count($res); $i++) {
            $v     = $res[$i];
            $depth = $v["f_depth"];
            if ($depth >= DEPTH_OF_HIERARCHY) {
                continue;
            }
            $id     = $v["f_customer_id"];
            $level1 = ($v["f_level1_kbn"] == STATUS_BRANCH_KBN_HONTEN) ? $v["f_level1_name"] : $v["f_level1_branch"];
            $level2 = ($v["f_level2_kbn"] == STATUS_BRANCH_KBN_HONTEN) ? $v["f_level2_name"] : $v["f_level2_branch"];
            $level3 = ($v["f_level3_kbn"] == STATUS_BRANCH_KBN_HONTEN) ? $v["f_level3_name"] : $v["f_level3_branch"];
            $level2 = (!is_empty($level2)) ? "{$level2} < " : "";
            $level3 = (!is_empty($level3)) ? "{$level3} < " : "";
            $list[$id] = "{$level3}{$level2}{$level1}";
        }
        return $list;
    }

    /**
     * 対象需要家の子階層リストを取得する
     *
     * @access    public
     * @param     string    需要家ID
     * @return    array
     */
    function getChildrenList($customerId)
    {
        // 検索条件
        $setParam = array();
        $setParam["f_del_flg"]     = DEL_FLG_LIST_OFF; // 削除フラグ
        $setParam["f_customer_id"] = $customerId;      // 需要家ID
        $res = $this->obj->execCommand($this->tableName, "children_list", $setParam, RECODE_TYPE_LIST);
        // check
        if ($res === false) {
            $this->obj->errorPage($this->obj->getMessage(STATUS_COMMON, "C_0009"));
            return;
        }
        return $res;
    }

    /**
     * 対象需要家の子階層IDリストを取得する
     *
     * @access    public
     * @param     string    需要家ID
     * @return    array
     */
    function getChildrenIdList($customerId)
    {
        // 検索条件
        $setParam = array();
        $setParam["f_del_flg"]     = DEL_FLG_LIST_OFF; // 削除フラグ
        $setParam["f_customer_id"] = $customerId;      // 需要家ID
        $res = $this->obj->execCommand($this->tableName, "children_list", $setParam, RECODE_TYPE_LIST);
        // check
        if ($res === false) {
            $this->obj->errorPage($this->obj->getMessage(STATUS_COMMON, "C_0009"));
            return;
        }
        $list = array();
        for ($i=0; $i<count($res); $i++) {
            $v  = $res[$i];
            $id = $v["f_customer_id"];
            $list[$id] = $id;
        }
        return $list;
    }

    /**
     * 対象需要家の子階層リストを取得する
     *
     * @access    public
     * @param     string    需要家ID
     * @return    array
     */
    function getChildrenCount($customerId)
    {
        // 検索条件
        $setParam = array();
        $setParam["f_del_flg"]     = DEL_FLG_LIST_OFF; // 削除フラグ
        $setParam["f_customer_id"] = $customerId;      // 需要家ID
        $res = $this->obj->execCommand($this->tableName, "children_count", $setParam);
        // check
        if ($res === false) {
            $this->obj->errorPage($this->obj->getMessage(STATUS_COMMON, "C_0009"));
            return;
        }
        $count = (isset($res["children_count"])) ? $res["children_count"] : 0;
        return $count;
    }

    /**
     * 対象の階層パスを取得する
     *
     * @access    public
     * @param     string    需要家ID
     * @param     string    需要家親ID
     * @return    string    パス
     */
    function getLevelPath($customerId, $parentId)
    {
        // 対象の需要家が親の場合
        $path = "/{$customerId}/";
        if (is_empty($parentId)) {
            return $path;
        }
        // 検索条件
        $setParam = array();
        $setParam["f_del_flg"]     = DEL_FLG_LIST_OFF; // 削除フラグ
        $setParam["f_customer_id"] = $parentId;        // 需要家親ID
        $res = $this->obj->execCommand($this->tableName, "one", $setParam);
        // check
        if ($res === false) {
            $this->obj->errorPage($this->obj->getMessage(STATUS_COMMON, "C_0009"));
            return;
        }
        $parentPath = (isset($res["f_level_path"])) ? $res["f_level_path"] : "";
        $path = "{$parentPath}{$customerId}/";
        return $path;
    }

    /**
     * 対象の階層パスを取得する（2階層対応）
     *
     * @access    public
     * @param     string    需要家ID
     * @param     string    需要家親ID
     * @return    string    パス
     */
    function getLevelPathTwo($customerId, $parentId)
    {
        // 階層パスの初期化
        $path = "";
        
        // 階層パスの設定
        if (is_null($parentId) || is_empty($parentId)) {
            // 親が設定されていない場合
            $path = "/{$customerId}/";
        } else if ($customerId == $parentId) {
            // 自身が親の場合
            $path = "/{$customerId}/";
        } else {
            // 自身が子の場合
            $path = "/{$parentId}/{$customerId}/";
        }
        
        return $path;
    }
}
?>