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
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">E-Mail</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_mail" type="text" class="formstb_m" value="{$param.f_mail}" />
            {$param.errmsg.f_mail|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Title</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_title" type="text" class="formstb_m" value="{$param.f_title}" />
            {$param.errmsg.f_title|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">PDF Upload</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {if is_file("`$param.dir_up_temp``$param.upload_file`")}
                {$param.f_filename}
                <input type="hidden" name="upload_file" value="{$param.upload_file|escape}">
                <input type="hidden" name="f_filename" value="{$param.f_filename|escape}">
                <input type="hidden" name="f_file_size" value="{$param.f_file_size|escape}">
                <br/>
            {/if}
            <input type="file" name="tmp_f_file" contentEditable="false" enctype="multipart/form-data">
            <input type="hidden" name="f_file" value="{$param.f_file|escape}">
            <span class="disclaimer">（File upload）</span>
            {$param.errmsg.f_file|admin_err}
        </td>
    </tr>
</table>