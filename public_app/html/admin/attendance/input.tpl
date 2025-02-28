{literal}
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
<link type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css" rel="stylesheet" />
<script type="text/javascript">
$(document).ready(function(){
    if ($('input[name=f_leave_type]:checked').val() == 4) {
                $('#reason').show();
            } else {
                $('#reason').val("");
                $('#reason').hide();
            }
        $('input[name=f_leave_type]:radio').click(function () {
            if ($('input[name=f_leave_type]:checked').val() == 4) {
                $('#reason').show();
            } else {
                $('#reason').val("");
                $('#reason').hide();
            }
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
<h3>>>>&nbsp;{$param.title|escape}Info</h3>
<table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Name</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <select name="f_name" id="f_name">
                <option value="">----</option>
                {select_option list=$param.disp_name value=$param.f_name}
            </select>
            {$param.errmsg.f_name|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Leave Type</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {radio_option list=$param.disp_leave_kbn name="f_leave_type" value=$param.f_leave_type|escape}
            {$param.errmsg.f_leave_type|admin_err}
            <input id="reason" name="f_leave_reason" type="text" class="formstb" value="{$param.f_leave_reason}" />
            {$param.errmsg.f_leave_reason|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Date</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input id="f_date22" name="f_date" type="label" class="formstb_s" value="{$param.f_date}" readonly/>
            {$param.errmsg.f_date|admin_err}
        </td>
    </tr>
</table>
