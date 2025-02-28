<?php
/**
 * m_zipテーブル定義クラス
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan
 * @version    1.1.1
 * @create date 2021/1/3
 */

class   MZipBasicsObject
{
    var $table_name;            //テーブル名
    var $table_comment;         //テーブルコメント
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
    function MZipBasicsObject() {
        $this->table_name   = 'm_zip';
        $this->table_comment= '';

        $this->field_name   = array(
                   'f_id',
                   'f_zip_cd',
                   'f_address',

                );

        $this->field_type   = array(
                   'f_id' => 'int',
                   'f_zip_cd' => 'int',
                   'f_address' => 'varchar',

                );

        $this->field_type_size  = array(
                   'f_id' => '11',
                   'f_zip_cd' => '7',
                   'f_address' => '200',

                );

        $this->field_type_key   = array(
                   'f_id' => 'PRI',
                   'f_zip_cd' => '',
                   'f_address' => '',

                );

        $this->field_null   = array(
                   'f_id' => 'NO',
                   'f_zip_cd' => 'NO',
                   'f_address' => 'NO',

                );

        $this->field_comment= array(
                   'f_id' => '',
                   'f_zip_cd' => '',
                   'f_address' => '',

                );

    }
    //--------------------------------------------------------------------------
}
//------------------------------------------------------------------------------

?>
