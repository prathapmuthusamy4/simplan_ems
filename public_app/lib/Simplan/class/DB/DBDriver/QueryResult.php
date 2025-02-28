<?php
include_once( DBD_DIR . 'MySqlQueryResultAdaptee.php');
include_once( DBD_DIR . 'QueryResultAdaptee.php');
/**
 * ＤＢクエリ結果クラス
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan.DB
 * @version    1.0
 */
class QueryResult{
	/**	@var resource
	 * @access	protected
	 */
    var $node;

    /**
     * コンストラクタ
     * @access  public
     */
    function QueryResult( $type, $res ){
        $this->res = $res;
        switch( strtoupper( $type ) ) {
            case 'MYSQL' :
            case 'MYSQL:FIELD' :
                $this->node = new MySqlQueryResultAdaptee( $type, $res );
                break;
        }
    }
    //--------------------------------------------------------------------------

    /**
     * クエリ結果の受信
     * @access  public
     * @return  none
     */
    function RecResult( $type = 0 ){
        if( is_null( $this->node ) ) return false;
        return $this->node->RecResult( $type );
    }
    //--------------------------------------------------------------------------

    /**
     * クエリ結果の取得
     * @access  public
     * @return  array
     */
    function GetResult(){
        if( is_null( $this->node ) ) return false;
        if( is_null( $this->node->node ) ) $this->node->RecResult( 1 );
        return $this->node->node;
    }
    //--------------------------------------------------------------------------

    /**
     * クエリ結果のデータ件数の取得
     * @access  public
     * @return  int
     */
    function GetRowNum(){
        if( is_null( $this->node ) ) return false;
        return $this->node->GetRowNum();
    }
    //--------------------------------------------------------------------------

    /**
     * クエリ結果のフィールド数の取得
     * @access  public
     * @return  int
     */
    function GetFiledNum(){
        if( is_null( $this->node ) ) return false;
        return $this->node->GetFiledNum();
    }
    //--------------------------------------------------------------------------

    /**
     * クエリ結果リソースの破棄
     * @access  public
     * @return  true/false
     */
    function FreeResult(){
        if( is_null( $this->node ) ) return false;
        return $this->node->FreeResult();
    }
    //--------------------------------------------------------------------------

    /**
     * クエリ結果をcsv形式で取得
     * @access  public
     * @return  string
     */
    function ResultToCsv(){
        if( is_null( $this->node ) ) return false;
        return $this->node->ResultToCsv();
    }

}
//------------------------------------------------------------------------------

?>
