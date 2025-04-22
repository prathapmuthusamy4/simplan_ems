<?php
include_once( '<!--{$pg_name}-->_common.php' );
/**
 *  ##### auto #####  
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license    
 * @package    Simplan
 * @version    1.0
 */

class <!--{$pg_name}-->ListProcess extends <!--{$pg_name}-->_common
{

	function initProc(){
		$this->table_name	= '{$table_name}';
		$this->session_name = <!--{$SessionName}-->_LIST;
		$this->display = 'del_e.tpl';
		return array(
			'reload'		=> 'executeReload',
			'change_page'	=> 'executeChangePage',
			'search'		=> 'executeSearch',
			'default'		=> 'executeDefault',
		);
	}   

    /**
     * 検索処理
     *
     * @access    public
     * @param     Array   $input 入力値
     * @param     Array   $param 出力値
     * @return    boolean ok:true, ng:false;
     */
    function executeSearch( $input ) {

        // set
        $this->setInputData($input, $this->param);

        // check input
        if( !$this->inputCheck($input, &$this->param) ) {
            $this->logger->debug("inputCheck ... NG");
			return false
        }

        /********************
         * 検索
         ********************/
        $this->searchData($this->param);

        // set
        $this->setSession($input, $this->param);

		return true;
    }

    /**
     * リストデータを検索する
     *
     * @access    public
     * @param     Array   $param 出力値
     */
    function searchData(&$param) {
        // dispCondition
        $setParam = $this->makeSearchParam($this->param);
        $dispCondition = $this->makeDispCondition($setParam, $param['pno']);
        $setParam['offset'] = $dispCondition['offset'] - 1;
        $setParam['limit'] = $dispCondition['page_limit'];
        $res = parent::execCommand('GET_LIST', $setParam);

        // check
		if( $res === false ){
            $errMsg = 'listProcess::searchProcess > '.$cmdRslt->getErrMsg();
            trigger_error ($errMsg, E_USER_ERROR);
            return false;
        }

        // set
        $param['list'] = $cmdRslt->getParameter();
        $param['page_info'] = $dispCondition;

        return true;
    }

    /**
     * ページ数を取得する
     *
     * @access    public
     * @param     Array   $setParam 検索対象文字列
     * @param     String  $pno  ページ数
     * @return    Array   検索情報
     */
    function makeDispCondition($setParam, $pno) {
        $dispCondition = array();
        $reader = new PropertyReader( ETC_DIR."site.properties" );
        $limit  = $reader->getProperty( 'PAGE_RECORD' );

        /********************
         * 総数の取得
         ********************/
		$res = parent::execCommand(
			$this->table_name, 'GET_LIST_COUNT', $setParam);
        // check
		if( $res === false ){
            $errMsg = 'listProcess::makePageTag > ' . $cmdRslt->getErrMsg();
            trigger_error ($errMsg, E_USER_ERROR);
            return false;
        }
        $total_count = $res['RowNum'];

        // データの開始位置と終了位置の取得
        $dispCondition = SimplanUtil::makePageCalc($total_count, $pno, $limit);
        $dispCondition['total_count'] = $total_count;
        $dispCondition['page_limit']  = $limit;

        return $dispCondition;
    }

}
?>
