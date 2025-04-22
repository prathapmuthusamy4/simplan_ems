<?php
/**
 * Simplan FW - PHP Web Application Framework
 *
 * Copyright(c) 2003-2010 THREET CO.,LTD. All Rights Reserved.
 *
 * http://www.threet.co.jp
 * http://www.simplan.jp
 *
 * PHP versions 4 and 5
 *
 * LICENSE:
 *
 *
 *
 *
 *
 * @author     Toru Yoshikawa <t-yoshikawa@threet.co.jp>
 * @license
 * @package    Simplan
 * @copyright  2003-2010 The Simplan Project by THREET CO.,LTD.
 * @create     2010.04.14
 * @version    0.9
 */

/**
 * SimplanIniReader Class
 *
 * @link
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license
 * @package    Simplan
 * @version    1.0
 */
class SimplanIniReader
{
    var $ini;
    var $logger;

    /**
     * コンストラクタ
     * [note] ここでLoggerを初期化してはいけない。
     *        Loggerもiniファイルを読むからである
     *
     * @access public
     * @param string $ini
     * @param string $lang
     * @return void
     */
    function __construct($ini, $flg = true)
    {
        // init
        $this->setIni($ini, $flg);
    }

    /**
     * 設定ファイル読み込み設定
     *
     * @access public
     * @param string $ini
     * @param boolean $flg
     * @return void
     */
    function setIni($ini, $flg)
    {
        // check
        if (!file_exists($ini)) {
            return;
        }
        $this->ini = parse_ini_file($ini, $flg);

        return;
    }

    /**
     * 設定ファイル取得
     *
     * @access public
     * @return void
     */
    function getIni()
    {
        return $this->ini;
    }

    /**
     * 値取得
     *
     * @access public
     * @param string $section
     * @param string $id
     * @return value
     */
    function getValue($section, $id)
    {
        $ret = "";
        $ini = $this->getIni();

        // search
        if (array_key_exists($section, $ini)) {
            if (array_key_exists($id, $ini[$section])) {
                $ret = $ini[$section][$id];
            }
        }

        return $ret;
    }

    /**
     * セクション情報取得
     *
     * @access public
     * @param string $section
     * @return array
     */
    function getSection($section)
    {
        $ret = array();
        $ini = $this->getIni();

        // search
        if (array_key_exists($section, $ini)) {
            $ret = $ini[$section];
        }

        return $ret;
    }
}
?>