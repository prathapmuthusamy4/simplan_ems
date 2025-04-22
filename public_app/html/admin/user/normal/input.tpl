{literal}
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
<link type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css" rel="stylesheet" />
<script type="text/javascript">
$(document).ready(function(){
  $("#f_dob").datepicker({
    onSelect: function(value, ui) {
        var today = new Date(), 
            age = today.getFullYear() - ui.selectedYear;
        $("#f_age").val(age);
    },
    changeYear: true,
    changeMonth: true,
    yearRange: "-100:+0",
  });
});
</script>
<style>
  .ui-datepicker select.ui-datepicker-month,
  .ui-datepicker select.ui-datepicker-year {width: 45%;}
</style>
{/literal}
<h3>>>>&nbsp;{$param.title|escape} Info</h3>
<table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Name</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_name" type="text" class="formstb_m" value="{$param.f_name}" />
            {$param.errmsg.f_name|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Date of Birth</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input id="f_dob" name="f_dob" type="text" class="formstb_s" value="{$param.f_dob}" />
            {$param.errmsg.f_dob|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Age</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input id="f_age" name="f_age" type="text" class="formstb_ss" value="{$param.f_age}" />
            {$param.errmsg.f_age|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Gender</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {radio_option list=$param.disp_gender name="f_gender" value=$param.f_gender|escape}
            {$param.errmsg.f_gender|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Blood Group</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <select name="f_blood_group" id="f_blood_group">
                <option value="">----</option>
                {select_option list=$param.disp_blood value=$param.f_blood_group}
            </select>
            {$param.errmsg.f_blood_group|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Hobbies</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {html_checkboxes name='f_hobbies' options=$param.disp_hobbies selected=$param.f_hobbies separator='&nbsp;'}
            {$param.errmsg.f_hobbies|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Remarks</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <textarea name="f_remarks" cols="100" rows="7" class="formstb_600">{$param.f_remarks}</textarea>
            {$param.errmsg.f_remarks|admin_err}
        </td>
    </tr>
</table>