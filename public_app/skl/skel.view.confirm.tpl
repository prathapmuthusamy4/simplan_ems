<!-- Confirm -->

            <h3><img src="./img/sq3.gif" width="12" height="12" align="absmiddle" />
              <!--{$APP_NAME}-->
              <img src="./img/sq3.gif" width="12" height="12" align="absmiddle" />
            </h3>
            <table width="660"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
<!--{foreach from=$Table_All_Field item="cur" name="current"}-->
              <tr valign="top" bgcolor="#FFFFFF">
                <td width="25%" valign="middle" class="tdcls1"><span class="cap1"><!--{$cur.name}--></span><span class="must">※</span></td>
                <td width="75%" valign="middle" class="tdcls2">
                  {$param.<!--{$cur.id}-->}&nbsp;
                </td>
              </tr>
<!--{/foreach}-->
            </table>

<!-- /Confirm -->
