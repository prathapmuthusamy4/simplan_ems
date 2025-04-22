<?php

include_once( DBD_DIR . 'DbException.php');
include_once( DBD_DIR . 'Query.php');
include_once( DBD_DIR . 'QueryResult.php');
include_once( DBD_DIR . 'CommandAdaptee.php');

/**
 * MySql用クエリ実行クラス
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan.DB
 * @version    1.0
 */
class MySqlCommandAdaptee extends CommandAdaptee{

    /**
     * コンストラクタ
     *
     * @access  public
	 * @param	array		&$db_info
	 * @param	resource	&$con
     */
    function MySqlCommandAdaptee( &$db_info, &$con ){
        parent::CommandAdaptee( $db_info, $con );
        $this->adapt_type = 'MySql';

        mysql_select_db( $db_info['DB_NAME'],  $this->con );
    }
    //--------------------------------------------------------------------------

    /**
     * トランザクション開始
     *
     * @access  public
	 * @param	bool	$type
	 * @return	QueryResult|resource
     */
    function Begin( $type = false ) {
        if( is_null( $this->con ) ) {
            return new DbException( $this,"Begin()::Connect has disappeared. ");
        }
        return $this->QueryExecute( 'START TRANSACTION', $type );
    }
    //--------------------------------------------------------------------------

    /**
     * コミット
     *
     * @access  public
	 * @param	bool	$type
	 * @return	QueryResult|resource
     */
    function Commit( $type = false ){
        if( is_null( $this->con ) ) {
            return new DbException($this,"Commit()::Connect has disappeared. ");
        }
        return $this->QueryExecute( 'COMMIT', $type );
    }
    //--------------------------------------------------------------------------

    /**
     * ロールバック
     *
     * @access  public
	 * @param	bool	$type
	 * @return	QueryResult|resource
     */
    function RollBack( $type = false ) {
        if( is_null( $this->con ) ) {
            return new DbException( $this,
                "RollBack()::Connect has disappeared. ");
        }
        return $this->QueryExecute( 'ROLLBACK', $type );
    }
    //--------------------------------------------------------------------------

    /**
     * クエリ実行
     *
     * @access  public
	 * @param	bool	$type
	 * @return	QueryResult|resource
     */
    function QueryExecute( $query, $ret_type = true){
        if( is_null( $this->con ) ) {
            return new DbException( $this,
                "QueryException()::Connect has disappeared. ");
        }
        $sql = '';


        //引数がQueryクラスのとき
        if( get_class( $query ) == 'Query' ) {
            $sql = $query->GetSQL();
        } else {
            if( gettype( $query ) == 'string' ) $sql = $query;
            else {
                return new DbException( $this,
                    "QueryException()::args is error ");
            }
        }

        //クエリー実行
        if( !($res = mysql_query( $sql,  $this->con ) ) ) {
            //クエリー失敗
            //  エラー情報取得
            $err_no = mysql_errno( $this->con );
            $err_msg= mysql_error( $this->con );

            return new DbException( $this,
                "QueryException()::'".$sql."'\n\t[$err_no]$err_msg");
        }

        if( $ret_type == false ) return $res;
        return new QueryResult( $this->adapt_type, $res );
    }   
    //--------------------------------------------------------------------------

    /**
     * テーブル一覧取得
     * @access  public
	 * @param	string $db_name
	 * @return	QueryResult|resource
     */
    function GetTableList( $db_name ){
        if( is_null( $this->con ) ) {
            return new DbException( $this,
                "GetTableList()::Connect has disappeared. ");
        }
        return new QueryResult(
                   $this->adapt_type, mysql_list_tables($db_name, $this->con) );
    }
    //--------------------------------------------------------------------------

    /**
     * テーブルに含まれるフィールドの情報を取得する
     * 
     * @access  public
	 * @param	string $db
	 * @param	string $table
     * @return  QueryResult|DbException
     */
    function GetFieldList( $db, $table ){
        if( is_null( $this->con ) ) {
            return new DbException( $this,
                "GetFieldList()::Connect has disappeared. ");
        }
        $type = $this->adapt_type.':Field';
        return new QueryResult(
                    $type, mysql_list_fields($db, $table, $this->con) );
    }
    //--------------------------------------------------------------------------

    /**
     * フィールドの情報を取得する
     *
     * @access  public
	 * @param	string $table
     * @return  QueryResult|DbException
     */
    function GetFieldInfo( $table ){
        if( is_null( $this->con ) ) {
            return new DbException( $this,
                "GetFieldInfo()::Connect has disappeared. ");
        }

        $query = new Query( 'show full fields from '.$table );

        return $this->QueryExecute( $query );
    }
    //--------------------------------------------------------------------------

    /**
     * テーブルに含まれるフィールドの情報を取得する(Primary情報含)
     *
     * @access  public
     * @return  QueryResult|DbException
     */
    function GetTableInfo(){
        if( is_null( $this->con ) ){
            return new DbException( $this,
                "GetTableInfo()::Connect has disppeared. ");
        }

        $query = new Query( 'show table status' );

        return $this->QueryExecute( $query );
    }
    //--------------------------------------------------------------------------

    /**
     * エラー番号取得
     * @access  public
     * @return  int
     */
	function GetError(){
		return mysql_errno( $this->con );
	}
    //--------------------------------------------------------------------------

    /**
     * エラーメッセージ取得
     * @access  public
     * @return  string
     */
	function GetErrorMsg(){
		return mysql_error( $this->con );
	}
    //--------------------------------------------------------------------------

    /** クエリで影響のあった件数を返す
     * @access  public
     * @return  int
     */
	function GetAffectedRows(){
		return mysql_affected_rows( $this->con );
	}
    //--------------------------------------------------------------------------
}
//------------------------------------------------------------------------------

?>
