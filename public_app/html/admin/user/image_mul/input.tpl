<h3>>>>&nbsp;{$param.title|escape}情報</h3>
<table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
    {section name=img start=1 loop=$param.img_num+1 step=1}
    <tr valign="top" bgcolor="#FFFFFF">
        <td colspan="2" width="20%" valign="middle" class="tdcls1"><span class="cap1">ロゴ画像{$smarty.section.img.index}</span></td>
        <td colspan="3" width="80%" valign="middle" class="tdcls2">
            {assign var=image_picture value="image_picture`$smarty.section.img.index`"}
            {if is_file("`$param.dir_tmp``$param.$image_picture`")}
                <a href="./{$param.url_tmp}{$param.$image_picture}" rel="lightbox" target="_blank">
                    {imageLink image="./`$param.url_tmp``$param.$image_picture`" width="200" height="100" }
                </a>
                {assign var=tmp_f_image_del value="tmp_f_image_del`$smarty.section.img.index`"}
                {assign var=del_image_check value="del_image_check`$smarty.section.img.index`"}
                <input type="checkbox" name="{$tmp_f_image_del}" value="1" id="{$tmp_f_image_del}" {$param.$del_image_check|escape}>
                <label for="f_img1">削除</label>
                <input type="hidden" name="{$image_picture}" value="{$param.$image_picture|escape}"><br/>
            {/if}
            {assign var=tmp_f_image value="tmp_f_image`$smarty.section.img.index`"}
            <input type="file" name="{$tmp_f_image}" contentEditable="false">
            <span class="disclaimer">（画像ファイル選択）</span>
            {$param.errmsg.$tmp_f_image|user_err}
        </td>
    </tr>
    {/section}
</table>