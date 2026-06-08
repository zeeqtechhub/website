<?php

define("DEV_PATH", substr_count(($_SERVER['SCRIPT_NAME'] ?? $_SERVER['PHP_SELF']), "ecommerce") > 0 ? '/ecommerce/' : ((substr_count(($_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME']), "localhost") || substr_count(($_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME']), "192.168.")) ? '/ecommerce/' : "/"));

/**
 * This File contains necessary class definitions e.t.c.
 */
class App {
    private static $instance;

    //app instance
    /**
     * Global Configurations
     */
    public $db;
    public $config = array();

    public $title = "";
    public $pageTitle = "";

    public $pageHeading = "";
    public $pageBannerImg = "";
    public $noMenu = false;
    public $noBanner = false;
    public $hasSlide = false;

    //page title
    public $keywords = "";
    public $description = "";
    public $metaTags = array();

    public $userid;

    //database object
    public $user;

    public $segments = array();
    public $plugins = array();
    public $queryCounts = 0;
    private $assets = array('css' => array(), 'js' => array());

    /**
     * Constructor
     */
    public function __construct() {

    }

    /**
     * Method to get the instance of app class
     */
    public static function getInstance() {
        if(static::$instance == null) {
            static::$instance = new App();
        }
        return static::$instance;
    }

    /**
     * Main application runner
     */
    public function run() {

        $this->config = include(__DIR__."/config.php");

        $this->config['base_url'] = getRoot();

        $this->config['cookie_path'] = getBase();

        stream_context_set_default(array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
            ),
        ));

        //load the admin settings
        $settings = array();
        $this->config = array_merge($this->config, $settings);

        $this->keywords = config('site-keywords');
        $this->description = config('site-description');

        $this->getUri();
        $ip_filters = preg_replace('/\s+/', '', config('ban_filters_ip', ''));
        if(segment(0) != 'admincp') {
            $ip = get_ip();
            if($ip_filters) {
                $ip_filters = explode(',', $ip_filters);
                foreach($ip_filters as $ip_filter) {
                    $regex = '/'.str_replace(' ', '.*?', preg_quote(str_replace('*', ' ', $ip_filter), '/')).'/i';
                    if(preg_match($regex, $ip)) {
                        exit("The IP addresss is banned");
                    }
                }
            }
        }

        //set admin selected language
        //set the default timezone by admin
        $timezone = (isset($_COOKIE['timezone']) && $_COOKIE['timezone'] ? $_COOKIE['timezone'] : $this->config('timezone', 'UTC'));
        date_default_timezone_set($timezone);

        $this->config['months'] = array(
            'january' => "January",
            'february' => "February",
            'march' => "March",
            'april' => "April",
            'may' => "May",
            'june' => "June",
            'july' => "July",
            'august' => "August",
            'september' => "September",
            'october' => "October",
            'november' => "November",
            'december' => "December"
        );

        $url = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on" ? 'https' : strtolower(explode('/', $_SERVER["SERVER_PROTOCOL"])[0])).'://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        $this->setMetaTags(
            array(
                'name' => $this->config("site-title"),
                'title' => $this->title,
                'description' => $this->description,
                'keywords' => $this->keywords,
                'image' => (!config('site-logo')) ? img("images/logo.png") : url_img(config('site-logo')),
                'url' => $url,
                'item-type' => 'article',
                'og-type' => 'website',
                //'fb-app-id' => $app_id,
                'twitter-card' => 'summary_large_image',
                'twitter-site' => config('twitter-username'),
                'twitter-creator' => config('twitter-username'),
            )
        );

    }

    /**
     * Method get a value from the configurations array
     *
     * @var string $key
     * @var mixed $default
     * @return mixed
     */
    public function config($key, $default = "") {
        if(!isset($this->config[$key])) return $default;
        return $this->config[$key];
    }


    /**
     * Get the base path
     * @param string $path
     * @return string
     */
    public function path($path = "") {
        $path = $this->config("base-path").$path;
        return $path;
    }

    /**
     * Method to get uri
     */
    public function getUri() {
        $fullUrl = getFullUrl();
        $uri = str_replace(strtolower($this->url()), "", strtolower($fullUrl));
        if(!empty($uri)) $this->segments = explode('/', $uri);
        return $uri;
    }

    /**
     * Form a url with the base url making a full url
     * @param string $url
     * @return string
     */
    public function url($url = "", $check_secure = 2) {
        //if($url) $url = fire_hook("filter.url", $url);
        if(preg_match('#http\:\/\/|https\:\/\/#', $url)) {
            if($check_secure) {
                $a = parse_url($url);
                $b = parse_url(url('', false));
                if(isset($a['host']) && isset($b['host']) && ($a['host'] == $b['host'] || 2)) {
                    $url = isSecure() ? preg_replace('/^http\:\/\//i', 'https://', $url) : $url;
                }
            }
            return $url;
        }
        return $this->config("base_url").$url;
    }

    /**
     * get a value from segment
     * @param $index
     * @return mixed
     */
    public function segment($index, $default = null) {
        if(isset($this->segments[$index])) {
            return $this->segments[$index];
        }
        return $default;
    }

    /**
     * Detect if ssl is enabled or not
     * @return mixed
     */
    public function sslEnabled() {
        return $this->config("https", true) && (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? true : false;
    }

    /**
     * function to set the current page title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title = "") {
        $this->pageTitle = $title;
        $this->pageHeading = ($this->pageHeading) ? $this->pageHeading : $title; //this is used to get current page heading
        $this->title = $title.' '.$this->config('title-separator', "-").' '.$this->config("site-title", "Template");
        return $this;
    }

    public function setKeywords($keywords) {
        $this->keywords = $keywords;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * Method for getting an array of the HTML meta tags of the current page.
     *
     */
    public function getMetaTags() {
        return $this->metaTags;
    }

    /**
     * Method for updating the array containing the HTML meta tags of the current page.
     *
     */
    public function setMetaTags($new_meta_tags) {
        $this->metaTags = array_merge($this->metaTags, $new_meta_tags);
        return $this->metaTags;
    }

    /**
     * Method for rendering the array containing the HTML meta tags of the current page in HTML.
     *
     */
    public function renderMetaTags() {
        $meta_array = $this->metaTags;
        $html = "";
        foreach($meta_array as $type => $content) {
            if($type == 'title' && trim($content) == '') {
                $content = config('site-title');
            }
            if($type == 'description' AND config('site-description')) {
                $html .= trim($content) != '' ? "\n\t".'<meta name="description" content="'.$content.'" />'."\n\t".'<meta itemprop="description" content="'.$content.'" />' : '';
            }
            if($type == 'keywords' AND config('site-keywords')) {
                $html .= trim($content) != '' ? "\n\t".'<meta name="keywords" content="'.$content.'" />' : '';
            }

        }
        //$meta_appends = "\n\t".'<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />'."\n\t".'<meta http-equiv="X-UA-Compatible" content="IE=edge" />'."\n\t".'<meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0">';
        //return $meta_appends."\t".$html."\n";
        return $html."\n";
    }


    /**
     * @param $asset
     * @return string
     */
    public function getAssetLink($asset, $base = true) {
        $base = ($base) ? $this->config("base_url") : '';
        if(file_exists($asset)) return $asset;
        return $base.$asset;
    }

    protected function parseAssetsContent($asset, $type) {
        $realPath = path($asset);
        $content = file_get_contents($asset);
        // Remove comments.
        $content = preg_replace('!/\*.*?\*/!s', '', $content);
        $content = preg_replace('/^\s*\/\/(.+?)$/m', "\n", $content);

        if($type == 'css') {
            /**
             * parse url with ../../
             */
            $content = str_replace('../../', url($this->stripSegment($asset, 2)).'/', $content);

            /**
             * now do ../
             */
            $content = str_replace('../', url($this->stripSegment($asset, 1)).'/', $content);

            // Remove tabs, spaces, newlines, etc.
            $content = str_replace(array("\r\n", "\r", "\n", "\t"), '', $content);

            // Remove other spaces before/after.
            $content = preg_replace(array('(( )+{)', '({( )+)'), '{', $content);
            $content = preg_replace(array('(( )+})', '(}( )+)', '(;( )*})'), '}', $content);
            $content = preg_replace(array('(;( )+)', '(( )+;)'), ';', $content);
        }

        return ($type == 'css') ? $content : ';'.$content;
    }

    /**
     * Help function to strip segment from a path
     *
     * @param string $path
     * @param int $number
     * @return string
     */
    protected function stripSegment($path, $number) {
        $a = explode('/', $path);

        $i = count($a) - ($number + 1);

        $path = "";

        for($y = 0; $y < $i; $y++) {
            $path .= $a[$y].'/';
        }

        return $path;
    }
}
