<?php

include_once 'SasFields.php';

/**
 * SasDefObjFactorにより生成される
 * Select文構成要素クラス
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan.DB.SAS
 * @version    1.0
 */
class   SasInsert
{
    var $table;
    var $value;     //public SasFields;
    var $def;

    /**
     * コンストラクタ
     *
     * @access  public
     * @return  none
     */
    function SasInsert( $table, $def, $val = NULL ){
        $this->table = $table ;
        $this->def = $def;
        if( is_null( $val ) ) {
            $this->value = new SasFields( $def );
        } else {
            $this->value = $val;
        }
    }
    //--------------------------------------------------------------------------

    /**
     * プライマリーキーのフィールドに置換文字列をセットする
     *
     * @access  public
     * @return  none
     */
    function MakeValue( $keyval = NULL ){
        $this->value->SetField_ReplaceKey( '<?>' );
    }
    //--------------------------------------------------------------------------

    function MakeOneWhere( $keyval = NULL ){
        $tmp = array();
        foreach( $this->def->field_type_key as $key => $val ){
            if( $val == 'PRI' ){
                if( is_null( $keyval ) ) {
                    $tmp[$key] = SasAutoSQL::Decorated( $key, $key, $this->def);
                }
                else $tmp[$key] = $keyval;
            }
        }
        $wf->SetFields( $tmp );
        $this->Add( 'AND', $wf );
    }
    //--------------------------------------------------------------------------
}
//------------------------------------------------------------------------------

?>
