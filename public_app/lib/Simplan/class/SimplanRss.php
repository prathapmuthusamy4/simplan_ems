<?php
/**
 *  SimplanRss
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license    
 * @package    Simplan
 * @version    1.0
 */
class SimplanRss
{
    /* site ini */
    protected $obj;

    /* rss ini */
    protected $ini;

    /* rss object */
    protected $rss;

    /**
     * コンストラクタ
     *
     * @access    public
     * @param     object   $obj   site ini
     */
    function __construct($obj)
    {
        // init
        $this->obj = $obj;
        $this->ini = $this->rss_ini();
        $this->rss = new UniversalFeedCreator(); 
    }

    /**
     * RSS INI
     *
     * @return   array   $ini
     */
    function rss_ini()
    {
        // site ini
        $base = $this->obj->getSection("BASE");
        $url  = dirname(t_this_url());
        // rss ini
        $ini = array(
                     'rss_title'             => "新着情報 - {$base['system_name']} - {$base['name']}",
                     'rss_link'              => "{$url}/index.php",
                     'rss_description'       => "{$base['system_name']} 新着情報です。",
                     'rss_image_title'       => "{$base['system_name']}",
                     'rss_image_url'         => "{$url}/img/common/logo.png",
                     'rss_image_link'        => "{$url}/",
                     'rss_image_description' => "{$base['meta_description']}",
                     'rss_item_link'         => "{$url}/news.php",
                     'rss_item_author'       => "{$base['system_name']}{$base['subname']}",
                     'rss_item_source'       => "{$url}/index.php",
                     );

        return $ini;
    }

    /**
     * Rssを生成する。
     *
     * @param   array   $list
     */
    function make_rss($list)
    {
        // make rss
        $this->rss->useCached(); // use cached version if age<1 hour
        $this->rss->title       = $this->ini['rss_title'];
        $this->rss->description = $this->ini['rss_description']; 

        //optional
        $this->rss->descriptionTruncSize = 500;
        $this->rss->descriptionHtmlSyndicated = true;
        $this->rss->syndicationURL = $this->ini['rss_link'];

        $image = new FeedImage(); 
        $image->title       = $this->ini['rss_image_title']; 
        $image->url         = $this->ini['rss_image_url'];
        $image->link        = $this->ini['rss_image_link'];
        $image->description = $this->ini['rss_image_description'];
        //optional
        $image->descriptionTruncSize = 500;
        $image->descriptionHtmlSyndicated = true;
        $this->rss->image = $image; 

        // news
        foreach ($list as $k => $v) {
            $item = new FeedItem(); 
            $item->title       = $v['title'];
            $item->link        = $this->ini['rss_item_link'] . "?prc=detail&sid={$v['id']}";
            $item->description = $v['content'];
            //optional
            $item->descriptionTruncSize = 500;
            $item->descriptionHtmlSyndicated = true;
            $item->date   = $v['date'] . "T00:00:00+09:00";
            $item->source = $this->ini['rss_item_source'];
            $item->author = $this->ini['rss_item_author'];
            $this->rss->addItem($item);
        }
    }

    /**
     * デストラクタ
     *
     * @access    public
     */   
    function __destruct()
    {
        // output rss
        $type = "RSS2.0";
        $feed = $this->rss->createFeed($type);
        echo ($feed);
    }
}
?>