<?php
/**
 * m_userテーブル定義クラス
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan
 * @version    1.1.1
 * @create date 2023/9/2
 */

class   MUserBasicsObject
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
    function MUserBasicsObject() {
        $this->table_name   = 'm_user';
        $this->table_comment= 'ユーザーマスタ';

        $this->field_name   = array(
                   'f_user_id',
                   'f_name',
                   'f_firstname',
                   'f_surname_kana',
                   'f_firstname_kana',
                   'f_mailaddress',
                   'f_login_id',
                   'f_password',
                   'f_del_flg',
                   'f_reg_account',
                   'f_reg_time',
                   'f_upd_account',
                   'f_upd_time',

                );

        $this->field_type   = array(
                   'f_user_id' => 'int',
                   'f_name' => 'varchar',
                   'f_firstname' => 'varchar',
                   'f_surname_kana' => 'varchar',
                   'f_firstname_kana' => 'varchar',
                   'f_mailaddress' => 'varchar',
                   'f_login_id' => 'varchar',
                   'f_password' => 'varchar',
                   'f_del_flg' => 'char',
                   'f_reg_account' => 'int',
                   'f_reg_time' => 'datetime',
                   'f_upd_account' => 'int',
                   'f_upd_time' => 'datetime',

                );

        $this->field_type_size  = array(
                   'f_user_id' => '10',
                   'f_name' => '64',
                   'f_firstname' => '50',
                   'f_surname_kana' => '100',
                   'f_firstname_kana' => '100',
                   'f_mailaddress' => '255',
                   'f_login_id' => '20',
                   'f_password' => '500',
                   'f_del_flg' => '1',
                   'f_reg_account' => '8',
                   'f_reg_time' => 'datetime',
                   'f_upd_account' => '8',
                   'f_upd_time' => 'datetime',

                );

        $this->field_type_key   = array(
                   'f_user_id' => 'PRI',
                   'f_name' => '',
                   'f_firstname' => '',
                   'f_surname_kana' => '',
                   'f_firstname_kana' => '',
                   'f_mailaddress' => '',
                   'f_login_id' => '',
                   'f_password' => '',
                   'f_del_flg' => '',
                   'f_reg_account' => '',
                   'f_reg_time' => '',
                   'f_upd_account' => '',
                   'f_upd_time' => '',

                );

        $this->field_null   = array(
                   'f_user_id' => 'NO',
                   'f_name' => 'YES',
                   'f_firstname' => 'YES',
                   'f_surname_kana' => 'YES',
                   'f_firstname_kana' => 'YES',
                   'f_mailaddress' => 'YES',
                   'f_login_id' => 'YES',
                   'f_password' => 'YES',
                   'f_del_flg' => 'NO',
                   'f_reg_account' => 'YES',
                   'f_reg_time' => 'YES',
                   'f_upd_account' => 'YES',
                   'f_upd_time' => 'YES',

                );

        $this->field_comment= array(
                   'f_user_id' => 'ユーザーID',
                   'f_name' => '名前（姓)',
                   'f_firstname' => '名前（名）',
                   'f_surname_kana' => '名前かな（姓)',
                   'f_firstname_kana' => '名前かな（名）',
                   'f_mailaddress' => 'メールアドレス',
                   'f_login_id' => 'ID',
                   'f_password' => 'パスワード',
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
