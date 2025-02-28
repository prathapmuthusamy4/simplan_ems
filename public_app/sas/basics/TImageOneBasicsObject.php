<?php
/**
 * t_image_oneテーブル定義クラス
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan
 * @version    1.1.1
 * @create date 2019/2/2
 */

class   TImageOneBasicsObject
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
    function TImageOneBasicsObject() {
        $this->table_name   = 't_image_one';
        $this->table_comment= '画像テーブル';

        $this->field_name   = array(
                   'f_image_one_id',
                   'f_image',
                   'f_del_flg',
                   'f_reg_account',
                   'f_reg_time',
                   'f_upd_account',
                   'f_upd_time',

                );

        $this->field_type   = array(
                   'f_image_one_id' => 'int',
                   'f_image' => 'varchar',
                   'f_del_flg' => 'char',
                   'f_reg_account' => 'int',
                   'f_reg_time' => 'datetime',
                   'f_upd_account' => 'int',
                   'f_upd_time' => 'datetime',

                );

        $this->field_type_size  = array(
                   'f_image_one_id' => '8',
                   'f_image' => '64',
                   'f_del_flg' => '1',
                   'f_reg_account' => '10',
                   'f_reg_time' => 'datetime',
                   'f_upd_account' => '10',
                   'f_upd_time' => 'datetime',

                );

        $this->field_type_key   = array(
                   'f_image_one_id' => 'PRI',
                   'f_image' => '',
                   'f_del_flg' => '',
                   'f_reg_account' => '',
                   'f_reg_time' => '',
                   'f_upd_account' => '',
                   'f_upd_time' => '',

                );

        $this->field_null   = array(
                   'f_image_one_id' => 'NO',
                   'f_image' => 'YES',
                   'f_del_flg' => 'YES',
                   'f_reg_account' => 'YES',
                   'f_reg_time' => 'YES',
                   'f_upd_account' => 'YES',
                   'f_upd_time' => 'YES',

                );

        $this->field_comment= array(
                   'f_image_one_id' => '画像ーID',
                   'f_image' => '画像',
                   'f_del_flg' => '削除フラグ',
                   'f_reg_account' => '登録者',
                   'f_reg_time' => '登録日時',
                   'f_upd_account' => '更新者',
                   'f_upd_time' => '更新日時',

                );

    }
    //--------------------------------------------------------------------------
}
//------------------------------------------------------------------------------

?>
