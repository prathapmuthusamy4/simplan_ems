<?php

include_once( DBD_DIR . 'DbException.php');
include_once( DBD_DIR . 'MySqlCommandAdaptee.php');

/**
 * ＤＢクエリ実行クラス
 *
 * @link       
 * @author     
 * @license    
 * @package    	Simplan.DB
 * @version    	1.0.1
 */
class Commander{
	/** @var resource */
    var $con;

	/** @var CommanderAdaptee */
	var $command;

    /**
     * コンストラクタ
     *
     * @access  public
	 * @param	array		&$db_info	データベース設定配列
	 * @param	resource	&$con	DBコネクタリソース
     */
    function Commander( &$db_info, &$con ){
        $this->con = $con->Get();

        //DB_TYPEに合ったCommandAdapteeの作成
        switch( strtoupper( $db_info['DB_TYPE'] ) ){
            case 'MYSQL':
                $this->command = new MySqlCommandAdaptee($db_info, $this->con);
                break;

            default:
                return new DbException( $this, "Connect()::Kind doesn't type" );
        }

        if( get_class( $this->command ) == 'DbException') {
            return new DbException($this,
                'Connect()::['.$this->conf['DB_TYPE'].']new miss');
        }

        return true;
    }
    //--------------------------------------------------------------------------

    /**
     * トランザクション開始
     *
     * @access  public
	 * @param	bool	$type
     * @return  void
     */
    function Begin( $type = false ){
        if( is_null( $this->command ) ) {
            return new DbException( $this, "Begin()::new It's not done." );
        }
        return $this->command->Begin();
    }
    //--------------------------------------------------------------------------

    /**
     * コミット
     *
     * @access  public
	 * @param	bool	$type
     * @return  void
     */
    function Commit( $type = false ){
        if( is_null( $this->command ) ) {
            return new DbException( $this, "Commit()::new It's not done." );
        }
        return $this->command->Commit();
    }
    //--------------------------------------------------------------------------

    /**
     * ロールバック
     *
     * @access  public
	 * @param	bool	$type
     * @return  void
     */
    function RollBack( $type = false ){
        if( is_null( $this->command ) ) {
            return new DbException( $this, "RollBack()::new It's not done." );
        }
        return $this->command->RollBack();
    }
    //--------------------------------------------------------------------------

    /**
     * クエリ実行
     *
     * @access  public
	 * @param	string	$query
     * @return  QueryResult | DbException
     */
    function QueryExecute( $query ){
        if( is_null( $this->command ) ) {
            return new DbException($this,"QueryExecute()::new It's not done.");
        }
        return $this->command->QueryExecute( $query );
    }   
    //--------------------------------------------------------------------------

    /**
     * テーブル一覧取得
     *
     * @access  public
	 * @param	string	$db_name
     * @return   QueryResult |  DbException
     */
    function GetTableList( $db_name ){
        if( is_null( $this->command ) ) {
            return new DbException($this,"GetTableList()::new It's not done.");
        }
        return $this->command->GetTableList($db_name);
    }
    //--------------------------------------------------------------------------

    /**
     * テーブルに含まれるフィールドの情報を取得する
     * 
     * @access  public
	 * @param	string	$table
     * @return  QueryResult |  DbException
     */
    function GetFieldList( $table ){
        if( is_null( $this->command ) ) {
            return new DbException($this,"GetFieldList()::new It's not done.");
        }
        return $this->command->GetFieldList( $table );
    }
    //--------------------------------------------------------------------------

    /**
     * テーブルに含まれるフィールドの情報を取得する(Primary情報含)
     *
     * @access  public
	 * @param	strin 	$table
     * @return   QueryResult |  DbException
     */
    function GetFieldInfo( $table ){
        if( is_null( $this->command ) ) {
            return new DbException($this,"GetFieldInfo()::new It's not done.");
        }
        return $this->command->GetFieldInfo( $table );
    }
    //--------------------------------------------------------------------------

    /**
     * テーブルの情報を取得する(コメント情報含)
     *
     * @access  public
     * @return   QueryResult |  DbException
     */
    function GetTableInfo(){
        if( is_null( $this->command ) ) {
            return new DbException($this,"GetTableInfo()::new It's not done.");
        }
        return $this->command->GetTableInfo( $table );
    }
    //--------------------------------------------------------------------------
    
    /**
     * エラー番号取得
     * @access  public
     * @return  int
     */
	function GetError(){
		if( is_null( $this->command ) ) return false;
        return $this->command->GetError();
	}
    //--------------------------------------------------------------------------

    /**
     * エラーメッセージ取得
     * @access  public
     * @return  string
     */
	function GetErrorMsg(){
		if( is_null( $this->command ) ) return false;
        return $this->command->GetErrorMsg();
	}
    //--------------------------------------------------------------------------

    /** クエリで影響のあった件数を返す
     * @access  public
     * @return  int
     */
	function GetAffectedRows(){
		if( is_null( $this->command ) ) return false;
        return $this->command->GetAffectedRows();
	}
    //--------------------------------------------------------------------------
}
//------------------------------------------------------------------------------

?>
