<?php
class Widetag{
    var $start;
    var $end;
    var $tag;

    var $name;
    var $type;
    var $type_args;

    var $code_start;
    var $code_end;

    function Widetag( $code ){
        $this->code_start   = $code[0];
        $this->code_end = $code[1];
    }

    function SetTag( $str ){
        if( strlen( $str ) == 0 || $str == '' ) {
            return false;
        }
        $this->tag = $str;
        $str = str_replace( $this->code_start, '', $str );
        $str = str_replace( $this->code_end, '', $str );
        $this->name = $str;
        if( strpos( $str, ':' ) !== false ){
            $tmp = explode( ':', $str );
            $this->name     = $tmp[0];
            $this->type     = $tmp[1];
            if( count( $tmp ) > 2 ){
                $this->type_args= $tmp[2];
            }
            /*
            list( $this->name, $this->type, $this->type_args ) =
                $this->parse_type( $str );
             */
        }
        return true;
    }
    //--------------------------------------------------------------------------

    function Dump(){
        echo "start    : ".$this->start."\n";
        echo "end      : ".$this->end."\n";
        echo "tag name : '".$this->name."'\n";
        echo "tag      : '{$this->tag}'\n";
        echo "type     : '{$this->type}'\n";
    }
    //--------------------------------------------------------------------------
}
//------------------------------------------------------------------------------

class WideDetail{

    public static function Detailing(
                $str,
                $args,
                &$ret,
                $encode = 'UTF-8',
                $tag_code = array( '{', '}' )
    ){
        $ret = true;
        $res = '';
        $mode = 0;

        $tag = new Widetag( $tag_code);

        //タグ検出
        $ret= $tag->SetTag(
            WideDetail::parsing_tag($str, $tag->start, $tag->end, 0, $tag )
        );  
        //タグ未検出の場合
        if( $ret === false ){ return $str; }

        $det = '';
        //ディテール処理
        if( array_key_exists($tag->name, $args) ){
            //属性に対しての処理
            switch( $tag->type ){
                case 'NVL':
                    $det = addslashes( $args[$tag->name] );
                    if( strlen( $args[$tag->name] ) == 0 ) $det = 'NULL';
                    break;
                case 'NVL_STRING':
                    $det = "'".addslashes( $args[$tag->name] )."'";
                    if( strlen( $args[$tag->name] ) == 0 ) $det = 'NULL';
                    break;
                case 'NVL_EMPTY_STRING':
                    $det = "'".addslashes( $args[$tag->name] )."'";
                    if( strlen( $args[$tag->name] ) == 0 ) $det = "''";
                    break;
                case 'SUB':
                    $det = $args[$tag->name];
                    break;
                case 'NVC':
                    $det = addslashes( $args[$tag->name] );
                    if( strlen($args[$tag->name]) == 0 ) $det = $tag->type_args;
                    break;
                case 'NVC_STRING':
                    $det = "'".addslashes( $args[$tag->name] )."'";
                    if( strlen($args[$tag->name]) == 0 )
                        $det = "'".$tag->type_args."'";
                    break;
                case 'NOSLASH':
                    $det = $args[$tag->name];
                    break;
                default:
                    $det = addslashes( $args[$tag->name] );
                    break;
            }
        } else if( $mode == 1 ) {
            return $str; 
        } else {
            //置換文字未検知時
            switch( $tag->type ){
                case 'NVL':
                case 'NVL_STRING':
                    $det =  'NULL';
                    break;
                case 'NVL_EMPTY_STRING':
                    $det =  "''";
                    break;
            }
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
    //
    public static function Detailing2(
                $str,
                $args,
                &$ret,
                &$offset = 0,
                $encode = 'UTF-8',
                $tag_code = array( '{', '}' )
    ){
        $ret = true;
        $res = '';

        $tag = new Widetag( $tag_code );

        //タグ検出
        $ret= $tag->SetTag(
            WideDetail::parsing_tag(
                $str, $tag->start, $tag->end, $offset, $tag )
        );  
        //タグ未検出の場合
        if( $ret === false ){ return $str; }

        //ディテール処理
        $det = '';
        if( array_key_exists($tag->name, $args) ){
            //属性に対しての処理
            switch( $tag->type ){
                case 'NVL':
                    $det = $args[$tag->name];
                    if( strlen( $args[$tag->name] ) == 0 ) $det = 'NULL';
                    break;
                default:
                    $det = $args[$tag->name];
                    break;
            }
        } else {
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

    public static function parsing_tag( $str, &$start, &$end, &$tag, $offset = 0){
        $start = strpos( $str, $tag->code_start, $offset  );
        if( $start === false ) {
            return '';
        }
        $end = strpos( $str, $tag->code_end, $start );
        if( $end === false ) {
            return '';
        }
        $end += strlen( $tag->code_end );
        return substr( $str, $start, $end - $start );
    }
    //-------------------------------------------------------------------------

    public static function parsing_rep( $str, &$start, &$end, &$tag, $offset = 0){
        $start = $offset;
        $end = strpos( $str, $tag->code_start, $offset );
        return substr( $str, $start, $end - $start );
    }
    //-------------------------------------------------------------------------

    public static function parse_type( $str ){
        $len = strlen( $str );
        $name       = '';
        $type       = '';
        $type_args  = '';

        //name の検出
        $p = 0;
        for(; $p < $len; $p ++ ){
            if( ($p = strpos( $str, ':', $p )) === false ) break;
            if( substr( $str, $p - 1, 1 ) === '\\' ) continue;
            $name = str_replace( '\\', '', substr( $str, 0, $p ) );
            break;
        }
        $bp = $p + 1;

        //typeの検出
        for(;$p < $len; $p ++ ){
            if( ($p = strpos( $str, '.', $p ) ) === false ) break;
            if( substr( $str, $p - 1, 1 ) === '\\' ) continue;
            $type = str_replace( '\\', '', substr( $str, $bp, $p - $bp ) );
            break;
        }
        $bp = $p + 1;

        //type_argsの検出
        if( $len > $p ) { $type_args = substr( $str, $bp ); }

        return array( $name, $type, $type_args );
    }
    //-------------------------------------------------------------------------

}
//------------------------------------------------------------------------------
?>
