<?php
/**
 * {$TableName}テーブル定義クラス
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan
 * @version    {$var_1}.{$var_2}.{$var_3}
 * @create date {$c_year}/{$c_month}/{$c_day}
 */

class   {$ObjectName}BasicsObject
{
    var $table_name;            //テーブル名
    var $field_name;            //フィールド名配列
    var $field_type;            //フィールド タイプ配列　[フィールド名]
    var $field_type_size;       //フィールド サイズ
    var $field_type_key;        //フィールド キー
    var $field_null;            //必須入力配列

    /**
     * コンストラクタ
     *
     * @access  public
     * @return  none
    **/
    function {$ObjectName}BasicsObject() {
        $this->table_name   = '{$TableName}';

        $this->field_name   = array(
{$Table_All_Fields}
                );

        $this->field_type   = array(
{$Table_Field_Type}
                );

        $this->field_type_size  = array(
{$Table_Field_Size}
                );

        $this->field_type_key   = array(
{$Table_Field_Key}
                );

        $this->field_null   = array(
{$Table_Field_Null}
                );

    }
    //--------------------------------------------------------------------------
}
//------------------------------------------------------------------------------

?>
