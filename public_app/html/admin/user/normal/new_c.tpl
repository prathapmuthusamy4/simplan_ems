{include file="`$common.head_tpl`"}
<!--rightmenu-->
<div id="rightm">
  <h2>{$param.title|escape}新規登録確認</h2>
  <p>以下の内容でよろしければ「完了画面へ >>」ボタンをクリックして下さい。</p>
  <ul id="main">
    <li>
{include file="confirm.tpl"}
    </li>
  </ul>
  <div id="pt">
    <input type="button" name="back" value="<< 入力画面へ" class="formbtn" onclick="return submitfrm('normal.php', 'new', 'back');" style="float:left;" />
    <input type="button" name="confirm" value="完了画面へ >>" class="formbtn"  onclick="return submitfrm('normal.php', 'new', 'regist');" />
  </div>
  <br />
  <div id="pt">
    <a href="#top">▲このページの先頭へもどる</a>
  </div>
</div>
<!--/rightmenu-->
{include file="`$common.foot_tpl`"}