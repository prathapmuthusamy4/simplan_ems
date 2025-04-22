{include file="`$common.head_tpl`"}
{include file="`$common.menu_tpl`"}

      <!--rightmenu-->
      <div id="rightm">
        <h2><!--{$APP_NAME}-->管理　削除確認</h2>
        <p>以下の内容を消去するには、「削除実行 &gt;&gt;」を押下して下さい。
        </p>
        <ul id="main">
          <li>

{include file="confirm.tpl"}

          </li>
        </ul>
        <div id="pt">
          <input type="button" name="back" value="&lt;&lt; 一覧へ戻る" class="formbtn" onclick="return submitfrm('<!--{$pg_name}-->.php', 'list', 'reload')" />
          <input type="button" name="confirm" value="削除実行 &gt;&gt;" class="formbtn"  onclick="return submitfrm('<!--{$pg_name}-->.php', 'del', 'delete')"/>
        </div>
        <br />
        <div id="pt">
          <a href="#">▲このページの先頭へもどる</a>
        </div>
      </div>

{include file="`$common.foot_tpl`"}
