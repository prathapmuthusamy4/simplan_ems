<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.permision_info.php
 * Type:     modifier
 * Name:     permision_value
 * Purpose:  パーミッション情報を完全な形で表示する
 *
 *  @param  array   $list    リスト
 *  @param  string  $value   現在値
 * -------------------------------------------------------------
 */
function smarty_modifier_permision_info($string)
{
    $info = "";

    if (($string & 0xC000) == 0xC000) {
        // ソケット
        $info = 's';
    } elseif (($string & 0xA000) == 0xA000) {
        // シンボリックリンク
        $info = 'l';
    } elseif (($string & 0x8000) == 0x8000) {
        // 通常のファイル
        $info = '-';
    } elseif (($string & 0x6000) == 0x6000) {
        // ブロックスペシャルファイル
        $info = 'b';
    } elseif (($string & 0x4000) == 0x4000) {
        // ディレクトリ
        $info = 'd';
    } elseif (($string & 0x2000) == 0x2000) {
        // キャラクタスペシャルファイル
        $info = 'c';
    } elseif (($string & 0x1000) == 0x1000) {
        // FIFO パイプ
        $info = 'p';
    } else {
        // 不明
        $info = 'u';
    }

    // 所有者
    $info .= (($string & 0x0100) ? 'r' : '-');
    $info .= (($string & 0x0080) ? 'w' : '-');
    $info .= (($string & 0x0040) ?
              (($string & 0x0800) ? 's' : 'x' ) :
              (($string & 0x0800) ? 'S' : '-'));

    // グループ
    $info .= (($string & 0x0020) ? 'r' : '-');
    $info .= (($string & 0x0010) ? 'w' : '-');
    $info .= (($string & 0x0008) ?
              (($string & 0x0400) ? 's' : 'x' ) :
              (($string & 0x0400) ? 'S' : '-'));

    // 全体
    $info .= (($string & 0x0004) ? 'r' : '-');
    $info .= (($string & 0x0002) ? 'w' : '-');
    $info .= (($string & 0x0001) ?
              (($string & 0x0200) ? 't' : 'x' ) :
              (($string & 0x0200) ? 'T' : '-'));

    return $info;

}
/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>