{literal}
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
<link type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css" rel="stylesheet" />
<script type="text/javascript">
$(document).ready(function(){
    if ($('input[name=f_status]:checked').val() == 2) {
                $('#reason').show();
            } else {
                $('#reason').hide();
            }
        $('input[name=f_status]:radio').click(function () {
        if ($('input[name=f_status]:checked').val() == 2) {
            $('#reason').show();
        } else {
            $('#reason').hide();
        }
        $('input[name=f_status]:radio').click(function () {
        if ($('input[name=f_status]:checked').val() != 2) {
            $("input[type=radio][name=f_leave_type]").prop('checked', false);
            $("input[type=radio][name=f_leave_reason]").value = "";
            document.getElementById("other_reason").value = "";


        }
        })
    });

    if ($('input[name=f_leave_type]:checked').val() == 4) {
                $('#other_reason').show();
            } else {
                $('#other_reason').hide();
            }
        $('input[name=f_leave_type]:radio').click(function () {
        if ($('input[name=f_leave_type]:checked').val() == 4) {
            $('#other_reason').show();
        } else {
            $('#other_reason').hide();
        }
        $('input[name=f_leave_type]:radio').click(function () {
        if ($('input[name=f_leave_type]:checked').val() != 4) {
            document.getElementById("other_reason").value = "";
        }
        })
    });
});
//datepicker
$(function() {
    $( "#f_date1" ).datepicker({
        changeYear: true,
        changeMonth:true,
    });
});

$(function() {
    // $('#f_date').datepicker({
        $('#f_date1').datepicker();
    $('#f_date1').datepicker('setDate', 'today');
    // });

    $('#f_date').datepicker({
            "setDate": new Date(),
            "autoclose": true,
	        readOnly : true
    });
});

</script>
<style>
  .ui-datepicker select.ui-datepicker-month,
  .ui-datepicker select.ui-datepicker-year {width: 45%;}
</style>
{/literal}
<h3>>>>&nbsp;Regitst</h3>
<table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
    <tr valign="top" bgcolor="#cccccc">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Employee Id</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.f_emp_id|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#cccccc">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Name</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.f_name|escape}
        </td>
    </tr>

    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Date</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.f_date|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Time</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.f_time|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">attendance</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {radio_option list=$param.disp_attendance name="f_status" value=$param.f_status|escape}
            {$param.errmsg.f_status|user_err}
        </td>
    </tr>
    <tr id="reason" valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Leave Type</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {radio_option  list=$param.disp_leave_kbn name="f_leave_type" value=$param.f_leave_type|escape}
            {$param.errmsg.f_leave_type|user_err}
            <input id = "other_reason" name="f_leave_reason" type="text" class="formstb_s" value="{$param.f_leave_reason}" />
            {$param.errmsg.f_leave_reason|user_err}
        </td>
    </tr>
</table>
