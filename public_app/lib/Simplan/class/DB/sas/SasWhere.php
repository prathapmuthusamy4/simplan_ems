<?php
/**
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan.DB.SAS
 * @version    1.0
 */

class   SasWhere{
	/** @var string
	 * @access protected
	 */
    var $operator;
	/** @var array
	 * @access protected
	 */
    var $object;
	/** @var int
	 * @access protected
	 */
    var $object_num;
    //--------------------------------------------------------------------------

    /**
     * コンストラクタ
     * @access  public
	 * @param	string	$ope
     */
    function SasWhere($ope = NULL){
        $this->object_num = 0;
        if( is_null( $ope ) ) $ope = 'And';
        $this->operator = $ope;
        $this->object = array();
    }
    //--------------------------------------------------------------------------

    /**
     * 全体の論理条件の設定
     *
     * @access  public
	 * @param	string	$ope
     * @return  void
     */ 
    function SetOperation( $ope ){
        $tmp = strtoupper( $ope );
        if( $tmp != 'AND' || $tmp != 'OR' ) return false;
        $this->$operation = $ope;
    }
    //--------------------------------------------------------------------------

    /**
     * WhereFieldsを追加する
     *
     * @access  public
	 * @param	string	$ope
	 * @param	array	$obj
     * @return  void
     */
    function Add( $ope, $obj ){
        $this->object[$this->object_num][$ope] = $obj;
        $this->object_num ++;
    }
    //--------------------------------------------------------------------------

    /**
     * 要素の有無を調べる
     *
     * @access  public
     * @return  true|false
     */
    function _Empty(){
        $flag = 0;
        if( $this->object_num == 0 ) return true;
        for( $n = 0; $n < $this->object_num; $n ++ ){
            $key = array_keys( $this->object[$n] );
            $key = $key[0];
            if( !$this->object[$n][$key]->_Empty() ) $flag ++;
        }
        if( $flag == 0 ) return true;
        return false;
    }
    //--------------------------------------------------------------------------

}
//------------------------------------------------------------------------------

?>
