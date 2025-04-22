<?php
/**
 * t_salaryテーブル定義クラス
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan
 * @version    1.1.1
 * @create date 2023/12/6
 */

class   TSalaryBasicsObject
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
    function TSalaryBasicsObject() {
        $this->table_name   = 't_salary';
        $this->table_comment= '';

        $this->field_name   = array(
                   'f_salary_id',
                   'f_employee_id',
                   'f_salary_month',
                   'f_basic_salary',
                   'f_hra',
                   'f_medical',
                   'f_conveyance',
                   'f_other_earnings',
                   'f_total_earnings',
                   'f_pf',
                   'f_tax',
                   'f_advance',
                   'f_loan',
                   'f_other_deduction',
                   'f_total_deduction',
                   'f_net_payable',
                   'f_no_of_working_days',
                   'f_no_of_present_days',
                   'f_leave_allowed',
                   'f_leave_taken',
                   'f_leave_balance',
                   'f_del_flg',
                   'f_reg_account',
                   'f_reg_time',
                   'f_upd_account',
                   'f_upd_time',

                );

        $this->field_type   = array(
                   'f_salary_id' => 'int',
                   'f_employee_id' => 'int',
                   'f_salary_month' => 'varchar',
                   'f_basic_salary' => 'int',
                   'f_hra' => 'int',
                   'f_medical' => 'int',
                   'f_conveyance' => 'int',
                   'f_other_earnings' => 'int',
                   'f_total_earnings' => 'int',
                   'f_pf' => 'int',
                   'f_tax' => 'int',
                   'f_advance' => 'int',
                   'f_loan' => 'int',
                   'f_other_deduction' => 'int',
                   'f_total_deduction' => 'int',
                   'f_net_payable' => 'int',
                   'f_no_of_working_days' => 'int',
                   'f_no_of_present_days' => 'int',
                   'f_leave_allowed' => 'int',
                   'f_leave_taken' => 'int',
                   'f_leave_balance' => 'int',
                   'f_del_flg' => 'char',
                   'f_reg_account' => 'varchar',
                   'f_reg_time' => 'datetime',
                   'f_upd_account' => 'varchar',
                   'f_upd_time' => 'datetime',

                );

        $this->field_type_size  = array(
                   'f_salary_id' => '8',
                   'f_employee_id' => '8',
                   'f_salary_month' => '20',
                   'f_basic_salary' => '20',
                   'f_hra' => '20',
                   'f_medical' => '20',
                   'f_conveyance' => '20',
                   'f_other_earnings' => '20',
                   'f_total_earnings' => '20',
                   'f_pf' => '20',
                   'f_tax' => '20',
                   'f_advance' => '20',
                   'f_loan' => '20',
                   'f_other_deduction' => '20',
                   'f_total_deduction' => '20',
                   'f_net_payable' => '20',
                   'f_no_of_working_days' => '20',
                   'f_no_of_present_days' => '20',
                   'f_leave_allowed' => '8',
                   'f_leave_taken' => '8',
                   'f_leave_balance' => '8',
                   'f_del_flg' => '1',
                   'f_reg_account' => '10',
                   'f_reg_time' => 'datetime',
                   'f_upd_account' => '10',
                   'f_upd_time' => 'datetime',

                );

        $this->field_type_key   = array(
                   'f_salary_id' => 'PRI',
                   'f_employee_id' => '',
                   'f_salary_month' => '',
                   'f_basic_salary' => '',
                   'f_hra' => '',
                   'f_medical' => '',
                   'f_conveyance' => '',
                   'f_other_earnings' => '',
                   'f_total_earnings' => '',
                   'f_pf' => '',
                   'f_tax' => '',
                   'f_advance' => '',
                   'f_loan' => '',
                   'f_other_deduction' => '',
                   'f_total_deduction' => '',
                   'f_net_payable' => '',
                   'f_no_of_working_days' => '',
                   'f_no_of_present_days' => '',
                   'f_leave_allowed' => '',
                   'f_leave_taken' => '',
                   'f_leave_balance' => '',
                   'f_del_flg' => '',
                   'f_reg_account' => '',
                   'f_reg_time' => '',
                   'f_upd_account' => '',
                   'f_upd_time' => '',

                );

        $this->field_null   = array(
                   'f_salary_id' => 'NO',
                   'f_employee_id' => 'NO',
                   'f_salary_month' => 'YES',
                   'f_basic_salary' => 'YES',
                   'f_hra' => 'YES',
                   'f_medical' => 'YES',
                   'f_conveyance' => 'YES',
                   'f_other_earnings' => 'YES',
                   'f_total_earnings' => 'YES',
                   'f_pf' => 'YES',
                   'f_tax' => 'YES',
                   'f_advance' => 'YES',
                   'f_loan' => 'YES',
                   'f_other_deduction' => 'YES',
                   'f_total_deduction' => 'YES',
                   'f_net_payable' => 'YES',
                   'f_no_of_working_days' => 'YES',
                   'f_no_of_present_days' => 'YES',
                   'f_leave_allowed' => 'YES',
                   'f_leave_taken' => 'YES',
                   'f_leave_balance' => 'YES',
                   'f_del_flg' => 'NO',
                   'f_reg_account' => 'YES',
                   'f_reg_time' => 'YES',
                   'f_upd_account' => 'YES',
                   'f_upd_time' => 'YES',

                );

        $this->field_comment= array(
                   'f_salary_id' => 'salary id',
                   'f_employee_id' => 'employee id',
                   'f_salary_month' => 'salary month',
                   'f_basic_salary' => 'basic salary',
                   'f_hra' => 'hra',
                   'f_medical' => 'medical',
                   'f_conveyance' => 'conveyance',
                   'f_other_earnings' => 'other earnings',
                   'f_total_earnings' => 'total earnings',
                   'f_pf' => 'pf',
                   'f_tax' => 'tax',
                   'f_advance' => 'advance',
                   'f_loan' => 'loan',
                   'f_other_deduction' => 'other deduction',
                   'f_total_deduction' => 'total deduction',
                   'f_net_payable' => 'net payable',
                   'f_no_of_working_days' => 'working days',
                   'f_no_of_present_days' => 'present days',
                   'f_leave_allowed' => 'leave allowed',
                   'f_leave_taken' => 'leave taken',
                   'f_leave_balance' => 'leave balance',
                   'f_del_flg' => 'Delete flag',
                   'f_reg_account' => 'Registrant',
                   'f_reg_time' => 'Registration date',
                   'f_upd_account' => 'Updated by',
                   'f_upd_time' => 'Update date',

                );

    }
    //--------------------------------------------------------------------------
}
//------------------------------------------------------------------------------

?>
