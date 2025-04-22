{include file="`$common.head_tpl`"}
<!--rightmenu-->
<div id="rightm">
  <h2>Attendance</h2>
  <p><span class="must">※</span>&nbsp;Required</p>
  <ul id="main">
    <li>
      {if ($param.list_count.count > 0)}
        <p style="color:red; font-weight: bold; text-align: center;">Today Attendance Already Registered!</p>
      {else}
        {include file="input.tpl"}
        <div id="pt">
          <input type="button" name="confirm" value="Confirm >>" class="formbtn"  onclick="return submitfrm('attendance.php', 'new', 'confirm');" />
        </div>
        <br />
      {/if}
    </li>
  </ul>
</div>
<!--/rightmenu-->
{include file="`$common.foot_tpl`"}
