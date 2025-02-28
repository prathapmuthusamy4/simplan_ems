<?php
// version	1.1 変更点 Build時にサニタジングの追加
/**
 * ＤＢクエリクラス
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan.DB
 * @version    1.1
 */
class Query{
    /** @var string
     * @access protected
     */
    var $sql;

    /**
     * コンストラクタ
     *
     * @access  public
     */
    function Query( $sql = ''){
        $this->sql = $sql;
    }
    //--------------------------------------------------------------------------

    /**
     * SQLテキストを取得する
     * @access  public
     * @return  string
     */ 
    function GetSQL(){ return $this->sql; }
    //--------------------------------------------------------------------------

    /**
     * SQLテンプレートファイルの読込
     * @access  public
     * @return  void
     */
    function Load( $filename ){
        if( !file_exists( $filename ) ) return false;

        $this->sql = file_get_contents( $filename );
		return true;
    }
    //--------------------------------------------------------------------------

	function AddLoad( $filename ){
		if( !file_exists( $filename ) ) return false;

        $this->sql .= file_get_contents( $filename );
		return true;
	}
    //--------------------------------------------------------------------------

    /**
     * SQLテンプレートの置換処理
     * @access  public
     * @return  void
     */
    function Build( $vars, $type = 'array_key', $con = NULL ){
		if( !is_array( $vars ) ) return false;
        switch( $type ){
            // 配列キー文字を置換
            case 'array_key':
                $ret = true;
                //エスケープシーケンス処理
				$index = array_keys( $vars );
                foreach( $index As $key ){
					if( is_array( $vars[$key] ) ) { continue; }
                    $vars[$key] = addslashes( $vars[$key] );
                }
                while( $ret ){
                    $this->sql = Detail::Detailing( $this->sql, $vars, $ret );
                }
                break;

			case 'array_key_none_secu':
                $ret = true;
                //エスケープシーケンス処理
                foreach( array_keys( $vars ) As $key ){
					if( is_array( $vars[$key] ) ) { continue; }
                    $vars[$key] = $vars[$key];
                }
				$offset = 0;
                while( $ret ){
					$this->sql =
					   	Detail::Detailing2( $this->sql, $vars, $ret, $offset );
                }
				break;

            // < ? >の処理
            default:
				foreach ($vars as $n => $v) {
					$pos = strpos($this->sql, '<?>');
		            if( $pos ){
						$this->sql = substr( $this->sql, 0, $pos ).
						   	$v.substr( $this->sql, $pos + 3 );
					} else {
						return false;
					}
				}
				break;
        }
        return true;
    }
    //--------------------------------------------------------------------------

}
//------------------------------------------------------------------------------

class tag{
    var $start;
    var $end;
    var $tag;

    var $name;
    var $type;

    function SetTag( $str ){
        if( strlen( $str ) == 0 || $str == '' ) {
            return false;
        }
        $this->tag = $str;
        $str = str_replace( '{', '', $str );
        $str = str_replace( '}', '', $str );
        $this->name = $str;
        return true;
    }
    //--------------------------------------------------------------------------

    function Dump(){
        echo "start    : ".$this->start."\n";
        echo "end      : ".$this->end."\n";
        echo "tag name : '".$this->name."'\n";
        echo "tag      : '{$this->tag}\n";
    }
    //--------------------------------------------------------------------------
}
//------------------------------------------------------------------------------

class Detail{
    function Detailing( $str, $args, &$ret, $encode = 'UTF-8' ){
        $ret = true;
        $res = '';

        $tag = new tag();

        //タグ検出
        $ret= $tag->SetTag(
            Detail::parsing_tag($str, $tag->start, $tag->end )
        );  
        //タグ未検出の場合
		if( $ret === false ){ return $str; }

        //ディテール処理
        $det = '';
		if( array_key_exists($tag->name, $args) ) $det = $args[$tag->name];
//		else if( $mode == 1 ) return $str; 

        //ディテール文字列の結合
        {
            $head = substr( $str, 0, $tag->start );
            $tail = substr( $str, $tag->end, strlen($str) - $tag->end );
            $res = $head.$det.$tail;
        }
        return $res;
    }
    //-------------------------------------------------------------------------
	//
    function Detailing2( $str, $args, &$ret, &$offset = 0, $encode = 'UTF-8' ){
        $ret = true;
        $res = '';

        $tag = new tag();

        //タグ検出
        $ret= $tag->SetTag(
            Detail::parsing_tag($str, $tag->start, $tag->end, $offset )
        );  
        //タグ未検出の場合
		if( $ret === false ){ return $str; }

        //ディテール処理
        $det = '';
		if( array_key_exists($tag->name, $args) ) $det = $args[$tag->name];
		else {
			$offset = $tag->end;
			return $str; 
		}

        //ディテール文字列の結合
        {
            $head = substr( $str, 0, $tag->start );
            $tail = substr( $str, $tag->end, strlen($str) - $tag->end );
            $res = $head.$det.$tail;
        }
        return $res;
    }
    //-------------------------------------------------------------------------


    function parsing_tag( $str, &$start, &$end, $offset = 0 ){
        $start = strpos( $str, '{', $offset  );
        if( $start === false ) {
            return '';
        }
        $end = strpos( $str, '}', $start );
        if( $end === false ) {
            return '';
        }
        $end ++;
        return substr( $str, $start, $end - $start );
    }
    //-------------------------------------------------------------------------

    function parsing_rep( $str, &$start, &$end, $offset = 0 ){
        $start = $offset;
        $end = strpos( $str, '{', $offset );
        return substr( $str, $start, $end - $start );
    }
    //-------------------------------------------------------------------------

}
//------------------------------------------------------------------------------

?>
