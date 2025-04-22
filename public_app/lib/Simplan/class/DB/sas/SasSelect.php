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
class   SasSelect{
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
     * @param   string $table
     * @param   BasicsObject    $def
     * @access  public
     */
    function SasSelect( $table, $def ){
        $this->table = $table;
        $this->def= $def;
        $this->where = new SasWhere();
    }
    //--------------------------------------------------------------------------

    /**
     * プライマリーキーのフィールドに置換文字列をセットする
     *
     * @access  public
     * @param   string  $keyval 置換トリガ文字
     * @return  void
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
