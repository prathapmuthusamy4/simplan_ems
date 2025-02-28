{include file="`$common.head_tpl`"}
<!--rightmenu-->
<div id="rightm">
  <h2>{$param.title|escape}Edit Confirm</h2>
  <ul id="main">
    <li>
{include file="confirm.tpl"}
    </li>
  </ul>
  <div id="pt">
    <input type="button" name="back" value="<< Back Edit" class="formbtn" onclick="return submitfrm('attendance.php', 'edit', 'back');" style="float:left;" />
    <input type="button" name="confirm" value="Regist >>" class="formbtn"  onclick="return submitfrm('attendance.php', 'edit', 'update');" />
  </div>
  <br />
  <div id="pt">
    <a href="#top">▲Go back to the top page</a>
  </div>
</div>
<!--/rightmenu-->
{include file="`$common.foot_tpl`"}