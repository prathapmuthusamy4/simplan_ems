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
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Mail</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_mailaddress" type="text" class="formstb_500" value="{$param.f_mailaddress}" style="ime-mode: disabled;" />
            <span class="disclaimer">（Ex:info@threet.co.jp）</span>
            {$param.errmsg.f_mailaddress|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">LoginID</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input id="f_id" name="f_id" type="text" class="formstb_m" value="{$param.f_id}" style="ime-mode: disabled;" />
            {$param.errmsg.f_id|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Password</span>{if $param.disp_type == $smarty.const.DISP_TYPE_NEW}<span class="must">※</span>{/if}</td>
        <td width="80%" valign="middle" class="tdcls2">
            <input id="f_password" name="f_password" type="password" class="password formstb_m" value="{$param.f_password}" style="ime-mode: disabled;" />
            {$param.errmsg.f_password|admin_err}
        </td>
    </tr>
        <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Password Confirm</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_password_conf" type="password" class="formstb_m" value="{$param.f_password_conf}" style="ime-mode: disabled;" />
            {$param.errmsg.f_password_conf|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Admin Category</span></td>
        <td width="80%" valign="middle" class="tdcls2">
    {if $param.disp_type == $smarty.const.DISP_TYPE_NEW}
            <select name="f_admin_kbn" id="f_admin_kbn">
                <option value="">----</option>
                {select_option list=$param.disp_admin_kbn value=$param.f_admin_kbn}
            </select>
            {$param.errmsg.f_admin_kbn|admin_err}
    {else}
        {if $param.logininfo.f_admin_kbn == $smarty.const.ADMIN_KBN_ID_SUPER_ADMIN && $param.logininfo.f_admin_id != $param.f_admin_id}
            <select name="f_admin_kbn" id="f_admin_kbn">
                <option value="">----</option>
                {select_option list=$param.disp_admin_kbn value=$param.f_admin_kbn}
            </select>
            {$param.errmsg.f_admin_kbn|admin_err}
        {else}
            {array_value key=$param.f_admin_kbn list=$param.disp_admin_kbn|escape}
            <input type="hidden" name="f_admin_kbn" value="{$param.f_admin_kbn}" />
        {/if}
    {/if}
            <span class="disclaimer">&nbsp;※Only admin users can set permissions.</span>
        </td>
    </tr>
</table>