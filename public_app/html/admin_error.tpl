{include file="`$common.head_tpl`"}
<!--rightmenu-->
<div id="rightm">
  <h2>{$param.content} error</h2>
  <p></p>
  <ul id="main">
    <li><font color="#CC0000">{$param.message}</font></li>
  </ul>
  <div id="pt">
    <input type="button" name="confirm" value="{$param.name}back to >>" class="formbtn_l"  onclick="return submitfrm('{$param.url}','{$param.process}','{$param.cmd}')"/>
  </div>
  <div class="blankheight300"></div>
</div>
{include file="`$common.foot_tpl`"}