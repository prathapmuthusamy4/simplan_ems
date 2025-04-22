{include file="`$common.head_tpl`"}
{literal}
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
<link type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css" rel="stylesheet" />
<script type="text/javascript">
//datepicker
$(function() {
    $( "#f_start_date" ).datepicker({
        changeYear: true,
        changeMonth:true,
    });
    // $( "#f_end_date" ).datepicker({
    //     changeYear: true,
    //     changeMonth:true,
    // });
    $(document).ready(function() {
    $('#f_end_date').datepicker({maxDate: '0'}).datepicker();
    });
});



</script>
<style>
  .ui-datepicker select.ui-datepicker-month,
  .ui-datepicker select.ui-datepicker-year {width: 45%;}
</style>
{/literal}
<!--rightmenu-->
<div id="rightm">
    <h2>{$param.title|escape} Search & List</h2>
    <p></p>
    <ul id="main">
        <li>
            <h3>>>>&nbsp;{$param.title|escape} Search</h3>
            <table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
                <tr valign="top" bgcolor="#FFFFFF" height="25">
                    <td width="20%" valign="middle"><h4>Name</h4></td>
                    <td width="80%" valign="middle" bgcolor="#F5F5F5">
                        &nbsp;<select name="f_name" id="f_name">
                            <option value="">----</option>
                            {select_option list=$param.disp_name value=$param.f_name}
                        </select>
                    </td>
                </tr>
                <tr valign="top" bgcolor="#FFFFFF" height="25">
                    <td width="20%" valign="middle"><h4>Start Date</h4></td>
                    <td width="80%" valign="middle" bgcolor="#F5F5F5">
                        <input id="f_start_date" name="f_start_date" type="text" class="formstb_s" value="{$param.f_start_date}" />
                    </td>
                </tr>
                    <tr valign="top" bgcolor="#FFFFFF" height="25">
                    <td width="20%" valign="middle"><h4>End Date</h4></td>
                    <td width="80%" valign="middle" bgcolor="#F5F5F5">
                        <input id="f_end_date" name="f_end_date" type="text" class="formstb_s" value="{$param.f_end_date}" />
                    </td>
                </tr>
                <tr valign="top" bgcolor="#FFFFFF" height="25">
                    <td width="20%" valign="middle"><h4>Status</h4></td>
                    <td width="80%" valign="middle" bgcolor="#F5F5F5">
                        &nbsp{radio_option list=$param.disp_attendance name="f_status" value=$param.f_status|escape}
                    </td>
                </tr>
                <tr valign="top" bgcolor="#FFFFFF" height="25">
                    <td width="20%" valign="middle"><h4>Number of Days</h4></td>
                    <td width="80%" valign="middle" bgcolor="#F5F5F5">
                        &nbsp{$param.attendance_count|escape}
                    </td>
                </tr>
            </table>
            <div id="pt">
                <input type="button" class="formbtn" onClick="return submitfrm('attendance.php', 'list', 'search');" value="Search"/>
            </div>
        </li>
        <li>
            <h3>>>>&nbsp;{$param.title|escape} List</h3>
            <p>{admin_page_navi info=$param.page_info}</p>
            <table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
                <tr align="center" valign="top" bgcolor="#F5F5F5" height="30">
                    <td width="30%" valign="middle" class="tfextra">Name</td>
                    <td width="20%" valign="middle" class="tfextra">Date</td>
                    <td width="30%" valign="middle" class="tfextra">Leave Reason</td>
                    <td width="20%" valign="middle" class="tfextra">Operation</td>
                </tr>
    {foreach from=$param.list item="cur" name="current"}
                <tr valign="top" bgcolor="{cycle values="#FFFFFF,#FAFAD2"}" height="30">
                    <td align="left" valign="middle" class="tfextrb">{$cur.f_name|escape}</td>
                    <td align="center" valign="middle" class="tfextrb">{$cur.f_date|escape}</td>
                    <td align="center" valign="middle" class="tfextrb">
                      {if $cur.f_leave_type == 4}
                        {$cur.f_leave_reason|escape}
                      {else}
                        {array_value key=$cur.f_leave_type list=$param.disp_leave_kbn|escape}
                      {/if}
                    </td>
                    <td align="center" valign="middle" class="tfextrb">
                    <input type="button" class="formstc" onClick="return selectfrm('attendance.php', 'edit', '', '{$cur.f_attendance_id|escape}');" value="Edit" />
                    <input type="button" class="formstc" onClick="return selectfrm('attendance.php', 'del',  'confirm', '{$cur.f_attendance_id|escape}');" value="Delete" />
                    </td>
                </tr>
    {foreachelse}
                <tr bgcolor="#FFFFFF" height="30">
                    <td align="center" colspan="4" class="tfextrb" >{$param.none|escape}</td>
                </tr>
    {/foreach}
            </table>
            <p>{admin_page_feed info=$param.page_info process="list"}</p>
            <div id="pt">
                <input type="button" class="formbtn" onClick="return submitfrm('attendance.php', 'new', '');" value="New Regist" />
            </div>
        </li>
    </ul>
    <div id="pt">
    <a href="#top">Go back to the top page</a>
    </div>
</div>
<!--/rightmenu-->
{include file="`$common.foot_tpl`"}
