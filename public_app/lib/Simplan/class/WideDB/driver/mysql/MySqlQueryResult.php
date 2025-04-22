<?php
define( 'MYSQL_RESULT_ROWS', 1);
define( 'MYSQL_RESULT_ARRAY', 2);

/**
 * MySQL用ＤＢクエリ結果クラス
 *
 * @link
 * @author
 * @license
 * @package    Simplan.DB
 * @version    1.0
 */
class MySqlQueryResult {
	/**
	 * @var string
	 * @access	protected
	 */
	var $type;

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
    function __construct( $res ){
        $this->type = 'mysql';
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
		$cnt = 0;
		if( $this->res == null ) return false;
		switch( $type ){
			case 1:
              	while($tmp=mysqli_fetch_array($this->res, MYSQLI_ASSOC)){
                   	$keys = array_keys( $tmp );
                   	for( $n = 0; $n < count( $keys ); $n ++ ){
						$this->node[$cnt][$keys[$n]] = $tmp[$keys[$n]];
					}
					$cnt ++;
				}
				break;

			case 2:
				while($tmp=mysqli_fetch_array($this->res, MYSQLI_ASSOC)){
					$keys = array_keys( $tmp );
					for( $n = 0; $n < count( $keys ); $n ++ ){
						$this->node[$keys[$n]][$cnt] = $tmp[$keys[$n]];
					}
					$cnt ++;
				}
				break;

			case 3:
                $row = mysqli_num_fields( $this->res );
                for( $n = 0; $n < $row; $n ++ ){
                    $finfo = $this->res->fetch_field_direct($n);
                    $tmp['name'][$n] = $finfo->name;
                    $tmp['type'][$n] = $finfo->type;
                    $tmp['len'][$n]  = $finfo->max_length;
                }
                $this->node = $tmp;
				break;

			default:
				$this->node = mysqli_fetch_array($this->res,MYSQLI_ASSOC);
				break;
		}
		return true;
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
		return mysqli_num_rows( $this->res );
   	}
    //--------------------------------------------------------------------------

    /**
     * クエリ結果のフィールド数の取得
     * @access  public
     * @return  int
     */
	function GetFiledNum(){
		if( is_bool( $this->res ) ) return true;
		return mysqli_field_count( $this->res );
   	}
    //--------------------------------------------------------------------------

    /**
     * クエリ結果リソースの破棄
     * @access  public
     * @return  void
     */
    function FreeResult(){
        mysqli_free_result( $this->res );
        $this->res = NULL;
        $this->node= NULL;
    }
    //--------------------------------------------------------------------------

	function GetID(){
		return mysqli_insert_id( $this->res );
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
