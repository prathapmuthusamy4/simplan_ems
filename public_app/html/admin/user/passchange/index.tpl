<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>SAMPLE| {$common.system_name|escape}</title>
    <link href="css/layout.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="./js/com.js?{$smarty.now}" type="text/JavaScript" charset="UTF-8"></script>
    <script language="JavaScript" src="./js/jquery.js?{$smarty.now}" type="text/JavaScript" charset="UTF-8"></script>
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
    <h3>SAMPLE USER PASSWORD</h3>
    <div id="logs">
              <div class="container">
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <div class="login-panel panel panel-default">
                            <div class="panel-heading">
                                {* <h3 class="panel-title"><img src="./img/logo.png" class="img-responsive" alt=""></h3> *}
                            </div>
                            <div class="panel-body">
                                {if !is_empty($param.errmsg.f_id)}
                                    {$param.errmsg.f_id|admin_err}
                                {else}
                                    <label>パスワードの変更</label>
                                    <div class="form-group">
                                        <input class="formstb_350" placeholder="パスワード" name="f_password" type="password" value="{$param.f_password|escape}" autofocus>
                                        {$param.errmsg.f_password|admin_err}
                                    </div>
                                    <div class="form-group">
                                        <input class="formstb_350" placeholder="パスワード確認" name="f_password_conf" type="password" value="{$param.f_password_conf|escape}" autofocus>
                                        {$param.errmsg.f_password_conf|admin_err}
                                    </div>
                                    <a href="javascript:void(0);" class="btn btn-lg btn-success btn-block" onclick="return submitfrm('passchange.php', 'index', 'update');"> <img src="img/reissue.gif" alt="送信" title="送信" width="140" height="30" /></a>

                                {/if}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <h4>
      </h4>
    </div>
    <!--maindefault end-->
  </div>
  <!--css reset-->
  <div id="cc"></div>
  <!--footer-->
  <div id="footer">
    <p align="right">Copyrights &copy; {$smarty.now|date_format:'%Y'} {$common.name_en}. All Right Reserved</p>
    <p align="right">{$common.system_name|escape}&nbsp;Version&nbsp;{$common.system_version|escape}</p>
    <p align="right">{$common.simplan_logo}</p>
  </div>
  <!--default end-->
</div>
</form>
</body>
</html>