{include file="`$common.head_tpl`"}
<!--rightmenu-->
<div id="rightm">
  <h2>{$param.title|escape}/Detail</h2>
  {*<p>If you are satisfied with the following contents, please click the "To the completion screen >>" button.</p>*}
  <ul id="main">
    <li>
{include file="confirm.tpl"}
    </li>
  </ul>
  <div id="pt">
    <input type="button" name="back" value="<< Back " class="formbtn" onclick="return submitfrm('addemployee.php', 'list', 'back');" style="float:left;" />
  </div>
  <br />
  <div id="pt">
    <a href="#top">▲Go back to the top of this page</a>
  </div>
</div>
<!--/rightmenu-->
{include file="`$common.foot_tpl`"}