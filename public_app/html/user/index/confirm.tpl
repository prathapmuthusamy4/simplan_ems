<h3>EMPLOYEE DETAILS</h3>
<table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
    <tr valign="top" bgcolor="#FFFFFF">
      <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Employee ID</span></td>
      <td width="80%" valign="middle" class="tdcls2">
          {$param.list.f_emp_id|escape}
      </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Name</span></td>
      <td width="80%" valign="middle" class="tdcls2">
          {$param.list.f_name|escape}
      </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Gender</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {array_value key=$param.list.f_gender list=$param.disp_gender|escape}&nbsp;
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Date Of Birth</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.list.f_date_of_birth|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Blood Group</span></td>
      <td width="80%" valign="middle" class="tdcls2">
          {array_value key=$param.list.f_blood_group list=$param.disp_blood_group|escape}
      </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Aadhar Number</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.list.f_aadhar_number|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Pan Number</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.list.f_pan_number|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Passport Number</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.list.f_passport|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Status</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {array_value key=$param.list.f_status list=$param.disp_status|escape}&nbsp;
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Door No/Street Name</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.list.f_address1|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Village/Town</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.list.f_address2|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">City</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.list.f_city|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">State</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.list.f_state|escape}
        </td>
    </tr><tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Pincode</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.list.f_pincode|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Country</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {array_value key=$param.list.f_country list=$param.disp_country|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Mobile Number</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.list.f_mobile_number|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Office Mail</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.list.f_office_email|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Personal Mail</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.list.f_personal_mail|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Profile Photo</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {if is_file("`$param.dir_tmp``$param.image_picture`") && ($param.tmp_f_image_del !== '1')}
                {imageLink image="./`$param.url_tmp``$param.image_picture`" width="100"  alt="logo" opt="title='logo'"}
            {/if}
          &nbsp;
        </td>
    </tr>
</table>
<h3>EMERGENCY CONTACT</h3>
<table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
    <tr valign="top" bgcolor="#FFFFFF">
      <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Name</span></td>
      <td width="80%" valign="middle" class="tdcls2">
          {$param.list.f_relation_name|escape}
      </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Relationship</span></td>
      <td width="80%" valign="middle" class="tdcls2">
          {$param.list.f_relationship|escape}
      </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Occupation</span></td>
      <td width="80%" valign="middle" class="tdcls2">
          {$param.list.f_occupation|escape}
      </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Address</span></td>
      <td width="80%" valign="middle" class="tdcls2">
          {$param.list.f_address|escape}
      </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Mobile Number</span></td>
      <td width="80%" valign="middle" class="tdcls2">
          {$param.list.f_phone_number|escape}
      </td>
    </tr>
</table>
<h3>JOB DETAILS</h3>
<table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
    <tr valign="top" bgcolor="#FFFFFF">
      <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Job Title</span></td>
      <td width="80%" valign="middle" class="tdcls2">
          {$param.list.f_job_title|escape}
      </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Join Date</span></td>
      <td width="80%" valign="middle" class="tdcls2">
          {$param.list.f_join_date|escape}
      </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Employee Status</span></td>
      <td width="80%" valign="middle" class="tdcls2">
            {array_value key=$param.list.f_emp_status list=$param.disp_emp_status|escape}&nbsp;
      </td>
    </tr>
    {if $param.f_emp_status == $smarty.const.ALLOW_STATUS_INACTIVE}
    <tr valign="top" bgcolor="#FFFFFF">
      <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Relive Date</span></td>
      <td width="80%" valign="middle" class="tdcls2">
          {$param.list.f_relive_date|escape}
      </td>
    </tr>
    {/if}
    <tr valign="top" bgcolor="#FFFFFF">
      <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Job Category</span></td>
      <td width="80%" valign="middle" class="tdcls2">
          {$param.list.f_category|escape}
      </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Location</span></td>
      <td width="80%" valign="middle" class="tdcls2">
          {$param.list.f_location|escape}
      </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Experience</span></td>
      <td width="80%" valign="middle" class="tdcls2">
          {$param.list.f_experience|escape}
      </td>
    </tr>
    
    <tr valign="top" bgcolor="#FFFFFF">
      <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Additional Skill</span></td>
      <td width="80%" valign="middle" class="tdcls2">
          {$param.list.f_additional_skill|escape}
      </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Language</span></td>
      <td width="80%" valign="middle" class="tdcls2">
            {foreach from=$param.list.f_language item="cur" name="current"}
                {array_value key=$cur list=$param.disp_language|escape}
            {/foreach}
            {if !empty($param.f_others)}--> {$param.f_others|escape}{/if}
      </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td width="20%" valign="middle" class="tdcls1"><span class="cap1">JLPT Level</span></td>
      <td width="80%" valign="middle" class="tdcls2">
          {foreach from=$param.list.f_jlpt item="cur" name="current"}
                {array_value key=$cur list=$param.disp_jlpt|escape}
            {/foreach}
      </td>
    </tr>
</table>
