<?php
/**
 *  メールマガジン削除クラス
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license    
 * @package    Simplan
 * @version    1.0
 */
include_once(MOD_DIR . '/adminmod.php');

class delProcess extends AdminProcess
{

    // session name
    var $session_name = ADMIN_ACCOUNT_DEL;

    /**
     * プロセス実行処理
     *
     * @access    public
     * @param     Array     (String)XSS対応後のPOST、GETデータ
     * @return    none
     */
    function execute($input)
    {
        // Login Check
        $this->isLogin();

        // param
        $param = $this->initParam();
        $display = 'del_c.tpl';

        //*** コマンド判定 ***//
        switch ($input['cmd']) {
        case 'confirm' :
            //*** 確認 ***//
            $display = 'del_c.tpl';
            if ($this->executeConfirm($input, $param)) {
                $display = 'del_c.tpl';
            }
            break;
        case 'delete' :
            //*** 更新 ***//
            $display = 'del_c.tpl';
            if ($this->executeDelete($input, $param)) {
                $display = 'del_e.tpl';
            }
            break;
        default :
            //*** デフォルト処理***//
            $this->errorPage('無効なアクション');
            break;
        }

        // view
        $this->view($display, $param);
        return;
    }

    /**
     * 表示パラメータ初期化
     *
     * @access    public
     * @return    Array   出力パラメータ
     */
    function initParam()
    {
        // init
        $param = array(
{$Table_All_Field}
                       'errmsg' => $this->initErrmsg(),
                       'title' => ADMIN_ACCOUNT_DISP_TITLE,
                       'disp_hotel' => unserialize(HOTEL_KBN_LIST),
                       'disp_type' => DISP_TYPE_DEL,
                       );
        return $param;
    }

    /**
     * エラーメッセージ初期化
     *
     * @access    public
     * @return    Array   エラーメッセージ
     */
    function initErrmsg()
    {
        // init
        $errmsg = array(
                        'system' => '',
                        );
        return $errmsg;
    }

    /*----------------------------------------------------------*
     * CONFIRM処理
     *----------------------------------------------------------*/
    /**
     * 確認処理
     *
     * @access    public
     * @param     Array   $input 入力値
     * @param     Array   $param 出力値
     * @return    boolean ok:true, ng:false;
     */
    function executeConfirm($input, &$param)
    {
        $this->logger->debug("Entering executeConfirm ...");
        // success flag
        $success = false;

        // session clear
        $this->clearSession();

        /********************
         * 検索
         ********************/
        if (!$this->select($input, $param)) {
            return $success;
        }

        // session set
        $this->setSession($input, &$param);
        $success = true;

        return $success;
    }

    /*----------------------------------------------------------*
     * DELETE処理
     *----------------------------------------------------------*/
    /**
     * 削除処理
     *
     * @access    public
     * @param     Array   $input 入力値
     * @param     Array   $param 出力値
     * @return    boolean ok:true, ng:false;
     */
    function executeDelete($input, &$param)
    {
        $this->logger->debug("Entering executeDelete ...");
        // success flag
        $success = false;

        // SESSIONからデータ取り出し
        $this->setParamFromSession($param);

        // check
        $cur_update = $this->getUpdateDate(
            $param['f_admin_id']
        );

        if ($cur_update != $param['f_update_time']) {
            $this->errorPage(ERR_DELETE_OTHER_TERMINAL);
        }

        /********************
         * 削除
         ********************/
        if ($this->delete($param)) {
            $success = true;
        }

        return $success;
    }

    /**
     * データ取得
     *
     * @access    public
     * @param     Array   $input 入力値
     * @param     Array   $param 出力値
     * @return    boolean ok:true, ng:false;
     */
    function select($input, &$param)
    {
        // success flag
        $success = false;

        // set
        $res = $this->getData($input['sid']);
        foreach($param as $key => $value) {
            if (array_key_exists($key, $res)) {
                $param[$key] = $res[$key];
            }
        }

        return $success = true;
    }

    /**
     * 削除処理
     *
     * @access    public
     * @param     Array   $param 出力値
     * @return    boolean ok:true, ng:false;
     */
    function delete(&$param)
    {
        $success = false;
        //
        // 削除用データ生成
        //
        $setParam = array();
        $setParam['f_admin_id'] = $param['f_admin_id'];
        //
        // トランザクション開始
        //
        $this->begin();
        $cmdRslt = parent::execCommand('DELETE', $setParam);
        if (!$cmdRslt->isSuccess()) {
            $this->logger->error("Delete m_admin ... NG");
            //
            // ロールバック
            //
            $this->rollback();
            $this->errorPage($cmdRslt->getErrMsg());
        } else {
            $this->logger->debug("Delete m_admin ... OK");
            //
            // コミット
            //
            $this->commit();
            $success = true;
        }

        return $success;
    }

    /*----------------------------------------------------------*
     * 共通
     *----------------------------------------------------------*/
    /**
     * 更新日時を取得する
     *
     * @access    public
     * @param     String   $id 対象メールID
     * @return    String   更新日時
     */
    function getUpdateDate($id)
    {
        $rst = $this->getData($id);

        return $rst['f_update_time'];
    }

    /**
     * データを取得する
     *
     * @access    public
     * @param     String   $id 対象メールID
     * @pram      Array    対象データ
     */
    function getData($id)
    {
        $setParam = array( 'f_admin_id' => $id);
        $cmdRslt = parent::execCommand("GET", $setParam);
        // check
        if (!$cmdRslt->isSuccess()) {
            $this->logger->error("select data ... NG");
            $this->errorPage($cmdRslt->getErrMsg());
            return;
        }

        return $cmdRslt->getParameter();
    }

    /**
     * エラーページ設定
     *
     * @access    public
     * @param     String   $msg メッセージ
     */
    function errorPage($msg)
    {
        // object
        $error = $this->getErrorObject();

        // set
        $error->setContent('管理者情報');
        $error->setMessage($msg);
        $error->setUrl('account.php');
        $error->setProcess('');
        $error->setCmd('');
        $error->setName('管理者情報一覧');

        // 表示
        $error->forwardPage();

        return;
    }
}
{/literal}
?>
