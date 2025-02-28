<!-- Confirm -->
<h3>>>>&nbsp;Info</h3>
<table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
  <tr valign="top" bgcolor="#FFFFFF">
    <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Employee Id</span></td>
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
    <td width="20%" valign="middle" class="tdcls1"><span class="cap1">attendance</span></td>
    <td width="80%" valign="middle" class="tdcls2">
      {array_value key=$param.f_status list=$param.disp_attendance|escape}
    </td>
  </tr>
  {if $param.f_status == $smarty.const.USER_ATTENDANCE_ABSENT}
  <tr valign="top" bgcolor="#FFFFFF">
    <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Leave Type</span></td>
    <td width="80%" valign="middle" class="tdcls2">
      {array_value key=$param.f_leave_type list=$param.disp_leave_kbn|escape}
      {if $param.f_leave_type == $smarty.const.ADMIN_LEAVE_KBN_OTHER}
       {if !empty($param.f_leave_reason)}--> {$param.f_leave_reason|escape}{/if}
      {/if}
    </td>
  </tr>
  {/if}
</table>
<!-- /Confirm -->
