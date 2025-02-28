<h3>>>>&nbsp;{$param.title|escape}情報</h3>
<table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
	<tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">ロゴ画像</span></td>
        <td width="80%" colspan="3" valign="middle" class="tdcls2">
            {if is_file("`$param.dir_tmp``$param.image_picture`") && ($param.tmp_f_image_del !== '1')}
                {imageLink image="./`$param.url_tmp``$param.image_picture`" width="200"  alt="logo" opt="title='logo'"}
            {/if}
          &nbsp;
        </td>
    </tr>
</table>