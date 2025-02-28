{include file="`$common.head_tpl`"}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
{literal}
<style type="text/css">
   .blink {
            animation: blinker 3.5s linear infinite;
            color: red;
            font-family: sans-serif;
        }
        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
</style>
{/literal}
<!--rightmenu-->
<div id="rightm">
  <h2>{$param.title|escape}/Search/List</h2>
  <p></p>
  <ul id="main">
    <li>
      <h3>&nbsp;SEARCH</h3>
      <table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
        <tr valign="top" bgcolor="#FFFFFF" height="25">
          <td width="20%" valign="middle"><h4>Employee Id</h4></td>
          <td width="80%" valign="middle" bgcolor="#F5F5F5">
            <input name="f_emp_id" type="text" class="formstb_m" value="{$param.f_emp_id}" />
              {$param.errmsg.f_emp_id|admin_err}
            </td>
        </tr>
        <tr valign="top" bgcolor="#FFFFFF" height="25">
          <td width="20%" valign="middle"><h4>Name</h4></td>
          <td width="80%" valign="middle" bgcolor="#F5F5F5">
            <input name="f_name" type="text" class="formstb_m" value="{$param.f_name}" />
              {$param.errmsg.f_name|admin_err}
          </td>
        </tr>
        <tr valign="top" bgcolor="#FFFFFF" height="25">
          <td width="20%" valign="middle"><h4>Status</h4></td>
          <td width="80%" valign="middle" bgcolor="#F5F5F5" class="formstd_c">
            <select name="f_emp_status">
                <option value="">All</option>
                {select_option list=$param.disp_emp_status value=$param.f_emp_status}
            </select>
            {$param.errmsg.f_emp_status|admin_err}
          </td>
        </tr>
      </table>
      <div id="pt">
        <input type="button" class="formbtn" onClick="return submitfrm('salary.php', 'list', 'search');" value="search"/>
      </div>
    </li>
    <li>
      <h3>&nbsp;LIST</h3>
      <p>{admin_page_navi info=$param.page_info}</p>
      <table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
        <tr align="center" valign="top" bgcolor="#F5F5F5" height="30">
          <td width="10%" valign="middle" class="tfextra">Profile Photo</td>
          <td width="10%" valign="middle" class="tfextra">Employee ID</td>
          <td width="15%" valign="middle" class="tfextra">Name</td>
          <td width="10%" valign="middle" class="tfextra">Date Of Birth</td>
          <td width="15%" valign="middle" class="tfextra">Aadhar Number</td>
          <td width="15%" valign="middle" class="tfextra">Passport Number</td>
          <td width="10%" valign="middle" class="tfextra">Mobile Number</td>
          <td width="15%" valign="middle" class="tfextra">Pay slip</td>
        </tr>
        {foreach from=$param.list item="cur" name="current"}
        <tr valign="top" bgcolor="{cycle values="#FFFFFF,#FAFAD2"}" height="30">
          <td align="center" valign="middle" class="tfextrb">
            {if is_file("../`$param.url_img``$cur.f_image`")}
              {imageLink image="../`$param.url_img``$cur.f_image`" width="70" height="70" }
            {/if}
          </td>
          <td align="center" valign="middle" class="tfextrb">{$cur.f_emp_id|escape}</td>
          <td align="left" valign="middle" class="tfextrb">{$cur.f_name}</td>
          <td align="left" valign="middle" class="tfextrb">
            {$cur.f_date_of_birth}
            {if ($cur.f_date_of_birth|date_format:'%m/%d') == ($smarty.now|date_format:'%m/%d')}
              <i style = "color:red;"class="fa fa-birthday-cake"></i>
            {/if}
          </td>
          <td align="center" valign="middle" class="tfextrb">{$cur.f_aadhar_number|escape}</td>
          {if $cur.f_passport_alert > 0}
            <td align="center" style="color:red" valign="middle" class="blink">{$cur.f_passport|escape}<br>{$cur.f_expiry_date}</td>
          {else}
            <td align="center" valign="middle" class="tfextrb">{$cur.f_passport|escape}<br>{$cur.f_expiry_date}</td>
          {/if}
          <td align="center" valign="middle" class="tfextrb">{$cur.f_mobile_number|escape}</td>
          <td align="center" valign="middle" class="tfextrb">
            <input type="button" class="formstc" onClick="return selectfrm('salary.php', 'new', '', '{$cur.f_employee_id|escape}');" value="Regist" />
            <input type="button" class="formstc" onClick="return selectfrm('salary.php', 'new', '', '{$cur.f_employee_id|escape}');" value="Download" />
            <!-- <input type="button" class="formstc_red" onClick="return selectfrm('addemployee.php', 'del',  'confirm', '{$cur.f_employee_id|escape}');" value="Delete" /> -->
          </td>
        </tr>
        {foreachelse}
        <tr bgcolor="#FFFFFF" height="30">
          <td align="center" colspan="8" class="tfextrb" >{$param.none|escape}</td>
        </tr>
        {/foreach}
      </table>
      <p>{admin_page_feed info=$param.page_info process="list"}</p>
      <div id="pt">
        <!-- <input type="button" class="formbtn" onClick="return submitfrmNofalse('addemployee.php', 'list', 'excel');" value="ExcelDownload" />
        <input type="button" class="formbtn" onClick="return submitfrm('addemployee.php', 'new', '');" value="New Regist" /> -->
      </div>
    </li>
  </ul>
  <div id="pt">
    <a href="#top">▲Go back to the top of this page</a>
  </div>
</div>
<!--/rightmenu-->
{include file="`$common.foot_tpl`"}
