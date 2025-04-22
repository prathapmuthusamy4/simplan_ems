<?php
include_once( '<!--{$pg_name}-->_common.php' );
/**
 *  ##### auto #####
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license    
 * @package    Simplan
 * @version    <!--{$SIMPLAN_VERSION}-->
 */

class <!--{$pg_name}-->DelProcess extends <!--{$pg_name}-->_common
{
	function initProc(){
		$this->table_name	= '<!--{$table_name}-->';
		$this->session_name = <!--{$SessionName}-->_DEL;
		$this->display = 'del_e.tpl';
		return array(
			'confirm'	=> 'executeConfirm',
			'delete'	=> 'executeDelete',
			'default'	=> 'executeDefault',
		);
	}

    /**
     * 確認処理
     *
     * @access    public
     * @param     Array   $input 入力値
     * @param     Array   $param 出力値
     * @return    boolean ok:true, ng:false;
     */
    function executeConfirm( $input ) {

        // session clear
        $this->clearSession();

        if( !$this->select($input, $param) ) {
			$this->error_info['func_name'] = 'executeConfirm';
			$this->error_info['msg'] = '確認データの取得に失敗';
			return false;
        }

        // session set
        $this->setSession($input, &$this->param);

		return true;
    }

    /**
     * 削除処理
     *
     * @access    public
     * @param     Array   $input 入力値
     * @param     Array   $param 出力値
     * @return    boolean ok:true, ng:false;
     */
    function executeDelete( $input ) {

        // SESSIONからデータ取り出し
        $this->setParamFromSession( $this->param );

        // check
		$cur_update = parent::getUpdateDate($this->param['<!--{$PrimaryKey}-->']);

        if( $cur_update != $this->param['f_upd_time'] ) {
            $this->errorPage(ERR_DELETE_OTHER_TERMINAL);
        }

        // トランザクション開始
        $this->begin();
        if( !$this->delete( $this->param ) ) {
            // ロールバック
            $this->rollback();
            $this->errorPage('DBの更新に失敗しました。');
			return false;
        }
        $this->commit();

		return true;
    }

    /**
     * データ取得
     *
     * @access    public
     * @param     Array   $input 入力値
     * @param     Array   $param 出力値
     * @return    boolean ok:true, ng:false;
     */
    function select( $input, &$param ) {
        // check
        if (!isset($input['sid'])) {
            $this->errorPage($this->getMessage('ERR_MISS_OPERATION'));
            exit();
        }

        $res = $this->getData($input['sid']);
		if( $res === false ) return false;

        // set
		parent::setParamArray( $res );

		return true;
    }

    /**
     * 削除処理
     *
     * @access    public
     * @param     Array   $param 出力値
     * @return    boolean ok:true, ng:false;
     */
    function delete( &$param ) {
        // 現在日付
        $curtime = date('YmdHis', mktime());

        // 削除データ生成
        ##### auto ######
        $setParam = array(
<!--{foreach from=$PrimaryField item="cur"}-->
            <!--{$cur|str_pad:24:" "}-->=> $this->param[<!--{$cur}-->],
<!--{/foreach}-->
        );
        ##### auto ######

		$setParam['f_update_account'] =
		   	$_SESSION[<!--{$SessionName}-->_SESSION]['f_admin_id'];
        $setParam['f_update_time'] = $curtime;
        $setParam['f_del_flg'] = DELETE_FLG_ON;

        // exec
        $res = parent::execCommand($this->table_name, 'DELETE', $setParam);

        // check
		if( $res === false ){
            $this->logger->error("Delete ".$this->table_name." ... NG");
			return false;
		}

        $this->logger->debug("Delete ".$this->table_name." ... OK");
		return true;
    }
}
?>
