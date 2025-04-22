<h3>EMPLOYEE DETAILS</h3>
<table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
    <tr valign="top" bgcolor="#FFFFFF">
      <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Employee ID</span></td>
      <td width="80%" valign="middle" class="tdcls2">
          {$param.f_emp_id|escape}
      </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Name</span></td>
      <td width="80%" valign="middle" class="tdcls2">
          {$param.f_name|escape}
      </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Gender</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {array_value key=$param.f_gender list=$param.disp_gender|escape}&nbsp;
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Date Of Birth</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.f_date_of_birth|escape}
        </td>
    </tr>


    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Mobile Number</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.f_mobile_number|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Office Mail</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {$param.f_office_email|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Profile Photo</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {if is_file("`$param.dir_tmp``$param.image_picture`") && ($param.tmp_f_image_del !== '1')}
                {imageLink image="../`$param.url_tmp``$param.image_picture`" width="100"  alt="logo" opt="title='logo'"}
            {/if}
          &nbsp;
        </td>
    </tr>
</table>

<h3>JOB DETAILS</h3>
<table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
    <tr valign="top" bgcolor="#FFFFFF">
      <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Job Title</span></td>
      <td width="80%" valign="middle" class="tdcls2">
          {$param.f_job_title|escape}
      </td>
    </tr>
    {/if}
    <tr valign="top" bgcolor="#FFFFFF">
      <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Job Category</span></td>
      <td width="80%" valign="middle" class="tdcls2">
          {$param.f_category|escape}
      </td>
    </tr>
</table>
