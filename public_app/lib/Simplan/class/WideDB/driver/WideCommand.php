<?php

include_once( dirname(dirname(__FILE__)).'/WideDbException.php');

/**
 * ＤＢクエリ実行クラス
 *
 * @link
 * @author
 * @license
 * @package     Simplan.DB
 * @version     1.0.1
 */
class WideCommand
{
    /**
     * @var     resource
     * @access  protected
     */
    var $con;
    var $db_info;

    /**
     * コンストラクタ
     *
     * @access  public
     * @param   array       &$db_info   データベース設定配列
     * @param   resource    &$con   DBコネクタリソース
     */
    function __construct( &$db_info, &$con ){
        $this->con = $con;
        $this->db_info = $db_info;
    }

    /**
     * トランザクション開始
     *
     * @access  public
     * @param   bool    $type
     * @return  void
     */
    function Begin( $type = false ){
        return false;
    }

    /**
     * コミット
     *
     * @access  public
     * @param   bool    $type
     * @return  void
     */
    function Commit( $type = false ){
        return false;
    }

    /**
     * ロールバック
     *
     * @access  public
     * @param   bool    $type
     * @return  void
     */
    function RollBack( $type = false ){
        return false;
    }

    /**
     * クエリ実行
     *
     * @access  public
     * @param   string  $query
     * @return  QueryResult | DbException
     */
    function QueryExecute( $query ){
        return false;
    }

    /**
     * テーブル一覧取得
     *
     * @access  public
     * @param   string  $db_name
     * @return   QueryResult |  DbException
     */
    function GetTableList( $db_name ){
        return false;
    }

    /**
     * テーブルに含まれるフィールドの情報を取得する
     *
     * @access  public
     * @param   string  $table
     * @return  QueryResult |  DbException
     */
    function GetFieldList( $db, $table ){
        return false;
    }

    /**
     * テーブルに含まれるフィールドの情報を取得する(Primary情報含)
     *
     * @access  public
     * @param   strin   $table
     * @return   QueryResult |  DbException
     */
    function GetFieldInfo( $table ){
        return false;
    }

    /**
     * テーブルの情報を取得する(コメント情報含)
     *
     * @access  public
     * @return   QueryResult |  DbException
     */
    function GetTableInfo(){
        return false;
    }

    /**
     * エラー番号取得
     * @access  public
     * @return  int
     */
    function GetError(){
        return false;
    }

    /**
     * エラーメッセージ取得
     * @access  public
     * @return  string
     */
    function GetErrorMsg(){
        return false;
    }

    /** クエリで影響のあった件数を返す
     * @access  public
     * @return  int
     */
    function GetAffectedRows(){
        return false;
    }

    function GetID(){
        return mysqli_insert_id($this->con);
    }

    function GetAutoIncrement($table)
    {
        $sql = "SHOW TABLE STATUS FROM {$this->db_info['NAME']} LIKE '{$table}'";
        $res = mysqli_query($this->con, $sql);
        $r   = mysqli_fetch_assoc($res);
        return $r['Auto_increment'];
    }

    function AlterAutoIncrement($table, $id)
    {
        $sql = "ALTER TABLE {$table} AUTO_INCREMENT = {$id}";
        $res = mysqli_query($this->con, $sql);
    }

    function get_mysql_version()
    {
        $sql  = "SELECT version() as version";
        $res = mysqli_query($this->con, $sql);
        $v   = mysqli_fetch_assoc($res);
        return $v["version"];
    }

}

?>
