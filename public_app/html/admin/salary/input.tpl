<script language="JavaScript" src="./js/jquery.js" type="text/JavaScript" charset="UTF-8"></script>
<link type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css" rel="stylesheet" />
{literal}
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
    if ($('input[name=f_emp_status]:checked').val() == 1) {
            $('#f_relive_date').show();
        } else {
            $('#f_relive_date').val("");
            $('#f_relive_date').hide();
        }
    $('input[name=f_emp_status]:radio').click(function () {
        if ($('input[name=f_emp_status]:checked').val() == 1) {
            $('#f_relive_date').show();
        } else {
            $('#f_relive_date').val("");
            $('#f_relive_date').hide();
        }
    });
    if ($('input[name=f_education_ug]:checked').val() == 0) {
        $('#degree_ug').show();
        $('#university_ug').show();
    } else {
        $('#degree_ug').val("");
        $('#university_ug').val("");
        $('#degree_ug').hide();
        $('#university_ug').hide();
    }
    $('input[name=f_education_ug]:radio').click(function () {
        if ($('input[name=f_education_ug]:checked').val() == 0) {
            $('#degree_ug').show();
            $('#university_ug').show();
        } else {
            $('#degree_ug').val("");
            $('#university_ug').val("");  
            $('#degree_ug').hide();
            $('#university_ug').hide();
        }
    });
    if ($('input[name=f_education_pg]:checked').val() == 0) {
        $('#degree_pg').show();
        $('#university_pg').show();
    } else {
        $('#degree_pg').val("");
        $('#university_pg').val("");
        $('#degree_pg').hide();
        $('#university_pg').hide();
    }
    $('input[name=f_education_pg]:radio').click(function () {
        if ($('input[name=f_education_pg]:checked').val() == 0) {
            $('#degree_pg').show();
            $('#university_pg').show();
        } else {
            $('#degree_pg').val("");
            $('#university_pg').val("");
            $('#degree_pg').hide();
            $('#university_pg').hide();
        }
    });
    if ($('input[name=f_language]:checked').val() == 4) {
        $('#others').show();
    } else {
        $('#others').val("");
        $('#others').hide();
    }
    $("[id$='language'][type='checkbox']:checkbox").click(function () {
        if ($(this).val() == 4) {
            if ($(this).prop('checked')==true){ 
                $('#others').show();
            } else {
                $('#others').val("");
                $('#others').hide();
            }
        }
    });
    $( "#f_salary_month" ).datepicker({
        changeMonth:true,
        changeYear:true,
        yearRange:"-4:+4",
        dateFormat:"yy/mm/dd"
    });
    $( "#f_expiry_date" ).datepicker({
        changeMonth:true,
        changeYear:true,
        yearRange:"-0:+15",
        dateFormat:"yy/mm/dd"
    });
    $( "#f_issue_date" ).datepicker({
        changeMonth:true,
        changeYear:true,
        yearRange:"-15:+15",
        dateFormat:"yy/mm/dd"
    });
    $( "#f_join_date" ).datepicker({
        changeMonth:true,
        changeYear:true,
        yearRange:"-60:+0",
        dateFormat:"yy/mm/dd"
    });
    $( "#f_date" ).datepicker({
        changeMonth:true,
        changeYear:true,
        yearRange:"-60:+0",
        dateFormat:"yy/mm/dd"
    });
    });


    function findHra() {
        let num1 = Number(document.querySelector("#qty1").value);
        // var tot = 0;
        console.log(num1);
        // for (var i = 0; i < arr.length; i++) {
        //     if (parseInt(arr[i].value))
        //     tot += parseInt(arr[i].value);
        // }

        // let sum1 = (num1/100)*40;
        let sum1 = (num1)*40/100;

        // const percentage = (numX / numY) * 40/100;

        document.getElementById('#qty2').value = sum1;
    }

    function findTotal() {
        let working_days = Number(document.querySelector("#working_days").value);
        let present_days = Number(document.querySelector("#present_days").value);
        if ((working_days == "") || (present_days == "")) {
            alert ("please enter the working days or present days");
        }

        let num1 = Number(document.querySelector("#qty1").value);
        let hra = (num1)*40/100;
        document.getElementById("qty2").value = hra;
        let num2 = Number(document.querySelector("#qty2").value);
        let medical = Math.round((1250/working_days)*present_days);
        document.getElementById("qty3").value = medical;
        let num3 = Number(document.querySelector("#qty3").value);
        let num4 = Number(document.querySelector("#qty4").value);
        let num5 = Number(document.querySelector("#qty5").value);

        let num6 = Number(document.querySelector("#qty6").value);
        let num7 = Number(document.querySelector("#qty7").value);
        let num8 = Number(document.querySelector("#qty8").value);
        let num9 = Number(document.querySelector("#qty9").value);
        let num10 = Number(document.querySelector("#qty10").value);

        let sum1 = num1 + num2 + num3 + num4 + num5;
        let sum2 = num6 + num7 + num8 + num9 + num10;

        // document.getElementById("total1").value = sum1;
        $('#total1').val(sum1);
        document.getElementById("total2").value = sum2;
        let sum3 = sum1 - sum2;
        document.getElementById("total3").value = sum3;
    }



</script>
{/literal}
    <li>
        <h3>&nbsp;SEARCH</h3>
        <table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
        <tr valign="top" bgcolor="#FFFFFF" height="25">
            <td width="20%" valign="middle"><h4>Salary Month</h4></td>
            <td width="80%" valign="middle" bgcolor="#F5F5F5">
                <input name="salary_month_search" id="salary_month_search" type="text" class="formstb_s" value="{$param.salary_month_search}" />
                {$param.errmsg.salary_month_search|admin_err}
            </td>
        </tr>
        </table>
        <div id="pt">
        <!-- <input type="button" class="formbtn" onClick="return submitfrm('salary.php', 'list', 'search');" value="search"/> -->
        <input type="button" class="formbtn" onClick="return selectfrm('salary.php', 'new', 'search', '{$param.f_employee_id|escape}');" value="search"/>

        </div>
  </li>

<h3>EMPLOYEE DETAILS</h3>
<table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Salary Month</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_salary_month" id="f_salary_month" type="text" class="formstb_s" value="{$param.f_salary_month}" />
            {$param.errmsg.f_salary_month|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Employee ID</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.f_emp_id|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Name</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.f_name|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Designation</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.f_job_title|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Department</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.f_category|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Bank Name</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.f_bank_name|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Account No.</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.f_acc_no|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Date of Joining</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.f_join_date|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Location</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.f_location|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">No of Working Days</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_no_of_working_days" id="working_days" type="text" class="formstb_m" value="{$param.f_no_of_working_days}" />
            {$param.errmsg.f_no_of_working_days|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">No of Days Present</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_no_of_present_days"  id= "present_days" type="text" class="formstb_m" value="{$param.f_no_of_present_days}" />
            {$param.errmsg.f_no_of_present_days|admin_err}
        </td>
    </tr>
</table>

<h3>EARNINGS</h3>
<table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Basic Salary</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input onchange="findTotal()" id="qty1" name="f_basic_salary" type="text" class="formstb_m" value="{$param.f_basic_salary}" />
            {$param.errmsg.f_basic_salary|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">HRA</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input onchange="findTotal()"  id="qty2" name="f_hra" type="text" class="formstb_m" value="{$param.f_hra}" />
            {$param.errmsg.f_hra|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Medical</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input onchange="findTotal()" id="qty3" name="f_medical" type="text" class="formstb_m" value="{$param.f_medical}" />
            {$param.errmsg.f_medical|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Conveyance</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input onchange="findTotal()" id="qty4" name="f_conveyance" type="text" class="formstb_m" value="{$param.f_conveyance}" />
            {$param.errmsg.f_conveyance|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Other Earnings</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input onchange="findTotal()" id="qty5" name="f_other_earnings" type="text" class="formstb_m" value="{$param.f_other_earnings}" />
            {$param.errmsg.f_other_earnings|admin_err}
        </td>
    </tr>

    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Total Earnings</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input id="total1" name="f_total_earnings" type="text" class="formstb_m" value="{$param.f_total_earnings}" />
            {$param.errmsg.f_total_earnings|admin_err}
        </td>
    </tr>
</table>

<h3>DEDUCTIONS</h3>
<table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">PF</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input onblur="findTotal()" id="qty6" name="f_pf" type="text" class="formstb_m" value="{$param.f_pf}" />
            {$param.errmsg.f_pf|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">TAX</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input onblur="findTotal()" id="qty7" name="f_tax" type="text" class="formstb_m" value="{$param.f_tax}" />
            {$param.errmsg.f_tax|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Advance</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input onblur="findTotal()" id="qty8" name="f_advance" type="text" class="formstb_m" value="{$param.f_advance}" />
            {$param.errmsg.f_advance|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Loan</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input onblur="findTotal()" id="qty9" name="f_loan" type="text" class="formstb_m" value="{$param.f_loan}" />
            {$param.errmsg.f_loan|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Other Deductions</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input onblur="findTotal()" id="qty10" name="f_other_deduction" type="text" class="formstb_m" value="{$param.f_other_deduction}" />
            {$param.errmsg.f_other_deduction|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Total Deductions</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input  id="total2" name="f_total_deduction" type="text" class="formstb_m" value="{$param.f_total_deduction}" />
            {$param.errmsg.f_total_deduction|admin_err}
        </td>
    </tr>
</table>

<table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Net Payable</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input id="total3" name="f_net_payable" type="text" class="formstb_m" value="{$param.f_net_payable}" />
            {$param.errmsg.f_net_payable|admin_err}
        </td>
    </tr>
</table>

<h3>CALCULATION OF LEAVE (CL)</h3>
<table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Leave Allowed</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_leave_allowed" type="text" class="formstb_m" value="{$param.f_leave_allowed}" />
            {$param.errmsg.f_leave_allowed|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Leave Taken</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_leave_taken" type="text" class="formstb_m" value="{$param.f_leave_taken}" />
            {$param.errmsg.f_leave_taken|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Balance Leave</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_leave_balance" type="text" class="formstb_m" value="{$param.f_leave_balance}" />
            {$param.errmsg.f_leave_balance|admin_err}
        </td>
    </tr>
</table>
