{include file="`$common.head_tpl`"}
{include file="`$common.menu_tpl`"}

      <!--rightmenu-->
      <div id="rightm">
        <h2><!--{$APP_NAME}-->管理　新規登録</h2>
        <p><span class="must">※</span>は必須項目です。
        </p>
        <ul id="main">
          <li>

{include file="input.tpl"}

          </li>
        </ul>
        <div id="pt">
          <input type="button" name="back" value="&lt;&lt; 一覧へ戻る" class="formbtn" onclick="return submitfrm('<!--{$pg_name}-->.php', 'list', 'reload')" />
          <input type="button" name="confirm" value="確認画面へ &gt;&gt;" class="formbtn"  onclick="return submitfrm('<!--{$pg_name}-->.php', 'new', 'confirm')"/>
        </div>
        <br />
        <div id="pt">
          <a href="#">▲このページの先頭へもどる</a>
        </div>
      </div>
      <!--/rightmenu-->

{include file="`$common.foot_tpl`"}
