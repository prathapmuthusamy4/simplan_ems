<?php
/**
 * SequenceCommand
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license
 * @package    Simplan.mod.common
 * @version    1.0
 */
class SequenceCommand
{
    /* simplanAbstractProcess object */
    private $obj;
    /* logger */
    private $logger;

    /**
     * コンストラクタ
     *
     * @access    public
     * @param     obj
     * @return    void
     */
    public function SequenceCommand($obj)
    {
        $this->obj    = $obj;
        $this->logger = $obj->logger;
    }

    /**
     * 対象需要家の子階層リストを取得する
     *
     * @access    public
     * @param     string    需要家ID
     * @return    array
     */
    function getSequence($tableName)
    {
        $seq = NULL;
        if (!$this->updateSequence($tableName)) {
            return $seq;
        }
        $setParam = array();
        $res = $this->obj->execCommand($tableName, "select_last_id", $setParam);
        // check
        if ($res === false) {
            return $seq;
        }
        $seq = (isset($res["f_last_id"])) ? $res["f_last_id"] : NULL;
        return $seq;
    }

    /**
     * 選択可能な親階層リストを取得する
     *
     * @access    public
     * @return    array
     */
    function updateSequence($tableName)
    {
        $success = false;
        $setParam = array();
        $res = $this->obj->execCommand($tableName, "update", $setParam);
        // check
        if ($res === false) {
            return $success;
        }
        return $success = true;
    }
}
?>