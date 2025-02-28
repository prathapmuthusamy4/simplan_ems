<?php
include_once( dirname(dirname(__FILE__)).'/WideCommand.php' );
include_once( 'MySqlQueryResult.php' );
/**
 * MySql用クエリ実行クラス
 *
 * @link
 * @author
 * @license
 * @package    Simplan.DB
 * @version    1.0
 */

class MySqlCommand extends WideCommand{

    /**
     * コンストラクタ
     *
     * @access  public
	 * @param	array		&$db_info
	 * @param	resource	&$con
     */
    function MySqlCommand( &$db_info, &$con ){
        parent::WideCommand( $db_info, $con );
        $this->adapt_type = 'MySql';
        mysqli_select_db($this->con ,$db_info['NAME']);
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
            return new WideDbException( $this,
				"Begin()::Connect has disappeared. ");
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
			return new WideDbException($this,
				"Commit()::Connect has disappeared. ");
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
            return new WideDbException( $this,
                "RollBack()::Connect has disappeared. ");
        }
        return $this->QueryExecute( 'ROLLBACK', $type );
    }
    //--------------------------------------------------------------------------

    /**
     * テーブルロック
     *
     * @access  public
	 * @param	bool	$type
	 * @return	QueryResult|resource
     */
    function TableLock( $table, $type = false ) {
        if( is_null( $this->con ) ) {
            return new WideDbException( $this,
                "TableLock()::Connect has disappeared. ");
        }
        return $this->QueryExecute( "LOCK TABLES {$table} WRITE", $type );
    }

    /**
     * テーブルアンロック
     *
     * @access  public
	 * @param	bool	$type
	 * @return	QueryResult|resource
     */
    function TableUnLock( $type = false ) {
        if( is_null( $this->con ) ) {
            return new WideDbException( $this,
                "TableLock()::Connect has disappeared. ");
        }
        return $this->QueryExecute( "UNLOCK TABLES ", $type );
    }

    /**
     * クエリ実行
     *
     * @access  public
	 * @param	bool	$type
	 * @return	QueryResult|resource
     */
    function QueryExecute( $query, $ret_type = true)
    {
        if (is_null($this->con)) {
            return new WideDbException($this,
                "QueryException()::Connect has disappeared. ");
        }
        if (strlen($query ) == 0) {
            return new WideDbException( $this,
                "QueryException():: SQL is Empty");
        }
        //クエリー実行
        if (!($res = mysqli_query($this->con, $query))) {
            //クエリー失敗
            $err_no = mysqli_errno($this->con);
            $err_msg= mysqli_error($this->con);
            return new WideDbException( $this,
                "QueryException()::'{$query}'\n\t[{$err_no}]{$err_msg}");
        }
        if (is_bool($res )) return $res;
        if (!$ret_type) return $res;
        return new MySqlQueryResult($res);
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
            return new WideDbException( $this,
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
     * @return  QueryResult|WideDbException
     */
    function GetFieldList( $db, $table ){
        if( is_null( $this->con ) ) {
            return new WideDbException( $this,
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
     * @return  QueryResult|WideDbException
     */
    function GetFieldInfo( $table ){
        if( is_null( $this->con ) ) {
            return new WideDbException( $this,
                "GetFieldInfo()::Connect has disappeared. ");
        }

        $query = 'show full fields from '.$table;

        return $this->QueryExecute( $query );
    }
    //--------------------------------------------------------------------------

    /**
     * テーブルに含まれるフィールドの情報を取得する(Primary情報含)
     *
     * @access  public
     * @return  QueryResult|WideDbException
     */
    function GetTableInfo(){
        if( is_null( $this->con ) ){
            return new WideDbException( $this,
                "GetTableInfo()::Connect has disppeared. ");
        }

        $query = 'show table status';

        return $this->QueryExecute( $query );
    }
    //--------------------------------------------------------------------------

    /**
     * エラー番号取得
     * @access  public
     * @return  int
     */
	function GetError(){
		return mysqli_errno( $this->con );
	}
    //--------------------------------------------------------------------------

    /**
     * エラーメッセージ取得
     * @access  public
     * @return  string
     */
	function GetErrorMsg(){
		return mysqli_error( $this->con );
	}
    //--------------------------------------------------------------------------

    /** クエリで影響のあった件数を返す
     * @access  public
     * @return  int
     */
	function GetAffectedRows(){
		return mysqli_affected_rows( $this->con );
	}
    //--------------------------------------------------------------------------
}
//------------------------------------------------------------------------------

?>
