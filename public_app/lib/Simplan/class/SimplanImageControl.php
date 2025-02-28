<?php
/**
 * Simplan FW - PHP Web Application Framework
 *
 * Copyright(c) 2003-2010 THREET CO.,LTD. All Rights Reserved.
 *
 * http://www.threet.co.jp
 * http://www.simplan.jp
 *
 * PHP versions 4 and 5
 *
 * LICENSE: 
 * 
 * 
 * 
 * 
 *
 * @author     Toru Yoshikawa <t-yoshikawa@threet.co.jp>
 * @license
 * @package    Simplan
 * @copyright  2003-2010 The Simplan Project by THREET CO.,LTD.
 * @version    $Id: $
 */

/**
 * 画像処理クラス
 *
 * [note] PHPにGDのモジュールの組み込みが必要
 *
 * @author     Toru Yoshikawa <t-yoshikawa@threet.co.jp>
 * @access     public
 * @package    Simplan
 */
class SimplanImageControl
{

    //*** 変数宣言 ***//
    var $originalImgPath;
    var $arrangeImgPath;
    var $newWidth;
    var $newHeight;
    var $arrangeMode;
    var $spreadImg;
    var $imgQuality = 80;

    /**
     * コンストラクタ
     * [note] mode: WIDTH  ：横幅を基準にサイズ調整
     *            : HEIGHT ：高さを基準にサイズ調整
     *            : CERTAIN：横幅、高さの比率を無視
     *            : AUTO   ：自動調整（サイズの大きい方を基準に縮小）
     *        expansion : 拡大ON・OFFフラグ
     * 
     * @access public
     * @param string $srcFileName
     * @param string $destFileName
     * @param int $width
     * @param int height
     * @param string $mode
     * @param boolean $expansion
     * @return void
     */
    function SimplanImageControl ($srcFileName, $destFileName, $width, $height, $mode = 'WIDTH', $expansion = FALSE)
    {
        // 元ファイル有無チェック
        if (!file_exists($srcFileName)) {
            //エラー処理
        }
        $this->originalImgPath  = $srcFileName;
        $this->arrangeImgPath   = $destFileName;
        $this->newWidth         = $width;
        $this->newHeight        = $height;
        $this->arrangeMode      = $mode;
        $this->spreadImg        = $expansion;

        return;
    }

    /**
     * 画像生成
     *
     * @access public
     * @return void
     */
    function createImage()
    {
        //拡張子の取得
        $fileName = basename($this->originalImgPath);
        list($name, $extention) = explode(".", $fileName);

        /*--------------------*
         * 画像ファイルの読み込み
         *--------------------*/
        switch (strtolower($extention)) {
            case 'jpg':     //JPEGファイルの読み込み
            case 'jpeg':
                $im = ImageCreateFromJPEG($this->originalImgPath);
                break;
            case 'gif':     //GIFファイルの読み込み
                $im = ImageCreateFromGIF($this->originalImgPath);
                break;
            case 'png':     //PNGファイルの読み込み
                $im = ImageCreateFromPNG($this->originalImgPath);
                break;
        }
        $oldWidth   = ImageSX($im); //画像の横幅サイズを取得
        $oldHeight  = ImageSY($im); //画像の高さサイズを取得

        /*--------------------*
         * モード別に画像の縮小率を算出
         *--------------------*/
        switch ($this->arrangeMode) {
            case 'WIDTH':           //横幅を基準に調整
                $percentX = (float)($this->newWidth / $oldWidth) * 100;
                $percentY = $percentX;
                break;
            case 'HEIGHT':          //高さを基準に調整
                $percentY = (float)($this->newHeight / $oldHeight) * 100;
                $percentX = $percentY;
                break;
            case 'CERTAIN':         //絶対指定調整
                $percentX = (float)($this->newWidth / $oldWidth) * 100;
                $percentY = (float)($this->newHeight / $oldHeight) * 100;
                 break;
/*
            case 'AUTO':            //自動調整
                if ($oldWidth > $oldHeight) {       //横幅で調整
                    $percentX = (float)($this->newWidth / $oldWidth) * 100;
                    $percentY = $percentX;
                } else {                            //高さで調整
                    $percentY = (float)($this->newHeight / $oldHeight) * 100;
                    $percentX = $percentY;
                }
                break;
*/
            case 'AUTO':         //自動調整
                if ($this->newWidth < $oldWidth || $this->newHeight < $oldHeight) {
                    if (($this->newWidth / $oldWidth) < ($this->newHeight / $oldHeight)) {
                        $percentX = (float)($this->newWidth / $oldWidth) * 100;
                        $percentY = $percentX;
                    } else {
                        $percentY = (float)($this->newHeight / $oldHeight) * 100;
                        $percentX = $percentY;
                    }
                } else {
                    $percentX = 100;
                    $percentY = 100;
                }
                break;
            default:
                return FALSE;
        }

        /*--------------------*
         * 拡大フラグがOFFの時で、オリジナルサイズより大きくなる時100%に補正する
         *--------------------*/
        if ($this->spreadImg === FALSE) {
            if ($percentX > 100 || $percentY > 100) {
                $percentX = 100;
                $percentY = 100;
            }
        }

        /*--------------------*
         * 縮小後の縦横サイズを算出後、縮小する
         *--------------------*/
        $newWidth   = floor($oldWidth * $percentX / 100);
        $newHeight  = floor($oldHeight * $percentY / 100);

        $newIm = ImageCreateTrueColor($newWidth, $newHeight);
        ImageCopyResampled($newIm, $im, 0, 0, 0, 0, $newWidth, $newHeight, $oldWidth, $oldHeight);

        /*--------------------*
         * 拡張子別にファイルを出力する
         *--------------------*/
        switch (strtolower($extention)) {
            case 'jpg':     //JPEGファイル出力
            case 'jpeg':
                if (function_exists('imageJpeg')) {
                    ImageJPEG( $newIm, $this->arrangeImgPath, $this->imgQuality );
                }
                break;
            case 'gif':     //GIFファイル出力
                if (function_exists('imagegif')) {
                    ImageGIF( $newIm, $this->arrangeImgPath );
                } else {
                    ImageJPEG( $newIm, $this->arrangeImgPath, $this->imgQuality );
                }
                break;
            case 'png':     //PNGファイル出力
                $im = ImageCreateFromPNG($this->originalImgPath);
                if(function_exists("imagePng")) {
                    ImagePNG($newIm, $this->arrangeImgPath);
                } else {
                    ImageJPEG($newIm, $this->arrangeImgPath, $this->imgQuality);
                }
                break;
        }

        ImageDestroy($im);
        ImageDestroy($newIm);

        return;
    }
}
?>