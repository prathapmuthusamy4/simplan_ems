{include file="`$common.head_tpl`"}
<!--rightmenu-->
<div id="rightm">
    <h2>{$param.title|escape}検索・一覧</h2>
    <p></p>
    <ul id="main">
        <li>
            <h3>>>>&nbsp;{$param.title|escape}検索</h3>
            <table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
                <tr valign="top" bgcolor="#FFFFFF" height="25">
                    <td width="20%" valign="middle"><h4>名前</h4></td>
                    <td width="80%" valign="middle" bgcolor="#F5F5F5">
                        <input name="f_name" type="text" class="formstb_500" value="{$param.f_name}" />
                        {$param.errmsg.f_name|admin_err}
                    </td>
                </tr>
                <tr valign="top" bgcolor="#FFFFFF" height="25">
                    <td width="20%" valign="middle"><h4>管理者区分</h4></td>
                    <td width="80%" valign="middle" bgcolor="#F5F5F5" class="formstd_c">
                        <select name="f_admin_kbn" class="formsta">
                            <option value="">----</option>
                            {select_option list=$param.disp_admin_kbn value=$param.f_admin_kbn}
                        </select>
                        {$param.errmsg.f_admin_kbn|admin_err}
                    </td>
                </tr>
            </table>
            <div id="pt">
                <input type="button" class="formbtn" onClick="return submitfrm('addemployee.php', 'list', 'search');" value="検　索"/>
            </div>
        </li>
        <li>
            <h3>>>>&nbsp;{$param.title|escape}一覧</h3>
            <p>{admin_page_navi info=$param.page_info}</p>
            <table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
                <tr align="center" valign="top" bgcolor="#F5F5F5" height="30">
                    <td width="15%" valign="middle" class="tfextra">所属部署</td>
                    <td width="20%" valign="middle" class="tfextra">名前</td>
                    <td width="10%" valign="middle" class="tfextra">ログインID</td>
                    <td width="25%" valign="middle" class="tfextra">メールアドレス</td>
                    <td width="15%" valign="middle" class="tfextra">管理者区分</td>
                    <td width="15%" valign="middle" class="tfextra">操　作</td>
                </tr>
    {foreach from=$param.list item="cur" name="current"}
                <tr valign="top" bgcolor="{cycle values="#FFFFFF,#FAFAD2"}" height="30">
        {assign var="adminkbn_color" value="#474746"}
        {if $cur.f_admin_kbn == $smarty.const.ADMIN_KBN_ID_SUPER_ADMIN}
            {assign var="adminkbn_color" value="red"}
        {/if}
                    <td align="left" valign="middle" class="tfextrb">{$cur.f_admin_id}</td>
                    <td align="left" valign="middle" class="tfextrb">{$cur.f_surname|escape}</td>
                    <td align="left" valign="middle" class="tfextrb">{$cur.f_id|escape}</td>
                    <td align="left" valign="middle" class="tfextrb">{$cur.f_mailaddress|escape|convert_ord}</td>
                    <td align="center" valign="middle" style="color:{$adminkbn_color};" class="tfextrb">{array_value key=$cur.f_admin_kbn|escape list=$param.disp_admin_kbn}</td>
                    <td align="center" valign="middle" class="tfextrb">
        {assign var="edit_disabled" value=""}
        {assign var="del_disabled" value=""}
        {if $param.logininfo.f_admin_id == $cur.f_admin_id}
            {assign var="del_disabled" value="disabled"}
        {/if}
        {if $param.logininfo.f_admin_kbn != $smarty.const.ADMIN_KBN_ID_SUPER_ADMIN}
            {assign var="del_disabled" value="disabled"}
            {if $param.logininfo.f_admin_id != $cur.f_admin_id}
                {assign var="edit_disabled" value="disabled"}
            {/if}
        {/if}
                    <input type="button" class="formstc" onClick="return selectfrm('addemployee', 'edit', '', '{$cur.f_admin_id|escape}');" value="変 更" {$edit_disabled} />
                    <input type="button" class="formstc" onClick="return selectfrm('addemployee', 'del',  'confirm', '{$cur.f_admin_id|escape}');" value="削 除" {$del_disabled} />
                    </td>
                </tr>
    {foreachelse}
                <tr bgcolor="#FFFFFF" height="30">
                    <td align="center" colspan="5" class="tfextrb" >{$param.none|escape}</td>
                </tr>
    {/foreach}
            </table>
            <p>{admin_page_feed info=$param.page_info process="list"}</p>
            <div id="pt">
                <input type="button" class="formbtn" onClick="return submitfrm('addemployee', 'new', '');" value="新 規 登 録" />
            </div>
        </li>
    </ul>
    <div id="pt">
    <a href="#top">▲このページの先頭へもどる</a>
    </div>
</div>
<!--/rightmenu-->
{include file="`$common.foot_tpl`"}