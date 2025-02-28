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
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Date of Birth</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.f_dob|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Age</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.f_age|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Gender</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {array_value key=$param.f_gender list=$param.disp_gender|escape}&nbsp;
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Graduate</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {array_value key=$param.f_graduate list=$param.disp_graduate|escape}&nbsp;
            {if $param.f_graduate == $smarty.const.STATUS_DISP_GRADUATE_YES}
                {$param.f_mark|escape}&nbsp;CGPA
            {/if}
        </td>
        
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Blood Group</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {array_value key=$param.f_blood_group list=$param.disp_blood|escape}&nbsp;
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">divya</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {array_value key=$param.f_divya_id list=$param.disp_sample|escape}&nbsp;
        </td>
    </tr>
  
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Hobbies</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {foreach from=$param.f_hobbies item="cur" name="current"}
            {array_value key=$cur list=$param.disp_hobbies|escape}
            {/foreach}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Remarks</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.f_remarks|escape|nl2br}
        </td>
    </tr>
   {* <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Image</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {if is_file("`$param.dir_tmp``$param.image_picture`") && ($param.tmp_f_image_del !== '1')}
                {imageLink image="./`$param.url_tmp``$param.image_picture`" width="200"  alt="logo" opt="title='logo'"}
            {/if}
          &nbsp;
        </td>
    </tr>*}
   {section name=img start=1 loop=$param.img_num+1 step=1}

    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">multiple Images</span></td>
        <td width="80%" valign="middle" class="tdcls2">
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
<!-- /Confirm -->