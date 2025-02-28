<?php
/**
 * t_customerテーブル定義クラス
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan
 * @version    1.1.1
 * @create date 2019/6/4
 */

class   TCustomerBasicsObject
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
    function TCustomerBasicsObject() {
        $this->table_name   = 't_customer';
        $this->table_comment= '';

        $this->field_name   = array(
                   'f_customer_id',
                   'f_name',
                   'f_dob',
                   'f_age',
                   'f_gender',
                   'f_blood_group',
                   'f_hobbies',
                   'f_remarks',
                   'f_del_flg',
                   'f_reg_account',
                   'f_reg_time',
                   'f_upd_account',
                   'f_upd_time',

                );

        $this->field_type   = array(
                   'f_customer_id' => 'int',
                   'f_name' => 'varchar',
                   'f_dob' => 'date',
                   'f_age' => 'int',
                   'f_gender' => 'char',
                   'f_blood_group' => 'int',
                   'f_hobbies' => 'varchar',
                   'f_remarks' => 'text',
                   'f_del_flg' => 'char',
                   'f_reg_account' => 'int',
                   'f_reg_time' => 'datetime',
                   'f_upd_account' => 'int',
                   'f_upd_time' => 'datetime',

                );

        $this->field_type_size  = array(
                   'f_customer_id' => '8',
                   'f_name' => '255',
                   'f_dob' => 'date',
                   'f_age' => '8',
                   'f_gender' => '1',
                   'f_blood_group' => '10',
                   'f_hobbies' => '255',
                   'f_remarks' => 'text',
                   'f_del_flg' => '1',
                   'f_reg_account' => '8',
                   'f_reg_time' => 'datetime',
                   'f_upd_account' => '8',
                   'f_upd_time' => 'datetime',

                );

        $this->field_type_key   = array(
                   'f_customer_id' => 'PRI',
                   'f_name' => '',
                   'f_dob' => '',
                   'f_age' => '',
                   'f_gender' => '',
                   'f_blood_group' => '',
                   'f_hobbies' => '',
                   'f_remarks' => '',
                   'f_del_flg' => '',
                   'f_reg_account' => '',
                   'f_reg_time' => '',
                   'f_upd_account' => '',
                   'f_upd_time' => '',

                );

        $this->field_null   = array(
                   'f_customer_id' => 'NO',
                   'f_name' => 'NO',
                   'f_dob' => 'NO',
                   'f_age' => 'NO',
                   'f_gender' => 'NO',
                   'f_blood_group' => 'NO',
                   'f_hobbies' => 'NO',
                   'f_remarks' => 'NO',
                   'f_del_flg' => 'NO',
                   'f_reg_account' => 'NO',
                   'f_reg_time' => 'NO',
                   'f_upd_account' => 'NO',
                   'f_upd_time' => 'NO',

                );

        $this->field_comment= array(
                   'f_customer_id' => '',
                   'f_name' => '',
                   'f_dob' => '',
                   'f_age' => '',
                   'f_gender' => '',
                   'f_blood_group' => '',
                   'f_hobbies' => '',
                   'f_remarks' => '',
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
