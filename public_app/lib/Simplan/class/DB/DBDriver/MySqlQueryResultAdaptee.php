<?php
include_once( DBD_DIR . 'QueryResultAdaptee.php');

/**
 * MySQL用ＤＢクエリ結果クラス
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan.DB
 * @version    1.0
 */
class MySqlQueryResultAdaptee extends QueryResultAdaptee{
	/**
	 * @var string
	 * @access	protected
	 */
	var $adapt_type;

	/**
	 * @var resource
	 * @access	protected
	 */
    var $res;

	/**
	 * @var array
	 * @access	protected
	 */
    var $node;

    /**
     * コンストラクタ
     * @access  public
     */
    function MySqlQueryResultAdaptee( $type, $res ){
        $this->adapt_type = $type;
        $this->res = $res;
        $this->node = array();
    }
    //--------------------------------------------------------------------------

    /**
     * クエリ結果の受信
     * @access  public
	 * @param	int	$type	return arrayのフォーマットタイプ
     * @return  array
     */
    function RecResult( $type = 0 ){
        $tmp = array();
        switch( strtoupper( $this->adapt_type ) ){
            case 'MYSQL':
                $cnt = 0;
				switch( $type ){
					case 1:
                    	while($tmp=mysql_fetch_array($this->res, MYSQL_ASSOC)){
                        	$keys = array_keys( $tmp );
                        	for( $n = 0; $n < count( $keys ); $n ++ ){
                            	$this->node[$cnt][$keys[$n]] = $tmp[$keys[$n]];
                        	}
                        	$cnt ++;
                    	}
						break;

					case 2:
                    	while($tmp=mysql_fetch_array($this->res, MYSQL_ASSOC)){
                        	$keys = array_keys( $tmp );
                        	for( $n = 0; $n < count( $keys ); $n ++ ){
                            	$this->node[$keys[$n]][$cnt] = $tmp[$keys[$n]];
                        	}
                        	$cnt ++;
                    	}
						break;

					default:
                    	$this->node = mysql_fetch_array($this->res,MYSQL_ASSOC);
						break;
				}
				break;

            case 'MYSQL:FIELD':
                $row = mysql_num_fields( $this->res );
                for( $n = 0; $n < $row; $n ++ ){
                    $tmp['name'][$n] = mysql_field_name( $this->res, $n );
                    $tmp['type'][$n] = mysql_field_type( $this->res, $n );
                    $tmp['len'][$n] = mysql_field_len( $this->res, $n );
                }
                $this->node = $tmp;
                break;
        }
    }
    //--------------------------------------------------------------------------

    /**
     * クエリ結果の取得
     * @access  public
     * @return  array
     */
    function GetResult(){
        return $this->node;
    }
    //--------------------------------------------------------------------------

    /**
     * クエリ結果のデータ件数の取得
     * @access  public
     * @return  int
     */
	function GetRowNum(){
		if( is_bool( $this->res ) ) return true;
		return mysql_num_rows( $this->res );
   	}
    //--------------------------------------------------------------------------

    /**
     * クエリ結果のフィールド数の取得
     * @access  public
     * @return  int
     */ 
	function GetFiledNum(){
		if( is_bool( $this->res ) ) return true;
		return mysql_num_fields( $this->res );
   	}
    //--------------------------------------------------------------------------

    /**
     * クエリ結果リソースの破棄
     * @access  public
     * @return  void
     */
    function FreeResult(){
        mysql_free_result( $this->res );
        $this->res = NULL;
        $this->node= NULL;
    }
    //--------------------------------------------------------------------------

    /**
     * クエリ結果をcsv形式で取得
     * @access  public
     * @return  string
     */ 
    function ResultToCsv(){
        $ret = '';
        $key = array_keys( $this->node );

        //ヘッダ行
        $len = count( $key );
        $ret .= "#";
        for( $n = 0; $n < $len; $n ++ ){
            $ret .= $key[$n];

            if( $n + 1 == $len ) $ret .= "\n";
            else $ret .= ',';
        }

        //Ditale
        $row = count( $this->node[$key[0]] );
        $len = count( $key );
        for( $n = 0; $n < $len; $n ++ ) {
            for( $na = 0; $na < $len; $na ++ ){
                $ret .= $this->node[ $key[$na] ][$n];
                if( $na < $len ) $ret .= ',';
            }
            $ret .= "\n";
        }

        return $ret;
    }
    //--------------------------------------------------------------------------


}
//------------------------------------------------------------------------------

?>
