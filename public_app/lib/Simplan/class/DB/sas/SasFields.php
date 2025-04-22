<?php
/**
 * SasDefObjFactorにより生成される
 * Where文構成要素クラス
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan.DB.SAS
 * @version    1.0
 */

class   SasFields{
	/** @var array
	 * @accese public
	 */
    var $fields;

    /**
     * コンストラクタ
     *
	 * @param	BasicsObject	$def
     * @access  public
     */
    function SasFields( $def ){
        $this->fields = array();
        foreach( $def->field_name as $val ) {
            $this->fields[$val] = '';
        }
    }
    //--------------------------------------------------------------------------

    /**
     * 配列から値を取込む
     *
     * @access  public
	 * @param	array	&$val
     * @return  none
     */
    function SetArray( &$val ) {
        foreach( $val as $key => $val ){
            $this->fields[$key] = $val;
        }
    }
    //--------------------------------------------------------------------------

    /**
     * 配列から値を取込む
     *
     * @access  public
	 * @param	array	$type
     * @return  none
     */
    function SetField_ReplaceKey( $type = NULL ){
        if( is_null( $type ) ){
            foreach( $this->fields as $key => $val ){
                $this->fields[$key] = '{$'.$key.'}';
            }
        } else {
            foreach( $this->fields as $key => $val ){
                $this->fields[$key] = $type;
            }
        }
    }
    //--------------------------------------------------------------------------

}
//------------------------------------------------------------------------------

?>
