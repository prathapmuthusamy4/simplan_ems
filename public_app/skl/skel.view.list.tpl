{include file="`$common.head_tpl`"}
{include file="`$common.menu_tpl`"}

      <!--rightmenu-->
      <div id="rightm">
        <h2><!--{$APP_NAME}-->管理　検索・一覧</h2>
        <p>
        </p>
        <ul id="main">
          <li>
            <h3><img src="./img/sq3.gif" width="12" height="12" align="absmiddle" />
              <!--{$APP_NAME}-->検索
              <img src="./img/sq3.gif" width="12" height="12" align="absmiddle" />
            </h3>
            <table width="660"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
              {** 
              <tr valign="top" bgcolor="#FFFFFF">
                <td width="25%" valign="middle"><h4><a href="#">タイトル</a></h4></td>
                <td width="75%" valign="middle" bgcolor="#FFFFCC">
                  <input name="f_information_title" type="text" class="formstb" value="{$param.f_information_title}" />
                  {$param.errmsg.f_information_title|admin_err}
                </td>
              </tr>
              **}
            </table>
           <div id="pt">
             <input type="button" class="formbtn" onClick="return submitfrm('<!--{$pg_name}-->.php', 'list', 'search');" value="検索"/>
           </div>
          </li>
          <li>
            <h3><img src="./img/sq3.gif" width="12" height="12" align="absmiddle" />
              <!--{$APP_NAME}-->一覧
              <img src="./img/sq3.gif" width="12" height="12" align="absmiddle" /></h3>
            <p>{admin_page_navi info=$param.page_info}</p>
            <table width="660"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
              <tr align="center" valign="top" bgcolor="#FFFFCC">

<!--{foreach from=$Table_All_Field item="cur" name="current"}-->
                <td width="15%" valign="middle" class="tfextra"><!--{$cur.name}--></td>
<!--{/foreach}-->
                <td width="15%" valign="middle" class="tfextra">操　作</td>

              </tr>

              {foreach from=$param.list item="cur" name="current"}
              <tr valign="top" bgcolor="#FFFFFF">

<!--{foreach from=$Table_All_Field item="cur" name="current"}-->
                <td align="center" valign="middle" class="tfextrb">{$cur.<!--{$cur.id}-->}</td>
<!--{/foreach}-->

                <td align="center" valign="middle" class="tfextrb">
                  <input type="button" class="formstc" onClick="return selectfrm('<!--{$pg_name}-->.php', 'edit', '', '{$cur.f_<!--{$pg_name}-->_id}');" value="変更"/>
                  <input type="button" class="formstc" onClick="return selectfrm('<!--{$pg_name}-->.php', 'del',  'confirm', '{$cur.f_<!--{$pg_name}-->_id}');" value="削除" />
                </td>
              </tr>
              {foreachelse}
              <tr bgcolor="#FFFFFF">
                <td align="center" colspan="7" class="tfextrb" >該当するデータはありません。</td>
              </tr>
              {/foreach}
            </table>
            <p>{admin_page_feed info=$param.page_info process="list"}</p>
            <div id="pt">
              <input type="button" class="formstc" onClick="return submitfrm('<!--{$pg_name}-->.php', 'new', '');" value="新規登録"/>
            </div>
          </li>
        </ul>
        <div id="pt">
          <a href="#">▲このページの先頭へもどる</a>
        </div>
      </div>
      <!--/rightmenu-->

{include file="`$common.foot_tpl`"}
