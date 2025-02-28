<!-- Confirm -->
<h3>>>>&nbsp;{$param.title|escape}情報</h3>
<table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
  <tr valign="top" bgcolor="#FFFFFF">
    <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Name</span></td>
    <td width="80%" valign="middle" class="tdcls2">
      {$param.f_name|escape}
    </td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF">
    <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Mail</span></td>
    <td width="80%" valign="middle" class="tdcls2">
      {$param.f_mailaddress|escape|convert_ord}&nbsp;
    </td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF">
    <td width="20%" valign="middle" class="tdcls1"><span class="cap1">LoginID</span></td>
    <td width="80%" valign="middle" class="tdcls2">
      {$param.f_id|escape}&nbsp;
    </td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF">
    <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Admin Category</span></td>
    <td width="80%" valign="middle" class="tdcls2">
      {array_value key=$param.f_admin_kbn list=$param.disp_admin_kbn|escape}&nbsp;
    </td>
  </tr>
</table>
<!-- /Confirm -->