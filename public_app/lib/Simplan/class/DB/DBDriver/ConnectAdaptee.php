<?php

/**
 * ＤＢコネクト基底クラス Interface Class
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan.DB
 * @version    1.0
 */
include_once( DBD_DIR . 'DbException.php');

class ConnectAdaptee{
    var $adapte_type;   //protected
    var $con;           //protected
    var $db_info;       //protected

    /**
     * コンストラクタ
     *
     * @access  public
     * @return  none
     * @comment Simplanの設定情報読込
     */
    function ConnectAdaptee( $db_info ){
        $this->adapte_type =  '';
        $this->con = NULL;
        $this->db_info = $db_info;
    }
    //--------------------------------------------------------------------------

    /**
     * DB接続:interface
     *
     * @access  public:abstruct
     * @return  none
     */
    function Connect(){
        return new DbException($this, "Connect()::This class can't Runing");
    }
    //--------------------------------------------------------------------------

    /**
     * DB切断:interface
     *
     * @access  public:abstruct
     * @return  none
     */
    function Disconnect(){
        return new DbException($this, "DisConnect()::This class can't Runing");
    }
    //--------------------------------------------------------------------------

    /**
     * DB接続リソース取得:interface
     *
     * @access  public:abstruct
     * @return  none
     */ 
    function Get(){
        return new DbException($this, "Get()::This class can't Runing");
    }
    //--------------------------------------------------------------------------
}
//------------------------------------------------------------------------------

?>
