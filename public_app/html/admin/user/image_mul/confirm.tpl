<h3>>>>&nbsp;{$param.title|escape}情報</h3>
<table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
	{section name=img start=1 loop=$param.img_num+1 step=1}
    <tr valign="top" bgcolor="#FFFFFF" height="30">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">ロゴ画像{$smarty.section.img.index}</span></td>
        <td width="80%" valign="middle" class="tdcls2" style="line-height:160%;">
            {assign var=image_picture value="image_picture`$smarty.section.img.index`"}
            {assign var=tmp_f_image_del value="tmp_f_image_del`$smarty.section.img.index`"}
{if $param.disp_type == $smarty.const.DISP_TYPE_NEW || $param.disp_type == $smarty.const.DISP_TYPE_EDIT}
            {if is_file("`$param.dir_tmp``$param.$image_picture`") && ($param.$tmp_f_image_del !== '1')}
                <a href="./{$param.url_tmp}{$param.$image_picture}" rel="lightbox" target="_blank">
                    {imageLink image="./`$param.url_tmp``$param.$image_picture`" width="200" alt=""}
                </a>
            {/if}
{else}
            {assign var=f_image value="f_image`$smarty.section.img.index`"}
            {if is_file("`$param.dir_img``$param.$f_image`")}
                <a href="./{$param.url_img}{$param.$f_image}" rel="lightbox" target="_blank">
                    {imageLink image="./`$param.url_img``$param.$f_image`" width="200" alt=""}
                </a>
            {/if}
{/if}
        </td>
    </tr>
{/section}
</table>