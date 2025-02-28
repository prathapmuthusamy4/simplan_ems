<?php
/**
 * ＤＢ例外クラス
 * 
 * @link       
 * @author     
 * @license    
 * @package    Simplan.DB
 * @version    1.0
 */

class DbException{
    var $err_object;
    var $msg;

    /**
     * コンストラクタ
     *
     * @access  public
     * @return  none
     * @comment DBFactoryをインスタンス化している
     */
    function DbException( $object, $msg ){
        if( is_string( $object ) ) $this->err_object = $object;
        else $this->err_object  = get_class( $object );

        $this->msg          = $msg;
    }
    //--------------------------------------------------------------------------

    function GetMsg(){
        return $this->err_object."::".$this->msg;
    }
    //--------------------------------------------------------------------------
}
//------------------------------------------------------------------------------

?>
