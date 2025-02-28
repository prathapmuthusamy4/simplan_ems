{include file="`$common.head_tpl`"}
<!--rightmenu-->
<div id="rightm">
  <h2>{$param.title|escape} EditComplete</h2>
  <div id="pt">
    <input type="button" name="confirm" value="Goto List >>" class="formbtn"  onclick="return submitfrm('attendance.php', 'list', 'reload');" />
  </div>
  <br />
  <div class="blankheight300"></div>
  <div id="pt">
    <a href="#top">▲Go back to the top page</a>
  </div>
</div>
<!--/rightmenu-->
{include file="`$common.foot_tpl`"}