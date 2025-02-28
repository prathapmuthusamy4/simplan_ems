<?php
include_once( MOD_DIR.'common/<!--{$ParentProcess}-->.php' );
class <!--{$pg_name}-->_common extends <!--{$ParentProcess}-->
{
    var $error_info;
    var $table_name;
    var $app_name;
    var $check_file;

    function <!--{$pg_name}-->_common( $logger ){
        parent::{$ParentProcess}( $logger );    
        $this->table_name   = '<!--{$table_name}-->';
        $this->app_name     = '<!--{$APP_NAME}-->';
        $this->check_file   = 'input.check';
        $this->error_info = array(
                'pg_name'   => get_class( $this ),
                'func_name' => '',
                'msg'       => '',
            );
    }

    /**
     * Paramに配列のデータをセットする
     *
     * @access    public
     * @return    Array   出力パラメータ
     */
    function setParamArray( $data ){
        foreach($this->param as $key => $value) {
            if( array_key_exists($key, $data) ) {
                $this->param[$key] = $data[$key];
            }
        }
    }

    /**
     * 検索条件を生成する
     *
     * @access    public
     * @param     Array   $param 出力情報
     * @return    Array   検索条件
     */
    function makeSearchParam($param) {

        $setParam = array();

        return $setParam;
    }

    /**
     * 入力をチェックする
     *
     * @access    public
     * @param     Array   $input 入力情報
     * @param     Array   $param 出力情報
     * @return    boolean ok:true, ng:false;
     */
    function inputCheck($input, &$param) {
        // エラーチェック
        $errList = parent::checkInput("input.check", $input);

        /********************
         * judge
         ********************/
        if( sizeof($errList) > 0 ) {
            $success = false;
            foreach ($errList as $key => $value) {
                $param['errmsg'][$key] = $value;
            }
            return false;
        }

        return true;
    }

    /**
     * データを取得する
     *
     * @access    public
     * @param     String   $id 対象メールID
     * @pram      Array    対象データ
     */
    function getData($id) {
        ##### auto ######
        $setParam = array(
<!--{foreach from=$PrimaryField item="cur"}-->
            <!--{$cur|str_pad:24:" "}-->=> $this->param[<!--{$cur}-->],
<!--{/foreach}-->
        );
        ##### auto ######

        $res = parent::execCommand( $this->table_name, "GET", $setParam);
        // check
        if( $res === false ) {
            $this->logger->error("select data ... NG");
            $this->errorPage($cmdRslt->getErrMsg());
            return false;
        }
        return $res;
    }

    /**
     * 表示パラメータ初期化
     *
     * @access    public
     * @return    Array   出力パラメータ
     */
    function initParam() {
        return array(
            /** ↓ ##### auto ###### **/
<!--{foreach from=$Table_All_Field item="cur" name="current"}-->
            <!--{$cur|str_pad:24:" "}-->=> '',
<!--{/foreach}-->
            /** ↑ ##### auto ###### **/
            'errmsg'        => $this->initErrmsg(),
            'disp_type'     => '',
            ##### auto #####
            'title'         => <!--{$SessionName}-->_DISP_TITLE,
            ##### auto #####
        );
    }

    /**
     * エラーメッセージ初期化
     *
     * @access    public
     * @return    Array   エラーメッセージ
     */
    function initErrmsg() {
        return array(
            /** ↓ ##### auto ###### **/
<!--{foreach from=$Table_All_Field item="cur" name="current"}-->
            <!--{$cur|str_pad:24:" "}-->=> '',
<!--{/foreach}-->
            /** ↑ ##### auto ###### **/

            'system' => '',
        );
    }

    /**
     * 更新日時を取得する
     *
     * @access    public
     * @param     String   $id 対象メールID
     * @return    String   更新日時
     */
    function getUpdateDate($id) {
        $rst = $this->getData($id);
        return $rst['f_update_time'];
    }

    /**
     * エラーページ設定
     *
     * @access    public
     * @param     String   $msg メッセージ
     */
    function errorPage($msg) {
        // object
        $error = $this->getErrorObject();
        $pg_name = '<!--{$app_name}-->';
        // set
        /** ↓ ##### auto ######  **/
        $error->setContent( $this->app_name );
        $error->setMessage($msg);
        $error->setUrl( $pg_name.'.php');
        $error->setProcess('');
        $error->setCmd('');
        $error->setName( $this->app_name.'<!--{$SessionName}-->' );
        /** ↑ ##### auto ###### **/

        // 表示
        $error->forwardPage();

        return;
    }

}
?>
