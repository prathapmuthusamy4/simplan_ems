{include file="`$common.head_tpl`"}
{include file="`$common.menu_tpl`"}

      <!--rightmenu-->
      <div id="rightm">
        <h2><!--{$APP_NAME}-->管理　登録確認</h2>
        <p>以下の内容でよろしければ「登録実行 &gt;&gt;」を押下して下さい。
        </p>
        <ul id="main">
          <li>

{include file="confirm.tpl"}

          </li>
        </ul>
        <div id="pt">
          <input type="button" name="back" value="&lt;&lt;入力内容修正" class="formbtn" onclick="return submitfrm('<!--{$pg_name}-->.php', 'new', 'back')" />
          <input type="button" name="confirm" value="登録実行 &gt;&gt;" class="formbtn"  onclick="return submitfrm('<!--{$pg_name}-->.php', 'new', 'regist')"/>
        </div>
        <br />
        <div id="pt">
          <a href="#">▲このページの先頭へもどる</a>
        </div>
      </div>
      <!--/rightmenu-->

{include file="`$common.foot_tpl`"}
