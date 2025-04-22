{include file="`$common.head_tpl`"}
{include file="`$common.menu_tpl`"}

      <!--rightmenu-->
      <div id="rightm">
        <h2><!--{$APP_NAME}-->管理　登録完了</h2>
        <p><!--{$APP_NAME}-->の登録が完了いたしました。
        </p>
        <br />
        <div id="pt">
          <input type="button" name="confirm" value="一覧へ戻る &gt;&gt;" class="formbtn"  onclick="return submitfrm('<!--{$pg_name}-->.php', 'list', 'reload')"/>
        </div>
        <br />
        <div id="pt">
          <a href="#">▲このページの先頭へもどる</a>
        </div>
        <div class="blankheight300"></div>
      </div>
      <!--/rightmenu-->

{include file="`$common.foot_tpl`"}
