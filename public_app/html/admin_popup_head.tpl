<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta http-equiv="Content-Language" content="ja" />
  <title>{if isset($param.title)}{$param.title|escape} | {/if}{$common.system_name|escape} Management screen</title>
  <link href="./css/layout.css?{$smarty.now}" rel="stylesheet" type="text/css" media="all" charset="UTF-8" />
  <script language="javascript" src="./js/com.js?{$smarty.now}" type="text/javascript" charset="UTF-8"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
</head>
<body>
<form name="mainfrm" id="mainfrm" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="prc" />
<input type="hidden" name="cmd" />
<input type="hidden" name="sid" />
<input type="hidden" name="pno" />
<div id="popupwrap">
<a name="top"></a>