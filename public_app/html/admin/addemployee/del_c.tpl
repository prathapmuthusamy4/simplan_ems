{include file="`$common.head_tpl`"}
<!--rightmenu-->
<div id="rightm">
  <h2>{$param.title|escape}/Delete confirmation</h2>
  <p>To clear the following contents, click the " Confirm >>" button.</p>
  <ul id="main">
    <li>
{include file="confirm.tpl"}
    </li>
  </ul>
  <div id="pt">
    <input type="button" name="back" value="<< Back " class="formbtn" onclick="return submitfrm('addemployee.php', 'list', 'reload');" style="float:left;" />
    <input type="button" name="confirm" value="Confirm >>" class="formbtn"  onclick="return submitfrm('addemployee.php', 'del', 'delete');" />
  </div>
  <br />
  <div id="pt">
    <a href="#top">▲Go back to the top of this page</a>
  </div>
</div>
{include file="`$common.foot_tpl`"}