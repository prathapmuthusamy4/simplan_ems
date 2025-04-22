{include file="`$common.head_tpl`"}
<!--rightmenu-->
<div id="rightm">
  <h2>{$param.title|escape}変更完了</h2>
  <p>{$param.title|escape}の変更が完了いたしました。</p>
  <div id="pt">
    <input type="button" name="confirm" value="一覧へ戻る >>" class="formbtn"  onclick="return submitfrm('files.php', 'list', 'reload');" />
  </div>
  <br />
  <div class="blankheight300"></div>
  <div id="pt">
    <a href="#top">▲このページの先頭へもどる</a>
  </div>
</div>
<!--/rightmenu-->
{include file="`$common.foot_tpl`"}