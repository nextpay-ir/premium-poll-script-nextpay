<?php 
 /**
 * ====================================================================================
 *                           Easy Media Script (c) KBRmedia
 * ----------------------------------------------------------------------------------
 * @copyright - This software is exclusively sold at CodeCanyon.net. If you have downloaded this
 *  from another site or received it from someone else than me, then you are engaged
 *  in illegal activity. You must delete this software immediately or buy a proper
 *  license from http://codecanyon.net/user/KBRmedia/portfolio?ref=KBRmedia.
 *
 *  Thank you for your cooperation and don't hesitate to contact me if anything :)
 * ====================================================================================
 *
 * @author KBRmedia (http://gempixel.com)
 * @link http://gempixel.com 
 * @license http://gempixel.com/license
 * @package Easy Media Script
 * @subpackage Main Class (Main.class.php)
*/
class Main{
    protected static $title="";
    protected static $description="";
    protected static $url="";
    protected static $image="";
    protected static $video="";
    protected static $body_class="";
    protected static $lang="";
    private static $config=array();
  /**
  * Generate meta title
  * @param none
  * @return title
  * @since v1.0
  */
    public static function title(){      
      if(empty(self::$title)){
        return self::$config["title"];
      }else{
        return self::$title." - ".self::$config["title"];
      }
    }
  /**
  * Generate meta description
  * @param none
  * @return description
  * @since v1.0
  */
    public static function description(){      
      if(empty(self::$description)){
        return self::$config["description"];
      }else{
        return self::$description;
      }
    }
  /**
  * Generate URL
  * @param none
  * @return description
  * @since v1.0
  */
    public static function url(){      
      if(empty(self::$url)){
        return self::$config["url"];
      }else{
        return self::$url;
      }
    } 
  /**
  * Body Class inject
  * @param none
  * @return message
  * @since v1.0
  */     
    public static function body_class(){
      if(!empty(self::$body_class)) return " class='".self::$body_class."'";
    }    
  /**
  * Generate URL
  * @param none
  * @return description
  * @since v1.0
  */
    public static function image(){      
      if(empty(self::$image)){
        return "http://s.wordpress.com/mshots/v1/".self::url()."?w=400";
      }else{
        return self::$image;
      }
    }   
  /**
  * Set meta info
  * @param none
  * @return Formatted array
  * @since v1.0
  */
    public static function set($meta,$value){
      if(!empty($value)){
        self::$$meta=$value;
      }
    }  
  /**
  * Generate Open-graph tags
  * @param none
  * @return string
  * @since v1.0
  */  
    public static function ogp(){
      $meta="<meta property='og:type' content='website' />\n\t";      
      $meta.="<meta property='og:url' content='".self::url()."' />\n\t"; 
      $meta.="<meta property='og:title' content='".self::title()."' />\n\t";
      $meta.="<meta property='og:description' content='".self::description()."' />\n\t";  
      if(!empty(self::$video)){
        $meta.=self::$video; 
      }
      echo $meta; 
    }  
  /**
  * Clean a string
  * @param string, cleaning level (1=lowest,2,3=highest)
  * @return cleaned string
  */

    public static function clean($string,$level='1',$chars=FALSE,$leave=""){        
        if(is_array($string)) return array_map("Main::clean",$string);

        $string=preg_replace('/<script[^>]*>([\s\S]*?)<\/script[^>]*>/i', '', $string);      
        switch ($level) {
          case '3':
            $string=strip_tags($string,$leave);    
            if($chars) {
              if(phpversion() >= 5.4){
                $string=htmlspecialchars($string, ENT_QUOTES | ENT_HTML5,"UTF-8");  
              }else{
                $string=htmlspecialchars($string, ENT_QUOTES,"UTF-8");  
              }
            }
            break;
          case '2':
            $string=strip_tags($string,'<b><i><s><u><strong>');
            break;
          case '1':
            $string=strip_tags($string,'<b><i><s><u><strong><a><pre><code><p><div>');
            break;
        }   
        $string=str_replace('href=','rel="nofollow" href=', $string);   
        return $string; 
    }
  /**
  * Is Set and Equal to
  * @param key, value
  * @return boolean
  */ 
   public static function is_set($key,$value=NULL,$method="GET"){
      if(!in_array($method, array("GET","POST"))) return FALSE;
      if($method=="GET") {
        $method=$_GET;
      }elseif($method=="POST"){
        $method=$_POST;
      }
      if(!isset($method[$key])) return FALSE;
      if(!is_null($value) && $method[$key]!==$value) return FALSE;
      return TRUE;
   }
  /**
  * Validate and sanitize email
  * @param string
  * @return email
  */  
    public static function email($email){
        $email=trim($email);
        if (preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]{2,})+$/i', $email) && strlen($email)<=50 && filter_var($email, FILTER_SANITIZE_EMAIL)){
            return filter_var($email, FILTER_SANITIZE_EMAIL);
        }
        return FALSE;
    }

  /**
  * Validate and sanitize username
  * @param string
  * @return username
  */  

    public static function username($user){
      if(preg_match('/^\w{4,}$/', $user) && strlen($user)<=20 && filter_var($user,FILTER_SANITIZE_STRING)) {
        return filter_var(trim($user),FILTER_SANITIZE_STRING);
      }
      return false;    
    }
  /**
  * Validate Date
  * @param string
  */  
    public static function validatedate($date, $format = 'Y-m-d H:i:s'){
      if(!class_exists("DateTime")){
        if(!preg_match("!(.*)-(.*)-(.*)!",$date)) return false;
        return true;
      }
      $d = DateTime::createFromFormat($format, $date);
      return $d && $d->format($format) == $date;
    }
  /**
   * Get IP
   * @since 1.0 
   **/
  public static function ip(){
    $ipaddress = '';
     if (getenv('HTTP_CLIENT_IP'))
         $ipaddress = getenv('HTTP_CLIENT_IP');
     else if(getenv('HTTP_X_FORWARDED_FOR'))
         $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
     else if(getenv('HTTP_X_FORWARDED'))
         $ipaddress = getenv('HTTP_X_FORWARDED');
     else if(getenv('HTTP_FORWARDED_FOR'))
         $ipaddress = getenv('HTTP_FORWARDED_FOR');
     else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
     else if(getenv('REMOTE_ADDR'))
         $ipaddress = getenv('REMOTE_ADDR');
     else
         $ipaddress = 'UNKNOWN';

     return $ipaddress; 
  }
  /**
   * Validate URLs
   * @since 1.0
   **/
  public static function is_url($url){
    if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$url) && filter_var($url, FILTER_VALIDATE_URL)){
      return true;
    }    
    return false;     
  }

  /**
  * Encode string
  * @param string, encode= MD5, SHA1 or SHA256 
  * @return hash
  */   
    public static function encode($string,$encoding="phppass"){      
      if($encoding=="phppass"){
        if(!class_exists("PasswordHash")) require_once(ROOT."/includes/library/phpPass.class.php");
        $e = new PasswordHash(8, FALSE);
        return $e->HashPassword($string.self::$config["security"]);
      }else{
        return hash($encoding,$string.self::$config["security"]);
      }
    }
  /**
  * Check Password
  * @param string, encode= MD5, SHA1 or SHA256 
  * @return hash
  */   
    public static function validate_pass($string,$hash,$encoding="phppass"){      

      if($encoding=="phppass"){
        if(!class_exists("PasswordHash")) require_once(ROOT."/includes/library/phpPass.class.php");
        $e = new PasswordHash(8, FALSE);
        return $e->CheckPassword($string.self::$config["security"], $hash);
      }else{
        return hash($encoding,$string.self::$config["security"]);
      }
    }
/**
 * Read user cookie and extract user info
 * @param 
 * @return array of info
 * @since v1.0
 */
  public static function user(){
    if(isset($_COOKIE["login"])){
      $data=json_decode(base64_decode($_COOKIE["login"]),TRUE);
    }elseif(isset($_SESSION["login"])){
      $data=json_decode(base64_decode($_SESSION["login"]),TRUE);     
    }
    if(isset($data["loggedin"]) && !empty($data["key"])){  
      return array(self::clean(substr($data["key"],60)),self::clean(substr($data["key"],0,60)));
    }     
    return FALSE;  
  }    
  /**
  * Generate api or random string
  * @param length, start
  * @return 
  */    
    public static function strrand($length=12,$api=""){    
        $use = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"; 
        srand((double)microtime()*1000000); 
        for($i=0; $i<$length; $i++) { 
          $api.= $use[rand()%strlen($use)]; 
        } 
      return $api; 
    }

  /**
  * Get extension
  * @param file name
  * @return extension
  */   
    public static function extension($file){
        return strrchr($file, "."); 
    }

  /**
  * Generate slug
  * @param string
  * @return slug
  */  

    public static function slug($url) {
        $url=preg_replace('/[^_0-9a-zA-Z -]/', '', strtolower($url));
        $url=preg_replace('/\s\s+/', ' ', $url);
        $url=str_replace(' ','-',$url);
      return $url;
    }  

  /**
  * Clean cookie
  * @param cookie
  * @return cleaned cookie
  */  

    public static function get_cookie($cookie){
      return Main::clean($cookie,1);
    }

  /**
  * Convert a timestap into timeago format
  * @param time
  * @return timeago
  */  

    public static function timeago($time){
       $time=strtotime($time);
       $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
       $lengths = array("60","60","24","7","4.35","12","10");
       $now = time();
         $difference = $now - $time;
         $tense= "ago";
         for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
           $difference /= $lengths[$j];
         }
         $difference = round($difference);
         if($difference != 1) {
           $periods[$j].= "s";
         }
       return "$difference $periods[$j] $tense ";
    } 

  /**
  * Redirect function
  * @param url/path (not including base), message and header code
  * @return nothing
  */   

    public static function redirect($url,$message=array(),$header="",$fullurl=FALSE){      

      if(!empty($message)){      
        $_SESSION["msg"]=self::clean("{$message[0]}::{$message[1]}",3,FALSE,"<span>");
      }
      switch ($header) {
        case '403':
          header('HTTP/1.1 301 Moved Permanently');
          break;
        case '404':
          header('HTTP/1.1 404 Not Found');
          break;
        case '503':
          header('HTTP/1.1 503 Service Temporarily Unavailable');
          header('Status: 503 Service Temporarily Unavailable');
          header('Retry-After: 60');
          break;
      }
      if($fullurl){
        header("Location: $url");
        exit;
      }
      header("Location: ".self::$config["url"]."/$url");
      exit;
    }

  /**
  * Notification Function
  * @param none
  * @return message
  */     

    public static function message(){
      if(isset($_SESSION["msg"]) && !empty($_SESSION["msg"])) {
        $message=explode("::",self::clean($_SESSION["msg"],3,FALSE,"<span>"));
          $message="<div class='alert alert-{$message[0]}'>{$message[1]}</div>";
          unset($_SESSION["msg"]);
      }else {
        $message="";
      }
      return stripslashes($message);
    }

  /**
  * Show error message
  * @param message
  * @return formatted message
  */  
    public static function error($message){
      return "<div class='alert alert-danger'>$message</div>";
    }

  /**
  * Truncate a string
  * @param string, delimiter, append string
  * @return truncated message
  */  
    public static function truncate($string,$del,$limit="...") {
      $len = strlen($string);
        if ($len > $del) {
           $new = substr($string,0,$del).$limit;
            return $new;
        }
        return $string;
    } 

  /**
  * Format Number
  * @param number, decimal
  * @return formatted number
  */  
    public static function formatnumber($number,$decimal="0") {
      if($number>1000000000000) $number= round($number /1000000000000, $decimal)."T";
      if($number>1000000000) $number= round($number /1000000000, $decimal)."B";
      if($number>1000000) $number= round($number /1000000, $decimal)."M";
      if($number>10000) $number= round($number /10000, $decimal)."K";

      return $number;
    }  

  /**
  * Get Facebook Likes
  * @param Facebook page
  * @return number of likes
  */   
  	public static function facebook_likes($url){
  		if(preg_match('((http://|https://|www.)facebook.+[\w-\d]+/(.*))', $url,$id)) {
  				$id = $id[2];
  				$content = json_decode(@file_get_contents("https://graph.facebook.com/$id/"),TRUE);
  			return $content["likes"];
  		}
  	}

  /**
  * Get Twitter followers
  * @param Twitter profile
  * @return number of followers
  */ 
  	public static function twitter_followers($url){
  		if(preg_match('((http://|https://|www.)twitter.+[\w-\d]+/(.*))', $url,$id)) {
  				$id = $id[2];
  				$content = json_decode(@file_get_contents("https://api.twitter.com/1/users/lookup.json?screen_name=$id"),TRUE);
  			return $content[0]["followers_count"];
  		}
  	}	

  /**
  * Ajax Button
  * @param type, max number of page, current page, url, text, class
  * @return formatted button
  */ 
    public static function ajax_button($type, $max, $current,$url,$text='',$class="ajax_load"){
      if($current >= $max) return FALSE;
      return "<a href='$url' data-page='$current' data-type='$type' class='button fullwidth $class'>Load More $text</a>";
    }

  /**
  * Generates url based on settings (seo or not)
  * @param default (non-seo), pretty urls (seo)
  * @return url
  */ 
    public static function href($default,$seo="",$base=TRUE){      
      if(empty($seo)){
        if(self::$config["mod_rewrite"]){
          return (!$base)?"$default":"".self::$config["url"]."/$default";
        }else{
	  //return "".self::$config["url"]."/index.php?a=$default";
          return (!$base)?"index.php?a=$default":"".self::$config["url"]."/index.php?a=$default";
        }
      }else{
        if(self::$config["mod_rewrite"]){
          return (!$base)?"$seo":"".self::$config["url"]."/$seo";
        }else{
          return (!$base)?"$default":"".self::$config["url"]."/$default";
        }
      }
    }

  /**
  * Generates admin url based on settings (seo or not)
  * @see Main::href()
  * @param default (non-seo), pretty urls (seo)
  * @return url
  */ 
    public static function ahref($default,$seo="",$base=TRUE){
      if(!empty($seo)) return Main::href("admin/index.php?a=$default","admin/$seo",$base);
      return Main::href("admin/index.php?a=$default","admin/$default",$base);
    }
  /**  
  * Generates pagination with class "pagination"
  * @param total number of pages, current pages, format of url
  * @return complete pagination elements
  */
  public static function pagination($total, $current, $format, $limit='1'){
         $page_count = ceil($total/$limit);
         $current_range = array(($current-5 < 1 ? 1 : $current-3), ($current+5 > $page_count ? $page_count : $current+3));

         $first_page = $current > 5 ? '<li><a href="'.sprintf($format, '1').'">'.Main::e("First").'</a></li>'.($current < 5 ? ' ' : '') : null;
         $last_page = $current < $page_count-2 ? ($current > $page_count-4 ? ' ' : '  ').'<li><a href="'.sprintf($format, $page_count).'">'.Main::e("Last").'</a></li>' : null;

         $previous_page = $current > 1 ? '<li><a href="'.sprintf($format, ($current-1)).'">'.Main::e("Previous").'</a></li> ' : null;
         $next_page = $current < $page_count ? ' <li><a href="'.sprintf($format, ($current+1)).'">'.Main::e("Next").'</a></li> ' : null;

         for ($x=$current_range[0];$x <= $current_range[1]; ++$x)    
        $pages[] = ($x == $current ? '<li class="active"><a href="#">'.$x.'</a></li>' : '<li><a href="'.sprintf($format, $x).'">'.$x.'</a></li>');
         if ($page_count > 1)
      return '<ul class="pagination">'.$first_page.$previous_page.implode(' ', $pages).$next_page.$last_page.'</ul>';
  }

  /**  
  * Generates the path to the thumbnail based on mod-rewrite settings
  * @param file name, width, height
  * @return url
  */    
    public static function thumb($file,$width="",$height="",$base=TRUE){
      return Main::href("index.php?action=thumb&p=".Main::clean($file,3)."/$width/$height","thumb/".Main::clean($file,3)."/$width/$height",$base);
    }

  /**  
  * Validates the captcha based on settings
  * @param data
  * @return ok
  */  
    public static function check_captcha($array){      
        if(self::$config["captcha"]=="1"){
          // Recaptcha
          require_once(ROOT."/includes/library/Recaptcha.php");
          if(empty($array["recaptcha_response_field"])) {
            return e('Please enter the CAPTCHA.');  
          }else{
            $resp = recaptcha_check_answer (self::$config["captcha_private"],$_SERVER["REMOTE_ADDR"],$array["recaptcha_challenge_field"],$array["recaptcha_response_field"]);
            if (!$resp->is_valid) {
              return e("The CAPTCHA wasn't entered correctly. Please try it again.");
            }
          }
        }
        return 'ok';    
      }

  /**  
  * Generates CAPTCHA html based on settings
  * @param none
  * @return captcha
  */     
    public static function captcha(){      
        if(self::$config["captcha"]=="1"){
          require_once(ROOT."/includes/library/Recaptcha.php");
          return recaptcha_get_html(self::$config["captcha_public"]);
        }
    }
  /**
  * Generated CSRF Token
  * @param none
  * @return token
  * @since v1.0
  */   
    public static function csrf_token($form=FALSE,$echo=TRUE){
        if($form && $echo && isset($_SESSION["CSRF"])) return "<input type='hidden' name='token' value='{$_SESSION["CSRF"]}' />";      
        if($echo && isset($_SESSION["CSRF"])) return $_SESSION["CSRF"];

        $token = self::encode("csrf_token".rand(0,1000000).time().uniqid(),"SHA1");
        $_SESSION["CSRF"] = $token;

        if($form) return "<input type='hidden' name='token' value='$token' />";
      return $token;
    }

  /**
  * Validate CSRF Token
  * @param token
  * @return boolean
  * @since v1.0
  */   
    public static function validate_csrf_token($token,$redirect=""){
      if(isset($_SESSION["CSRF"]) && ($_SESSION["CSRF"] == trim($token))) {
        unset($_SESSION["CSRF"]);
        return TRUE;
      }
      if(!empty($redirect)) self::redirect($redirect,array("error",e("The CSRF token is not valid. Please try again.")));
      return FALSE;
    }  
/**
  * Create Nonce
  * @param none
  * @return token
  * @since v1.0
  */   
    public static function nonce_create($action="",$duration="5"){
      $i = ceil( time() / ( $duration*60 / 2 ) );
      return md5( $i . $action . $action);
    }
/**
  * Return Nonce
  * @param none
  * @return token
  * @since v1.0
  */   
    public static function nonce($action="",$key="_nonce"){
      return $key."=".substr(self::nonce_create($action), -12, 10);
    }
  /**
  * Validate CSRF Token
  * @param token
  * @return boolean
  * @since v1.0
  */   
    public static function validate_nonce($action="",$key="_nonce"){
      if(isset($_GET[$key]) && substr(self::nonce_create($action), -12, 10) == $_GET[$key]){
        return true;
      }
      return false;
    }  

  /**
   * Set ucookie
   * @param Name, value
   * @since v1.0
   */  
    public static function cookie($name,$value="",$time=1){
      if(empty($value)){
        if(isset($_COOKIE[$name])){
          return Main::clean($_COOKIE[$name],3,FALSE);
        }else{
          return FALSE;
        }
      }
      setcookie($name,$value, time()+($time*60), "/","",FALSE,TRUE);
    }
  /**
   * Enqueue scripts to header and footer
   * @since v1.0
   */
    public static function enqueue($where="header"){
      if($where=="footer"){  
        global $enqueue_footer;
        echo $enqueue_footer;
      }else{
        global $enqueue_header;
        echo $enqueue_header;
      } 
    }
  /**
   * Add scripts to header and footer
   * @since v1.0
   */  
    public static function add($url,$type="script",$footer=TRUE){
      if($type=="style"){
        $tag='<link rel="stylesheet" type="text/css" href="'.$url.'">';
      }elseif($type=="custom"){
        $tag=$url;
      }else{
        $tag='<script type="text/javascript" src="'.$url.'"></script>';
      }
      if($footer){
        global $enqueue_footer;
        $enqueue_footer.=$tag."\n\t";
      }else{
        global $enqueue_header;
        $enqueue_header.=$tag."\n\t";
      }
    } 
  /**
   * Enqueue scripts to header and footer
   * @since v1.0
   */
    public static function admin_enqueue($where="header"){
      if($where=="footer"){  
        global $admin_enqueue_footer;
        echo $admin_enqueue_footer;
      }else{
        global $admin_enqueue_header;
        echo $admin_enqueue_header;
      } 
    }
  /**
   * Add scripts to header and footer
   * @since v1.0
   */  
    public static function admin_add($url,$type="script",$footer=TRUE){
      if($type=="style"){
        $tag='<link rel="stylesheet" type="text/css" href="'.$url.'">';
      }elseif($type=="custom"){
        $tag=$url;
      }else{
        $tag='<script type="text/javascript" src="'.$url.'"></script>';
      }
      if($footer){
        global $admin_enqueue_footer;
        $admin_enqueue_footer.=$tag."\n\t";
      }else{
        global $admin_enqueue_header;
        $admin_enqueue_header.=$tag."\n\t";
      }
    }
   /**
    * List of CDNs
    * Powered by CloudFlare.com
    * @since 1.0
    **/  
    public static function cdn($cdn,$version="",$admin=FALSE){      
      $cdns=array(
        "jquery"=> array(
            "src" => "//cdnjs.cloudflare.com/ajax/libs/jquery/[version]/jquery.min.js",
            "latest" =>"2.0.3"
          ),
        "jquery-ui"=> array(
            "src" => "//cdnjs.cloudflare.com/ajax/libs/jqueryui/[version]/jquery-ui.min.js",
            "latest" =>"1.10.3"
          ),
        "ace"=>array(
            "src"=>"//cdnjs.cloudflare.com/ajax/libs/ace/[version]/ace.js",
            "latest" => "1.1.01"
          ),
        "icheck"=>array(
            "src"=>"//cdnjs.cloudflare.com/ajax/libs/iCheck/[version]/icheck.min.js",
            "latest" => "1.0.1"
          ),
        "ckeditor"=>array(
            "src"=>"//cdnjs.cloudflare.com/ajax/libs/ckeditor/[version]/ckeditor.js",
            "latest" => "4.3.2"
          ),
        "selectize"=>array(
            "src"=>"//cdnjs.cloudflare.com/ajax/libs/selectize.js/[version]/js/standalone/selectize.min.js",
            "latest"=>"0.8.5"
          ),
        "zlip"=>array(
            "src"=>"//cdnjs.cloudflare.com/ajax/libs/zclip/[version]/jquery.zclip.min.js",
            "latest"=>"1.1.2"
          ),
        "flot"=>array(
            "src"=>"//cdnjs.cloudflare.com/ajax/libs/flot/[version]/jquery.flot.min.js",
            "latest"=>"0.8.2"
          ),
        "less"=>array(
            "src"=>"//cdnjs.cloudflare.com/ajax/libs/less.js/[version]/less.min.js",
            "latest"=>"1.6.2"
          ),
        "ckeditor"=>array(
            "src"=>"//cdnjs.cloudflare.com/ajax/libs/ckeditor/[version]/ckeditor.js",
            "latest"=>"4.3.2"
          )        
        );
      if(array_key_exists($cdn, $cdns)){
        if(!empty($version)  && $version <= $cdns[$cdn]["latest"]){
          $js=str_replace("[version]", $version, $cdns[$cdn]["src"])."?v=$version";
        }else{
          $js=str_replace("[version]", $cdns[$cdn]["latest"], $cdns[$cdn]["src"])."?v={$cdns[$cdn]["latest"]}";
        }
       if($admin){
        return Main::admin_add($js,"script",FALSE);
      }else{
        return Main::add($js,"script",FALSE);
      }
      }
      return FALSE;
    }
  /**
   * Translate strings
   * @since v1.0
   */   
    public static function e($text){
      if(!is_array(Main::$lang)) return $text;
      if(isset(Main::$lang[$text]) && !empty(Main::$lang[$text])) {
        return ucfirst(Main::$lang[$text]);
      }
      return $text;    
    }
  /**
   * Check if user agent is bot
   * @since v1.0
   */  
  public static function bot($ua=""){
    if(empty($ua)){
      if(!isset($_SERVER['HTTP_USER_AGENT']) || empty($_SERVER['HTTP_USER_AGENT']) || is_null($_SERVER['HTTP_USER_AGENT'])){
        return TRUE;
      }
      $ua=$_SERVER['HTTP_USER_AGENT'];
    }
    $list = array("facebookexternalhit","Teoma", "alexa", "froogle", "Gigabot", "inktomi",
    "looksmart", "URL_Spider_SQL", "Firefly", "NationalDirectory",
    "Ask Jeeves", "TECNOSEEK", "InfoSeek", "WebFindBot", "girafabot",
    "crawler", "www.galaxy.com", "Googlebot", "Scooter", "Slurp",
    "msnbot", "appie", "FAST", "WebBug", "Spade", "ZyBorg", "rabaz",
    "Baiduspider", "Feedfetcher-Google", "TechnoratiSnoop", "Rankivabot",
    "Mediapartners-Google", "Sogou web spider", "WebAlta Crawler","TweetmemeBot",
    "Butterfly","Twitturls","Me.dium","Twiceler");
    foreach($list as $bot){
      if(strpos($ua,$bot)!==false)
      return true;
    }
    return false; 
  }
  /**
   * List of Countries and ISO Code
   * @since 1.0
   **/
  public static function countries($code=""){
    $countries=array('AF'=>'Afghanistan','AX'=>'Aland Islands','AL'=>'Albania','DZ'=>'Algeria','AS'=>'American Samoa','AD'=>'Andorra','AO'=>'Angola','AI'=>'Anguilla','AQ'=>'Antarctica','AG'=>'Antigua And Barbuda','AR'=>'Argentina','AM'=>'Armenia','AW'=>'Aruba','AU'=>'Australia','AT'=>'Austria','AZ'=>'Azerbaijan','BS'=>'Bahamas','BH'=>'Bahrain','BD'=>'Bangladesh','BB'=>'Barbados','BY'=>'Belarus','BE'=>'Belgium','BZ'=>'Belize','BJ'=>'Benin','BM'=>'Bermuda','BT'=>'Bhutan','BO'=>'Bolivia','BA'=>'Bosnia And Herzegovina','BW'=>'Botswana','BV'=>'Bouvet Island','BR'=>'Brazil','IO'=>'British Indian Ocean Territory','BN'=>'Brunei Darussalam','BG'=>'Bulgaria','BF'=>'Burkina Faso','BI'=>'Burundi','KH'=>'Cambodia','CM'=>'Cameroon','CA'=>'Canada','CV'=>'Cape Verde','KY'=>'Cayman Islands','CF'=>'Central African Republic','TD'=>'Chad','CL'=>'Chile','CN'=>'China','CX'=>'Christmas Island','CC'=>'Cocos (Keeling) Islands','CO'=>'Colombia','KM'=>'Comoros','CG'=>'Congo','CD'=>'Congo, Democratic Republic','CK'=>'Cook Islands','CR'=>'Costa Rica','CI'=>'Cote D\'Ivoire','HR'=>'Croatia','CU'=>'Cuba','CY'=>'Cyprus','CZ'=>'Czech Republic','DK'=>'Denmark','DJ'=>'Djibouti','DM'=>'Dominica','DO'=>'Dominican Republic','EC'=>'Ecuador','EG'=>'Egypt','SV'=>'El Salvador','GQ'=>'Equatorial Guinea','ER'=>'Eritrea','EE'=>'Estonia','ET'=>'Ethiopia','FK'=>'Falkland Islands (Malvinas)','FO'=>'Faroe Islands','FJ'=>'Fiji','FI'=>'Finland','FR'=>'France','GF'=>'French Guiana','PF'=>'French Polynesia','TF'=>'French Southern Territories','GA'=>'Gabon','GM'=>'Gambia','GE'=>'Georgia','DE'=>'Germany','GH'=>'Ghana','GI'=>'Gibraltar','GR'=>'Greece','GL'=>'Greenland','GD'=>'Grenada','GP'=>'Guadeloupe','GU'=>'Guam','GT'=>'Guatemala','GG'=>'Guernsey','GN'=>'Guinea','GW'=>'Guinea-Bissau','GY'=>'Guyana','HT'=>'Haiti','HM'=>'Heard Island & Mcdonald Islands','VA'=>'Holy See (Vatican City State)','HN'=>'Honduras','HK'=>'Hong Kong','HU'=>'Hungary','IS'=>'Iceland','IN'=>'India','ID'=>'Indonesia','IR'=>'Iran, Islamic Republic Of','IQ'=>'Iraq','IE'=>'Ireland','IM'=>'Isle Of Man','IL'=>'Israel','IT'=>'Italy','JM'=>'Jamaica','JP'=>'Japan','JE'=>'Jersey','JO'=>'Jordan','KZ'=>'Kazakhstan','KE'=>'Kenya','KI'=>'Kiribati','KR'=>'Korea','KW'=>'Kuwait','KG'=>'Kyrgyzstan','LA'=>'Lao People\'s Democratic Republic','LV'=>'Latvia','LB'=>'Lebanon','LS'=>'Lesotho','LR'=>'Liberia','LY'=>'Libyan Arab Jamahiriya','LI'=>'Liechtenstein','LT'=>'Lithuania','LU'=>'Luxembourg','MO'=>'Macao','MK'=>'Macedonia','MG'=>'Madagascar','MW'=>'Malawi','MY'=>'Malaysia','MV'=>'Maldives','ML'=>'Mali','MT'=>'Malta','MH'=>'Marshall Islands','MQ'=>'Martinique','MR'=>'Mauritania','MU'=>'Mauritius','YT'=>'Mayotte','MX'=>'Mexico','FM'=>'Micronesia, Federated States Of','MD'=>'Moldova','MC'=>'Monaco','MN'=>'Mongolia','ME'=>'Montenegro','MS'=>'Montserrat','MA'=>'Morocco','MZ'=>'Mozambique','MM'=>'Myanmar','NA'=>'Namibia','NR'=>'Nauru','NP'=>'Nepal','NL'=>'Netherlands','AN'=>'Netherlands Antilles','NC'=>'New Caledonia','NZ'=>'New Zealand','NI'=>'Nicaragua','NE'=>'Niger','NG'=>'Nigeria','NU'=>'Niue','NF'=>'Norfolk Island','MP'=>'Northern Mariana Islands','NO'=>'Norway','OM'=>'Oman','PK'=>'Pakistan','PW'=>'Palau','PS'=>'Palestinian Territory, Occupied','PA'=>'Panama','PG'=>'Papua New Guinea','PY'=>'Paraguay','PE'=>'Peru','PH'=>'Philippines','PN'=>'Pitcairn','PL'=>'Poland','PT'=>'Portugal','PR'=>'Puerto Rico','QA'=>'Qatar','RE'=>'Reunion','RO'=>'Romania','RU'=>'Russian Federation','RW'=>'Rwanda','BL'=>'Saint Barthelemy','SH'=>'Saint Helena','KN'=>'Saint Kitts And Nevis','LC'=>'Saint Lucia','MF'=>'Saint Martin','PM'=>'Saint Pierre And Miquelon','VC'=>'Saint Vincent And Grenadines','WS'=>'Samoa','SM'=>'San Marino','ST'=>'Sao Tome And Principe','SA'=>'Saudi Arabia','SN'=>'Senegal','RS'=>'Serbia','SC'=>'Seychelles','SL'=>'Sierra Leone','SG'=>'Singapore','SK'=>'Slovakia','SI'=>'Slovenia','SB'=>'Solomon Islands','SO'=>'Somalia','ZA'=>'South Africa','GS'=>'South Georgia And Sandwich Isl.','ES'=>'Spain','LK'=>'Sri Lanka','SD'=>'Sudan','SR'=>'Suriname','SJ'=>'Svalbard And Jan Mayen','SZ'=>'Swaziland','SE'=>'Sweden','CH'=>'Switzerland','SY'=>'Syrian Arab Republic','TW'=>'Taiwan','TJ'=>'Tajikistan','TZ'=>'Tanzania','TH'=>'Thailand','TL'=>'Timor-Leste','TG'=>'Togo','TK'=>'Tokelau','TO'=>'Tonga','TT'=>'Trinidad And Tobago','TN'=>'Tunisia','TR'=>'Turkey','TM'=>'Turkmenistan','TC'=>'Turks And Caicos Islands','TV'=>'Tuvalu','UG'=>'Uganda','UA'=>'Ukraine','AE'=>'United Arab Emirates','GB'=>'United Kingdom','US'=>'United States','UM'=>'United States Outlying Islands','UY'=>'Uruguay','UZ'=>'Uzbekistan','VU'=>'Vanuatu','VE'=>'Venezuela','VN'=>'Viet Nam','VG'=>'Virgin Islands, British','VI'=>'Virgin Islands, U.S.','WF'=>'Wallis And Futuna','EH'=>'Western Sahara','YE'=>'Yemen','ZM'=>'Zambia','ZW'=>'Zimbabwe');
    if(!empty($code)) return $countries[$code];
    return $countries;
  }
  /**
   * Custom cURL Function
   * @since 1.0
   **/  
  public static function curl($url,$option=array()){
    if(in_array('curl', get_loaded_extensions())){    
      $option=!empty($options)?$option:array(CURLOPT_RETURNTRANSFER => 1,CURLOPT_URL => $url,CURLOPT_USERAGENT => 'Premium Poll Script');
      $curl = curl_init();
      curl_setopt_array($curl,$option);
      $resp = curl_exec($curl);
      curl_close($curl);    
      return $resp;
    }

    if(ini_get('allow_url_fopen')){
      return @file_get_contents($url);
    }
  }  
  /**
   * Send Email
   * @param array
   * @return boolean
   */  
  public static function send(array $array){    
    require_once(ROOT."/includes/library/PHPMailer.class.php");
    $mail= new PHPMailer();  
    if(!empty(self::$config["smtp"]["host"])){
      $mail->IsSMTP();
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = "tls";
      $mail->Host= self::$config["smtp"]["host"];
      $mail->Port = self::$config["smtp"]["port"]; 
      $mail->Username= self::$config["smtp"]["user"]; 
      $mail->Password  = self::$config["smtp"]["pass"];     
    }
    $mail->IsHTML(true); 
    $mail->SetFrom(self::$config["email"], self::$config["title"]);
    $mail->AddReplyTo(self::$config["email"], self::$config["title"]);
    $mail->AddAddress($array["to"]);
    $mail->Subject= $array["subject"];    

    $content=file_get_contents(TEMPLATE."/email.php");
    $content=str_replace("[subject]",$array["subject"],$content);
    $content=str_replace("[message]",$array["message"],$content);
    $content=str_replace("[title]",self::$config["title"],$content);
    $content=str_replace("[url]","<a href='".self::$config["url"]."'>".self::$config["url"]."</a>",$content);
    if(!empty(self::$config["facebook"])){
      $content=str_replace("[facebook]"," | <a href='".self::$config["facebook"]."'>Like us on Facebook</a>",$content);  
    }else{
      $content=str_replace("[facebook]","",$content);  
    }
    if(!empty(self::$config["twitter"])){
      $content=str_replace("[twitter]"," | <a href='".self::$config["twitter"]."'>Follow us on Twitter</a>",$content);
    }else{
      $content=str_replace("[twitter]","",$content);  
    }
    $mail->Body = $content;
    if(!$mail->Send()) {
        error_log("SMTP Error: {$mail->ErrorInfo}");
        $headers  = 'From:  '.self::$config["title"].' <'.self::$config["email"].'>' . "\r\n";
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        mail($array["to"], $array["subject"], $content, $headers);
        return TRUE;
    } else {
      return TRUE;
    }          
  }  
  /**
   * Country Codes
   * @since 1.0
   **/
 public static function ccode($code,$reverse=FALSE){
    $array=array('AF' => 'Afghanistan', 'AX' => 'Aland Islands', 'AL' => 'Albania', 'DZ' => 'Algeria', 'AS' => 'American Samoa', 'AD' => 'Andorra', 'AO' => 'Angola', 'AI' => 'Anguilla', 'AQ' => 'Antarctica', 'AG' => 'Antigua And Barbuda', 'AR' => 'Argentina', 'AM' => 'Armenia', 'AW' => 'Aruba', 'AU' => 'Australia', 'AT' => 'Austria', 'AZ' => 'Azerbaijan', 'BS' => 'Bahamas', 'BH' => 'Bahrain', 'BD' => 'Bangladesh', 'BB' => 'Barbados', 'BY' => 'Belarus', 'BE' => 'Belgium', 'BZ' => 'Belize', 'BJ' => 'Benin', 'BM' => 'Bermuda', 'BT' => 'Bhutan', 'BO' => 'Bolivia', 'BA' => 'Bosnia And Herzegovina', 'BW' => 'Botswana', 'BV' => 'Bouvet Island', 'BR' => 'Brazil', 'IO' => 'British Indian Ocean Territory', 'BN' => 'Brunei Darussalam', 'BG' => 'Bulgaria', 'BF' => 'Burkina Faso', 'BI' => 'Burundi', 'KH' => 'Cambodia', 'CM' => 'Cameroon', 'CA' => 'Canada', 'CV' => 'Cape Verde', 'KY' => 'Cayman Islands', 'CF' => 'Central African Republic', 'TD' => 'Chad', 'CL' => 'Chile', 'CN' => 'China', 'CX' => 'Christmas Island', 'CC' => 'Cocos (Keeling) Islands', 'CO' => 'Colombia', 'KM' => 'Comoros', 'CG' => 'Congo', 'CD' => 'Congo, Democratic Republic', 'CK' => 'Cook Islands', 'CR' => 'Costa Rica', 'CI' => 'Cote D\'Ivoire', 'HR' => 'Croatia', 'CU' => 'Cuba', 'CY' => 'Cyprus', 'CZ' => 'Czech Republic', 'DK' => 'Denmark', 'DJ' => 'Djibouti', 'DM' => 'Dominica', 'DO' => 'Dominican Republic', 'EC' => 'Ecuador', 'EG' => 'Egypt', 'SV' => 'El Salvador', 'GQ' => 'Equatorial Guinea', 'ER' => 'Eritrea', 'EE' => 'Estonia', 'ET' => 'Ethiopia', 'FK' => 'Falkland Islands (Malvinas)', 'FO' => 'Faroe Islands', 'FJ' => 'Fiji', 'FI' => 'Finland', 'FR' => 'France', 'GF' => 'French Guiana', 'PF' => 'French Polynesia', 'TF' => 'French Southern Territories', 'GA' => 'Gabon', 'GM' => 'Gambia', 'GE' => 'Georgia', 'DE' => 'Germany', 'GH' => 'Ghana', 'GI' => 'Gibraltar', 'GR' => 'Greece', 'GL' => 'Greenland', 'GD' => 'Grenada', 'GP' => 'Guadeloupe', 'GU' => 'Guam', 'GT' => 'Guatemala', 'GG' => 'Guernsey', 'GN' => 'Guinea', 'GW' => 'Guinea-Bissau', 'GY' => 'Guyana', 'HT' => 'Haiti', 'HM' => 'Heard Island & Mcdonald Islands', 'VA' => 'Holy See (Vatican City State)', 'HN' => 'Honduras', 'HK' => 'Hong Kong', 'HU' => 'Hungary', 'IS' => 'Iceland', 'IN' => 'India', 'ID' => 'Indonesia', 'IR' => 'Iran, Islamic Republic Of', 'IQ' => 'Iraq', 'IE' => 'Ireland', 'IM' => 'Isle Of Man', 'IL' => 'Israel', 'IT' => 'Italy', 'JM' => 'Jamaica', 'JP' => 'Japan', 'JE' => 'Jersey', 'JO' => 'Jordan', 'KZ' => 'Kazakhstan', 'KE' => 'Kenya', 'KI' => 'Kiribati', 'KR' => 'Korea', 'KW' => 'Kuwait', 'KG' => 'Kyrgyzstan', 'LA' => 'Lao People\'s Democratic Republic', 'LV' => 'Latvia', 'LB' => 'Lebanon', 'LS' => 'Lesotho', 'LR' => 'Liberia', 'LY' => 'Libyan Arab Jamahiriya', 'LI' => 'Liechtenstein', 'LT' => 'Lithuania', 'LU' => 'Luxembourg', 'MO' => 'Macao', 'MK' => 'Macedonia', 'MG' => 'Madagascar', 'MW' => 'Malawi', 'MY' => 'Malaysia', 'MV' => 'Maldives', 'ML' => 'Mali', 'MT' => 'Malta', 'MH' => 'Marshall Islands', 'MQ' => 'Martinique', 'MR' => 'Mauritania', 'MU' => 'Mauritius', 'YT' => 'Mayotte', 'MX' => 'Mexico', 'FM' => 'Micronesia, Federated States Of', 'MD' => 'Moldova', 'MC' => 'Monaco', 'MN' => 'Mongolia', 'ME' => 'Montenegro', 'MS' => 'Montserrat', 'MA' => 'Morocco', 'MZ' => 'Mozambique', 'MM' => 'Myanmar', 'NA' => 'Namibia', 'NR' => 'Nauru', 'NP' => 'Nepal', 'NL' => 'Netherlands', 'AN' => 'Netherlands Antilles', 'NC' => 'New Caledonia', 'NZ' => 'New Zealand', 'NI' => 'Nicaragua', 'NE' => 'Niger', 'NG' => 'Nigeria', 'NU' => 'Niue', 'NF' => 'Norfolk Island', 'MP' => 'Northern Mariana Islands', 'NO' => 'Norway', 'OM' => 'Oman', 'PK' => 'Pakistan', 'PW' => 'Palau', 'PS' => 'Palestinian Territory, Occupied', 'PA' => 'Panama', 'PG' => 'Papua New Guinea', 'PY' => 'Paraguay', 'PE' => 'Peru', 'PH' => 'Philippines', 'PN' => 'Pitcairn', 'PL' => 'Poland', 'PT' => 'Portugal', 'PR' => 'Puerto Rico', 'QA' => 'Qatar', 'RE' => 'Reunion', 'RO' => 'Romania', 'RU' => 'Russian Federation', 'RW' => 'Rwanda', 'BL' => 'Saint Barthelemy', 'SH' => 'Saint Helena', 'KN' => 'Saint Kitts And Nevis', 'LC' => 'Saint Lucia', 'MF' => 'Saint Martin', 'PM' => 'Saint Pierre And Miquelon', 'VC' => 'Saint Vincent And Grenadines', 'WS' => 'Samoa', 'SM' => 'San Marino', 'ST' => 'Sao Tome And Principe', 'SA' => 'Saudi Arabia', 'SN' => 'Senegal', 'RS' => 'Serbia', 'SC' => 'Seychelles', 'SL' => 'Sierra Leone', 'SG' => 'Singapore', 'SK' => 'Slovakia', 'SI' => 'Slovenia', 'SB' => 'Solomon Islands', 'SO' => 'Somalia', 'ZA' => 'South Africa', 'GS' => 'South Georgia And Sandwich Isl.', 'ES' => 'Spain', 'LK' => 'Sri Lanka', 'SD' => 'Sudan', 'SR' => 'Suriname', 'SJ' => 'Svalbard And Jan Mayen', 'SZ' => 'Swaziland', 'SE' => 'Sweden', 'CH' => 'Switzerland', 'SY' => 'Syrian Arab Republic', 'TW' => 'Taiwan', 'TJ' => 'Tajikistan', 'TZ' => 'Tanzania', 'TH' => 'Thailand', 'TL' => 'Timor-Leste', 'TG' => 'Togo', 'TK' => 'Tokelau', 'TO' => 'Tonga', 'TT' => 'Trinidad And Tobago', 'TN' => 'Tunisia', 'TR' => 'Turkey', 'TM' => 'Turkmenistan', 'TC' => 'Turks And Caicos Islands', 'TV' => 'Tuvalu', 'UG' => 'Uganda', 'UA' => 'Ukraine', 'AE' => 'United Arab Emirates', 'GB' => 'United Kingdom', 'US' => 'United States', 'UM' => 'United States Outlying Islands', 'UY' => 'Uruguay', 'UZ' => 'Uzbekistan', 'VU' => 'Vanuatu', 'VE' => 'Venezuela', 'VN' => 'Viet Nam', 'VG' => 'Virgin Islands, British', 'VI' => 'Virgin Islands, U.S.', 'WF' => 'Wallis And Futuna', 'EH' => 'Western Sahara', 'YE' => 'Yemen', 'ZM' => 'Zambia', 'ZW' => 'Zimbabwe');
    if($reverse){
      $array=array_flip($array);
      if(isset($array[$code])) return $array[$code];      
    }
    $code=strtoupper($code);
    if(isset($array[$code])) return $array[$code];
  }  
  /**
   * Current
   * @since 1.0
   **/
 public static function currency($code="",$amount=""){
    $array = array('RIAL' => array('label'=>'Iranian Rial','format' => '%s ریال'),'TOMAN' => array('label'=>'Iranian Toman','format' => '%s تومان'),'AUD' => array('label'=>'Australian Dollar','format' => '$ %s'),'CAD' => array('label' => 'Canadian Dollar','format' => '$ %s'),'EUR' => array('label' => 'Euro','format' => '€ %s'),'GBP' => array('label' => 'Pound Sterling','format' => '£ %s'),'JPY' => array('label' => 'Japanese Yen','format' => '¥ %s'),'USD' => array('label' => 'U.S. Dollar','format' => '$ %s'),'NZD' => array('label' => 'N.Z. Dollar','format' => '$ %s'),'CHF' => array('label' => 'Swiss Franc','format' => '%s Fr'),'HKD' => array('label' => 'Hong Kong Dollar','format' => '$ %s'),'SGD' => array('label' => 'Singapore Dollar','format' => '$ %s'),'SEK' => array('label' => 'Swedish Krona','format' => '%s kr'),'DKK' => array('label' => 'Danish Krone','format' => '%s kr'),'PLN' => array('label' => 'Polish Zloty','format' => '%s zł'),'NOK' => array('label' => 'Norwegian Krone','format' => '%s kr'),'HUF' => array('label' => 'Hungarian Forint','format' => '%s Ft'),'CZK' => array('label' => 'Czech Koruna','format' => '%s Kč'),'ILS' => array('label' => 'Israeli New Sheqel','format' => '₪ %s'),'MXN' => array('label' => 'Mexican Peso','format' => '$ %s'),'BRL' => array('label' => 'Brazilian Real','format' => 'R$ %s'),'MYR' => array('label' => 'Malaysian Ringgit','format' => 'RM %s'),'PHP' => array('label' => 'Philippine Peso','format' => '₱ %s'),'TWD' => array('label' => 'New Taiwan Dollar','format' => 'NT$ %s'),'THB' => array('label' => 'Thai Baht','format' => '฿ %s'),'TRY' => array('label' => 'Turkish Lira','format' => 'TRY %s'));
    if(empty($code)) return $array;
    
    $code=strtoupper($code);
    if(isset($array[$code])) return sprintf($array[$code]["format"],$amount);
  }   
 /**
  * Format Font
  * @since 1.0
  **/  
 public static function fontf($fonts){
   return json_encode(explode("\n",str_replace("\r", "", $fonts)));
 }
}
?>
