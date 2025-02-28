<?php
include_once( DBD_DIR . 'DbException.php');
include_once( DBD_DIR . 'ConnectAdaptee.php');

/**
 * MySQL用コネクタ
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan.DB
 * @version    1.0
 */
class MySQLConnectAdaptee extends ConnectAdaptee{
    var $con;   //protected コネクタ

    /**
     * コンストラクタ
     * @access  public
	 * @param	array	$db_info
     */
    function MySQLConnectAdaptee( $db_info ){
        parent::ConnectAdaptee( $db_info );
        $this->db_info['DB_HOST'] = $db_info['DB_HOST'];
        $this->db_info['DB_NAME'] = $db_info['DB_NAME'];
        $this->db_info['DB_USER'] = $db_info['DB_USER'];
        $this->db_info['DB_PASS'] = $db_info['DB_PASS'];
        $this->adapte_type = 'MySql';
    }
    //--------------------------------------------------------------------------

    /**
     * DB接続
     * @access  public
     * @return  true|DbException
     */
    function Connect(){
        if( !is_NULL( $this->con ) ) {
        	return true;
           //return new DbException($this,'Connect()::it was done two times.');
        }
        $this->con = mysql_connect(
            $this->db_info['DB_HOST'],
            $this->db_info['DB_USER'],
            $this->db_info['DB_PASS'] );

        if( $this->con == false ) {
            return new DbException( $this,'Connect()::Connecting done' );
        }
        return true;
    }
    //--------------------------------------------------------------------------
    
    /**
     * DB切断
     * @access  public
     * @return  void
     */
    function DisConnect(){
        mysql_close( $this->con );
        $this->con = NULL;
    }
    //--------------------------------------------------------------------------

    /**
     * DB接続リソース取得
     *
     * @access  public
     * @return  resource
     */ 
    function Get(){
        return $this->con;
    }
    //--------------------------------------------------------------------------
}
//------------------------------------------------------------------------------

?>
