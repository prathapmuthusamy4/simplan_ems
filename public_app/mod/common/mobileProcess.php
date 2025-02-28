<?php
/**
 *  ユーザプロセス共通クラス
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license
 * @package    Simplan
 * @version    1.0
 */

define("M_CHARSET", "SHIFT_JIS");

class mobileProcess extends userProcess
{
    /**
     * getSmartyCommon
     *  [* オーバーライド *]
     *
     * @access    public
     */
    function getSmartyCommon()
    {
        // get parent common param
        $common = parent::getSmartyCommon();

        $common["charset"]     = M_CHARSET;
        $common["ses_name"]    = session_name();
        $common["ses_id"]      = session_id();
        $common["head_tpl"]    = "file:" . HTML_DIR . "mobile_head.tpl";
        $common["foot_tpl"]    = "file:" . HTML_DIR . "mobile_foot.tpl";
        $common["menu_tpl"]    = "file:" . HTML_DIR . "mobile_menu.tpl";
        $common["disp_carrer"] = SimplanMobile::getCareer();

        return $common;
    }

    /**
     * 総処理
     *  [* オーバーライド *]
     *
     * @access    public
     * @param     Array    $input  入力値
     */
    function init($input)
    {
        // 入力データの文字コード変換
        foreach($input as $key => $value) {
            // 入力データが配列の場合
            if (is_array($value)) {
                $vals = array();
                foreach($value as $k => $v) {
                    $vals[$k] = mb_convert_encoding($v, "UTF-8", "SJIS");
                }
                $input[$key] = $vals;
            // それ以外の場合
            } else {
                $input[$key] = mb_convert_encoding($value, "UTF-8", "SJIS");
            }
        }

        parent::init($input);
    }

    /**
     * getErrorObject
     *   [* オーバーライド *]
     * @access    public
     */
    function getErrorObject()
    {
        $obj = new mobileErrorPage($this->logger, $this->smarty);
        return $obj;
    }


    /**
     * 表示処理
     *  [* オーバーライド *]
     *
     * @access    abstract
     * @param     String     $template  テンプレート名
     * @param     Array      $param     パラメータ
     */
    function view($template, $param)
    {
        $this->smarty->assign("param", $param);

        $output = $this->smarty->fetch($template);
        $output=mb_convert_kana($output,"k","UTF-8");
        //SJISに変換
        $output=mb_convert_encoding($output,"SJIS","UTF-8");

        // out put
        ini_set("default_charset", M_CHARSET);
        echo($output);
    }
}
?>