<?php
/**
 * EraCommand
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license
 * @package    Simplan.mod.common
 * @version    1.0
 */
class EraCommand
{
    /* simplanAbstractProcess object */
    private $obj;
    /* logger */
    private $logger;
    /* テーブル名 */
    private $tableName;

    /**
     * コンストラクタ
     *
     * @access    public
     * @param     obj
     * @return    void
     */
    public function EraCommand($obj)
    {
        $this->obj       = $obj;
        $this->logger    = $obj->logger;
        $this->tableName = "m_era";
    }

    /**
     * 対象日の和暦を取得する
     *
     * @access    public
     * @param     string    年
     * @param     string    月
     * @param     string    日
     * @return    string    和暦
     */
    public function getWareki($year, $month, $day)
    {
        // チェック
        if (is_empty($year) || is_empty($month) || is_empty($day)) {
            return;
        }
        // 検索条件
        $setParam = array();
        $setParam["f_del_flg"] = DEL_FLG_LIST_OFF; // 削除フラグ
        $setParam["f_date"]    = "{$year}{$month}{$day}";
        $eraData = $this->obj->execCommand($this->tableName, "one", $setParam);
        // check
        if ($eraData === false) {
            $this->obj->errorPage($this->obj->getMessage(STATUS_COMMON, "C_0009"));
            return;
        }
        $eraName = $eraData["f_era"];
        $eraYear = ($year - $eraData["f_subtract_year"]);
        $eraDate = "{$eraName}{$eraYear}年{$month}月{$day}日";
        return $eraDate;
    }
}
?>