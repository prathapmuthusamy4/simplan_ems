<?php
/**
 * ＤＢクエリ実行基底クラス Interface Class
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan.DB
 * @version    1.0
 */

include_once( DBD_DIR . 'Query.php');
include_once( DBD_DIR . 'QueryResult.php');

class CommandAdaptee{
	/** @var string */
    var $adapt_type;

	/** @var resource */
	var $con;

    /**
     * コンストラクタ
     *
     * @access  public
	 * @param	array		$db_info
	 * @param	resource	$con
     */
    function CommandAdaptee( $db_info, $con ){
        $this->con = $con;
    }
    //--------------------------------------------------------------------------

    /**
     * トランザクション開始
     *
     * @access  public
	 * @param	bool	$type
     * @return 	DbException
     */
    function Begin( $type = false ){
        return new DbException($this, "Begin()::This class can't Runing");
    }
    //--------------------------------------------------------------------------

    /**
     * コミット
     *
     * @access  public
	 * @param	bool	$type
     * @return 	DbException
     */
    function Commit( $type = false ){
        return new DbException($this, "Commit()::This class can't Runing");
    }
    //--------------------------------------------------------------------------

    /**
     * ロールバック
     *
     * @access  public
	 * @param	bool	$type
     * @return 	DbException
     */
    function RollBack( $type = false ){
        return new DbException($this, "RollBack()::This class can't Runing");
    }
    //--------------------------------------------------------------------------

    /**
     * クエリ実行
     *
     * @access  public
	 * @param	bool	$type
     * @return 	DbException
     */
    function QueryExecute( $query,  $type = false ){
        return new DbException($this, "QueryExecute()::This class can't Runing");
    }
    //--------------------------------------------------------------------------

    /**
     * テーブル一覧取得
     *
     * @access  public
     * @return 	DbException
     */
    function GetTableList( $db ){
        return new DbException($this,"GetTableList()::This class can't Runing");
    }
    //--------------------------------------------------------------------------

    /**
     * テーブルに含まれるフィールドの情報を取得する
     * 
     * @access  public
     * @return 	DbException
     */
    function GetFiledList( $db, $table ){
        return new DbException($this,"GetFieldList()::This class can't Runing");
    }
    //--------------------------------------------------------------------------

    /**
     * テーブルに含まれるフィールドの情報を取得する(Primary情報含)
     *
     * @access  public
     * @return 	DbException
     */
    function GetFiledInfo( $table ){
        return new DbException($this,"GetFieldInfo()::This class can't Runing");
    }
    //--------------------------------------------------------------------------

    /**
     * テーブルに含まれるフィールドの情報を取得する(Primary情報含)
     *
     * @access  public
     * @return 	DbException
     */
    function GetTableInfo(){
        return new DbException($this,"GetTableInfo()::This class can't Runing");
    }
    //--------------------------------------------------------------------------

}
//------------------------------------------------------------------------------

?>
