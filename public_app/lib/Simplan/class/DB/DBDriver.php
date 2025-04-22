<?php

/** DBDriverクラスのパス */
define( DBD_DIR,
        SIMPLAN_BASE . DIRECTORY_SEPARATOR
        .'class'.DIRECTORY_SEPARATOR
        .'DB'.DIRECTORY_SEPARATOR.'DBDriver'.DIRECTORY_SEPARATOR );

include_once( DBD_DIR . 'DbException.php' );
include_once( DBD_DIR . 'DBFactory.php' );
include_once( DBD_DIR . 'Query.php' );
include_once( DBD_DIR . 'QueryResult.php' );
include_once( DBD_DIR . 'DBErrHandle.php' );

/**
 * DB Driverクラス
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan.DB
 * @version    1.0.1
 */
class DBDriver
{
    /**
     * @access  protected
     * @var     DBFactory
     */
    var $factor;

    /**
     * @access  protected
     * @var     Connector
     */
    var $connect;

    /**
     * @access  protected
     * @var     Commander
     */
    var $command;

    /**
     * @access  protected
     * @var     SystemLog
     */
    var $logger;

    /** 例外処理 ハンドル
     * @access  protected
     */
    var $err_handle;

    /**
     * コンストラクタ
     *
     * @access  public
     * @param   SystemLog   &$logger
     */
    function DBDriver( &$logger ){
        $this->factor = new DBFactory();
        $this->err_handle = NULL;

        if( is_null( $logger ) ) $this->logger = new SystemLog();
        else $this->logger = $logger;
    }
    //--------------------------------------------------------------------------

    /**
     * ＤＢ接続:Connectorを生成しＤＢへの接続を行う
     *
     * @access  public
     * @return   Connector|false
     */
    function Connect(){
        if( is_null( $this->connect ) ) {
            $this->connect = $this->factor->CreateConnector();
        }
        return $this->ExceptionProcess( $this->connect->Connect() );
    }
    //--------------------------------------------------------------------------

    /**
     * ＤＢ切断:ＤＢを切断し,Connectorを開放する
     * 
     * @access  public
     * @return  bool
     */
    function DisConnect(){
        $ret = $this->ExceptionProcess( $this->connect->DisConnect() );
        unset( $this->connect );
        return $ret;
    }
    //--------------------------------------------------------------------------

    /**
     * 接続確認
     * 
     * @access  public
     * @return  bool
     */ 
    function isConnect(){
        if( is_null( $this->connect ) ) return false;
        if( is_null( $this->connect->con ) ) return false;
        return true;
    }
    //--------------------------------------------------------------------------

    /**
     * クエリ実行可能か確認する
     * 
     * @access  public
     * @return  bool
     */
    function isReady(){
        if( is_null( $this->command ) ) return false;
        return true;
    }
    //--------------------------------------------------------------------------
 
    /**
     * クエリ実行可能な状態にする
     * 
     * @access  public
     * @return  bool
     */   
    function Ready(){
        $ret = NULL;
        if( is_null( $this->connect ) ) $this->Connect();


        if( is_null( $this->command ) ){
            $ret = $this->factor->CreateCommander( $this->connect );
            DBDriver::ExceptionProcess( $ret );
        }
        $this->command = $ret;

        return true;
    }
    //--------------------------------------------------------------------------
    
    /**
     * コマンドを取得する
     * 
     * @access  public
     * @return  Commander|false
     */
    function GetCommand(){
        if(!$this->isReady() ) $this->Ready();
        return $this->command;
    }
    //--------------------------------------------------------------------------

    /**
     * クエリを実行する
     * 
     * @access  public
     * @return  Commander|false
     */
    function QueryExecute( &$query, $ret_type = NULL ){
        if( !$this->isReady() ) $this->Ready();
        $ret = $this->command->QueryExecute( $query, $ret_type );
        return DBDriver::ExceptionProcess( $ret );
    }
    //--------------------------------------------------------------------------

    /**
     * トランザクション開始
     *
     * @access  public
     * @return  none
     */
    function Begin( $type = false ){
        if( !$this->isReady() ) $this->Ready();
        $ret = $this->command->Begin( $type );
        return DBDriver::ExceptionProcess( $ret );
    }
    //--------------------------------------------------------------------------

    /**
     * コミット
     *
     * @access  public
     * @param   bool    $type
     * @return  void
     */
    function Commit( $type = NULL ){
        if( !$this->isReady() ) $this->Ready();
        $ret = $this->command->Commit( $type );
        return DBDriver::ExceptionProcess( $ret );
    }
    //--------------------------------------------------------------------------

    /**
     * ロールバック
     *
     * @access  public
     * @param   bool    $type
     * @return  none
     */
    function RollBack( $type = NULL ){
        if( !$this->isReady() ) $this->Ready();
        $ret = $this->command->RollBack( $type );
        return DBDriver::ExceptionProcess( $ret );
    }
    //--------------------------------------------------------------------------


    /**
     * データベースに含まれるテーブルの名前を取得する
     * 
     * @access  public
     * @return   QueryResult|false
     */
    function GetTableList(){
        //コマンダーが存在していないときは生成する
        if( !$this->isReady() ) $this->Ready();
        $ret = $this->command->GetTableList($this->factor->db_conf['DB_NAME']);
        return $this->ExceptionProcess( $ret );
    }
    //--------------------------------------------------------------------------

    /**
     * テーブルに含まれるフィールドの情報を取得する
     * 
     * @access  public
     * @param   string  $table
     * @return  QueryResult|false
     */
    function GetFieldList( $table ){
        //コマンダーが存在していないときは生成する
        if( !$this->isReady() ) $this->Ready();
        $ret = $this->command->GetFieldList(
                        $this->factor->db_conf['DB_NAME'], $table );
        return $this->ExceptionProcess( $ret );
    }
    //--------------------------------------------------------------------------

    /**
     * テーブルに含まれるフィールドの情報を取得する(Primary情報含)
     * 
     * @access  public
     * @param   string  $table
     * @return   QueryResult|false
     */
    function GetFieldInfo( $table ){
        //コマンダーが存在していないときは生成する
        if( !$this->isReady() ) $this->Ready();
        $ret = $this->command->GetFieldInfo( $table );
        return $this->ExceptionProcess( $ret );
    }
    //--------------------------------------------------------------------------

    /**
     * テーブルの情報を取得する(コメント情報含)
     * 
     * @access  public
     * @return  QueryResult|false
     */
    function GetTableInfo(){
        //コマンダーが存在していないときは生成する
        if( !$this->isReady() ) $this->Ready();
        $ret = $this->command->GetTableInfo();
        return $this->ExceptionProcess( $ret );
    }
    //--------------------------------------------------------------------------

    /**
     * 例外処理関数をセットする
     * 
     * @access  public
     * @param   object  &$handle    エラー処理クラスオブジェクト
     * @param   string  $func_name  エラー処理クラスオブジェクトの関数名
     * @return   QueryResult|false
     */
    function SetErrHandle( &$handle, $func_name ){
        $this->err_handle = array( get_class($handle), $func_name );
        return true;
    }
    //--------------------------------------------------------------------------

    /**
     * 例外処理
     * 引数の$exceptionがDBExceptionクラスの場合例外処理を実行する
     * 
     * @access  protected
     * @param   object  $exception  例外チェック変数
     * @return  object|false
     */ 
    function ExceptionProcess( $exception ){
        $ret = NULL;
        if( get_class( $exception ) != 'DbException' ) return $exception;

        //エラーハンドルの確認
        if( is_null( $this->err_handle ) ) {
            //エラーハンドルが無い場合　ログをはく
            $this->logger->error( $exception->GetMsg() );
            return false;
        } else {
            //エラーハンドルがある場合　エラー処理関数を実行する
            $ret = call_user_func( $this->err_handle );

            //　エラー処理関数の戻り値がfalseならばログをはき、falseを返す
            if( $ret == false ) {
                $this->logger->error( $exception->GetMsg() );
            }
            return false;
        }
    }
    //--------------------------------------------------------------------------
}
//------------------------------------------------------------------------------

?>