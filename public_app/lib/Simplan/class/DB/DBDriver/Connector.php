<?php
include_once( DBD_DIR . 'DbException.php');
include_once( DBD_DIR . 'MySqlConnectAdaptee.php');

/**
 * ＤＢコネクトクラス
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan.DB
 * @version    1.0
 */

class Connector{
	/**
	 * @var ConectAdaptee
	 * @access protected
	 */
    var $adaptee;
	/**
	 * @var array
	 * @access protected
	 */
    var $conf;

    /**
     * コンストラクタ
     *
     * @access  public
	 * @param	array	$conf
     */
    function Connector( $conf ){
        $this->adaptee  = NULL;
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
        if( !is_null( $this->adaptee ) ) {
        	return $this->adaptee->Connect();
        }

        //ConecterAdapteeの生成
        switch( strtoupper( $this->conf['DB_TYPE'] ) ) {
            case 'MYSQL':
                $this->adaptee = new
                    MySqlConnectAdaptee( $this->conf );
                break;
            /*
            case 'POSTAGE':
                break;
            */
            default:
                return new DbException( $this, "Connect()::Kind doesn't type" );
        }

        //生成確認
        if( get_class( $this->adaptee ) == 'DbException') {
            return new DbException($this,
                'Connect()::['.$this->conf['DB_TYPE'].']new miss');
        }

        return $this->adaptee->Connect();
    }
    //--------------------------------------------------------------------------
    
    /**
     * DB切断
     *
     * @access  public
     * @return  void
     */ 
    function DisConnect(){
        if( is_null( $this->adaptee ) ) {
            return new DbException( $this, "DisConnect()::it's not Connect." );
        }

        $this->adaptee->DisConnect();

        $this->adaptee = NULL;
    }
    //--------------------------------------------------------------------------
    
    /**
     * ＤＢ接続リソースの取得
     *
     * @access  public
     * @return  ConnectorAdaptee
     */ 
    function Get(){
        if( is_null( $this->adaptee ) ) {
            return new DbException( $this, "Get()::it's not Connect." );
        }
        return $this->adaptee->con;
    }
    //--------------------------------------------------------------------------

}
//------------------------------------------------------------------------------
?>
