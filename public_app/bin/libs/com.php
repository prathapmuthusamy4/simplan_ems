<?php
include_once( 'command_define.php' );

//テンプレート置換エンジン
include_once( SIMPLAN_CLASS_DIR.'WideQuery/WideQuery.php' );
include_once( SIMPLAN_CLASS_DIR.'WideDB/CommandInterface.php' );

//------------------------------------------------------------------------------
// Simplanコマンド関数ライブラリ
//------------------------------------------------------------------------------

function FileReplaceAArray( $in_file, $out_file, $array ){
    if( !file_exists( $in_file ) ){
        echo "$in_file is not exists.\n";
        exit;
    }

    if( is_null( $array ) ){
        echo "array is null.\n";
        exit;
    }

    return file_put_contents( $out_file,
        ReplaceAArray( file_get_contents($in_file), $array) );
}
//------------------------------------------------------------------------------

function FileReplaceArray( $in_file, $out_file, $array ){
    if( !file_exists( $in_file ) ){
        echo "$in_file is not exists.\n";
        exit;
    }

    if( is_null( $array ) ){
        echo "array is null.\n";
        exit;
    }

    return file_put_contents( $out_file,
        ReplaceArray( file_get_contents($in_file), $array) );
}
//------------------------------------------------------------------------------

function SetArrayValue( $key, &$set, &$array ){
	if( array_key_exists( $key, $array ) ){
		$set = $array[$key];
		return true;
	}
	return false;
}
//------------------------------------------------------------------------------

function ReplaceAArray( $tmp, $array ){
    $d = new command_Detail();
    foreach( $array As $key => $val ){
        //Detail処理
        if( is_array( $val ) ) {
            $offset = 0;
            $loop = 0;
            //複数タグが合った場合の処理
            while( $offset >= 0 ){
                $loop ++;

                $d->Reset();
                //タグの検出
                while( $d->GetTagName() != $key ){
                    $offset = $d->ReadTag( $tmp, $offset );
                    //タグ未検出
                    if( $offset < 0 ) break;
                }
                //タグ未検出
                if( $offset < 0 ) break;

                if( $loop == 1 ) $val = EncodingAArray( $val[0] );
                $tmp = $d->SetDetail( $tmp, $val );
            }
            //タグ未検出
            if( $offset < 0 ) break;

        } else {
            $tmp = str_replace( $key, $val, $tmp );
        }
    }
    return $tmp;
}
//------------------------------------------------------------------------------

function ReplaceArray( $tmp, $array ){
    foreach( $array As $key => $val ){
        $tmp = str_replace( $key, $val, $tmp );
    }
    return $tmp;
}
//------------------------------------------------------------------------------

function EncodingArray( $array, $encode = 'UTF-8' ){
    foreach( $array as $key => $val )
        $array[$key] = mb_convert_encoding( $val, 'EUC-JP', $encode );
    return $array;
}
//------------------------------------------------------------------------------

function EncodingAArray( $array, $encode = 'UTF-8' ){
    foreach( $array as $key => $val )
        $array[$key] = EncodingArray( $val );
    return $array;
}
//------------------------------------------------------------------------------


function MyEcho( $str ){
    Global  $EchoFlag;
    if( $EchoFlag ) echo $str."\n";
}
//------------------------------------------------------------------------------

function DebugEcho( $str ){
    Global $DebugFlag;
    Global  $EchoFlag;
    if( $DebugFlag && $EchoFlag ) echo "Debug > ".$str."\n";
}
//------------------------------------------------------------------------------

function MyExit( $str, $error = false ){
	if( $error ){
		MyEcho( '**********************************************************' );
		MyEcho( '* ERROR  Done...                                         *' );
		MyEcho( '**********************************************************' );
    	MyEcho( ' '.$str );
		MyEcho( '**********************************************************' );
	} else {
    	MyEcho( $str );
	}
    exit;
}
//------------------------------------------------------------------------------

function SaveINI( $obj, $name ){
    if( ($fp = fopen( $name, "w" ) ) == false ) {
        MyEcho( " *** $name can't Open\n" );
        MyExit( " Don't Save Install Infomation\n" );
        exit;
    }

    foreach( $obj as $Skey => $Sval ){
        fputs( $fp, "[".$Skey."]\n" );
        foreach( $Sval as $Ekey => $Eval ){
            fputs( $fp, "$Ekey = $Eval\n" );
        } 
    }

    fclose( $fp );
}
//------------------------------------------------------------------------------

function mb_str_pad(
                $ps_input,
                $pn_pad_length,
                $ps_pad_string = " ",
                $pn_pad_type = STR_PAD_RIGHT,
                $ps_encoding = 'UTF-8'
) {
	if( strlen( $ps_input ) == 0 ) return '';
    return mb_convert_encoding(
                str_pad(
                    mb_convert_encoding( $ps_input, 'EUC-JP', $ps_encoding),
                    22,
                    $ps_pad_string,
                    $ps_pad_type
                ),
                $ps_encoding,
                'EUC-JP'
            );
}
//------------------------------------------------------------------------------

################################################################################
# Detail Begin
################################################################################
class command_tag{
    var $start;
    var $end;
    var $tag;

    var $name;
    var $type;

    function Reset(){
        $this->start = 0;
        $this->end = 0;
        $this->tag = '';
        $this->name = '';
        $this->type = '';
    }
    //--------------------------------------------------------------------------

    function SetTag( $str ){
        if( strlen( $str ) == 0 || $str == '' ) {
            return false;
        }
        $this->tag = $str;
        $str = str_replace( '{--', '', $str );
        $str = str_replace( '--}', '', $str );
        if( strpos( $str, ':' ) === false ) {
            echo "Tag Error:{$this->start}\n";
            exit;
        }
        $tmp = split( ':', $str );
        $this->type = $tmp[0];
        $this->name = $tmp[1];
        return true;
    }
    //--------------------------------------------------------------------------

    function Dump(){
        echo "start : ".$this->start."\n";
        echo "end     : ".$this->end."\n";
        echo "tag type : '".$this->type."'\n";
        echo "tag name : '".$this->name."'\n";
        echo "tag     : '".
            mb_convert_encoding($this->tag, 'UTF-8', 'EUC-JP')."'\n";
    }
    //--------------------------------------------------------------------------
}
//------------------------------------------------------------------------------

class command_Detail{
    var     $start;
    var     $end;
    var     $rep;

    function command_Detail(){
        $start = NULL;
        $end = NULL;
        $rep = NULL;
    }
    //--------------------------------------------------------------------------

    function Reset(){
        if( !is_null( $this->start ) ) $this->start->Reset();
        if( !is_null( $this->end ) ) $this->end->Reset();
        if( !is_null( $this->rep ) ) $this->rep->Reset();
    }
    //--------------------------------------------------------------------------

    function GetTagName(){
        if( is_null( $this-start ) ) return '';
        return $this->start->name;
    }
    //--------------------------------------------------------------------------

    function ReadTag( $str, $offset = 0, $encode = 'UTF-8' ){
        $str = mb_convert_encoding( $str, 'EUC-JP', $encode );

        if( $offset >= strlen( $str ) ) return -1;

        //開始位置の検出
        if( is_null( $this->start ) ) $this->start = new command_tag();
        $this->start->Reset();
        if( $this->start->SetTag( command_Detail::parsing_tag(
                $str, $this->start->start, $this->start->end, $offset )
            ) === false )
        {
            //タグ未検出
            return -2;
        }

        //終了位置の検出
        if( is_null( $this->end ) ) $this->end = new command_tag();
        $this->end->Reset();
        if( $this->end->SetTag( command_Detail::parsing_tag(
            $str, $this->end->start, $this->end->end, $this->start->end)
            ) === false )
        {
            //タグ未検出
            return -3;
        }

        //タグのチェック
        //　属性チェック
        if( strcmp(
                strtoupper( $st_tag->type ),
                strtoupper( $en_tag->type )
            ) !== 0  )
        {
            return -4;
        }
        //　名前チェック
        if( strcmp(
                strtoupper( $st_tag->name ),
                strtoupper( $en_tag->name )
            ) !== 0 )
        {
            return -5;
        }

        //置換エリアの検出
        if( is_null( $this->rep ) ) $this->rep = new command_tag();
        $this->rep->tag = command_Detail::parsing_rep(
            $str, $this->rep->start, $this->rep->end, $this->start->end );

        $this->rep->tag = rtrim( $this->rep->tag );

        return $this->end->end;
    }
    //--------------------------------------------------------------------------

    function SetDetail( $str, $args, $encode = 'UTF-8' ){
        $str = mb_convert_encoding( $str, 'EUC-JP', $encode );

        $det = '';
        foreach( $args as $val ) {
            $det .= ReplaceArray( $this->rep->tag, $val );
        }


        //ディテール文字列の結合
        {
            $head = substr( $str, 0, $this->start->start );
            $tail = substr( $str,
                $this->end->end, strlen($str) - $this->end->end );
            $res = $head.$det.$tail;
        }

        return mb_convert_encoding( $res, $encode, 'EUC-JP' );
    }
    //--------------------------------------------------------------------------

    function Detailing( $str, $args, $encode = 'UTF-8' ){
        $str = mb_convert_encoding( $str, 'EUC-JP', $encode );
        $res = '';

        $st_tag = new command_tag();
        $en_tag = new command_tag();
        $rp_tag = new command_tag();

        //開始位置の検出
        $st_tag->SetTag(
            command_Detail::parsing_tag($str, $st_tag->start, $st_tag->end )
        );
        //終了位置の検出
        $en_tag->SetTag(
			command_Detail::parsing_tag(
				$str, $en_tag->start, $en_tag->end, $st_tag->end )
        );

        //タグのチェック
        //　属性チェック
        if( strcmp(
                strtoupper( $st_tag->type ),
                strtoupper( $en_tag->type )
            ) !== 0  )
        {
            echo "Tag Type did not mach\n";
            exit;
        }
        //　名前チェック
        if( strcmp(
                strtoupper( $st_tag->name ),
                strtoupper( $en_tag->name )
            ) !== 0 )
        {
            echo "Tag Name did not mach\n";
            exit;
        }

        //置換エリアの検出
        $rp_tag->tag = command_Detail::parsing_rep(
				$str, $rp_tag->start, $rp_tag->end, $st_tag->end
		   	);

        $rp_tag->tag = ltrim( $rp_tag->tag, "\r\n" );
        $rp_tag->tag = rtrim( $rp_tag->tag, "\r\n"  );

        //ディテール処理
        $det = '';
        foreach( $args as $val ){
            $det .= ReplaceArray( $rp_tag->tag, $val); 
        }

        //ディテール文字列の結合
        {
            $head = substr( $str, 0, $st_tag->start );
            $tail = substr( $str, $en_tag->end, strlen($str) - $en_tag->end );
            $res = $head.$det.$tail;
        }
        return $res;
    }
    //-------------------------------------------------------------------------

    function parsing_tag( $str, &$start, &$end, $offset = 0 ){
        $start = strpos( $str, '{--', $offset  );
        if( $start === false ) { return ''; }
        $end = strpos( $str, '--}', $start );
        if( $end === false ) { return ''; }
        $end += 3;
        return substr( $str, $start, $end - $start );
    }
    //-------------------------------------------------------------------------

    function parsing_rep( $str, &$start, &$end, $offset = 0 ){
        $start = $offset;
        $end = strpos( $str, '{--', $offset );
        return substr( $str, $start, $end - $start );
    }
    //-------------------------------------------------------------------------

}
################################################################################
# Detail END
################################################################################

?>
