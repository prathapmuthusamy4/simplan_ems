<h3>>>>&nbsp;{$param.title|escape}情報</h3>
<table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
    <tr valign="top" bgcolor="#FFFFFF">
  	    <td colspan="2" width="20%" valign="middle" class="tdcls1"><span class="cap1">ロゴ画像</span></td>
        <td colspan="3" width="80%" valign="middle" class="tdcls2">
            {if is_file("`$param.dir_tmp``$param.image_picture`")}
                {imageLink image="./`$param.url_tmp``$param.image_picture`" width="200" height="100" }
                <input type="checkbox" name="tmp_f_image_del" value="1" id="f_img" {$param.del_check|escape}>
                <label for="f_img">削除</label>
                <input type="hidden" name="image_picture" value="{$param.image_picture|escape}"><br />
            {/if}
            <input type="file" name="tmp_f_image" contentEditable="false">
            <input type="hidden" name="f_image" value="{$param.f_image}">
            <span class="disclaimer">（画像ファイル選択）</span>
            {$param.errmsg.tmp_f_image|user_err}
        </td>
    </tr>
</table>