<?php
/**
 *  Smarty拡張クラス
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license    
 * @package    Simplan
 * @version    1.0
 */

class SimplanSmarty extends Smarty
{

    /**
     * Construct
     *
     * @access public
     * @return void
     */
    function __construct()
    {
        //Smartyコンストラクタ
        parent::__construct();

        $this->template_dir = DISP_DIR;
        $this->compile_dir = TMP_DIR;
        $this->cache_dir = TMP_DIR;
        $this->compile_id = md5($this->template_dir);
        $this->plugins_dir = array('plugins', SIMPLAN_BASE.'/class/SmartyPlugins');
        $this->assign('common', $this->getSmartyCommon());

        return;
    }

    /**
     * Smartyプラグイン処理
     *
     * @access    abstract
     * @param     String     $path  プラグインパス
     */
    function setSmartyPlugins( $path )
    {
        $this->plugins_dir[] = $path;
    }

    /**
     * 表示処理
     *
     * @access    abstract
     * @param     String     $template  テンプレート名
     * @param     Array      $param     パラメータ
     */
    function View($template, $param)
    {
        $this->assign('param', $param);
        $this->display($template);
    }

    /**
     * 静的ページ生成処理
     *
     * @param String $template テンプレート名
     * @param Array  $param    パラメータ
     * @param String $html     出力HTMLファイル名
     */
    function StaticView($template, $param, $html)
    {
        $this->smarty->assign('param', $param);
        file_put_contents( $html, $this->fetch( $template ) );
    }

    /**
     * Smarty取得 抽象メソッド
     *
     * @access    abstract
     */
    function getSmartyCommon()
    {
        return array();
    }

}

?>