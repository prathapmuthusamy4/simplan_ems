<?php

/**
 * sDBパス定義
 */
define( 'SDB_DIR', SIMPLAN_BASE . DIRECTORY_SEPARATOR
                    .'class'.DIRECTORY_SEPARATOR
                    .'DB'.DIRECTORY_SEPARATOR );

/**
 * Sas,DBDriver Rapper Class
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan.DB
 * @version    1.0
 */
class sDB extends Sas{
    /** @var DBDriver
     * @access  protected
     */
    var $db;

    /**
     * コンストラクタ
     *
     * @access  public
     * @param   SystemLoger $logger
     */
    function sDB( &$logger = NULL){
        if( is_null( $logger ) ) $this->logger = new SystemLog();
        else $this->logger = $logger;

        $this->db = new DBDriver( $this->logger );
    }
    //--------------------------------------------------------------------------

    /**
     * データベース例外処理ハンドルの設定
     *
     * @access  public
     * @param   object  $obj    エラー処理クラスハンドル
     * @param   string  $func   $objメンバのエラー処理関数名
     * @return  void
     */
    function SetDBErrorProccess( &$obj, $func ){
        return $this->db->SetErrHandle( $obj, $func );
    }
    //--------------------------------------------------------------------------

    /**
     * DBDriverのハンドルを取得する
     *
     * @access  public
     * @param   DBDriver    &$res   DBDriverのハンドル
     * @return  void
     */
    function GetDB( &$res ){
        $res = $this->db;
    }
    //--------------------------------------------------------------------------

    /**
     * Commanderのハンドルを取得する
     *
     * @access  public
     * @param   Commander   &$res   Commanderのハンドル
     * @return  void
     */
    function GetCommander( &$res ){
        $res =  $this->db->GetCommand();
    }
    //--------------------------------------------------------------------------

    /**
     * Connectorのハンドルを取得する
     *
     * @access  public
     * @param   Connector   &$res   Connectorのハンドル
     * @return  void
     */
    function GetConnection( &$res ){
        $res = $tshi->db->connect->con ();
    }
    //--------------------------------------------------------------------------

    /**
     * SQLクエリを実行する
     *
     * @access  public
     * @param   string|SasObject    $query      SQLクエリ|SasObject
     * @param   bool    $ret_type   Trueをセットされた場合はmy_sqlのコネクタリソースを返す
     * @return  resource | False 
     */
    function QueryExecute( $query, $ret_type = NULL ){
        $sql = '';
        if( !is_string( $query ) ) {
            switch( get_class( $query ) ){
                case 'SasDelete':
                case 'SasInsert':
                case 'SasSelect':
                case 'SasUpdate':
                    $sql = parent::AutoSQL( $query );
                    break;
            }
        } else $sql = $query;

        if( strlen( $sql ) == 0 ) return false;

        return $this->db->QueryExecute( $sql, $ret_type );
    }
    //--------------------------------------------------------------------------

    /**
     * SQLクエリをバインドする
     *
     * @access  public
     * @param   string	$query	SQLクエリ
     * @param   array	$vars	置換配列
     * @param   string	$type	'array_keys' or 'def'
     * @return  string | False 
     */
	function QueryBind( $query, $vars, $type = 'array_keys' ){
		$q = new Query( $query );
		$q->Build( $vars, $type );
		return $q->GetSql();
	}
    //--------------------------------------------------------------------------

    /**
     * トランザクション開始
     *
     * @access  public
     * @param   bool    $type   戻り値のタイプ指定
     * @return  void | resource
     */
    function Begin( $type = NULL ){
        return $this->db->Begin($type);
    }
    //--------------------------------------------------------------------------

    /**
     * コミット
     *
     * @access  public
     * @param   bool    $type   戻り値のタイプ指定
     * @return  void | resource
     */
    function Commit( $type = NULL ){
        return $this->db->Commit($type);
    }
    //--------------------------------------------------------------------------

    /**
     * ロールバック
     *
     * @access  public
     * @param   bool    $type   戻り値のタイプ指定
     * @return  void | resource
     */
    function RollBack( $type = NULL ){
        return $this->db->RollBack($type);
    }
    //--------------------------------------------------------------------------

}
//------------------------------------------------------------------------------

?>
