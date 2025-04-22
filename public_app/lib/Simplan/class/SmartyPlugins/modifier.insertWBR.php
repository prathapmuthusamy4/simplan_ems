<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.insertWBR.php
 * Type:     modifier
 * Name:     insertWBR
 * Purpose:  Firefox用にWBRタグを挿入する
 *
 *
 *  sample:
 *  <code>
 *  {"日本語です"|insertWBR"}
 *  </code>
 *  <code>
 *  日本語...
 *  </code>
 *
 *  @param  string  $string  対象文字列
 *  @return string  $string  挿入文字列を代入した対象文字列
 * -------------------------------------------------------------
 */
function smarty_modifier_insertWBR($string) {
    if ($string === "" || $string == null) {
        return "";
    }
    
    $str = '';
    for ($i = 0; $i < mb_strlen($string, 'UTF-8'); $i++) {
      $c = mb_substr($string, $i, 1, 'UTF-8');
      $str .= $c;
      if ($c == '&') {
        $p = mb_strpos($string, ';', $i, 'UTF-8');
        if ($p !== FALSE) {
          $str .= mb_substr($string, $i + 1, $p - $i, 'UTF-8');
          $i = $p;
          continue;
        }
      }
      if (!preg_match("/[\r\n]/", $c)) {
        $str .= '<wbr>';
      }
    }
    
    return $str;
}
?>
