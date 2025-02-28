{include file="`$common.head_tpl`"}
<!--rightmenu-->
<div id="rightm">
  <h2>{$param.title|escape}/Change completed</h2>
  <p>{$param.title|escape} has been changed.</p>
  <div id="pt">
    <input type="button" name="confirm" value="Back >>" class="formbtn"  onclick="return submitfrm('salary.php', 'list', '');" />
  </div>
  <br />
  <div class="blankheight300"></div>
  <div id="pt">
    <a href="#top">▲Go back to the top of this page</a>
  </div>
</div>
<!--/rightmenu-->
{include file="`$common.foot_tpl`"}