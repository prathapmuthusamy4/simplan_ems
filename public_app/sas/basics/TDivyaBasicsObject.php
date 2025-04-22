<?php
/**
 * t_divyaテーブル定義クラス
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan
 * @version    1.1.1
 * @create date 2020/2/5
 */

class   TDivyaBasicsObject
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
    function TDivyaBasicsObject() {
        $this->table_name   = 't_divya';
        $this->table_comment= '';

        $this->field_name   = array(
                   'f_divya_id',
                   'f_reg_no',
                   'f_name',
                   'f_dob',
                   'f_age',
                   'f_gender',
                   'f_graduate',
                   'f_mark',
                   'f_blood_group',
                   'f_priya_id',
                   'f_hobbies',
                   'f_remarks',
                   'f_image1',
                   'f_image2',
                   'f_image3',
                   'f_del_flg',
                   'f_reg_account',
                   'f_reg_time',
                   'f_upd_account',
                   'f_upd_time',

                );

        $this->field_type   = array(
                   'f_divya_id' => 'int',
                   'f_reg_no' => 'int',
                   'f_name' => 'varchar',
                   'f_dob' => 'date',
                   'f_age' => 'int',
                   'f_gender' => 'char',
                   'f_graduate' => 'varchar',
                   'f_mark' => 'varchar',
                   'f_blood_group' => 'int',
                   'f_priya_id' => 'int',
                   'f_hobbies' => 'varchar',
                   'f_remarks' => 'text',
                   'f_image1' => 'varchar',
                   'f_image2' => 'varchar',
                   'f_image3' => 'varchar',
                   'f_del_flg' => 'char',
                   'f_reg_account' => 'int',
                   'f_reg_time' => 'datetime',
                   'f_upd_account' => 'int',
                   'f_upd_time' => 'datetime',

                );

        $this->field_type_size  = array(
                   'f_divya_id' => '8',
                   'f_reg_no' => '8',
                   'f_name' => '255',
                   'f_dob' => 'date',
                   'f_age' => '8',
                   'f_gender' => '1',
                   'f_graduate' => '20',
                   'f_mark' => '20',
                   'f_blood_group' => '10',
                   'f_priya_id' => '255',
                   'f_hobbies' => '255',
                   'f_remarks' => 'text',
                   'f_image1' => '64',
                   'f_image2' => '64',
                   'f_image3' => '64',
                   'f_del_flg' => '1',
                   'f_reg_account' => '8',
                   'f_reg_time' => 'datetime',
                   'f_upd_account' => '8',
                   'f_upd_time' => 'datetime',

                );

        $this->field_type_key   = array(
                   'f_divya_id' => 'PRI',
                   'f_reg_no' => '',
                   'f_name' => '',
                   'f_dob' => '',
                   'f_age' => '',
                   'f_gender' => '',
                   'f_graduate' => '',
                   'f_mark' => '',
                   'f_blood_group' => '',
                   'f_priya_id' => '',
                   'f_hobbies' => '',
                   'f_remarks' => '',
                   'f_image1' => '',
                   'f_image2' => '',
                   'f_image3' => '',
                   'f_del_flg' => '',
                   'f_reg_account' => '',
                   'f_reg_time' => '',
                   'f_upd_account' => '',
                   'f_upd_time' => '',

                );

        $this->field_null   = array(
                   'f_divya_id' => 'NO',
                   'f_reg_no' => 'NO',
                   'f_name' => 'NO',
                   'f_dob' => 'NO',
                   'f_age' => 'NO',
                   'f_gender' => 'NO',
                   'f_graduate' => 'NO',
                   'f_mark' => 'NO',
                   'f_blood_group' => 'NO',
                   'f_priya_id' => 'NO',
                   'f_hobbies' => 'NO',
                   'f_remarks' => 'NO',
                   'f_image1' => 'NO',
                   'f_image2' => 'NO',
                   'f_image3' => 'NO',
                   'f_del_flg' => 'NO',
                   'f_reg_account' => 'NO',
                   'f_reg_time' => 'NO',
                   'f_upd_account' => 'NO',
                   'f_upd_time' => 'NO',

                );

        $this->field_comment= array(
                   'f_divya_id' => '',
                   'f_reg_no' => '',
                   'f_name' => '',
                   'f_dob' => '',
                   'f_age' => '',
                   'f_gender' => '',
                   'f_graduate' => '',
                   'f_mark' => '',
                   'f_blood_group' => '',
                   'f_priya_id' => '',
                   'f_hobbies' => '',
                   'f_remarks' => '',
                   'f_image1' => '',
                   'f_image2' => '',
                   'f_image3' => '',
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
