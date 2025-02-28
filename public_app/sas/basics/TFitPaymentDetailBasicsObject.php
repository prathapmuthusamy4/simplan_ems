<?php
/**
 * t_fit_payment_detailテーブル定義クラス
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan
 * @version    1.1.1
 * @create date 2020/12/6
 */

class   TFitPaymentDetailBasicsObject
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
    function TFitPaymentDetailBasicsObject() {
        $this->table_name   = 't_fit_payment_detail';
        $this->table_comment= 'FIT納付金詳細テーブル';

        $this->field_name   = array(
                   'f_fit_payment_detail_id',
                   'f_fit_id',
                   'f_supply_date',
                   'f_invoice_id',
                   'f_invoice_no',
                   'f_supply_point_no',
                   'f_amount',
                   'f_renewable_price',
                   'f_del_flg',
                   'f_reg_account',
                   'f_reg_time',
                   'f_upd_account',
                   'f_upd_time',

                );

        $this->field_type   = array(
                   'f_fit_payment_detail_id' => 'int',
                   'f_fit_id' => 'int',
                   'f_supply_date' => 'date',
                   'f_invoice_id' => 'int',
                   'f_invoice_no' => 'varchar',
                   'f_supply_point_no' => 'varchar',
                   'f_amount' => 'varchar',
                   'f_renewable_price' => 'varchar',
                   'f_del_flg' => 'char',
                   'f_reg_account' => 'int',
                   'f_reg_time' => 'datetime',
                   'f_upd_account' => 'int',
                   'f_upd_time' => 'datetime',

                );

        $this->field_type_size  = array(
                   'f_fit_payment_detail_id' => '8',
                   'f_fit_id' => '8',
                   'f_supply_date' => 'date',
                   'f_invoice_id' => '8',
                   'f_invoice_no' => '20',
                   'f_supply_point_no' => '22',
                   'f_amount' => '10',
                   'f_renewable_price' => '20',
                   'f_del_flg' => '1',
                   'f_reg_account' => '8',
                   'f_reg_time' => 'datetime',
                   'f_upd_account' => '8',
                   'f_upd_time' => 'datetime',

                );

        $this->field_type_key   = array(
                   'f_fit_payment_detail_id' => 'PRI',
                   'f_fit_id' => 'MUL',
                   'f_supply_date' => '',
                   'f_invoice_id' => '',
                   'f_invoice_no' => '',
                   'f_supply_point_no' => '',
                   'f_amount' => '',
                   'f_renewable_price' => '',
                   'f_del_flg' => '',
                   'f_reg_account' => '',
                   'f_reg_time' => '',
                   'f_upd_account' => '',
                   'f_upd_time' => '',

                );

        $this->field_null   = array(
                   'f_fit_payment_detail_id' => 'NO',
                   'f_fit_id' => 'YES',
                   'f_supply_date' => 'YES',
                   'f_invoice_id' => 'YES',
                   'f_invoice_no' => 'YES',
                   'f_supply_point_no' => 'YES',
                   'f_amount' => 'YES',
                   'f_renewable_price' => 'YES',
                   'f_del_flg' => 'NO',
                   'f_reg_account' => 'YES',
                   'f_reg_time' => 'YES',
                   'f_upd_account' => 'YES',
                   'f_upd_time' => 'YES',

                );

        $this->field_comment= array(
                   'f_fit_payment_detail_id' => 'FIT納付金詳細ID',
                   'f_fit_id' => 'FITID',
                   'f_supply_date' => '供給年月',
                   'f_invoice_id' => '請求書ID',
                   'f_invoice_no' => '請求書番号',
                   'f_supply_point_no' => '供給地点特定番号',
                   'f_amount' => '数量',
                   'f_renewable_price' => '再生エネルギー賦課金',
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
