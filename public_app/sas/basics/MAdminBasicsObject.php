<?php
/**
 * m_adminテーブル定義クラス
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan
 * @version    1.1.1
 * @create date 2023/7/4
 */

class   MAdminBasicsObject
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
    function MAdminBasicsObject() {
        $this->table_name   = 'm_admin';
        $this->table_comment= '管理者マスタ';

        $this->field_name   = array(
                   'f_admin_id',
                   'f_name',
                   'f_mailaddress',
                   'f_id',
                   'f_password',
                   'f_admin_kbn',
                   'f_auth',
                   'f_auth_value',
                   'f_del_flg',
                   'f_start_date',
                   'f_end_date',
                   'f_last_send_date',
                   'f_next_send_date',
                   'f_reg_account',
                   'f_reg_time',
                   'f_upd_account',
                   'f_upd_time',

                );

        $this->field_type   = array(
                   'f_admin_id' => 'int',
                   'f_name' => 'varchar',
                   'f_mailaddress' => 'varchar',
                   'f_id' => 'varchar',
                   'f_password' => 'varchar',
                   'f_admin_kbn' => 'char',
                   'f_auth' => 'int',
                   'f_auth_value' => 'varchar',
                   'f_del_flg' => 'char',
                   'f_start_date' => 'date',
                   'f_end_date' => 'date',
                   'f_last_send_date' => 'date',
                   'f_next_send_date' => 'date',
                   'f_reg_account' => 'int',
                   'f_reg_time' => 'datetime',
                   'f_upd_account' => 'int',
                   'f_upd_time' => 'datetime',

                );

        $this->field_type_size  = array(
                   'f_admin_id' => '8',
                   'f_name' => '100',
                   'f_mailaddress' => '255',
                   'f_id' => '20',
                   'f_password' => '500',
                   'f_admin_kbn' => '1',
                   'f_auth' => '4',
                   'f_auth_value' => '100',
                   'f_del_flg' => '1',
                   'f_start_date' => 'date',
                   'f_end_date' => 'date',
                   'f_last_send_date' => 'date',
                   'f_next_send_date' => 'date',
                   'f_reg_account' => '8',
                   'f_reg_time' => 'datetime',
                   'f_upd_account' => '8',
                   'f_upd_time' => 'datetime',

                );

        $this->field_type_key   = array(
                   'f_admin_id' => 'PRI',
                   'f_name' => '',
                   'f_mailaddress' => '',
                   'f_id' => '',
                   'f_password' => '',
                   'f_admin_kbn' => '',
                   'f_auth' => '',
                   'f_auth_value' => '',
                   'f_del_flg' => '',
                   'f_start_date' => '',
                   'f_end_date' => '',
                   'f_last_send_date' => '',
                   'f_next_send_date' => '',
                   'f_reg_account' => '',
                   'f_reg_time' => '',
                   'f_upd_account' => '',
                   'f_upd_time' => '',

                );

        $this->field_null   = array(
                   'f_admin_id' => 'NO',
                   'f_name' => 'YES',
                   'f_mailaddress' => 'YES',
                   'f_id' => 'YES',
                   'f_password' => 'YES',
                   'f_admin_kbn' => 'YES',
                   'f_auth' => 'YES',
                   'f_auth_value' => 'YES',
                   'f_del_flg' => 'NO',
                   'f_start_date' => 'YES',
                   'f_end_date' => 'YES',
                   'f_last_send_date' => 'YES',
                   'f_next_send_date' => 'YES',
                   'f_reg_account' => 'YES',
                   'f_reg_time' => 'YES',
                   'f_upd_account' => 'YES',
                   'f_upd_time' => 'YES',

                );

        $this->field_comment= array(
                   'f_admin_id' => '管理者ID',
                   'f_name' => 'Name',
                   'f_mailaddress' => 'メールアドレス',
                   'f_id' => 'ID',
                   'f_password' => 'パスワード',
                   'f_admin_kbn' => '管理者区分',
                   'f_auth' => '権限',
                   'f_auth_value' => '権限値',
                   'f_del_flg' => '削除フラグ',
                   'f_start_date' => '開始日',
                   'f_end_date' => '終了日',
                   'f_last_send_date' => '最近送信日',
                   'f_next_send_date' => '次に送信日',
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
