<?php
/**
 * t_user_attendanceテーブル定義クラス
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan
 * @version    1.1.1
 * @create date 2023/9/5
 */

class   TUserAttendanceBasicsObject
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
    function TUserAttendanceBasicsObject() {
        $this->table_name   = 't_user_attendance';
        $this->table_comment= 'Attendance Table';

        $this->field_name   = array(
                   'f_attendance_id',
                   'f_emp_id',
                   'f_name',
                   'f_date',
                   'f_start_date',
                   'f_end_date',
                   'f_time',
                   'f_status',
                   'f_leave_type',
                   'f_leave_reason',
                   'f_del_flg',
                   'f_reg_account',
                   'f_reg_time',
                   'f_upd_account',
                   'f_upd_time',

                );

        $this->field_type   = array(
                   'f_attendance_id' => 'int',
                   'f_emp_id' => 'varchar',
                   'f_name' => 'varchar',
                   'f_date' => 'date',
                   'f_start_date' => 'date',
                   'f_end_date' => 'date',
                   'f_time' => 'time',
                   'f_status' => 'varchar',
                   'f_leave_type' => 'varchar',
                   'f_leave_reason' => 'varchar',
                   'f_del_flg' => 'char',
                   'f_reg_account' => 'varchar',
                   'f_reg_time' => 'datetime',
                   'f_upd_account' => 'varchar',
                   'f_upd_time' => 'datetime',

                );

        $this->field_type_size  = array(
                   'f_attendance_id' => '8',
                   'f_emp_id' => '100',
                   'f_name' => '100',
                   'f_date' => 'date',
                   'f_start_date' => 'date',
                   'f_end_date' => 'date',
                   'f_time' => 'time',
                   'f_status' => '20',
                   'f_leave_type' => '20',
                   'f_leave_reason' => '200',
                   'f_del_flg' => '1',
                   'f_reg_account' => '8',
                   'f_reg_time' => 'datetime',
                   'f_upd_account' => '8',
                   'f_upd_time' => 'datetime',

                );

        $this->field_type_key   = array(
                   'f_attendance_id' => 'PRI',
                   'f_emp_id' => '',
                   'f_name' => '',
                   'f_date' => '',
                   'f_start_date' => '',
                   'f_end_date' => '',
                   'f_time' => '',
                   'f_status' => '',
                   'f_leave_type' => '',
                   'f_leave_reason' => '',
                   'f_del_flg' => '',
                   'f_reg_account' => '',
                   'f_reg_time' => '',
                   'f_upd_account' => '',
                   'f_upd_time' => '',

                );

        $this->field_null   = array(
                   'f_attendance_id' => 'NO',
                   'f_emp_id' => 'YES',
                   'f_name' => 'YES',
                   'f_date' => 'YES',
                   'f_start_date' => 'YES',
                   'f_end_date' => 'YES',
                   'f_time' => 'YES',
                   'f_status' => 'YES',
                   'f_leave_type' => 'YES',
                   'f_leave_reason' => 'YES',
                   'f_del_flg' => 'NO',
                   'f_reg_account' => 'YES',
                   'f_reg_time' => 'YES',
                   'f_upd_account' => 'YES',
                   'f_upd_time' => 'YES',

                );

        $this->field_comment= array(
                   'f_attendance_id' => 'AttID',
                   'f_emp_id' => 'Employee Id',
                   'f_name' => 'Name',
                   'f_date' => 'attendance date',
                   'f_start_date' => 'Start_Date',
                   'f_end_date' => 'End Date',
                   'f_time' => 'time',
                   'f_status' => 'attendance status',
                   'f_leave_type' => 'leave type',
                   'f_leave_reason' => 'Leave Reason',
                   'f_del_flg' => 'Del flag',
                   'f_reg_account' => 'Reg account',
                   'f_reg_time' => 'Reg time',
                   'f_upd_account' => 'Upd account',
                   'f_upd_time' => 'Upd time',

                );

    }
    //--------------------------------------------------------------------------
}
//------------------------------------------------------------------------------

?>
