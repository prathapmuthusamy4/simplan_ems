{include file="`$common.head_tpl`"}
<!--rightmenu-->
<div id="rightm">
  <h2>{$param.title|escape} Edit</h2>
  <ul id="main">
    <li>
{include file="input.tpl"}
    </li>
  </ul>
  <div id="pt">
    <input type="button" name="back" value="<< Back List" class="formbtn" onclick="return submitfrm('attendance.php', 'list', 'reload');" style="float:left;" />
    <input type="button" name="confirm" value="Confirm >>" class="formbtn"  onclick="return submitfrm('attendance.php', 'edit', 'confirm');" />
  </div>
  <br />
  <div id="pt">
    <a href="#top">▲Go back to the top page</a>
  </div>
</div>
<!--/rightmenu-->
{include file="`$common.foot_tpl`"}