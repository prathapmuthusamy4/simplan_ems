<?php
/**
 * t_companyテーブル定義クラス
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan
 * @version    1.1.1
 * @create date 2019/11/5
 */

class   TCompanyBasicsObject
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
    function TCompanyBasicsObject() {
        $this->table_name   = 't_company';
        $this->table_comment= 'Files Table';

        $this->field_name   = array(
                   'f_company_id',
                   'f_name',
                   'f_size',
                   'f_color',
                   'f_price',
                   'f_del_flg',
                   'f_reg_account',
                   'f_reg_time',
                   'f_upd_account',
                   'f_upd_time',

                );

        $this->field_type   = array(
                   'f_company_id' => 'int',
                   'f_name' => 'varchar',
                   'f_size' => 'varchar',
                   'f_color' => 'varchar',
                   'f_price' => 'varchar',
                   'f_del_flg' => 'char',
                   'f_reg_account' => 'int',
                   'f_reg_time' => 'datetime',
                   'f_upd_account' => 'int',
                   'f_upd_time' => 'datetime',

                );

        $this->field_type_size  = array(
                   'f_company_id' => '8',
                   'f_name' => '64',
                   'f_size' => '50',
                   'f_color' => '64',
                   'f_price' => '50',
                   'f_del_flg' => '1',
                   'f_reg_account' => '8',
                   'f_reg_time' => 'datetime',
                   'f_upd_account' => '8',
                   'f_upd_time' => 'datetime',

                );

        $this->field_type_key   = array(
                   'f_company_id' => 'PRI',
                   'f_name' => '',
                   'f_size' => '',
                   'f_color' => '',
                   'f_price' => '',
                   'f_del_flg' => '',
                   'f_reg_account' => '',
                   'f_reg_time' => '',
                   'f_upd_account' => '',
                   'f_upd_time' => '',

                );

        $this->field_null   = array(
                   'f_company_id' => 'NO',
                   'f_name' => 'YES',
                   'f_size' => 'YES',
                   'f_color' => 'YES',
                   'f_price' => 'YES',
                   'f_del_flg' => 'NO',
                   'f_reg_account' => 'YES',
                   'f_reg_time' => 'YES',
                   'f_upd_account' => 'YES',
                   'f_upd_time' => 'YES',

                );

        $this->field_comment= array(
                   'f_company_id' => 'FilesID',
                   'f_name' => 'name',
                   'f_size' => 'Size',
                   'f_color' => 'color',
                   'f_price' => '',
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
