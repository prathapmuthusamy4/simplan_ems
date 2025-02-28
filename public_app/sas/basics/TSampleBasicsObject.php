<?php
/**
 * t_sampleテーブル定義クラス
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan
 * @version    1.1.1
 * @create date 2019/12/6
 */

class   TSampleBasicsObject
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
    function TSampleBasicsObject() {
        $this->table_name   = 't_sample';
        $this->table_comment= '';

        $this->field_name   = array(
                   'f_id',
                   'f_address',
                   'f_name',
                   'f_mailaddress',
                   'f_time',
                   'f_del_flg',
                   'f_reg_account',
                   'f_reg_time',
                   'f_upd_account',
                   'f_upd_time',

                );

        $this->field_type   = array(
                   'f_id' => 'int',
                   'f_address' => 'varchar',
                   'f_name' => 'varchar',
                   'f_mailaddress' => 'varchar',
                   'f_time' => 'datetime',
                   'f_del_flg' => 'int',
                   'f_reg_account' => 'int',
                   'f_reg_time' => 'datetime',
                   'f_upd_account' => 'int',
                   'f_upd_time' => 'datetime',

                );

        $this->field_type_size  = array(
                   'f_id' => '64',
                   'f_address' => '100',
                   'f_name' => '100',
                   'f_mailaddress' => '100',
                   'f_time' => 'datetime',
                   'f_del_flg' => '11',
                   'f_reg_account' => '8',
                   'f_reg_time' => 'datetime',
                   'f_upd_account' => '8',
                   'f_upd_time' => 'datetime',

                );

        $this->field_type_key   = array(
                   'f_id' => 'PRI',
                   'f_address' => '',
                   'f_name' => '',
                   'f_mailaddress' => '',
                   'f_time' => '',
                   'f_del_flg' => '',
                   'f_reg_account' => '',
                   'f_reg_time' => '',
                   'f_upd_account' => '',
                   'f_upd_time' => '',

                );

        $this->field_null   = array(
                   'f_id' => 'NO',
                   'f_address' => 'NO',
                   'f_name' => 'NO',
                   'f_mailaddress' => 'NO',
                   'f_time' => 'NO',
                   'f_del_flg' => 'NO',
                   'f_reg_account' => 'NO',
                   'f_reg_time' => 'NO',
                   'f_upd_account' => 'NO',
                   'f_upd_time' => 'NO',

                );

        $this->field_comment= array(
                   'f_id' => '',
                   'f_address' => '',
                   'f_name' => '',
                   'f_mailaddress' => '',
                   'f_time' => '',
                   'f_del_flg' => '',
                   'f_reg_account' => '',
                   'f_reg_time' => '',
                   'f_upd_account' => '',
                   'f_upd_time' => '',

                );

    }
    //--------------------------------------------------------------------------
}
//------------------------------------------------------------------------------

?>
