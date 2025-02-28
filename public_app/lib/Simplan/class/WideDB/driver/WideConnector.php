<?php

include_once( dirname(dirname(__FILE__)).'/WideDbException.php');
/**
 * ＤＢコネクトクラス
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan.DB
 * @version    1.0
 */
class WideConnector{

	/**
	 * @var array
	 * @access protected
	 */
    var $conf;

	/**
	 * @var		resource
	 * @access	protected
	 */
	var $con;

    /**
     * コンストラクタ
     *
     * @access  public
	 * @param	array	$conf
     */
    function __construct( $conf ){
        $this->conf = $conf;
    }
    //--------------------------------------------------------------------------

    /**
     * DB接続
     *
     * @access  public
     * @return  ConnectAdaptee|DbException
     */
    function Connect(){
		return false;
    }
    //--------------------------------------------------------------------------
    
    /**
     * DB切断
     *
     * @access  public
     * @return  void
     */ 
    function DisConnect(){
		return false;
    }
    //--------------------------------------------------------------------------
    
    /**
     * ＤＢ接続リソースの取得
     *
     * @access  public
     * @return  ConnectorAdaptee
     */ 
    function Get(){
        return NULL;
    }
    //--------------------------------------------------------------------------

}
//------------------------------------------------------------------------------
?>
