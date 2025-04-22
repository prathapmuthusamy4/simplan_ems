{include file="`$common.head_tpl`"}
<!--rightmenu-->
<div id="rightm">
  <h2>{$param.title|escape}詳細</h2>
  {*<p>以下の内容でよろしければ「完了画面へ >>」ボタンをクリックして下さい。</p>*}
  <ul id="main">
    <li>
{include file="confirm.tpl"}
    </li>
  </ul>
  <div id="pt">
    <input type="button" name="back" value="<< 一覧へ戻る" class="formbtn" onclick="return submitfrm('priya.php', 'list', 'reload');" style="float:left;" />
  </div>
  <br />
  <div id="pt">
    <a href="#top">▲このページの先頭へもどる</a>
  </div>
</div>
<!--/rightmenu-->
{include file="`$common.foot_tpl`"}