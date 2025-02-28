<?php
/**
 * ＤＢクエリ結果クラス
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan.DB
 * @version    1.0
 */

class QueryResultAdaptee{
    var $adapt_type;
    var $res;
    var $node;

    /**
     * コンストラクタ
     *
     * @access  public
     * @return  none
     */
    function QueryResultAdaptee( $type, $res ){
    }
    //--------------------------------------------------------------------------

    /**
     * クエリ結果の受信
     *
     * @access  public
     * @return  none
     */
    function RecResult(){
    }
    //--------------------------------------------------------------------------

    /**
     * クエリ結果の取得
     *
     * @access  public
     * @return  array
     */
    function GetResult(){
    }
    //--------------------------------------------------------------------------

    /**
     * クエリ結果のデータ件数の取得
     *
     * @access  public
     * @return  int
     */
    function GetRowNum(){
    }
    //--------------------------------------------------------------------------

    /**
     * クエリ結果のフィールド数の取得
     *
     * @access  public
     * @return  int
     */ 
    function GetFiledNum(){
    }
    //--------------------------------------------------------------------------

    /**
     * クエリ結果リソースの破棄
     *
     * @access  public
     * @return  true/false
     */
    function FreeResult(){
    }
    //--------------------------------------------------------------------------

    /**
     * クエリ結果をcsv形式で取得
     *
     * @access  public
     * @return  string
     */
    function ResultToCsv(){
    }
    //--------------------------------------------------------------------------
}
//------------------------------------------------------------------------------

?>
