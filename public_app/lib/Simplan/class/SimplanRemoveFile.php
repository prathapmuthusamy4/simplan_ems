<?php
//***************************************************************//
// ファイル削除クラス 
//***************************************************************//

/**
 *  SimplanRemoveFile Class
 *
 */
class SimplanRemoveFile
{
    /**
     *  ディレクトリ内のファイルを削除する。
     *
     *  @access public
     *  @param  string  $dir   ディレクトリ
     *  @param  string  $var   何日前
     *  @return boolean OK:true , NG:false
     */
    function removeFileTargetUpdTime($dir, $var = 1)
    {
        $success = false;

        // 対象日
        $target = date('Ymd', mktime(0, 0, 0, date('m'), date('d')-$var, date('Y')));

        // ディレクトリ内のファイルを削除
        if ($handle = opendir($dir)) {
            while (false !== ($name = readdir($handle))) {
                // ファイル名の作成
                $file = $dir . $name;
                if (is_file($file)) {
                    $mod = date('Ymd', filemtime($file));  // ファイル更新日時
                    // 対象日より古いファイルを削除
                    if ($target >= $mod) {
                        unlink($file);
                    }
                }
            }
            closedir($handle);
        } else {
            return $success;
        }

        return $success = true;
    }
}
?>