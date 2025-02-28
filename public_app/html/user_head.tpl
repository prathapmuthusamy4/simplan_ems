<!doctype html>
<html>
  <head>
  <meta charset="utf-8" />
  <title>{$common.system_name|escape}</title>
  <link href="./css/layout.css?{$smarty.now}" rel="stylesheet" type="text/css" media="all" />
  <link href="./css/dropdown.css" rel="stylesheet" type="text/css" />
  <script language="JavaScript" src="./js/com.js?{$smarty.now}" type="text/JavaScript" charset="UTF-8"></script>
  <script language="JavaScript" src="./js/dropdown.js" type="text/JavaScript" charset="UTF-8"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="./js/jquery.jclock-1.2.0.js.txt" type="text/javascript"></script>
</head>
<body>
<form name="mainfrm" id="mainfrm" action="" method="post" enctype="multipart/form-data">
{include file="../jquery_head.tpl"}
<input type="hidden" name="prc" />
<input type="hidden" name="cmd" />
<input type="hidden" name="sid" />
<input type="hidden" name="pno" />
  <div id="topwrap">
    <!--default start-->
    <!--header-->
    <div id="header" style="margin:10px 0px 0px 0px;">
      <div id="headerleft">
        <a href="index.php"><img src="img/logo.png" alt="{$common.system_name|escape}～{$common.name|escape}～" title="{$common.system_name|escape}～{$common.name|escape}～" width="100" /></a>
      </div>
      <div id="headerright">
        <p>
          {$smarty.now|date_format:"%Y/%m/%d (%a)"}&nbsp;
          <span class="jclock"></span>
        </p>
        <p>
          <a href="index.php?cmd=logout" style="text-decoration: none;">
            <img src="img/logout.png" alt="logout" title="logout" width="100" height="36" />
          </a>
        </p>
      </div>
    <div id="cc"></div>
    {include file="`$common.menu_tpl`"}
    </div>
    <div id="cc"></div>
    <!--maindefault-->
    <div id="mainstage">
