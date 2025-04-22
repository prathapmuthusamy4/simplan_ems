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
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">E-mail</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.f_mail|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Title</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.f_title|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">PDF Upload</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.f_filename}
        </td>
    </tr>
</table>
<!-- /Confirm -->