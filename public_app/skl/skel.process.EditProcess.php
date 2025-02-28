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

class <!--{$pg_name}-->EditProcess extends <!--{$pg_name}-->_common
{

   	function initProc(){
		$this->table_name	= '<!--{$table_name}-->';
		$this->session_name = <!--{$SessionName}-->_EDIT;
		$this->display = 'del_e.tpl';
		return array(
			'confirm'	=> 'executeConfirm',
			'update'	=> 'executeDelete',
			'default'	=> 'executeDefault',
			'back'		=> 'executeBack',
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
        // set
        $this->setParamFromSession($this->param);
        $this->setInputData($input, $this->param);
        // check input
        if( !$this->inputCheck($input, &$this->param) ) {
			return false;
        }

        $this->setSession($input, $this->param);
		return true;
    }

    /**
     * 更新処理
     *
     * @access    public
     * @param     Array   $input 入力値
     * @param     Array   $param 出力値
     * @return    boolean ok:true, ng:false;
     */
    function executeUpdate( $input ) {

        // SESSIONからデータ取り出し
        $this->setParamFromSession($this->param);
        // check
        //$cur_update = $this->getUpdateDate( $this->param[''] );
        if ($cur_update != $param['f_update_time']) {
            $this->errorPage($this->getMessage('ERR_UPDATE_OTHER_TERMINAL'));
			return false;
        }

        /********************
         * 更新
         ********************/
        // トランザクション開始
        $this->begin();
        if( !$this->update($param) ) {
            // ロールバック
            $this->rollback();
            $this->errorPage('DBの更新に失敗しました。');
        	$this->clearSession();
	        unset($_SESSION[$this->session_name]);
			return false;
        }

        $this->commit();
        // SESSION 破棄
        $this->clearSession();
        unset($_SESSION[$this->session_name]);

		return true;
    }

    /**
     * DB更新
     *
     * @access    public
     * @param     Array   $param 出力値
     * @return    boolean ok:true, ng:false;
     */
    function update(&$param) {
        // success flag
        $success = false;

        // 現在日付
        $curtime = date('YmdHis', mktime());

        // 更新データ生成
        ##### auto ######
        $setParam = array(
<!--{foreach from=$PrimaryField item="cur"}-->
            <!--{$cur|str_pad:24:" "}-->=> $this->param[<!--{$cur}-->],
<!--{/foreach}-->
        );
        ##### auto ######
        $setParam['f_disp_flg'] = $param['f_disp_flg'];
        $setParam['f_update_account'] = $_SESSION[ADMIN_SESSION]['f_admin_id'];
        $setParam['f_update_time'] = $curtime;

        // exec
        $res = parent::execCommand('UPDATE', $setParam);

        // check
		if( $res === false ){
            $this->logger->debug("Update information ... OK");
			return false;
        }

        $this->logger->error("Update information ... NG");
        return true;
    }
}
?>
