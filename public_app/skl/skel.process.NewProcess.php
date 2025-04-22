<?php
include_once( '<!--{$pg_name}-->_common.php' );
/**
 * ##### auto #####  
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license    
 * @package    Simplan
 * @version    1.0
 */

class <!--{$pg_name}-->NewProcess extends <!--{$pg_name}-->_common
{
    function initProc(){
        $this->table_name   = '<!--{$table_name}-->';
        $this->session_name = <!--{$SessionName}-->_NEW;
        $this->display = 'del_e.tpl';
        return array(
            'confirm'   => 'executeConfirm',
            'regist'    => 'executeRegist',
            'back'      => 'executeBack',
            'default'   => 'executeDefault',
        );
    }

    /**
     * 登録処理
     *
     * @access    public
     * @param     Array   $input 入力値
     * @param     Array   $param 出力値
     */
    function executeRegist( $input ) {
        if (!isset($_SESSION[$this->session_name])) {
            $this->errorPage($this->getMessage('ERR_MISS_OPERATION'));
            return false;
        }
        // SESSIONからデータ取り出し
        $this->setParamFromSession( $this->param );

        // トランザクション開始
        $this->begin();
        if( $this->regist($this->param)) {
            // ロールバック
            $this->rollback();
            $success = false;
            $this->errorPage('DBの登録に失敗しました。');
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
     * DB登録
     *
     * @access    public
     * @param     Array   $param 出力値
     * @return    boolean ok:true, ng:false;
     */
    function regist(&$param) {
        // 現在日付
        $curtime = date('YmdHis', mktime());
        // 登録データ生成
        $setParam = array();

        /** ↓ ##### auto ###### **/
        <!--{$SetParamFieldPrim}-->
        /** ↑ ##### auto ###### **/

        $setParam['f_del_flg']      = DELETE_FLG_OFF;
        $setParam['f_reg_account']  = $_SESSION[ADMIN_SESSION]['f_admin_id'];
        $setParam['f_reg_time']     = $curtime;
        $setParam['f_update_account'] = $_SESSION[ADMIN_SESSION]['f_admin_id'];
        $setParam['f_update_time']  = $curtime;

        // exec
        $res = parent::execCommand('INSERT', $setParam);

        // check
        if( $res === false ) {
            $this->logger->error("Insert information ... NG");
            return false;
        }
        $this->logger->debug("Insert information ... OK");

        return true;
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
        if (!isset($_SESSION[$this->session_name])) {
            $this->errorPage($this->getMessage('ERR_MISS_OPERATION'));
            return false;
        }

        // set
        $this->setParamFromSession($this->param);
        $this->setInputData($input, $this->param);

        // check input
        if( !$this->inputCheck($input, &$this->param)) {
            return false;
        }

        // session
        $this->setSession($input, $this->param);

        return true;
    }

}
?>
