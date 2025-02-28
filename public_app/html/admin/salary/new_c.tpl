{include file="`$common.head_tpl`"}
<!--rightmenu-->
<div id="rightm">
  <h2>{$param.title|escape}/Salary confirmation</h2>
  <p>If you are satisfied with the following contents, please click the "Confirm >>" button.</p>
  <ul id="main">
    <li>
{include file="confirm.tpl"}
    </li>
  </ul>
  <div id="pt">
    <input type="button" name="back" value="<< Back" class="formbtn" onclick="return submitfrm('salary.php', 'new', 'back');" style="float:left;" />
    <input type="button" name="confirm" value="Confirm >>" class="formbtn"  onclick="return submitfrm('salary.php', 'new', 'update');" />
  </div>
  <br />
  <div id="pt">
    <a href="#top">▲Go back to the top of this page</a>
  </div>
</div>
<!--/rightmenu-->
{include file="`$common.foot_tpl`"}