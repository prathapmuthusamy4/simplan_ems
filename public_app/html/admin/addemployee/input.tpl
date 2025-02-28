<script language="JavaScript" src="./js/jquery.js" type="text/JavaScript" charset="UTF-8"></script>
<link type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css" rel="stylesheet" />
{literal}
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
<script type="text/javascript">
    function experienceCalculator() {
        var userinput = document.getElementById("f_join_date").value;
        var dob = new Date(userinput);
        var month_diff = Date.now() - dob.getTime();
        var age_dt = new Date(month_diff); 
        var year = age_dt.getUTCFullYear();
        var age = Math.abs(year - 1970);
        $('#f_experience').html(age);
        $('#f_exp').val(age);
    }
    function ageCalculator() {
        var userinput = document.getElementById("f_date_of_birth").value;
        var dob = new Date(userinput);
        var month_diff = Date.now() - dob.getTime();
        var age_dt = new Date(month_diff); 
        var year = age_dt.getUTCFullYear();
        var age = Math.abs(year - 1970);
        $('#f_age').html(age);
        $('#f_age_1').val(age);
    }
    $(document).ready(function(){
    if ($('input[name=f_emp_status]:checked').val() == 1) {
            $('#f_relive_date').show();
        } else {
            $('#f_relive_date').val("");
            $('#f_relive_date').hide();
        }
    $('input[name=f_emp_status]:radio').click(function () {
        if ($('input[name=f_emp_status]:checked').val() == 1) {
            $('#f_relive_date').show();
        } else {
            $('#f_relive_date').val("");
            $('#f_relive_date').hide();
        }
    });
    if ($('input[name=f_education_ug]:checked').val() == 0) {
        $('#degree_ug').show();
        $('#university_ug').show();
    } else {
        $('#degree_ug').val("");
        $('#university_ug').val("");
        $('#degree_ug').hide();
        $('#university_ug').hide();
    }
    $('input[name=f_education_ug]:radio').click(function () {
        if ($('input[name=f_education_ug]:checked').val() == 0) {
            $('#degree_ug').show();
            $('#university_ug').show();
        } else {
            $('#degree_ug').val("");
            $('#university_ug').val("");  
            $('#degree_ug').hide();
            $('#university_ug').hide();
        }
    });
    if ($('input[name=f_education_pg]:checked').val() == 0) {
        $('#degree_pg').show();
        $('#university_pg').show();
    } else {
        $('#degree_pg').val("");
        $('#university_pg').val("");
        $('#degree_pg').hide();
        $('#university_pg').hide();
    }
    $('input[name=f_education_pg]:radio').click(function () {
        if ($('input[name=f_education_pg]:checked').val() == 0) {
            $('#degree_pg').show();
            $('#university_pg').show();
        } else {
            $('#degree_pg').val("");
            $('#university_pg').val("");
            $('#degree_pg').hide();
            $('#university_pg').hide();
        }
    });
    if ($('input[name=f_language]:checked').val() == 4) {
        $('#others').show();
    } else {
        $('#others').val("");
        $('#others').hide();
    }
    $("[id$='language'][type='checkbox']:checkbox").click(function () {
        if ($(this).val() == 4) {
            if ($(this).prop('checked')==true){ 
                $('#others').show();
            } else {
                $('#others').val("");
                $('#others').hide();
            }
        }
    });
    $( "#f_date_of_birth" ).datepicker({
        changeMonth:true,
        changeYear:true,
        yearRange:"-60:+0",
        dateFormat:"yy/mm/dd"
    });
    $( "#f_expiry_date" ).datepicker({
        changeMonth:true,
        changeYear:true,
        yearRange:"-0:+15",
        dateFormat:"yy/mm/dd"
    });
    $( "#f_issue_date" ).datepicker({
        changeMonth:true,
        changeYear:true,
        yearRange:"-15:+15",
        dateFormat:"yy/mm/dd"
    });
    $( "#f_join_date" ).datepicker({
        changeMonth:true,
        changeYear:true,
        yearRange:"-60:+0",
        dateFormat:"yy/mm/dd"
    });
    $( "#f_date" ).datepicker({
        changeMonth:true,
        changeYear:true,
        yearRange:"-60:+0",
        dateFormat:"yy/mm/dd"
    });
    });
</script>
{/literal}
<h3 style="color:32A80F" id="result" align="center"></h3>
<h3>EMPLOYEE DETAILS</h3>
<table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Employee ID</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_emp_id" type="text" class="formstb_s" value="{$param.f_emp_id}" />
            {$param.errmsg.f_emp_id|admin_err}
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
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Gender</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            &nbsp;{radio_option list=$param.disp_gender name="f_gender" value=$param.f_gender|escape}
            {$param.errmsg.f_gender|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Date Of Birth</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_date_of_birth" id="f_date_of_birth" type="text" class="formstb_s" value="{$param.f_date_of_birth}" onchange="ageCalculator()" />
            {$param.errmsg.f_date_of_birth|admin_err}
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="cap1">Age : </span><span id="f_age">{$param.f_age|escape}</span>&nbsp;years
          <input id="f_age_1" type="hidden" name="f_age" value="{$param.f_age|escape}">
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Blood Group</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            &nbsp;<select name="f_blood_group" id="f_blood_group">
                <option value="">----</option>
                {select_option list=$param.disp_blood_group value=$param.f_blood_group}
            </select>
            {$param.errmsg.f_blood_group|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Aadhar Number</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_aadhar_number" type="text" class="formstb_m" value="{$param.f_aadhar_number}" />
            {$param.errmsg.f_aadhar_number|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Pan Number</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_pan_number" type="text" class="formstb_m" value="{$param.f_pan_number}" />
            {$param.errmsg.f_pan_number|admin_err}
        </td>
    </tr>
        <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Passport Number</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_passport" type="text" class="formstb_m" value="{$param.f_passport}" />
            {$param.errmsg.f_passport|admin_err}
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cap1">Issue Date</span>
            <input name="f_issue_date" id="f_issue_date" type="text" class="formstb_s" value="{$param.f_issue_date}" />
            {$param.errmsg.f_issue_date|admin_err}
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="cap1">Expiry Date</span>
            <input name="f_expiry_date" id="f_expiry_date" type="text" class="formstb_s" value="{$param.f_expiry_date}" />
            {$param.errmsg.f_expiry_date|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Marital Status</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            &nbsp;{radio_option list=$param.disp_status name="f_status" value=$param.f_status|escape}
            {$param.errmsg.f_status|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Door No/Street Name</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_address1" type="text" class="formstb_m" value="{$param.f_address1}" />
            {$param.errmsg.f_address1|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Village/Town</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_address2" type="text" class="formstb_m" value="{$param.f_address2}" />
            {$param.errmsg.f_address2|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">City</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_city" type="text" class="formstb_m" value="{$param.f_city}" />
            {$param.errmsg.f_city|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">State</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_state" type="text" class="formstb_m" value="{$param.f_state}" />
            {$param.errmsg.f_state|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Pincode</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_pincode" type="text" class="formstb_m" value="{$param.f_pincode}" />
            {$param.errmsg.f_pincode|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Country</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            &nbsp;<select name="f_country">
                <option value="">----</option>
                {select_option list=$param.disp_country value=$param.f_country}
            </select>
            {$param.errmsg.f_country|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Mobile Number</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_mobile_number" type="text" class="formstb_m" value="{$param.f_mobile_number}" />
            {$param.errmsg.f_mobile_number|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Office Mail</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_office_email" type="text" class="formstb_m" value="{$param.f_office_email}" />
            {$param.errmsg.f_office_email|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Personal Mail</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_personal_mail" type="text" class="formstb_m" value="{$param.f_personal_mail}" />
            {$param.errmsg.f_personal_mail|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Profile Photo</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {if is_file("`$param.dir_tmp``$param.image_picture`")}
                {imageLink image="../`$param.url_tmp``$param.image_picture`" width="200" height="100" }
                <input type="checkbox" name="tmp_f_image_del" value="1" id="f_img" {$param.del_check|escape}>
                <label for="f_img">Delete</label>
                <input type="hidden" name="image_picture" value="{$param.image_picture|escape}"><br />
            {/if}
            <input type="file" name="tmp_f_image" contentEditable="false">
            <input type="hidden" name="f_image" value="{$param.f_image}">
            <span class="disclaimer">（Select image file）</span>
            {$param.errmsg.tmp_f_image|user_err}
        </td>
    </tr>
</table>
<h3>EMERGENCY CONTACT</h3>
<table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Name</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_relation_name" type="text" class="formstb_m" value="{$param.f_relation_name}" />
            {$param.errmsg.f_relation_name|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Relationship</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_relationship" type="text" class="formstb_m" value="{$param.f_relationship}" />
            {$param.errmsg.f_relationship|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Occupation</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_occupation" type="text" class="formstb_m" value="{$param.f_occupation}" />
            {$param.errmsg.f_occupation|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Address</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_address" type="text" class="formstb_m" value="{$param.f_address}" />
            {$param.errmsg.f_address|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Mobile Number</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_phone_number" type="text" class="formstb_m" value="{$param.f_phone_number}" />
            {$param.errmsg.f_phone_number|admin_err}
        </td>
    </tr>
</table>
<h3>JOB DETAILS</h3>
<table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Job Title</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_job_title" type="text" class="formstb_m" value="{$param.f_job_title}" />
            {$param.errmsg.f_job_title|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Join Date</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_join_date" id="f_join_date" type="text" class="formstb_s" value="{$param.f_join_date}" onchange = "experienceCalculator()"/>
            {$param.errmsg.f_join_date|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Employee Status</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            &nbsp;{radio_option list=$param.disp_emp_status name="f_emp_status" value=$param.f_emp_status|escape}
            {$param.errmsg.f_emp_status|admin_err}
        </td>
    </tr>
    <tr id="f_relive_date" valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Relive Date</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_relive_date" id="f_date" type="text" class="formstb_s" value="{$param.f_relive_date}" />
            {$param.errmsg.f_relive_date|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Job Category</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_category" type="text" class="formstb_m" value="{$param.f_category}" />
            {$param.errmsg.f_category|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Location</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_location" type="text" class="formstb_m" value="{$param.f_location}" />
            {$param.errmsg.f_location|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Experience</span></td>
      <td width="80%" valign="middle" class="tdcls2">
          <span id="f_experience">{$param.f_experience|escape}</span>&nbsp;years
          <input id="f_exp" type="hidden" name="f_experience" value="{$param.f_experience|escape}">
      </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Graduate->UG</span></td>
        <td width="80%" valign="middle" class="tdcls2">
           &nbsp;{radio_option list=$param.disp_education_ug name="f_education_ug" value=$param.f_education_ug|escape}
           {$param.errmsg.f_education_ug|admin_err}
        </td>
    </tr>
    <tr id="degree_ug" valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Degree->UG</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_degree_ug" type="text" class="formstb_s" value="{$param.f_degree_ug}" />
            {$param.errmsg.f_degree_ug|admin_err}
        </td>
    </tr>
    <tr id="university_ug" valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">University->UG</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_university_ug" type="text" class="formstb_s" value="{$param.f_university_ug}" />
            {$param.errmsg.f_university_ug|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Graduate->PG</span></td>
        <td width="80%" valign="middle" class="tdcls2">
           &nbsp;{radio_option list=$param.disp_education_pg name="f_education_pg" value=$param.f_education_pg|escape}
           {$param.errmsg.f_education_pg|admin_err}
        </td>
    </tr>
    <tr id="degree_pg" valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Degree->PG</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_degree_pg" type="text" class="formstb_s" value="{$param.f_degree_pg}" />
            {$param.errmsg.f_degree_pg|admin_err}
        </td>
    </tr>
    <tr id="university_pg" valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">University->PG</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_university_pg" type="text" class="formstb_s" value="{$param.f_university_pg}" />
            {$param.errmsg.f_university_pg|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Additional Skill</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_additional_skill" type="text" class="formstb_m" value="{$param.f_additional_skill}" />
            {$param.errmsg.f_additional_skill|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Language</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            &nbsp;{html_checkboxes id="language" name='f_language' options=$param.disp_language selected=$param.f_language separator='&nbsp;'}
            {$param.errmsg.f_language|admin_err}
            <input id="others" name="f_others" type="text" class="formstb_s" value="{$param.f_others}" />
            {$param.errmsg.f_others|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">JLPT Level</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            &nbsp;{radio_option list=$param.disp_jlpt name="f_jlpt" value=$param.f_jlpt|escape}
            {$param.errmsg.f_jlpt|admin_err}
        </td>
    </tr>
</table>
<h3>ACCOUNT DETAILS</h3>
<table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Bank Name</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_bank_name" type="text" class="formstb_m" value="{$param.f_bank_name}" />
            {$param.errmsg.f_bank_name|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Branch Name</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_bank_branch" type="text" class="formstb_m" value="{$param.f_bank_branch}" />
            {$param.errmsg.f_bank_branch|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Account Number</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_acc_no" type="text" class="formstb_m" value="{$param.f_acc_no}" />
            {$param.errmsg.f_acc_no|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">IFSC Code</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_ifsc_code" type="text" class="formstb_m" value="{$param.f_ifsc_code}" />
            {$param.errmsg.f_ifsc_code|admin_err}
        </td>
    </tr>
</table>
