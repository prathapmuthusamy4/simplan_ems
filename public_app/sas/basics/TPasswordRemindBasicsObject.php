<?php
/**
 * t_password_remindテーブル定義クラス
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan
 * @version    1.1.1
 * @create date 2019/11/2
 */

class   TPasswordRemindBasicsObject
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
    function TPasswordRemindBasicsObject() {
        $this->table_name   = 't_password_remind';
        $this->table_comment= 'パスワードリマインダーテーブル';

        $this->field_name   = array(
                   'f_remind_id',
                   'f_user_id',
                   'f_ref_key',
                   'f_valid_date',
                   'f_del_flg',
                   'f_reg_account',
                   'f_reg_time',
                   'f_upd_account',
                   'f_upd_time',

                );

        $this->field_type   = array(
                   'f_remind_id' => 'int',
                   'f_user_id' => 'int',
                   'f_ref_key' => 'varchar',
                   'f_valid_date' => 'datetime',
                   'f_del_flg' => 'char',
                   'f_reg_account' => 'int',
                   'f_reg_time' => 'datetime',
                   'f_upd_account' => 'int',
                   'f_upd_time' => 'datetime',

                );

        $this->field_type_size  = array(
                   'f_remind_id' => '8',
                   'f_user_id' => '8',
                   'f_ref_key' => '100',
                   'f_valid_date' => 'datetime',
                   'f_del_flg' => '1',
                   'f_reg_account' => '8',
                   'f_reg_time' => 'datetime',
                   'f_upd_account' => '8',
                   'f_upd_time' => 'datetime',

                );

        $this->field_type_key   = array(
                   'f_remind_id' => 'PRI',
                   'f_user_id' => '',
                   'f_ref_key' => '',
                   'f_valid_date' => '',
                   'f_del_flg' => '',
                   'f_reg_account' => '',
                   'f_reg_time' => '',
                   'f_upd_account' => '',
                   'f_upd_time' => '',

                );

        $this->field_null   = array(
                   'f_remind_id' => 'NO',
                   'f_user_id' => 'YES',
                   'f_ref_key' => 'NO',
                   'f_valid_date' => 'YES',
                   'f_del_flg' => 'NO',
                   'f_reg_account' => 'YES',
                   'f_reg_time' => 'YES',
                   'f_upd_account' => 'YES',
                   'f_upd_time' => 'YES',

                );

        $this->field_comment= array(
                   'f_remind_id' => 'リマインダーID',
                   'f_user_id' => 'ユーザーID',
                   'f_ref_key' => 'キー',
                   'f_valid_date' => '有効時間',
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
