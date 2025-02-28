<?php
include_once( DBD_DIR . 'DbException.php');
include_once( DBD_DIR . 'ConnectAdaptee.php');

/**
 * PostgreSql用コネクタ
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan.DB
 * @version    1.0
 */
class PostgreSqlConnectAdaptee extends ConnectAdaptee{
    var $con;   //protected コネクタ

    /**
     * コンストラクタ
     *
     * @access  public
     * @return  none
     * @comment Simplanの設定情報読込
     */
    function PostgreSqlConnectAdaptee( $db_info ){
        parent::ConnectAdaptee( $db_info );
        $this->db_info['DB_HOST'] = $db_info['DB_HOST'];
        $this->db_info['DB_NAME'] = $db_info['DB_NAME'];
        $this->db_info['DB_USER'] = $db_info['DB_USER'];
        $this->db_info['DB_PASS'] = $db_info['DB_PASS'];
        $this->adapte_type = 'MySql';
    }
    //--------------------------------------------------------------------------

    /**
     * DB接続:interface
     *
     * @access  public
     * @return  true / class DbException
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
		$this->con = pg_connect(
			' host='.$this->db_info['DB_HOST'].
			' dbname='.$this->db_info['DB_NAME'].
			' user= '.$this->db_info['DB_USER'].
			' passwd='.$this->db_info['DB_PASS']
		);

        if( $this->con == false ) {
            return new DbException( $this,'Connect()::Connecting done' );
        }
        return true;
    }
    //--------------------------------------------------------------------------
    
    /**
     * DB切断:interface
     *
     * @access  public:abstruct
     * @return  none
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
     * @return  none
     */ 
    function Get(){
        return $this->con;
    }
    //--------------------------------------------------------------------------
}
//------------------------------------------------------------------------------

?>
