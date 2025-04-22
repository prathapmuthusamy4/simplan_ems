<?php
/**
 * t_filesテーブル定義クラス
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan
 * @version    1.1.1
 * @create date 2019/11/4
 */

class   TFilesBasicsObject
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
    function TFilesBasicsObject() {
        $this->table_name   = 't_files';
        $this->table_comment= 'Files Table';

        $this->field_name   = array(
                   'f_files_id',
                   'f_name',
                   'f_mail',
                   'f_title',
                   'f_filename',
                   'f_file',
                   'f_del_flg',
                   'f_reg_account',
                   'f_reg_time',
                   'f_upd_account',
                   'f_upd_time',

                );

        $this->field_type   = array(
                   'f_files_id' => 'int',
                   'f_name' => 'varchar',
                   'f_mail' => 'varchar',
                   'f_title' => 'varchar',
                   'f_filename' => 'varchar',
                   'f_file' => 'varchar',
                   'f_del_flg' => 'char',
                   'f_reg_account' => 'int',
                   'f_reg_time' => 'datetime',
                   'f_upd_account' => 'int',
                   'f_upd_time' => 'datetime',

                );

        $this->field_type_size  = array(
                   'f_files_id' => '8',
                   'f_name' => '64',
                   'f_mail' => '50',
                   'f_title' => '64',
                   'f_filename' => '200',
                   'f_file' => '64',
                   'f_del_flg' => '1',
                   'f_reg_account' => '8',
                   'f_reg_time' => 'datetime',
                   'f_upd_account' => '8',
                   'f_upd_time' => 'datetime',

                );

        $this->field_type_key   = array(
                   'f_files_id' => 'PRI',
                   'f_name' => '',
                   'f_mail' => '',
                   'f_title' => '',
                   'f_filename' => '',
                   'f_file' => '',
                   'f_del_flg' => '',
                   'f_reg_account' => '',
                   'f_reg_time' => '',
                   'f_upd_account' => '',
                   'f_upd_time' => '',

                );

        $this->field_null   = array(
                   'f_files_id' => 'NO',
                   'f_name' => 'YES',
                   'f_mail' => 'YES',
                   'f_title' => 'YES',
                   'f_filename' => 'YES',
                   'f_file' => 'YES',
                   'f_del_flg' => 'NO',
                   'f_reg_account' => 'YES',
                   'f_reg_time' => 'YES',
                   'f_upd_account' => 'YES',
                   'f_upd_time' => 'YES',

                );

        $this->field_comment= array(
                   'f_files_id' => 'FilesID',
                   'f_name' => 'なめえ',
                   'f_mail' => 'メール',
                   'f_title' => 'Title',
                   'f_filename' => '',
                   'f_file' => 'File',
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
