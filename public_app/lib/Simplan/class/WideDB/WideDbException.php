<?php
class WideDbException{
    var $err_object;
    var $msg;
	var $sql;

    /**
     * コンストラクタ
     *
     * @access  public
     * @return  none
     * @comment DBFactoryをインスタンス化している
     */
    function WideDbException( $object, $msg ){
		if( is_string($object) ) {
			$this->err_object = $object;
		} else {
			$this->err_object  = get_class( $object );
		}
        $this->msg          = $msg;
        var_dump($this);
    }
    //--------------------------------------------------------------------------

    function GetMsg(){
        return $this->err_object."::".$this->msg;
    }
    //--------------------------------------------------------------------------
}
//------------------------------------------------------------------------------

?>
