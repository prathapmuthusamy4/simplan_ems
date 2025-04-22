{include file="`$common.head_tpl`"}<!--rightmenu-->
<div id="rightm">
    <h2>{$param.title|escape}Search・List</h2>
    <p></p>
    <ul id="main">
        <li>
            <h3>>>>&nbsp;{$param.title|escape} Customer Search</h3>
            <table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
                <tr valign="top" bgcolor="#FFFFFF" height="25">
                    <td width="20%" valign="middle"><h4>Name</h4></td>
                    <td width="80%" valign="middle" bgcolor="#F5F5F5">
                        <input name="f_name" type="text" class="formstb" value="{$param.f_name}" />
                        {$param.errmsg.f_name|admin_err}
                    </td>
                </tr>
                <tr valign="top" bgcolor="#FFFFFF" height="25">
                    <td width="20%" valign="middle"><h4>Blood</h4></td>
                    <td width="80%" valign="middle" bgcolor="#F5F5F5" class="formstd_c">
                        <select name="f_blood_group" class="formsta">
                            <option value="">----</option>
                            {select_option list=$param.disp_blood value=$param.f_blood_group}
                        </select>
                        {$param.errmsg.f_blood_group|admin_err}
                    </td>
                </tr>
            </table>
            <div id="pt">
                <input type="button" class="formbtn" onClick="return submitfrm('priya.php', 'list', 'search');" value="Search"/>
            </div> 
            <table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
             <tr valign="top" bgcolor="#FFFFFF" height="25">
              <td width="20%" valign="middle"><h4>CSVUPLOAD</h4></td>
               <td width="80%" valign="middle" bgcolor="#F5F5F5">
                 &nbsp;&nbsp;<input name="upload_file" type="file" size="60" onkeydown="return false;" onbeforeeditfocus="return false;" />
                 &nbsp;&nbsp;<input type="button" class="formbtn" onClick="return submitfrm('priya.php', 'list', 'csv_upload');" value="CSVupload"/>
                 {$param.errmsg.upload_file|escape|admin_err}
                        {foreach from=$param.errmsg.err_list item="cur" name="current"}
                            {$cur|admin_err}
                        {/foreach}
               </td>
             </tr>
           </table>
        </li>
        <li>
            <h3>>>>&nbsp;{$param.title|escape} Customer List</h3>
            <p>{admin_page_navi info=$param.page_info}</p>
            <table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
                <tr align="center" valign="top" bgcolor="#F5F5F5" height="30">
                    <td width="10%" valign="middle" class="tfextra">S.No</td>
                    <td width="40%" valign="middle" class="tfextra">Name</td>
                    <td width="10%" valign="middle" class="tfextra">Age</td>
                    <td width="10%" valign="middle" class="tfextra">Gender</td>
                    <td width="5%" valign="middle" class="tfextra">Graduate</td>
                    <td width="5%" valign="middle" class="tfextra">Blood</td>
                    <td width="20%" valign="middle" class="tfextra">操　作</td>
                </tr>
                {foreach from=$param.list item="cur" name="current"}
                    <tr valign="top" bgcolor="{cycle values="#FFFFFF,#FAFAD2"}" height="30">
                        <td align="center" valign="middle" class="tfextrb">{$smarty.foreach.current.iteration}</td>
                        <td align="left" valign="middle" class="tfextrb">{$cur.f_name|escape}</td>
                        <td align="center" valign="middle" class="tfextrb">{$cur.f_age|escape}</td>
                        <td align="center" valign="middle" class="tfextrb">{array_value key=$cur.f_gender list=$param.disp_gender|escape}</td>
                        <td align="center" valign="middle" class="tfextrb">{array_value key=$cur.f_graduate list=$param.disp_graduate|escape}</td>
                        <td align="center" valign="middle" class="tfextrb">
                            {array_value key=$cur.f_blood_group list=$param.disp_blood|escape}
                        </td>
                        <td align="center" valign="middle" class="tfextrb"> 
                            <input type="button" class="formstc" onClick="return selectfrm('priya.php', 'edit', '', '{$cur.f_priya_id|escape}');" value="Edit" />
                            <input type="button" class="formstc" onClick="return selectfrm('priya.php', 'del',  'confirm', '{$cur.f_priya_id|escape}');" value="Del"/>
                            <input type="button" class="formstc" onClick="return selectfrm('priya.php', 'detail',  'confirm', '{$cur.f_priya_id|escape}');" value="detail" /></a>
                        </td>
                    </tr>
                {foreachelse}
                    <tr bgcolor="#FFFFFF" height="30">
                        <td align="center" colspan="6" class="tfextrb" >{$param.none|escape}</td>
                    </tr>
                {/foreach}
            </table>
            <p>{admin_page_feed info=$param.page_info process="list"}</p>
            <div id="pt">
                <input type="button" class="formbtn" onClick="return submitfrmNofalse('priya.php', 'list', 'csvdownload');" value="CSVDownload"/>
                <input type="button" class="formbtn" onClick="return submitfrm('priya.php', 'new', ' ');" value="New Register" />
            </div>
        </li>
    </ul>
    <div id="pt">
    <a href="#top">▲Top of this Page</a>
    </div>
</div>
<!--/rightmenu-->
{include file="`$common.foot_tpl`"}