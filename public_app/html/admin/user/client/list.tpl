{include file="`$common.head_tpl`"}
<!--rightmenu-->
<div id="rightm">
    <h2>{$param.title|escape}Search・List</h2>
    <p></p>
    <ul id="main">
        <li>
            <h3>>>>&nbsp;{$param.title|escape} Search</h3>
            <table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
                <tr valign="top" bgcolor="#FFFFFF" height="25">
                    <td width="20%" valign="middle"><h4>Name</h4></td>
                    <td width="80%" valign="middle" bgcolor="#F5F5F5">
                        <input name="f_name" type="text" class="formstb" value="{$param.f_name}" />
                        {$param.errmsg.f_name|admin_err}
                    </td>
                </tr>
            </table>
            <div id="pt">
                <input type="button" class="formbtn" onClick="return submitfrm('client.php', 'list', 'search');" value="Search"/>
            </div>
        </li>
        <li>
            <h3>>>>&nbsp;{$param.title|escape} List</h3>
            <p>{admin_page_navi info=$param.page_info}</p>
            <table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
                <tr align="center" valign="top" bgcolor="#F5F5F5" height="30">
                    <td width="20%" valign="middle" class="tfextra">S.No</td>
                    <td width="30%" valign="middle" class="tfextra">Name</td>
                    <td width="30%" valign="middle" class="tfextra">Device</td>
                    <td width="20%" valign="middle" class="tfextra">操　作</td>
                </tr>
                {foreach from=$param.list item="cur" name="current"}
                    <tr valign="top" bgcolor="{cycle values="#FFFFFF,#FAFAD2"}" height="30">
                        <td align="center" valign="middle" class="tfextrb">{$smarty.foreach.current.iteration}</td>
                        <td align="left" valign="middle" class="tfextrb">{$cur.f_name|escape}</td>
                        <td align="left" valign="middle" class="tfextrb">{$cur.f_device|escape}</td>
                        <td align="center" valign="middle" class="tfextrb">
                            <input type="button" class="formstc" onClick="return selectfrm('client.php', 'edit', '', '{$cur.f_client_id|escape}');" value="Edit" />
                            <input type="button" class="formstc" onClick="return selectfrm('client.php', 'del',  'confirm', '{$cur.f_client_id|escape}');" value="Del"/>
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
                <input type="button" class="formbtn" onClick="return submitfrm('client.php', 'new', '');" value="New Register" />
            </div>
        </li>
    </ul>
    <div id="pt">
    <a href="#top">▲Top of this Page</a>
    </div>
</div>
{literal}
<script language="javascript" src="./js/jquery.cookie.js" type="text/javascript" charset="UTF-8"></script>
<script type="text/javascript">
$(document).ready(function() {
    // PDF出力
   /* $("input[id^='download']").click(function(ev){
        // form data
        this.id.match(RegExp("download([0-9]+)"));
        var filesId = RegExp.$1;
        selectfrmNofalse("files.php", "list", "download", filesId);
        setInterval(function () {
            if ($.cookie("downloaded")) {
                $.removeCookie("downloaded", { path: "/" });
                submitfrm("files.php", "list", "reload");
            }
        }, 1000);
    }); */
});
</script>
{/literal}
<!--/rightmenu-->
{include file="`$common.foot_tpl`"}