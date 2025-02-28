<link type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css" rel="stylesheet" />
<script language="JavaScript" src="./js/jquery.js" type="text/JavaScript" charset="UTF-8"></script>
{literal}
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
    if ($('input[name=f_graduate]:checked').val() == 1) {
                $('#f_mark').show();
            } else {
                $('#f_mark').hide();
            }
        $('input[name=f_graduate]:radio').click(function () {
            if ($('input[name=f_graduate]:checked').val() == 1) {
                $('#f_mark').show();
            } else {
                $('#f_mark').hide();
            }
        });
    });
    // datepicker
    $(function() {
            $( "#f_dob" ).datepicker({
                changeMonth:true,
                changeYear:true,
                yearRange:"-50:+0",
                dateFormat:"yy/mm/dd"
            });
         });
</script>
{/literal}
<h3>>>>&nbsp;{$param.title|escape} Info</h3>
<table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Reg.No</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_reg_no" type="text" class="formstb_m" value="{$param.f_reg_no}" />
            {$param.errmsg.f_reg_no|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Name</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_name" type="text" class="formstb_m" value="{$param.f_name}" />
            {$param.errmsg.f_name|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Date of Birth</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input id="f_dob" name="f_dob" type="text" class="formstb_s" value="{$param.f_dob}" />
            {$param.errmsg.f_dob|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Age</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input id="f_age" name="f_age" type="text" class="formstb_ss" value="{$param.f_age}" />
            {$param.errmsg.f_age|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Gender</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {radio_option list=$param.disp_gender name="f_gender" value=$param.f_gender|escape}
            {$param.errmsg.f_gender|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Graduate</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {radio_option list=$param.disp_graduate name="f_graduate" value=$param.f_graduate|escape }
            {*<input name="f_mark" id="f_mark" type="text" value="{$param.f_mark|escape}">*}
            {$param.errmsg.f_graduate|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF" id="f_mark">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Mark</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_mark" id="f_mark" type="text" value="{$param.f_mark|escape}">
            {$param.errmsg.f_mark|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Blood Group</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <select name="f_blood_group" id="f_blood_group">
                <option value="">----</option>
                {select_option list=$param.disp_blood value=$param.f_blood_group}
            </select>
            {$param.errmsg.f_blood_group|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Sample</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <select name="f_priya_id" >
                <option value="">----</option>
                {select_option list=$param.disp_sample value=$param.f_priya_id}
            </select>
            {$param.errmsg.f_priya_id|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Hobbies</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {html_checkboxes name='f_hobbies' options=$param.disp_hobbies selected=$param.f_hobbies separator='&nbsp;'}
            {$param.errmsg.f_hobbies|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Remarks</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <textarea name="f_remarks" cols="100" rows="7" class="formstb_600">{$param.f_remarks}</textarea>
            {$param.errmsg.f_remarks|admin_err}
        </td>
    </tr>
    {*<tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Image</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {if is_file("`$param.dir_tmp``$param.image_picture`")}
                {imageLink image="./`$param.url_tmp``$param.image_picture`" width="200" height="100" }
                <input type="checkbox" name="tmp_f_image_del" value="1" id="f_img" {$param.del_check|escape}>
                <label for="f_img">Delete</label>
                <input type="hidden" name="image_picture" value="{$param.image_picture|escape}"><br />
            {/if}
            <input type="file" name="tmp_f_image" contentEditable="false">
            <input type="hidden" name="f_image" value="{$param.f_image}">
            <span class="disclaimer"></span>
            {$param.errmsg.tmp_f_image|admin_err}
        </td>
    </tr>*}
   {section name=img start=1 loop=$param.img_num+1 step=1}
    <tr valign="top" bgcolor="#FFFFFF">
        <td  width="20%" valign="middle" class="tdcls1"><span class="cap1">Multiple images{$smarty.section.img.index}</span></td>
        <td  width="80%" valign="middle" class="tdcls2">
            {assign var=image_picture value="image_picture`$smarty.section.img.index`"}
            {if is_file("`$param.dir_tmp``$param.$image_picture`")}
                <a href="./{$param.url_tmp}{$param.$image_picture}" rel="lightbox" target="_blank">
                    {imageLink image="./`$param.url_tmp``$param.$image_picture`" width="200" height="100" }
                </a>
                {assign var=tmp_f_image_del value="tmp_f_image_del`$smarty.section.img.index`"}
                {assign var=del_image_check value="del_image_check`$smarty.section.img.index`"}
                <input type="checkbox" name="{$tmp_f_image_del}" value="1" id="{$tmp_f_image_del}" {$param.$del_image_check|escape}>
                <label for="f_image1">削除</label>
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