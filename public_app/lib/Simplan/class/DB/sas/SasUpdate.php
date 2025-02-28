<?php
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

class   SasUpdate{
    /** @var SasFields
     * @access public
     */
    var $value;
    /** @var string
     *  @access protected
     */
    var $table;
    /** @var BasecisObject
     * @access public
     */
    var $def;
    /** @var SasWhere;
     * @access public
     */
    var $where;

    /**
     * コンストラクタ
     *
     * @access  public
     */
    function SasUpdate( $table, $def, $field = NULL, $where = NULL){
        $this->table = $table;
        $this->def = $def;

        if( is_null( $field ) ) $this->value = new SasFields( $def );
        else $this->value = $field;

        if( is_null( $where ) ) $this->where = new SasWhere();
        else $this->where = $where;
    }
    //--------------------------------------------------------------------------

    /**
     * プライマリーキーのフィールドに置換文字列をセットする
     *
     * @access  public
     * @param   string  $keyval 置換トリガ文字
     * @return  none
     */
    function MakeOneWhere( $keyval = NULL ){
        $wf = new SasWhereFields( $this->table, $this->def );
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
        $this->where->Add( 'AND', $wf );
    }
    //--------------------------------------------------------------------------
}
//------------------------------------------------------------------------------

?>
