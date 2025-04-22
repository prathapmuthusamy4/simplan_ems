<?php
/**
 * t_normal_newテーブル定義クラス
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan
 * @version    1.1.1
 * @create date 2019/11/2
 */

class   TNormalNewBasicsObject
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
    function TNormalNewBasicsObject() {
        $this->table_name   = 't_normal_new';
        $this->table_comment= 'Normal Table';

        $this->field_name   = array(
                   'f_normal_id',
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
                   'f_normal_id' => 'int',
                   'f_name' => 'varchar',
                   'f_dob' => 'date',
                   'f_age' => 'int',
                   'f_gender' => 'char',
                   'f_blood_group' => 'int',
                   'f_hobbies' => 'varchar',
                   'f_remarks' => 'varchar',
                   'f_del_flg' => 'char',
                   'f_reg_account' => 'int',
                   'f_reg_time' => 'datetime',
                   'f_upd_account' => 'int',
                   'f_upd_time' => 'datetime',

                );

        $this->field_type_size  = array(
                   'f_normal_id' => '8',
                   'f_name' => '64',
                   'f_dob' => 'date',
                   'f_age' => '8',
                   'f_gender' => '1',
                   'f_blood_group' => '10',
                   'f_hobbies' => '64',
                   'f_remarks' => '55',
                   'f_del_flg' => '1',
                   'f_reg_account' => '8',
                   'f_reg_time' => 'datetime',
                   'f_upd_account' => '8',
                   'f_upd_time' => 'datetime',

                );

        $this->field_type_key   = array(
                   'f_normal_id' => 'PRI',
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
                   'f_normal_id' => 'NO',
                   'f_name' => 'YES',
                   'f_dob' => 'YES',
                   'f_age' => 'YES',
                   'f_gender' => 'YES',
                   'f_blood_group' => 'YES',
                   'f_hobbies' => 'YES',
                   'f_remarks' => 'YES',
                   'f_del_flg' => 'NO',
                   'f_reg_account' => 'YES',
                   'f_reg_time' => 'YES',
                   'f_upd_account' => 'YES',
                   'f_upd_time' => 'YES',

                );

        $this->field_comment= array(
                   'f_normal_id' => 'NormalID',
                   'f_name' => '名前',
                   'f_dob' => 'DOB',
                   'f_age' => 'Age',
                   'f_gender' => 'Gender',
                   'f_blood_group' => 'Blood Group',
                   'f_hobbies' => 'Hobbies',
                   'f_remarks' => 'remark',
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
