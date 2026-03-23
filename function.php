<?php
/**
 * Function to get the full url
 * @param bool $queryStr
 * @return string
 */
function getFullUrl($queryStr = false) {
    $host = (isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
    $isSecure = (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == "on") ? true : false;
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $queryString = (isset($_SERVER['QUERY_STRING'])) ? trim($_SERVER['QUERY_STRING'], '?') : null;
    $scheme = (App::getInstance()->sslEnabled()) ? "https://" : "http://";
    //$scheme = ($isSecure) ? "https://" : "http://";
    $fullUrl = $scheme.$host.$uri;
    return $fullUrl = ($queryStr) ? $fullUrl.'?'.$queryString : $fullUrl;
}

/**
 * Function to check if a site has SSL certificate or not
 * it returns true it has SSL
 * @return bool
 */
function isSecure() {
    $isSecure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? true : false;
    return $isSecure;
}

function getScheme() {
    return (App::getInstance()->sslEnabled()) ? 'https' : 'http';
}

function getHost() {
    $request = $_SERVER;
    $host = (isset($request['HTTP_HOST'])) ? $request['HTTP_HOST'] : $request['SERVER_NAME'];

    //remove unwanted characters
//  $host = strtolower(preg_replace('/:\d+$/', '', trim($host)));
    //prevent Dos attack
    if($host && '' !== preg_replace('/(?:^\[)?[a-zA-Z0-9-:\]_]+\.?/', '', $host)) {
        die();
    }

    return $host;
}

function getRoot() {
    $base = getBase();
    return getScheme().'://'.getHost().$base;
}

function getBase() {
    /*
    $page = basename($_SERVER["SCRIPT_FILENAME"], '/');
    $filename = basename(server('SCRIPT_FILENAME'));
    if(basename(server('SCRIPT_NAME')) == $filename) {
        $baseUrl = server('SCRIPT_NAME');
    } elseif(basename(server('PHP_SELF')) == $filename) {
        $baseUrl = server('PHP_SELF');
    } elseif(basename(server('ORIG_SCRIPT_NAME')) == $filename) {
        $baseUrl = server('ORIG_SCRIPT_NAME');
    } else {
        $baseUrl = server('SCRIPT_NAME');
    }

    $baseUrl = preg_replace('/'.$page.'\//i', '', $baseUrl);
    */

    $baseUrl = substr_count(($_SERVER['SCRIPT_NAME'] ?? $_SERVER['PHP_SELF']), config("basename")) > 0 ? '/'.config('basename').'/' : ((substr_count(($_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME']), "localhost") || substr_count(($_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME']), "192.168.")) ? '/'.config('basename').'/' : "/");

    return $baseUrl;
}

/**
 * Function to get the request method
 * @return string
 */
function get_request_method() {
    return strtoupper($_SERVER['REQUEST_METHOD']);
}

/**
 * Method to get path
 */
function path($path = "") {
    return App::getInstance()->path($path);
}

/**
 * Function to get app instance
 */
function app() {
    return App::getInstance();
}

function error() {
    return MyError::getInstance();
}

function get_page_banner_image() {
    $defaultImage = 'images/page-banner.jpg';
    $setImage = App::getInstance()->pageBannerImg;
    return ($setImage) ? $setImage : $defaultImage;
}


/**
 * Function to get the generated page heading
 */
function get_page_heading() {
    return App::getInstance()->pageHeading;
}

/**
 * Function to get image assets
 * @param string $path e.g images/file.png or pluginname:images/file.png
 * @param int $size
 * @return string
 */
function img($path, $size = null) {
    $path = ($size) ? str_replace('%w', $size, $path) : $path;
    return url(App()->getAssetLink($path, false));
}

function asset_link($path) {
    return App::getInstance()->getAssetLink($path);
}

function url_img($path, $size = null) {
    $path = ($size) ? str_replace('%w', $size, $path) : $path;

    if(stripos('%d', $path) != -1) {
        if($size < 200) {
            $size = 200;
        } elseif($size < 700) {
            $size = 600;
        } else {
            $size = 960;
        }
        $path = ($size) ? str_replace('%d', $size, $path) : $path;
    }
    $url = url($path);
    return $url;
}

/**
 * Method to get the database instance
 */
function db() {
    return App::getInstance()->db();
}

function config($key, $default = null) {
    return App::getInstance()->config($key, $default);
}

/**
 * function to remove asset resources from a page
 */
function remove_header() {
    return App::getInstance()->noMenu;
}

/**
 * Function get user inputs from GET or POST Method
 * @param string $name
 * @param mixed $default
 * @return mixed
 */
function input($name, $default = "", $escape = true) {
    //if (!isset($_POST[$name]) and !isset($_GET[$name])) return $default;
    //for all admin lets escape be off
    //if (segment(0) == 'admincp') $escape = false;
    if($name == "val" and get_request_method() != "POST") return false;
    $index = "";
    if(preg_match("#\.#", $name)) list($name, $index) = explode(".", $name);

    $result = (isset($_GET[$name])) ? $_GET[$name] : $default;
    $result = (isset($_POST[$name])) ? $_POST[$name] : $result;

    if(is_array($result)) {
        if(empty($index)) {
            $nR = array();
            foreach($result as $k => $v) {
                if(is_array($v)) {
                    $newResult = array();
                    foreach($v as $n => $a) {
                        $newResult[$n] = ((!is_array($a) and $escape === true) || (is_array($escape) && !in_array($k, $escape))) ? str_replace("\\\"", "\"", str_replace("\\n", "\n", str_replace("\\r", "\r", mysqli_real_escape_string(db(), sanitizeText($a))))) : str_replace(PHP_EOL, '', str_replace("'", '&#39;', $v));
                    }
                    $nR[$k] = $newResult;
                } else {
                    $nR[$k] = ($escape === true || (is_array($escape) && !in_array($k, $escape))) ? str_replace("\\\"", "\"", str_replace("\\n", "\n", str_replace("\\r", "\r", mysqli_real_escape_string(db(), sanitizeText($v))))) : str_replace(PHP_EOL, '', str_replace("'", '&#39;', $v));
                }
            }
            $result = $nR;
        } else {
            if(!isset($result[$index])) return $default;
            if(is_array($result[$index])) {
                $newResult = array();
                foreach($result[$index] as $n => $v) {
                    $newResult[$n] = ((!is_array($v) and $escape === true) || (is_array($escape) && !in_array($index, $escape))) ? str_replace("\\\"", "\"", str_replace("\\n", "\n", str_replace("\\r", "\r", mysqli_real_escape_string(db(), sanitizeText($v))))) : str_replace(PHP_EOL, '', str_replace("'", '&#39;', $v));
                }
                $result = $newResult;
            } else {
                $result = ((!is_array($result[$index]) and $escape === true) || (is_array($escape) && !in_array($index, $escape))) ? str_replace("\\\"", "\"", str_replace("\\n", "\n", str_replace("\\r", "\r", mysqli_real_escape_string(db(), sanitizeText($result[$index]))))) : str_replace(PHP_EOL, '', str_replace("'", '&#39;', $result[$index]));
            }

        }
    } else {
        $result = ((!is_array($result) and $escape === true) || (is_array($escape) && !in_array($name, $escape))) ? str_replace("\\\"", "\"", str_replace("\\n", "\n", str_replace("\\r", "\r", mysqli_real_escape_string(db(), sanitizeText($result))))) : str_replace("'", '&#39;', $result);
    }

    return $result;
}

/**
 * Function get user file input
 * @param string $name
 * @return mixed
 */
function input_file($name) {
    if(isset($_FILES[$name])) {
        if(is_array($_FILES[$name]['name'])) {
            $files = array();
            $index = 0;
            foreach($_FILES[$name]['name'] as $n) {
                if($_FILES[$name]['name'] != 0) {
                    $files[] = array(
                        'name' => $n,
                        'type' => $_FILES[$name]['type'][$index],
                        'tmp_name' => $_FILES[$name]['tmp_name'][$index],
                        'error' => $_FILES[$name]['error'][$index],
                        'size' => $_FILES[$name]['size'][$index]
                    );
                }
                $index++;
            }

            if(empty($files)) return false;
            return $files;
        } else {
            if(isset($_FILES[$name]['size']) && $_FILES[$name]['size'] == 0) return false;
            return $_FILES[$name];
        }
    }
    return false;
}

/**
 * Method to put data into the session
 * @param string $name
 * @param string $value
 * @return boolean
 */
function session_put($name, $value = "") {
    $_SESSION[$name] = $value;
    return true;
}

/**
 * Function to get value from a session
 * @param string $name
 * @param string $default
 * @return string
 */
function session_get($name, $default = false) {
    if(!isset($_SESSION[$name])) return $default;
    return $_SESSION[$name];
}

/**
 * Method to remove data from the session
 * @param string $name
 * @return boolean
 */
function session_forget($name) {
    if(isset($_SESSION[$name])) unset($_SESSION[$name]);
    return true;
}

/**
 * Function to redirect by link
 * @param string $url
 * @parapm array $flash array('id' => 'flash-message-id', 'message' => '')
 * @return mixed
 */
function redirect($url, $flash = array()) {
    add_flash($flash);
    @session_write_close();
    @session_regenerate_id(true);
    header("Location:".$url);
    exit;
}

/**
 * Function to redirect back
 */
function redirect_back($flash = array()) {
    $back = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
    add_flash($flash);
    if(empty($back) and !preg_match("#".config("base_url")."#", $back)) redirect(url());
    redirect($back);
}

function add_flash($flash = array()) {
    if($flash and isset($flash['id']) and isset($flash['message'])) {
        $id = $flash['id'];
        $message = serialize($flash['message']);
        session_put($id, $message);
    }
}

/**
 * Function to flash data
 * @param string $id
 */
function get_flash($id) {
    $data = session_get($id);
    if($data) $data = unserialize($data);
    session_forget($id);
    return $data;
}



/**
 * Method to generate a link
 * @param string $url
 * @return string
 */
function url($url = "") {
    return App::getInstance()->url($url);
}

/**
 * Method to generate link to a pager
 * @param string $id
 * @param array $param
 * @return string
 */

/**
 * Function to save a value to cache
 * @param string $key
 * @param mixed $value
 * $param int   $time
 * @param null $time
 */
function set_cache($key, $value, $time = null) {
    $cache = new Cache;
    $cache->set($key, $value, $time);
}

/**
 * Function to get value from cache
 * @param mixed $key
 */
function get_cache($key, $default = null) {
    $cache = Cache::getInstance();
    return $cache->get($key, $default);
}

/**
 * Function to set a value forever in cache
 * @param string $key
 * @param $value
 * @internal param mixed $value
 */
function set_cacheForever($key, $value) {
    $cache = Cache::getInstance();
    $cache->setForever($key, $value);
}

/**
 * Function to unset a value from cache
 * @return void
 */
function forget_cache($key) {
    $cache = Cache::getInstance();
    $cache->forget($key);
}

/**
 * Function to check if a key exists in cache
 * @param string $key
 * @return bool
 */
function cache_exists($key) {
    $cache = Cache::getInstance();
    return $cache->keyexists($key);
}

/**
 * function get admin settings
 * @param string $key
 * @param string $default
 */
function get_setting($key, $default = "") {
    return config($key, $default);
}

/**
 * Function to hash content
 * @param string $content
 * @return string
 */
function hash_make($content) {
    $app = App::getInstance();
    if($app->config('bcrypt')) {
        require_once path("includes/libraries/password/");
        return password_hash($content, PASSWORD_BCRYPT, array('cost' => 10));
    } else {
        return md5($content);
    }
}

/**
 * function to check if a given hash match a content
 * @param string $content
 * @param string $hash
 * @return boolean
 */
function hash_check($content, $hash) {
    $app = App::getInstance();
    if($app->config('bcrypt')) {
        require_once path("includes/libraries/password/");
        return password_verify($content, $hash);
    } else {
        return (md5($content) == $hash);
    }
}


/**
 * Function to segment from the uri
 * @param int $index
 * @return string
 */
function segment($index, $default = null) {
    return App::getInstance()->segment($index, $default);
}


/**
 * Function to get user ip address
 * @return string
 */
function get_ip() {
    //Just get the headers if we can or else use the SERVER global
    if(function_exists('apache_request_headers')) {
        $headers = apache_request_headers();
    } else {
        $headers = $_SERVER;
    }

    //Get the forwarded IP if it exists
    if(array_key_exists('X-Forwarded-For', $headers) && filter_var($headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        $the_ip = $headers['X-Forwarded-For'];
    } elseif(array_key_exists('HTTP_X_FORWARDED_FOR', $headers) && filter_var($headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        $the_ip = $headers['HTTP_X_FORWARDED_FOR'];
    } else {
        $the_ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }

    return $the_ip;
}

if(!function_exists('perfectSerialize')) {
    function perfectSerialize($string) {
        return base64_encode(serialize($string));
    }
}

if(!function_exists('perfectUnserialize')) {
    function perfectUnserialize($string) {

        if(base64_decode($string, true) == true) {

            return @unserialize(base64_decode($string));
        } else {
            return @unserialize($string);
        }
    }
}

if(!function_exists('sanitizeText')) {
    function sanitizeText($string, $limit = false, $output = false) {
        if(!is_string($string)) return $string;
        $lawed_config = array(
            'safe' => 1,
            'deny_attribute' => 'id, style, class'
        );
        $string = lawedContent($string, $lawed_config);//great one
        $string = trim($string);
        //$string = htmlspecialchars($string, ENT_QUOTES);

        $string = str_replace('&amp;#', '&#', $string);
        $string = str_replace('&amp;', '&', $string);
        if($limit) {
            $string = substr($string, 0, $limit);
        }
        return $string;
    }

}

function lawedContent($t, $C = 1, $S = array()) {
    if(file_exists(path('includes/libraries/htmlawed/htmLawed/'))) {
        require_once path('includes/libraries/htmlawed/htmLawed/');

        return htmLawed($t, $C, $S);
    }

    return $t;
}

/**
 * Function to convert a string to slug
 * @param $text
 * <p>This is the string to convert to slug</p>
 * @return mixed|string
 */
function slugify($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text); // replace non letter or digits by -
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text); // transliterate
    $text = preg_replace('~[^-\w]+~', '', $text); // remove unwanted characters
    $text = trim($text, '-');// trim
    $text = preg_replace('~-+~', '-', $text); // remove duplicate -
    $text = strtolower($text); // lowercase
    if (empty($text)) {
        return 'n-a';
    }
    return $text;
}

/**
 * Function to check if the current page is the menu page
 * @param string $page
 * @param string $cssClass
 * @return string|null
 */
function current_menu($page = null, $cssClass = "active") {
    $path = trim(parse_url(getFullUrl(), PHP_URL_PATH), "/");
    $page = (!$page || $page == "index" || $page == "home") ? "" : $page;

    if($path === $page) return $cssClass;
    return null;
}

/**
 * This returns only the host name without subdomain
 * For example, if the url is http://demo.yuniqtools.com
 * it will return only yuniqtools.com
 */
function get_domain() {
    $scheme = (isset($_SERVER['HTTPS'])) ? 'https://' : 'http://';
    $url = (isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
    $pieces = parse_url($scheme.$url);
    $domain = isset($pieces['host']) ? $pieces['host'] : '';
    if ($domain AND preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
        return $regs['domain'];
    }

    $host = strtolower(preg_replace('/:\d+$/', '', trim($url)));
    //prevent Dos attack
    if ($host && '' !== preg_replace('/(?:^\[)?[a-zA-Z0-9-:\]_]+\.?/', '', $host)) {
        die();
    }

    return $host;
}

function localhost() {
    if(substr_count(($_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME']), "localhost") OR substr_count(($_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME']), "192.168.")) return true;
    return false;
}

function urllink($link) {
    $scheme = getScheme();
    return (localhost()) ? url($link) : $scheme."://".$link. "." .get_domain();
}

function assetlink($path) {
    $scheme = getScheme();
    return (localhost()) ? url($path) : $scheme."://".get_domain()."/".$path;
}













