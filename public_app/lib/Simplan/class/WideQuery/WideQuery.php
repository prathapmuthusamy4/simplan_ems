<?php
include_once( 'widtag.php' );
class WideQuery{
    /** @var string
     * @access protected
     */
    var $sql;

    var $tag_st;
    var $tag_ed;
    /**
     * コンストラクタ
     *
     * @access  public
     */
    function WideQuery( $sql = ''){
        $this->sql = $sql;
        $this->SetTag();
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

    function SubBuild( $vars ){
        return $this->Build( $vars, 'array_key_none_secu' );
    }
    //--------------------------------------------------------------------------

    function SetTag( $st ='{', $ed ='}'){
        $this->tag_st = $st;
        $this->tag_ed = $ed;
    }
    //--------------------------------------------------------------------------

    /**
     * SQLテンプレートの置換処理
     * @access  public
     * @return  void
     */
    function Build( $vars, $type = 'array_key', $con = NULL ){
        switch( $type ){
            // 配列キー文字を置換
            case 'array_key':
                $ret = true;
                //エスケープシーケンス処理
                foreach( array_keys( $vars ) As $key ){
                    if( is_array( $vars[$key] ) ) { continue; }
                    //$vars[$key] = addslashes( $vars[$key] );
                    $vars[$key] = $vars[$key];
                }
                while( $ret ){
                    $this->sql = WideDetail::Detailing(
                        $this->sql,
                        $vars,
                        $ret,
                        'UTF-8',
                        array( $this->tag_st, $this->tag_ed )
                    );
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
                    $this->sql = WideDetail::Detailing2(
                        $this->sql,
                        $vars,
                        $ret,
                        $offset,
                        array( $this->tag_st, $this->tag_ed )
                    );
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

?>
