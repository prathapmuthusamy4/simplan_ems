<?php
/**
 *  SimplanSitemap
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license    
 * @package    Simplan
 * @version    1.0
 */
class SimplanSitemap
{
    /* sitemap.xml */
    protected $fsp;
    
    /**
     * コンストラクタ
     *
     * @access    public
     * @param     string   $sitemap   sitemap.xml
     */
    function __construct($sitemap)
    {
        // sitemap.xml open
        $this->fsp = fopen($sitemap, "w");
        // sitemap.xml header
        $xml  = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
        $xml .= "<url>\n";
        fputs($this->fsp, trim($xml));
        fputs($this->fsp, "\r\n");
    }

    /**
     * sitemap.xmlを動的に作成する
     *
     * @access    public
     * @param     array    $list   urlリスト
     */   
    function sitemap_xml($list)
    {
        // sitemap.xml main
        foreach ($list as $var) {
            foreach ($var as $tag => $val) {
                $xml = " <{$tag}>{$val}</{$tag}>";
                fputs($this->fsp, trim($xml));
                fputs($this->fsp, "\r\n");
            }
        }
    }

    /**
     * デストラクタ
     *
     * @access    public
     */   
    function __destruct()
    {
        // sitemap.xml footer
        $xml = "</url>\n</urlset>";
        fputs($this->fsp, trim($xml));
        fputs($this->fsp, "\r\n");
        fclose($this->fsp);
    }
}
?>