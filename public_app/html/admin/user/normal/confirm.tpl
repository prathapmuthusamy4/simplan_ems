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
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Date of Birth</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.f_dob|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Age</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.f_age|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Gender</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {array_value key=$param.f_gender list=$param.disp_gender|escape}&nbsp;
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Blood Group</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {array_value key=$param.f_blood_group list=$param.disp_blood|escape}&nbsp;
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Hobbies</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {foreach from=$param.f_hobbies item="cur" name="current"}
                {array_value key=$cur list=$param.disp_hobbies|escape}
            {/foreach}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Remarks</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.f_remarks|escape|nl2br}
        </td>
    </tr>
</table>
<!-- /Confirm -->