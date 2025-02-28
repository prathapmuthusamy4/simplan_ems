<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>パスワード再発行 | {$common.system_name|escape}</title>
    <link href="css/layout.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="./js/com.js" type="text/JavaScript"></script>
  </head>
<body>
<form name="mainfrm" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="prc" />
<input type="hidden" name="cmd" />
<div id="topwrap">
  <!--default start-->
  <!--header-->
  <div id="header" style="margin-top:10px;">
    <img src="img/logo.gif" alt="{$common.system_name|escape}～{$common.name|escape}～" width="356" />
  </div>
  <div id="cc"></div>
  <!--maindefault-->
  <div id="mainstaget">
    <h3>SAMPLE</h3>
    <div id="logs">
      <p align="center"> パスワードの再設定を行いました。</p><br /><br /><br />
      <table width="500"  border="0" cellspacing="0" cellpadding="3">
        <tr>
          <td width="100%" align="center">
            <a href="javascript:void(0);" onclick="return submitfrm('index.php', '', '');" >
              <img src="img/go_login.gif" alt="ログイン画面へ" title="ログイン画面へ" width="140" height="30" />
            </a>
          </td>
        </tr>
      </table>
      <h4>
      </h4>
    </div>
    <!--maindefault end-->
  </div>
  <!--css reset-->
  <div id="cc"></div>
  <!--footer-->
  <div id="footer">
    <p align="right">Copyrights &copy; {$smarty.now|date_format:'%Y'} {$common.name_en} All Right Reserved</p>
    <p align="right">{$common.system_name|escape}&nbsp;Version&nbsp;{$common.system_version|escape}</p>
    <p align="right">{$common.simplan_logo}</p>
  </div>
  <!--default end-->
</div>
</form>
</body>
</html>