<?php
/**
 * Sas例外処理クラス
 * 
 * @link       
 * @author     
 * @license    
 * @package    Simplan.DB.SAS
 * @version    1.0
 */
class SasException{
    var $err_object;
    var $msg;

    /**
     * コンストラクタ
     *
     * @access  public
     * @return  none
     * @comment DBFactoryをインスタンス化している
     */
    function SasException( $object, $msg ){

        if( is_string( $object ) ) $this->object = $object;
        else $this->err_object  = get_class( $object );

        $this->msg          = $msg;
    }
    //--------------------------------------------------------------------------

    /**
     * メッセージを構築して返す
     *
     * @access  public
     * @return  none
     */
    function GetMsg(){
        return $this->err_object."::".$this->msg;
    }
    //--------------------------------------------------------------------------

    /**
     * SasExceptionクラスであるかを調べる
     *
     * @access  public
     * @return  true / false
     */
    function is_Except( &$obj ){
		if( !is_object( $obj ) ) return false;
        if( get_class( $obj ) != 'SasException' ) return false;
        return true;
    }
    //--------------------------------------------------------------------------
}
//------------------------------------------------------------------------------

?>
