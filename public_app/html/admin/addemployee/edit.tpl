{include file="`$common.head_tpl`"}
<!--rightmenu-->
<div id="rightm">
  <h2>{$param.title|escape}/Edit</h2>
  <p><span class="must">※</span>&nbsp;It is a required field.</p>
  <ul id="main">
    <li>
{include file="input.tpl"}
    </li>
  </ul>
  <div id="pt">
    <input type="button" name="back" value="<< Back" class="formbtn" onclick="return submitfrm('addemployee.php', 'list', 'reload');" style="float:left;" />
    <input type="button" name="confirm" value="Confirm >>" class="formbtn"  onclick="return selectfrm('addemployee.php', 'edit', 'confirm', '{$param.f_employee_id|escape}');" />
  </div>
  <br />
  <div id="pt">
    <a href="#top">▲Go back to the top of this page</a>
  </div>
</div>
<!--/rightmenu-->
{include file="`$common.foot_tpl`"}
