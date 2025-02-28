<!-- Confirm -->
<h3>>>>&nbsp;{$param.title|escape}Info</h3>
<table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
  <tr valign="top" bgcolor="#FFFFFF">
    <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Name</span></td>
    <td width="80%" valign="middle" class="tdcls2">
      {array_value key=$param.f_name list=$param.disp_name|escape}
    </td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF">
    <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Leave Type</span></td>
    <td width="80%" valign="middle" class="tdcls2">
      {array_value key=$param.f_leave_type list=$param.disp_leave_kbn|escape} {if !empty($param.f_leave_reason)}--> {$param.f_leave_reason|escape}{/if}
    </td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF">
    <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Date</span></td>
    <td width="80%" valign="middle" class="tdcls2">
      {$param.f_date|escape}
    </td>
  </tr>
</table>
<!-- /Confirm -->