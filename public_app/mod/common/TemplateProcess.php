<?php 
include_once("baseProcess.php");
/**
 *  TemplateProcess.php
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license
 * @package    Simplan
 * @version    1.0
 */
class TemplateProcess extends baseProcess
{
    /**
     * 前処理
     *
     * @access    public
     * @return    array   $input   入力値
     */
    function precute($input)
    {
        $this->base_precute($input);
    }

    /**
     * 主処理
     *
     * @access    public
     * @return    array   $input   入力値
     */
    function execute($input)
    {
        //登録関数の実行
        $ret = $this->executeFunction($input);
        // CSV出力の場合
        if ($ret) {
            if ($this->execFuncName == "executeCsv" || $this->execFuncName == "executeDownload") {
                exit();
            }
        }
        //エラー処理
        if (!$ret) {
            $this->logger->debug(get_class($this) . "Error " . $this->execFuncName . " ... NG");
        }
        return $ret;
    }

    /**
     * 後処理
     *
     * @access    public
     * @return    array   $input   入力値
     */
    function postcute($input)
    {
        if (is_empty($this->display)) {
            $this->display = "index.tpl";
        }
        $this->view($this->display, $this->param);
        return;
    }

    /**
     * executeFunction
     *
     * @access    public
     * @return    array   $input   入力値
     */
    function executeFunction($input)
    {
        // 登録関数名の検出
        if (!array_key_exists($input["cmd"], $this->proc)) {
            if (!array_key_exists("default", $this->proc)) {
                $this->execFuncName = "executeDefault";
            } else {
                $this->execFuncName = $this->proc["default"];
            }
        } else {
            $this->execFuncName = $this->proc[$input["cmd"]];
        }
        // プロセス関数を実行する
        $this->logger->debug(get_class($this) . " Entering " . $this->execFuncName . " ...");
        return $this->{$this->execFuncName}($input);
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
     * バック処理
     *
     * @access    public
     * @param     array    $input   入力値
     * @return    bool
     */
    function executeBack($input)
    {
        $success = false;
        // get session
        $this->setParamFromSession($this->param);
        return $success = true;
    }

    /**
     * リロード処理
     *
     * @access    public
     * @param     array    $input   入力値
     * @return    bool
     */
    function executeReload($input)
    {
        $success = false;
        // get session
        $this->setParamFromSession($this->param);
        // list
        $this->searchData($this->param);
        // session set
        $this->setSession($input, $this->param);
        return $success = true;
    }

    /**
     * 改ページ処理
     *
     * @access    public
     * @param     array    $input   入力値
     * @return    bool
     */
    function executeChangepage($input)
    {
        $success = false;
        // get session
        $this->setParamFromSession($this->param);
        $this->param["pno"] = $input["pno"];
        // list
        $this->searchData($this->param);
        // session set
        $this->setSession($input, $this->param);
        return $success = true;
    }

    /**
     * 検索処理
     *
     * @access    public
     * @param     array    $input   入力値
     * @return    bool
     */
    function executeSearch($input)
    {
        $success = false;
        // set input
        $this->setInputData($input, $this->param);
        // list
        $this->searchData($this->param);
        // session set
        $this->setSession($input, $this->param);
        return $success = true;
    }

    /**
     * CSVダウンロード処理
     *
     * @access    public
     * @param     array   $input    入力値
     * @return    bool
     */
    function executeCsv($input)
    {
        $success = false;
        // get session
        $this->setParamFromSession($this->param);
        // csv list
        $this->searchCsvData($this->param);
        // make filename
        $fname = SimplanMakeCsvFile::makeCsvFileName(date("Ymd"). $this->csv_name);
        // make csv data
        $csv_data = $this->makeCsvOutputData($this->param["csv_list"], $this->param);
        if (!SimplanMakeCsvFile::makeCsvFile($csv_data, $fname, unserialize($this->csv_define))) {
            return $success;
        }
        // output csv
        if (!SimplanMakeCsvFile::outputCsvFile($fname)) {
            return $success;
        }
        // delete csv
        if (is_file($fname)) {
            unlink($fname);
        }
        // session set
        $this->setSession($input, $this->param);
        return $success = true;
    }

    /**
     * リストデータを検索する
     *
     * @access    public
     * @param     array    $param   出力値
     */
    function searchData(&$param)
    {
        $setParam = array();
        $setParam["where"] = $this->makeSearchParam($param);                     // where
        $dispCondition     = $this->makeDispCondition($setParam, $param["pno"]); // dispCondition
        $setParam["limit"] = $this->makeLimitParam($dispCondition);              // limit
        // get list
        $res = parent::execCommand($this->table_name, "select_list", $setParam, RECODE_TYPE_LIST);
        // check
        if ($res === false) {
            $this->logger->error($this->table_name . " select_list ... NG");
            $this->errorPage($this->getMessage(STATUS_COMMON, "C_0007"));
            return;
        }
        // set
        $param["list"] = $res;
        $param["page_info"] = $dispCondition;
        return;
    }

    /**
     * CSVリストデータを検索する
     *
     * @access    public
     * @param     array    $param   出力値
     */
    function searchCsvData(&$param)
    {
        $setParam = array();
        $setParam["where"] = $this->makeSearchParam($param); // where
        $setParam["limit"] = "";                             // limit
        // get list
        $res = parent::execCommand($this->table_name, "select_list", $setParam, RECODE_TYPE_LIST);
        // check
        if ($res === false) {
            $this->logger->error($this->table_name . " select_list ... NG");
            $this->errorPage($this->getMessage(STATUS_COMMON, "C_0007"));
            return;
        }
        // set
        $param["csv_list"] = $res;
        return;
    }

    /**
     * ページ数を取得する
     *
     * @access    public
     * @param     array    $setParam        検索条件
     * @param     string   $pno             ページ数
     * @return    array    $dispCondition   検索情報
     */
    function makeDispCondition($setParam, $pno)
    {
        // read limit
        $limit  = $this->getSiteValue("SITE", $this->page_record);
        // get list count
        $res = parent::execCommand($this->table_name, "select_list_count", $setParam);
        // check
        if ($res === false) {
            $this->logger->error($this->table_name . " select_list_count ... NG");
            $this->errorPage($this->getMessage(STATUS_COMMON, "C_0008"));
            return;
        }
        // count
        $total_count = $res["count"];
        // make dispCondition
        $dispCondition = array();
        $dispCondition = SimplanUtil::makePageCalc($total_count, $pno, $limit);
        $dispCondition["total_count"] = $total_count;
        $dispCondition["page_limit"]  = $limit;
        return $dispCondition;
    }

    /**
     * 更新日時を取得する
     *
     * @access    public
     * @param     string   $id   対象ID
     * @return    string         更新日時
     */
    function getUpdateDate($id)
    {
        // check
        if (is_empty($id)) {
            $this->errorPage($this->getMessage(STATUS_COMMON, "C_0009"));
        }
        $res= $this->getData($id);
        $upd_time = (isset($res["f_upd_time"])) ? $res["f_upd_time"] : NULL;
        return $upd_time;
    }

    /**
     * データを取得する
     *
     * @access    public
     * @param     string   $id    対象ID
     * @pram      array    $res   対象データ
     */
    function getData($id)
    {
        $success = false;
        // 検索条件
        $setParam = array();
        $setParam["where"] = $this->makeWhereParam($id);
        $res = parent::execCommand($this->table_name, "select_one", $setParam);
        // check
        if ($res === false) {
            $this->logger->error($this->table_name . " select_one ... NG");
            $this->errorPage($this->getMessage(STATUS_COMMON, "C_0009"));
            return $success;
        }
        return $res;
    }

    /**
     * データ取得
     *
     * @access    public
     * @param     array   $input
     * @param     array   $param
     * @return    bool
     */
    function select($input, &$param)
    {
        $success = false;
        // check
        if (!isset($input["sid"]) || is_empty($input["sid"])) {
            $this->errorPage($this->getMessage(STATUS_COMMON, "C_0009"));
            return $success;
        }
        // set
        $res = $this->getData($input["sid"]);
        foreach($param as $key => $value) {
            if (array_key_exists($key, $res)) {
                $param[$key] = $res[$key];
            }
        }
        return $success = true;
    }

   /**
     *  配列の値からキーを返す
     *
     *  @param  array   $ary   配列１
     *  @return array   配列に変換された値
     */
    function searchArrayKey($str, $list)
    {
        $ret = "";
        if (is_empty($str)) {
            return $ret;
        }
        if (!is_array($list) || count($list) <= 0) {
            return $ret;
        }

        foreach ($list as $key => $val) {
            // 文字を処理
            $val = trim($val);
            $val = str_replace(array("\r\n","\n","\r"), '', $val);
            // マッチング
            if ($str == $val) {
                $ret = $key;
                    break;
            }
        }
        return $ret;
    }

    /**
     * CSVの読み込みを行う
     *
     * @access    public
     * @param     array    $param   出力値
     */
    function readCsv(&$handle, $len = NULL, $d = ',', $e = '"')
    {
        $d = preg_quote($d);
        $e = preg_quote($e);
        $l = "";
        $eof = false;
        while (($eof != true ) && (!feof($handle))) {
            $l  .= (empty($len) ? fgets($handle) : fgets($handle, $len));
            $cnt = preg_match_all('/' . $e . '/', $l, $dummy);
            if ($cnt % 2 == 0) {
                $eof = true;
            }
        }
        $line    = preg_replace('/(?:\\r\\n|[\\r\\n])?$/', $d, trim($l));
        $pattern = '/(' . $e . '[^' . $e . ']*(?:' . $e . $e . '[^' . $e . ']*)*' . $e . '|[^' . $d . ']*)' . $d . '/';

        preg_match_all($pattern, $line, $match);
        $data = $match[1];
        $cnt  = count($data);
        $row  = array();
        for ($i=0; $i<$cnt; $i++) {
            $row[$i] = preg_replace('/^' . $e . '(.*)' . $e . '$/s', '$1', $data[$i]);
            $row[$i] = str_replace($e . $e, $e, $row[$i]);
            $row[$i] = $this->encCsv($row[$i]);
        }
        return (is_empty($l)) ? false : $row;
    }

    /**
     * 読み込みデータの文字コードを変換する
     *
     * @access    public
     * @param     array    $data   読込データ
     * @return    array    $data   文字コード変換後読込データ
     */
    function encCsv($v)
    {
        $enc = mb_detect_encoding($v, "SJIS-WIN,SJIS");
        $val = mb_convert_encoding(trim($v), 'UTF-8', $enc);
        return $val;
    }
}
?>
