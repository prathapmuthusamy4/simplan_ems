<?php
// URL Dirctory
define('URL_DIR', dirname(__FILE__));

// Current Directory
include_once(dirname(dirname(__FILE__)) . "/controll.php");

/** DISPの指定 通常は未使用 テンプレートを修正する場合等に利用 **/
define('DISP_DIR', HTML_DIR);

?>