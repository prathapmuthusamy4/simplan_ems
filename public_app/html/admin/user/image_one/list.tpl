{include file="`$common.head_tpl`"}
<!--rightmenu-->
<div id="rightm">
    <h2>{$param.title|escape}Search・List</h2>
    <p></p>
    <ul id="main">
    	<li>
            <h3>>>>&nbsp;{$param.title|escape} List</h3>
            <p>{admin_page_navi info=$param.page_info}</p>
            <table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
                <tr align="center" valign="top" bgcolor="#F5F5F5" height="30">
                    <td width="10%" valign="middle" class="tfextra">S.No</td>
                    <td width="40%" valign="middle" class="tfextra">画像名</td>
                    <td width="40%" valign="middle" class="tfextra">画像</td>
                    <td width="20%" valign="middle" class="tfextra">操　作</td>
                </tr>
                {foreach from=$param.list item="cur" name="current"}
                    <tr valign="top" bgcolor="{cycle values="#FFFFFF,#FAFAD2"}" height="30">
                        <td align="center" valign="middle" class="tfextrb">{$smarty.foreach.current.iteration}</td>
                        <td align="left" valign="middle" class="tfextrb">{$cur.f_image|escape}</td>
                        <td align="center" valign="middle" class="tfextrb">
                            {if is_file("`$param.url_img``$cur.f_image`")}
                                {imageLink image="./`$param.url_img``$cur.f_image`" width="100" height="100" }
                            {/if}
                        </td>
                        <td align="center" valign="middle" class="tfextrb">
                            <input type="button" class="formstc" onClick="return selectfrm('image_one.php', 'edit', '', '{$cur.f_image_one_id|escape}');" value="変 更" />
                            <input type="button" class="formstc" onClick="return selectfrm('image_one.php', 'del',  'confirm', '{$cur.f_image_one_id|escape}');" value="削 除"/>
                        </td>
                    </tr>
                {foreachelse}
                    <tr bgcolor="#FFFFFF" height="30">
                        <td align="center" colspan="3" class="tfextrb" >{$param.none|escape}</td>
                    </tr>
                {/foreach}
            </table>
            <p>{admin_page_feed info=$param.page_info process="list"}</p>
            <div id="pt">
                <input type="button" class="formbtn" onClick="return submitfrm('image_one.php', 'new', '');" value="新 規 登 録" />
            </div>
        </li>
    </ul>
</div>
<!--/rightmenu-->
{include file="`$common.foot_tpl`"}