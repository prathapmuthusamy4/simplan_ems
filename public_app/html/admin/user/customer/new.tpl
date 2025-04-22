{include file="`$common.head_tpl`"}
<!--rightmenu-->
<div id="rightm">
  <h2>{$param.title|escape}New Register</h2>
  <p><span class="must">※</span>&nbsp;Required</p>
  <ul id="main">
    <li>
{include file="input.tpl"}
    </li>
  </ul>
  <div id="pt">
    <input type="button" name="back" value="<< 一覧へ戻る" class="formbtn" onclick="return submitfrm('customer.php', 'list', 'reload');" style="float:left;" />
    <input type="button" name="confirm" value="確認画面へ >>" class="formbtn"  onclick="return submitfrm('customer.php', 'new', 'confirm');" />
  </div>
  <br />
  <div id="pt">
    <a href="#top">▲このページの先頭へもどる</a>
  </div>
</div>
<!--/rightmenu-->
{include file="`$common.foot_tpl`"}