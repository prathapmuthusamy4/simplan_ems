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
class   SasWhereFields{
    /** @var string
     *  @access protected
     */
    var $tablename;     //protected
    /** @var BasecisObject
     * @access public
     */
    var $def;
    /** @var SasFields
     * @access public
     */
    var $fields;

    /**
     * コンストラクタ
     *
     * @access  public
     * @return  none
     */
    function SasWhereFields( $tablename, &$def ){
        $this->tablename = $tablename;
        $this->def = $def;

        $fields = $def->field_name;
        for( $n = 0; $n < count( $fields ); $n ++ ){
            $this->fields[$fields[$n]]['value'] = '';
            $this->fields[$fields[$n]]['operation'] = '=';
            $this->fields[$fields[$n]]['func'] = '';
        }
    }
    //--------------------------------------------------------------------------

    /**
     * 配列からのデータを取込
     *
     * @access  public
     * @return  none
     */
    function SetFields( $val ){
        $keys = array_keys( $val );
        for( $n = 0; $n < count( $val ); $n ++ ){
            $this->fields[$keys[$n]]['value'] = $val[$keys[$n]];
            $this->fields[$keys[$n]]['operation'] = '=';
        }
    }
    //--------------------------------------------------------------------------

    /**
     * 条件要素の有無を調べる
     *
     * @access  public
     * @return  ture / false
     */
    function _Empty(){
        $flag = 0;
        $keys = array_keys( $this->fields );
        for( $n = 0; $n < count( $keys ); $n ++ ){
            if( !is_null( $this->fields[$keys[$n]]['value']) ) $flag ++;
        }
        if( $flag == 0 ) return true;
        return false;
    }
    //--------------------------------------------------------------------------

    /**
     * 指定したフィールドの要素の有無を調べる
     *
     * @access  public
     * @return  ture / false
     */
    function EmptyRow( $key ){
        if( strlen( $this->fields[$key]['value'] ) == 0 ) return true;
        return false;
    }
    //--------------------------------------------------------------------------

    /**
     * WhereFieldsを追加する
     *
     * @access  public
     * @return  none
     */
    function Add( $ope, &$node ){
        $key = '';
        for( $n = 0; $n < 100; $n ++ ){
            $key = 'NEST'.sprintf("%03d", $n );
            if( !array_key_exists( $key, $this->fields ) ) break;
        }
        $this->fields[$key]['value'] = $ope;
        $this->fields[$key]['operation'] = $node;
    }   
    //--------------------------------------------------------------------------

}
//------------------------------------------------------------------------------

?>
