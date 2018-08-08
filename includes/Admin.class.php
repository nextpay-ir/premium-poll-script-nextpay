<?php 
/**
 * ====================================================================================
 *                           Premium Poll Script (c) KBRmedia
 * ----------------------------------------------------------------------------------
 *  @copyright - This software is exclusively sold at CodeCanyon.net. If you have downloaded this
 *  from another site or received it from someone else than me, then you are engaged
 *  in illegal activity. You must delete this software immediately or buy a proper
 *  license from http://codecanyon.net/user/KBRmedia/portfolio?ref=KBRmedia.
 *
 *	@license http://gempixel.com/license
 *
 *  Thank you for your cooperation and don't hesitate to contact me if anything :)
 * ====================================================================================
 *
 * @author KBRmedia (http://gempixel.com)
 * @link http://gempixel.com
 * @package Premium Poll Script
 * @subpackage Admin Class (Admin.class.php)
 */

class Admin{
  /**
   * Authorized actions
   * @since 1.0
   **/
  protected $actions=array("users","polls","payments","pages","settings","help","search");
  /**
   * Config
   * @since 1.0
   **/
  protected $config; 
  /**
   *  DB
   * @since 1.0
   **/
  protected $db;
  /**
   * Admin Info
   * @since 1.0
   **/
  protected $user;
  /**
   * Admin URL
   * @since 1.0
   **/
  protected $url;
  /**
   *  Current Page 
   * @since 1.0
   **/
  protected $page;
  /**
   * Reseverd Variable
   * @since 1.0
   **/
  protected $action;
  /**
   * Reseverd Variable
   * @since 1.0
   **/  
  protected $do;
  /**
   * Reseverd Variable
   * @since 1.0
   **/
  protected $id;
  /**
   * Admin Limit/Page
   * @since 1.0
   **/
  protected $limit=24;

  /**
   * Construct Admin
   * @since 1.0
   **/
  public function __construct($config,$db){
     $this->config=$config;
     $this->db=$db;     
     $this->url="{$this->config["url"]}/admin";
     $this->page=(isset($_GET["page"]) && is_numeric($_GET["page"]) && $_GET["page"]!="0")?$_GET["page"]:'1';     
     $this->check();
  }
  public function __destruct(){
	  unset($this->config,$this->db,$this->error,$this->user);
  }
  /**
   * Check if user is logged
   * @since 1.0
   **/
  public function check(){
    if($info=Main::user()){
      $this->db->object=TRUE;
      if($user=$this->db->get("user",array("id"=>"?","auth_key"=>"?"),array("limit"=>1),array($info[0],$info[1]))){
        if(!$user->admin) return Main::redirect("404");
        $this->logged=TRUE;       
        $this->user = $user;
        $this->user->membership=(empty($user->membership) || $user->membership=='free')?"free":"pro";
        return TRUE;
      }
    }
    return Main::redirect("404");
  }  
  /**
   * Run Admin Panel
   * @since 1.0
   **/
  public function run(){
    if(isset($_GET["a"]) && !empty($_GET["a"])){
      $var=explode("/",$_GET["a"]);
      if(in_array($var[0],$this->actions) && method_exists("Admin", $var[0])){
        $this->action=Main::clean($var[0],3,TRUE);
        if(isset($var[1]) && !empty($var[1])) $this->do=Main::clean($var[1],3,TRUE);
        if(isset($var[2]) && !empty($var[2])) $this->id=Main::clean($var[2],3,TRUE);
        return $this->{$var[0]}();
      } 
      return Main::redirect("admin",array("danger","Oups! The page you are looking for doesn't exist."));
    }else{
      return $this->home();
    }
  }  
  /**
   * Admin Home Page
   * @since 1.0
   **/
  protected function home(){
    // Chart Data
    $this->charts();
    $topcountries=$this->countries();

    $this->db->object=TRUE;
    $polls=$this->db->get("poll","",array("limit"=>5,"order"=>"created"));
    $users=$this->db->get("user","",array("limit"=>5,"order"=>"date"));
    $payments=$this->db->run("SELECT {$this->db->prefix}payment.*,{$this->db->prefix}user.email FROM {$this->db->prefix}payment INNER JOIN {$this->db->prefix}user ON {$this->db->prefix}payment.userid = {$this->db->prefix}user.id ORDER BY date DESC LIMIT 20",array(),TRUE);
    $this->header();
    include($this->t(__FUNCTION__));
    $this->footer();
  }
    /**
     *  Dashboard Chart Data Function
     *  @since 1.0
     */   
      protected function charts($span=15){
        $this->db->object=FALSE;
        $usersbydate=$this->db->get(array("count"=>"COUNT(DATE(date)) as count, DATE(date) as date","table"=>"user"),"(date >= CURDATE() - INTERVAL $span DAY)",array("group_custom"=>"DATE(date)","limit"=>"0 , $span"));
        $usersbymem=$this->db->get(array("count"=>"COUNT(DATE(date)) as count, DATE(date) as date","table"=>"user"),"(date >= CURDATE() - INTERVAL $span DAY) AND membership='pro'",array("group_custom"=>"DATE(date)","limit"=>"0 , $span"));
        $polls=$this->db->get(array("count"=>"COUNT(DATE(created)) as count, DATE(created) as date","table"=>"poll"),"(created >= CURDATE() - INTERVAL $span DAY)",array("group_custom"=>"DATE(created)","limit"=>"0 , $span"));

        $new_date=array();  
        $new_mem=array(); 
        $new_polls=array();
        if($usersbydate){
          foreach ($usersbydate as $user[0] => $data) {
            $new_date[date("d M",strtotime($data["date"]))]=$data["count"];
          } 
        }
        foreach ($usersbymem as $user[0] => $data) {
          $new_mem[date("d M",strtotime($data["date"]))]=$data["count"];
        } 
        foreach ($polls as $polls[0] => $data) {
          $new_polls[date("d M",strtotime($data["date"]))]=$data["count"];
        }
        $timestamp = time();
        for ($i = 0 ; $i < $span ; $i++) {
            $array[date('d M', $timestamp)]=0;
            $timestamp -= 24 * 3600;
        }
        $date=""; $var=""; $date1=""; $var1=""; $date2=""; $var2=""; $i=0; 

        foreach ($array as $key => $value) {
          $i++;
          if(isset($new_date[$key])){
            $var.="[".($span-$i).", ".$new_date[$key]."], ";
            $date.="[".($span-$i).",\"$key\"], ";
          }else{
            $var.="[".($span-$i).", 0], ";
            $date.="[".($span-$i).", \"$key\"], ";
          }
          if(isset($new_mem[$key])){
            $var1.="[".($span-$i).", ".$new_mem[$key]."], ";
            $date1.="[".($span-$i).",\"$key\"], ";
          }else{
            $var1.="[".($span-$i).", 0], ";
            $date1.="[".($span-$i).", \"$key\"], ";
          }   
          if(isset($new_polls[$key])){
            $var2.="[".($span-$i).", ".$new_polls[$key]."], ";
            $date2.="[".($span-$i).",\"$key\"], ";
          }else{
            $var2.="[".($span-$i).", 0], ";
            $date2.="[".($span-$i).", \"$key\"], ";
          }   
        }
        $data=array("registered"=>array($var,$date),"mem"=>array($var1,$date1),"poll"=>array($var2,$date2));
        Main::admin_add("<script type='text/javascript'>var options = {
              series: {
                lines: { show: true, lineWidth: 2,fill: true},
                //bars: { show: true,lineWidth: 1 },  
                points: { show: true, lineWidth: 2 }, 
                shadowSize: 0
              },
              grid: { hoverable: true, clickable: true, tickColor: '#fff', borderWidth:0 },
              colors: ['#0da1f5', '#F11010', '#1F2227'],
              xaxis: {ticks:[{$data["registered"][1]},{$data["mem"][1]}], tickDecimals: 0, color: '#999'},
              yaxis: {ticks:3, tickDecimals: 0, color: '#999'},
              xaxes: [ { mode: 'time'} ]
          }; 
          var data = [{
              label: ' New Users',
              data: [{$data['registered'][0]}]
          },{
              label: ' Pro Memberships',
              data: [{$data["mem"][0]}]
          }];
          var data2 =[{
              label: ' Polls',
              data: [{$data["poll"][0]}]
          }];
          $.plot('#user-chart', data ,options);$.plot('#poll-chart', data2 ,options);</script>",'custom',TRUE);        
      } 
    /**
     *  Dashboard Country Function
     *  @since 1.1
     */     
     protected function countries(){
        $this->db->object=FALSE;
        $countries=$this->db->get(array("count"=>"COUNT(country) as count, country as country","table"=>"vote"),"",array("group"=>"country","order"=>"count"));
        $i=0;
        $top_countries=array();
        $country=array();
        foreach ($countries as $c) {
          $country[strtoupper($c["country"])]=$c["count"];
          if($i<=10){
            if(!empty($c["country"])) $top_countries[Main::ccode($c["country"])]=$c["count"];
          }
          $i++;
        }
        Main::admin_add("<script type='text/javascript'>var data=".json_encode($country)."; $('#country-map').vectorMap({
          map: 'world_mill_en',
          backgroundColor: 'transparent',
          series: {
            regions: [{
              values: data,
              scale: ['#74CBFA', '#0da1f5'],
              normalizeFunction: 'polynomial'
            }]
          },
          onRegionLabelShow: function(e, el, code){
            if(typeof data[code]!='undefined') el.html(el.html()+' ('+data[code]+' Votes)');
          }     
        });</script>","custom");
        return $top_countries;
     }    
  /**
   * Polls
   * @since 1.0
   **/
  protected function polls(){
    // Edit Poll
    if($this->do=="edit" && is_numeric($this->id)){    
      $this->poll_edit();
      return;
    }
    // Delete Poll
    if($this->do=="delete"){
      // Disable this for demo
      if($this->config["demo"]) return Main::redirect("admin",array("danger","Feature disabled in demo."));      
      $this->poll_delete();
      return;
    }
    $this->db->object=TRUE;
    $filters=array("id"=>array("id",TRUE),"votes"=>array("votes",FALSE));    
    if(isset($_GET["filter"]) && array_key_exists($_GET["filter"] ,$filters)){
      $filter=$filters[$_GET["filter"]][0];
      $asc=$filters[$_GET["filter"]][1];
    }else{
      $filter="id";
      $asc=FALSE;
    }           
    if($this->do=="view" && is_numeric($this->id)){
      $where=array("userid"=>$this->id);
    }else{
      $where="";
    }
    $polls=$this->db->get("poll",$where,array("count"=>1,"order"=>$filter,"limit"=>(($this->page-1)*$this->limit).", ".$this->limit."","asc"=>$asc));
    if (($this->db->rowCount%$this->limit)<>0) {
      $max=floor($this->db->rowCount/$this->limit)+1;
    } else {
      $max=floor($this->db->rowCount/$this->limit);
    }    
    $header="".e("Polls")." ({$this->db->rowCount}) <a href='".Main::href("create")."' class='btn btn-xs btn-primary pull-right'>".e("Create")."</a>";
    $thead="<th><input type='checkbox' id='check-all'></th><th><a href='".Main::ahref("polls&filter=id","polls?filter=id")."'><span class='glyphicon glyphicon-sort pull-right'></span> ".e("Poll ID")."</a></th><th>".e("User ID")."</th><th>".e("Question")."</th><th>".e("Number of Answers")."</th><th><a href='".Main::ahref("polls&filter=votes","polls?filter=votes")."'><span class='glyphicon glyphicon-sort pull-right'></span> ".e("Votes")."</a></th><th>".e("Open")."</th><th>".e("Options")."</th>";
    $tbody="";
      foreach ($polls as $poll){
              $tbody.="<tr>
                <td><input type='checkbox' class='data-delete-check' name='delete-id[]' value='{$poll->id}'></td>
                <td>{$poll->id}</td>
                <td>".(($poll->userid==0)?'Anonymous':$poll->userid)."</td>
                <td>{$poll->question}</td>
                <td>".count(json_decode($poll->options,TRUE))."</td>
                <td>{$poll->votes}</td>
                <td>{$poll->open}</td>
                <td>
                  <a href='".Main::href($poll->uniqueid)."' class='btn btn-xs btn-success' target='_blank'>".e("View")."</a>
                  <a href='".Main::ahref("polls/edit/{$poll->id}")."' class='btn btn-xs btn-primary'>".e("Edit")."</a>
                  <a href='".Main::ahref("polls/delete/{$poll->id}&".Main::nonce(),"polls/delete/{$poll->id}?".Main::nonce())."' class='btn btn-xs btn-danger delete'>".e("Delete")."</a>
                </td>
              </tr>";             
      }
    $pagination=Main::pagination($max,$this->page,Main::ahref("polls&page=%d&filter=$filter","polls?page=%d&filter=$filter"));
    Main::set("title","Polls");
    $this->header();
    include($this->t("template"));
    $this->footer();
  }
    /**
     * Edit Poll
     * @since 1.0
     **/
    private function poll_edit(){
      // Update Poll
      if(isset($_POST["token"])){ 
        // Disable this for demo
        if($this->config["demo"]) return Main::redirect("admin",array("danger","Feature disabled in demo."));        
        // Validat Poll
        if(!Main::validate_csrf_token($_POST["token"])){
          return Main::redirect(Main::href("polls/edit/{$this->id}","",FALSE),array("danger",e("Invalid token. Please try again.")));
        }     
        // Check Question
        if(strlen(Main::clean($_POST["question"],3,TRUE,FALSE)) < 5) return Main::redirect(Main::ahref("polls/edit/{$this->id}","",FALSE),array("danger",e("That is not a valid question.")));
        $new_options=array();
        $total=0;
        foreach ($_POST["option"] as $key=>$q) {  
          $q["answer"]=Main::clean($q["answer"],3,TRUE);
          if(empty($q["answer"])) continue;
          if(isset($q["count"]) && is_numeric($q["count"])){
            $count=$q["count"];
          }else{
            $count=0;
          }
          $total=$total+$count;
          $new_options[$key]=array("answer"=>$q["answer"],"count"=>$count);
        }

        if(empty($new_options[1]["answer"])) return Main::redirect(Main::ahref("polls/edit/{$this->id}","",FALSE),array("danger",e("That is not a valid choice of answers.")));
        
        $custom=array(
          "background" => Main::clean($_POST["background"],3),
          "font" => in_array($_POST["font"], json_decode($this->config["fonts"],TRUE))?$_POST["font"]:"null"
        );

        $data=array(
          ":userid" => $_POST["userid"],
          ":question" => Main::clean($_POST["question"],3,TRUE),
          ":options" => json_encode($new_options),
          ":share" => in_array($_POST["share"],array("1","0"))?$_POST["share"]:"0",
          ":pass" => Main::clean($_POST["pass"],3,TRUE),
          ":choice" => in_array($_POST["choice"],array("1","0"))?$_POST["choice"]:"0",
          ":theme" => str_replace(" ", "_", Main::clean($_POST["theme"],3,TRUE)),
          ":custom" => json_encode($custom),
          ":results"=> in_array($_POST["results"],array("1","0"))?$_POST["results"]:"0",
          ":count" => in_array($_POST["vote"],array("month","day","off"))?$_POST["vote"]:"off",
          ":votes" => $total
          );        

          if($_POST["expires"]!=="Never") $data[":expires"]=$_POST["expires"];
          if($this->db->update("poll","",array("id"=>$this->id),$data))       {
            return Main::redirect(Main::ahref("polls/edit/{$this->id}","",FALSE),array("success",e("Poll has been edited.")));
          }
      }        
      $this->db->object=TRUE;
      $poll=$this->db->get("poll",array("id"=>"?"),array("limit"=>1),array($this->id));
      if(!$poll) Main::redirect(Main::ahref("polls","",FALSE),array("danger","Poll not found."));
      $header="Edit: {$poll->question}";
      $options=json_decode($poll->options);
      $custom=json_decode($poll->custom);
      $poll->font=$custom->font;
      $poll->background=$custom->background;
      $poll->theme=str_replace("_"," ",$poll->theme);
      $poll->expires=(empty($poll->expires) || is_null($poll->expires) || !$poll->expires)?"":$poll->expires;
      $content="<div class='row'>
            <form action='".Main::ahref("polls/edit/{$poll->id}")."' method='post'>                  
              <div class='col-md-8'>
                <div class='box-holder live_form'>                  
                  <h4>".e('Question')."</h4>
                  <div class='form-group'>
                    <input type='text' class='form-control' placeholder='Question' name='question' value='{$poll->question}'>
                  </div>  
                  <h4>".e('Answers')."</h4>
                    <ul id='sortable'>";
                    foreach ($options as $key => $value) {
                      $content.= "<li id='poll_sort_".($key)."'>
                        <div class='row'>
                          <div class='col-md-9'>
                            <div class='input-group'>
                              <span class='input-group-addon'><i class='glyphicon glyphicon-move'></i></span>
                              <input type='text' class='form-control' name='option[".($key)."][answer]' value='{$value->answer}'>
                            </div>                          
                          </div>
                          <div class='col-md-3'>
                            <div class='input-group'>
                              <span class='input-group-addon'><i class='glyphicon glyphicon-user'></i></span>
                              <input type='text' class='form-control counts' name='option[".($key)."][count]' value='{$value->count}'>
                            </div>                          
                          </div>
                        </div>                
                      </li>   ";
                    }                           
      $content.="     </ul>    
                    <p>
                      <a href='#' id='add-field' class='btn btn-transparent'><small>".e('Add Field')."</small></a>
                    </p>                  
                </div>       
                <p class='hidden help-block'>Click the reset button will reset the votes to 0 but they will only be saved once you click Edit Poll. To cancel it reload the page without saving.</p>
                <p><br>
                  <input type='hidden' name='reset' value='0' />
                  <button type='submit' class='btn btn-primary btn-lg'>".e('Edit Poll')."</button>
                  <a href='#' class='btn btn-danger btn-lg' id='reset-votes'>".e('Reset Votes')."</a>
                  <a href='".Main::href($poll->uniqueid)."' class='btn btn-success btn-lg pull-right' target='_blank'>".e('View')."</a>
                </p> 
              </div>
              <div class='col-md-4'>  
              <ul class='nav nav-pills tabs'>
                <li class='active'><a href='#options'>".e("Options")."</a></li>
                <li><a href='#theme-options'>".e("Design")."</a></li>
              </ul>         
              <br>   
               <div id='options' class='tabbed'>
                <div class='form-group'>
                  <label for='share'>".e('Sharing')."</label>
                  <select id='share' name='share'>
                    <option value='1' ".($poll->share?"selected":"").">".e('Enabled')."</option>
                    <option value='0' ".(!$poll->share?"selected":"").">".e('Disabled')."</option>                
                  </select>
                </div>    
                <div class='form-group'>
                  <label for='results'>".e('Show Results')."</label>
                  <select id='results' name='results'>
                    <option value='1' ".($poll->results?"selected":"").">".e('Enabled')."</option>
                    <option value='0' ".(!$poll->results?"selected":"").">".e('Disabled')."</option>                
                  </select>
                </div>                  
                <div class='form-group'>
                  <label for='choise'>".e('Mutliple Choices')."</label>
                  <select id='choice' name='choice'>
                    <option value='1' ".($poll->choice?"selected":"").">".e('Enabled')."</option>
                    <option value='0' ".(!$poll->choice?"selected":"").">".e('Disabled')."</option>                
                  </select>
                </div>      
                <div class='form-group'>
                  <label for='vote'>".e('Multiple Votes')."</label>
                  <select id='vote' name='vote'>
                    <option value='month' ".($poll->count=="month"?"selected":"").">".e('Monthly')."</option>
                    <option value='day' ".($poll->count=="day"?"selected":"").">".e('Daily')."</option>
                    <option value='0' ".($poll->count=="off"?"selected":"").">".e('Disabled')."</option>                
                  </select>
                </div>                                                  
                <div class='form-group'>
                  <label for='expires'>".e('Expires in')." (None if empty)</label>
                  <input type='text' class='form-control datepicker' id='expires' name='expires' value='{$poll->expires}'>
                </div>
                <div class='form-group'>
                  <label for='pass'>Password</label>
                  <input type='text' class='form-control' id='pass' name='pass' value='{$poll->pass}'>
                </div>  
               </div> 
               <div id='theme-options' class='tabbed'>
                <h5>".e("Simple")."</h5>
                <ul class='themes'>                
                  <li class='dark'><a href='#' ".($poll->theme=="dark"?"class='current'":"")." data-class='dark'>Dark</a></li>
                  <li class='light'><a href='#'  ".($poll->theme=="light"?"class='current'":"")." data-class='light'>Light</a></li>
                  <li class='blue'><a href='#' ".($poll->theme=="blue"?"class='current'":"")." data-class='blue'>Blue</a></li>                
                  <li class='red'><a href='#' ".($poll->theme=="red"?"class='current'":"")." data-class='red'>Red</a></li>
                  <li class='green'><a href='#'  ".($poll->theme=="green"?"class='current'":"")." data-class='green'>Green</a></li>
                  <li class='yellow'><a href='#' ".($poll->theme=="yellow"?"class='current'":"")." data-class='yellow'>Yellow</a></li>
                </ul> 
                <h5>".e("Boxed")."</h5>
                <ul class='themes'>                
                  <li class='dark '><a href='#' ".($poll->theme=="bs dark"?"class='current'":"")." data-class='bs dark'>Dark</a></li>
                  <li class='light'><a href='#'  ".($poll->theme=="bs light"?"class='current'":"")." data-class='bs light'>Light</a></li>
                  <li class='blue '><a href='#' ".($poll->theme=="bs blue"?"class='current'":"")." data-class='bs blue'>Blue</a></li>                
                  <li class='red'><a href='#' ".($poll->theme=="bs red"?"class='current'":"")." data-class='bs red'>Red</a></li>
                  <li class='green'><a href='#'  ".($poll->theme=="bs green"?"class='current'":"")." data-class='bs green'>Green</a></li>
                  <li class='yellow'><a href='#' ".($poll->theme=="bs yellow"?"class='current'":"")." data-class='bs yellow'>Yellow</a></li>
                </ul>     
                <h5>".e("Inline")."</h5>
                <ul class='themes'>                
                  <li class='dark '><a href='#' ".($poll->theme=="is dark"?"class='current'":"")." data-class='is dark'>Dark</a></li>
                  <li class='light'><a href='#'  ".($poll->theme=="is light"?"class='current'":"")." data-class='is light'>Light</a></li>
                  <li class='blue '><a href='#' ".($poll->theme=="is blue"?"class='current'":"")." data-class='is blue'>Blue</a></li>                
                  <li class='red'><a href='#' ".($poll->theme=="is red"?"class='current'":"")." data-class='is red'>Red</a></li>
                  <li class='green'><a href='#'  ".($poll->theme=="is green"?"class='current'":"")." data-class='is green'>Green</a></li>
                  <li class='yellow'><a href='#' ".($poll->theme=="is yellow"?"class='current'":"")." data-class='is yellow'>Yellow</a></li>
                </ul>                  
                <input type='hidden' name='theme' value='{$poll->theme}' id='poll_theme_value'>    
                <br>             
                <div class='form-group'>
                  <label for='font'>".e('Font')."</label>
                  <select id='font' name='font' class='choose_font'>
                    <option value='null' ".($poll->font=="null"?"selected":"").">Default</option>";
                  $fonts=json_decode($this->config["fonts"],TRUE);
                  foreach ($fonts as $font){
                      $content.="<option value='".str_replace(" ","_", strtolower($font))."' ".($poll->font==str_replace(" ","_", $font)?'selected':'').">$font</option>";
                  }                
                                     
            $content.="</select>
                </div>              
                <div class='form-group'>
                  <label for='background'>".e('Custom Image Background')."</label>
                  <input type='text' class='form-control' name='background' value='{$poll->background}' id='background' placholder='e.g. http://mysite.com/background.png'>
                </div>                  
              </div>
              <input type='hidden' value='{$poll->userid}' name='userid'>
              ".Main::csrf_token(TRUE)."
            </form>
          </div>";
      Main::set("title","Edit Poll");
      $this->header();
      include($this->t("edit"));
      $this->footer();
    }
    /**
     * Delete Poll
     * @since 1.0
     **/
    private function poll_delete(){
      if(isset($_POST["token"]) && isset($_POST["delete-id"]) && is_array($_POST["delete-id"])){
        // Validate Token
        if(!Main::validate_csrf_token($_POST["token"])){
          return Main::redirect(Main::ahref("polls","",FALSE),array("danger",e("Invalid token. Please try again.")));
        }     
        $query="(";
        $query2="(";
        $c=count($_POST["delete-id"]);
        $p="";
        $i=1;
        foreach ($_POST["delete-id"] as $id) {
          if($i>=$c){
            $query.="`id` = :id$i";
            $query2.="`pollid` = :id$i";
          }else{
            $query.="`id` = :id$i OR ";
            $query2.="`pollid` = :id$i OR ";
          }
          $query.=")";
          $query2.=")";           
          $p[":id$i"]=$id;
          $i++;
        }    

        $this->db->delete("poll",$query,$p);
        $this->db->delete("vote",$query2,$p);
        return Main::redirect(Main::ahref("polls","",FALSE),array("success",e("Polls have been deleted.")));
      }
      if(!empty($this->id) && is_numeric($this->id)){
        // Validated Nonce
        if(!Main::validate_nonce()) return Main::redirect(Main::ahref("polls","",FALSE),array("danger","Security token expired. Please try again."));
        $id=$this->id;
        $this->db->delete("poll",array("id"=>"?"),array($id));
        $this->db->delete("vote",array("pollid"=>"?"),array($id));
        return Main::redirect(Main::ahref("polls","",FALSE),array("success",e("Poll has been deleted.")));
      } 
      return Main::redirect(Main::ahref("polls","",FALSE),array("danger",e("An unexpected error occured.")));
    }
  /**
   * Payments
   * @since 1.0
   **/
  protected function payments(){
    // Export
    if($this->do=="export"){
      // Disable this for demo
      if($this->config["demo"]) return Main::redirect("admin",array("danger","Feature disabled in demo."));
      // Validated Nonce
      if(!Main::validate_nonce()) return Main::redirect(Main::ahref("payments","",FALSE),array("danger","Security token expired. Please try again."));
      // Export Payments
      header('Content-Type: text/csv');
      header('Content-Disposition: attachment;filename=Payments.csv');
      $this->db->object=TRUE;
      $payments = $this->db->get("payment","",array("order"=>"id","all"=>1));
      echo "Transaction ID,Paypal Transaction ID,Status,User ID,Date,Membership Expiration,Amount\n";
      foreach ($payments as $payment) {
        echo "{$payment->id},{$payment->tid},{$payment->status},{$payment->userid},{$payment->date},{$payment->expires},{$payment->amount}\n";
      }
      return Main::redirect(Main::ahref("payments","",FALSE),array("danger","Security token expired. Please try again."));;      
    }
    // Make a payment as Completed
    if($this->do=="review" && is_numeric($this->id)){
      // Disable this for demo
      if($this->config["demo"]) return Main::redirect("admin",array("danger","Feature disabled in demo."));
      if($this->db->update("payment",array("status"=>"?"),array("id"=>"?"),array("Completed",$this->id))){
        return Main::redirect(Main::ahref("payments","",FALSE),array("success","Payment has been marked as Completed."));
      }
      return Main::redirect(Main::ahref("payments","",FALSE),array("danger","Security token expired. Please try again."));
    }

    // Get Payments
    Main::set("title","Payments");
    $this->db->object=TRUE;
    $filters=array("id"=>array("id",TRUE),"date"=>array("date",TRUE),"expire"=>array("expires",FALSE));   
    if(isset($_GET["filter"]) && array_key_exists($_GET["filter"] ,$filters)){
      $filter=$filters[$_GET["filter"]][0];
      $asc=$filters[$_GET["filter"]][1];
    }else{
      $filter="id";
      $asc=FALSE;
    }       
    if($this->do=="view" && is_numeric($this->id)){
      $where=array("userid"=>$this->id);
    }else{
      $where="";
    }
    $payments=$this->db->get("payment",$where,array("count"=>1,"order"=>$filter,"limit"=>(($this->page-1)*$this->limit).", ".$this->limit."","asc"=>$asc));

    if (($this->db->rowCount%$this->limit)<>0) {
      $max=floor($this->db->rowCount/$this->limit)+1;
    } else {
      $max=floor($this->db->rowCount/$this->limit);
    }    
    $header="Payments ({$this->db->rowCount}) <a href='".Main::ahref("payments/export&".Main::nonce(),"payments/export?".Main::nonce())."' class='btn btn-xs btn-primary pull-right'>Export</a>";
    $thead="<th><a href='".Main::ahref("payments&filter=id","payments?filter=id")."'><span class='glyphicon glyphicon-sort pull-right'></span> Transaction ID</a></th><th>Paypal Transaction ID</th><th>Status</th><th>User ID</th><th><a href='".Main::ahref("payments&filter=date","payments?filter=date")."'><span class='glyphicon glyphicon-sort pull-right'></span> Date</a></th><th><a href='".Main::ahref("payments&filter=expire","payments?filter=expire")."'><span class='glyphicon glyphicon-sort pull-right'></span> Membership Expiration</a></th><th>Amount</th>";
    $tbody="";
      foreach ($payments as $payment){
        if($this->config["demo"]) $payment->tid="Hidden in demo to protect privacy";
              $tbody.="<tr>
                <td>{$payment->id}</td>
                <td>{$payment->tid}</td>
                <td>".(($payment->status!=="Completed")?"<a href='".Main::ahref("payments/review/{$payment->id}&".Main::nonce(),"payments/review/{$payment->id}?".Main::nonce())."' class='btn btn-xs btn-primary'>{$payment->status} (Mark as Completed)</a>":$payment->status)."</td>
                <td><a href='".Main::ahref("users/edit/{$payment->userid}")."'>{$payment->userid}</a></td>
                <td>".date("d-M-Y, H:i",strtotime($payment->date))."</td>
                <td>".date("d-M-Y, H:i",strtotime($payment->expires))."</td>
                <td>{$payment->amount}</td>
              </tr>";             
      }
    $pagination=Main::pagination($max,$this->page,Main::ahref("payments&page=%d&filter=$filter","payments?page=%d&filter=$filter"));
    $this->header();
    include($this->t("template"));
    $this->footer();    
  }  
  /**
   * Users
   * @since 1.0
   **/
  protected function users(){
    // Edit User
    if($this->do=="edit" && is_numeric($this->id)){
      $this->user_edit();
      return;
    }
    // Add User
    if($this->do=="add"){
      $this->user_add();
      return;
    }    
    // Delete User
    if($this->do=="delete"){
      // Disable this for demo
      if($this->config["demo"]) return Main::redirect("admin",array("danger","Feature disabled in demo."));
      $this->user_delete();
      return;
    }    
    
    $this->db->object=TRUE;    
    $filters=array("id"=>array("id",TRUE),"date"=>array("date",TRUE),"mem"=>array("membership",FALSE),"expire"=>array("expires",FALSE));    
    if(isset($_GET["filter"]) && array_key_exists($_GET["filter"] ,$filters)){
      $filter=$filters[$_GET["filter"]][0];
      $asc=$filters[$_GET["filter"]][1];
    }else{
      $filter="id";
      $asc=FALSE;
    }    
    $users=$this->db->get("user","",array("count"=>1,"order"=>"$filter","limit"=>(($this->page-1)*$this->limit).", ".$this->limit."","asc"=>$asc));
    if (($this->db->rowCount%$this->limit)<>0) {
      $max=floor($this->db->rowCount/$this->limit)+1;
    } else {
      $max=floor($this->db->rowCount/$this->limit);
    }    
    $header="".e("Users")." ({$this->db->rowCount}) <a href='".Main::ahref("users/add")."' class='btn btn-xs btn-primary pull-right'>".e("Add User")."</a>";
    $thead="<th><input type='checkbox' id='check-all'></th><th><a href='".Main::ahref("users&filter=id","users?filter=id")."'><span class='glyphicon glyphicon-sort pull-right'></span>  ".e("User ID")."</a></th><th>".e("Email")."</th><th><a href='".Main::ahref("users&filter=date","users?filter=date")."'><span class='glyphicon glyphicon-sort pull-right'></span>  ".e("Registration Date")."</a></th><th><a href='".Main::ahref("users&filter=mem","users?filter=mem")."'><span class='glyphicon glyphicon-sort pull-right'></span>  ".e("Membership")."</a></th><th><a href='".Main::ahref("users&filter=expire","users?filter=expire")."'><span class='glyphicon glyphicon-sort pull-right'></span>  ".e("Membership Expiration")."</a></th><th>".e("Options")."</th>";
    $tbody="";
      foreach ($users as $user){
        if($this->config["demo"]) $user->email="Hidden in demo to protect privacy";
              $tbody.="<tr>
                <td><input type='checkbox' class='data-delete-check' name='delete-id[]' value='{$user->id}'></td>
                <td>{$user->id}</td>
                <td>".($user->admin?"<strong>{$user->email}</strong>":$user->email)."</td>
                <td>".date("M d, Y H:i",strtotime($user->date))."</td>
                <td>".ucfirst($user->membership)."</td>
                <td>".($user->membership=="free"?"Never":date("M d, Y",strtotime($user->expires)))."</td>
                <td>
                  <a href='".Main::ahref("polls/view/{$user->id}")."' class='btn btn-xs btn-default'>".e("View Polls")."</a>
                  <a href='".Main::ahref("payments/view/{$user->id}")."' class='btn btn-xs btn-success'>".e("View Payments")."</a>
                  <a href='".Main::ahref("users/edit/{$user->id}")."' class='btn btn-xs btn-primary'>".e("Edit")."</a>
                  <a href='".Main::ahref("users/delete/{$user->id}&".Main::nonce(),"users/delete/{$user->id}?".Main::nonce())."' class='btn btn-xs btn-danger delete'>".e("Delete")."</a>
                </td>
              </tr>";             
      }
    $pagination=Main::pagination($max,$this->page,Main::ahref("users&page=%d&filter=$filter","users?page=%d&filter=$filter"));
    Main::set("title","Users");
    $this->header();
    include($this->t("template"));
    $this->footer();
  }
    /**
     * Edit User
     * @since 1.0
     **/  
    private function user_edit(){
      // Save user info
      if(isset($_POST["token"])){
        // Disable this for demo
        if($this->config["demo"]) return Main::redirect("admin",array("danger","Feature disabled in demo."));        
        // Validate Token
        if(!Main::validate_csrf_token($_POST["token"])){
          return Main::redirect(Main::ahref("users/edit/{$this->id}","",FALSE),array("danger",e("Invalid token. Please try again.")));
        }     

        if(!Main::email($_POST["email"])) return Main::redirect(Main::ahref("users/edit/{$this->id}","",FALSE),array("danger",e("The email entered is not valid.")));
        // Check email in database
        if($this->db->get("user","email=? AND id!=?","",array($_POST["email"],$this->id))) return Main::redirect(Main::ahref("users/edit/{$this->id}","",FALSE),array("danger",e("An account is already associated with this email.")));        
        $data=array(
          ":email" => Main::clean($_POST["email"],3),
          ":banned" => (in_array($_POST["banned"], array("0","1"))?$_POST["banned"]:0),
          ":admin" => (in_array($_POST["admin"], array("0","1"))?$_POST["admin"]:0),
          ":membership" => (in_array($_POST["membership"], array("free","pro"))?$_POST["membership"]:"free")
          );
        if(!empty($_POST["password"])){
          if(strlen($_POST["password"])<5) return Main::redirect(Main::ahref("users/edit/{$this->id}","",FALSE),array("danger",e("Password must be at least 5 characters.")));
          $data[":password"]=Main::encode($_POST["password"]);
        }

        if($this->db->update("user","",array("id"=>$this->id),$data)){
          return Main::redirect(Main::ahref("users/edit/{$this->id}","",FALSE),array("success",e("User has been updated.")));
        }
        return Main::redirect(Main::ahref("users/edit/{$this->id}","",FALSE),array("danger",e("An unexpected error occured.")));
      }
      // Get user info
      $this->db->object=TRUE;
      $user=$this->db->get("user",array("id"=>"?"),array("limit"=>1),array($this->id));
      if(!$user) return Main::redirect(Main::ahref("users","",FALSE),array("danger","User not found!"));
      
      if($this->config["demo"]) $user->email="Hidden in demo to protect privacy";
      Main::set("title","Edit User");
      $this->header();

      $header="Edit User";
      $content="
                  ".($user->id==$this->user->id?"<p class='alert alert-warning'><strong>This is your account!</strong> Be careful when editing the password or the admin status to prevent locking yourself out.</p>":"")."
                  <form class='form-horizontal' role='form' action='".Main::ahref("users/edit/{$user->id}")."' method='post'>
                    <div class='form-group'>
                      <label for='email' class='col-sm-3 control-label'>Email</label>
                      <div class='col-sm-9'>
                        <input type='text' class='form-control' name='email' id='email' value='{$user->email}'>
                      </div>
                    </div>      
                    <div class='form-group'>
                      <label for='password' class='col-sm-3 control-label'>Password</label>
                      <div class='col-sm-9'>
                        <input type='password' class='form-control' name='password' id='password'>
                        <p class='help-block'>Leave empty to keep the current password. Make sure to add a strong password (min. 5 chars).</p>
                      </div>
                    </div>
                    <div class='form-group'>
                      <label for='banned' class='col-sm-3 control-label'>User Activity</label>
                      <div class='col-sm-9'>
                          <select name='banned' id='banned'>
                            <option value='0' ".($user->banned=='0'?'selected':'').">Active</option>                          
                            <option value='1' ".($user->banned=='1'?'selected':'').">Banned</option>
                          </select>
                      </div>
                    </div>                        
                    <div class='form-group'>
                      <label for='admin' class='col-sm-3 control-label'>User Type</label>
                      <div class='col-sm-9'>
                          <select name='admin' id='admin'>
                            <option value='1' ".($user->admin=='1'?'selected':'').">Admin</option>
                            <option value='0' ".($user->admin=='0'?'selected':'').">User</option>
                          </select>
                      </div>
                    </div>                                          
                    <div class='form-group'>
                      <label for='membership' class='col-sm-3 control-label'>Membership</label>
                      <div class='col-sm-9'>
                          <select name='membership' id='membership'>
                            <option value='free' ".($user->membership=='free'?'selected':'').">Free</option>
                            <option value='pro' ".($user->membership=='pro'?'selected':'').">Pro</option>
                          </select>
                      </div>
                    </div>   
                    <div class='form-group'>
                      <label for='admin' class='col-sm-3 control-label'>Membership Expiration</label>
                      <div class='col-sm-9'>                        
                        ".(strtotime($user->expires)<=0?"Never":date("D m, Y h:i",strtotime($user->expires)))."
                      </div>
                    </div> 
                    <div class='form-group'>
                      <label for='admin' class='col-sm-3 control-label'>Last Payment</label>
                      <div class='col-sm-9'>
                        ".(strtotime($user->last_payment)<=0?"Never":date("D m, Y h:i",strtotime($user->last_payment)))."
                      </div>
                    </div>         
                    <br />       
                    <div class='form-group'>
                      <div class='col-sm-12'>
                        ".Main::csrf_token(TRUE)."
                        <button type='submit' class='btn btn-default'>Save User</button>
                        ".($user->id!==$this->user->id?"<a href='".Main::ahref("users/delete/{$user->id}")."' class='btn btn-danger delete pull-right'>Delete</a>":"")."
                      </div>
                    </div>                                                                                      
                  </form>
                </div>
            </div>";
      include($this->t("edit"));
      $this->footer();
    }
    /**
     * Add User
     * @since 1.0
     **/  
    private function user_add(){
      // Save user info
      if(isset($_POST["token"])){
        // Disable this for demo
        if($this->config["demo"]) return Main::redirect("admin",array("danger","Feature disabled in demo."));        
        // Validate Token
        if(!Main::validate_csrf_token($_POST["token"])){
          return Main::redirect(Main::ahref("users/add","",FALSE),array("danger",e("Invalid token. Please try again.")));
        }     
        // Validate Email
        if(!Main::email($_POST["email"])) return Main::redirect(Main::ahref("users/add","",FALSE),array("danger",e("The email entered is not valid.")));
        // Check email in database
        if($this->db->get("user",array("email"=>"?"),"",array($_POST["email"]))) return Main::redirect(Main::ahref("users/add","",FALSE),array("danger",e("An account is already associated with this email.")));
        // Validate Password
        if(empty($_POST["password"]) || strlen($_POST["password"])<5) return Main::redirect(Main::ahref("users/add","",FALSE),array("danger",e("Password must be at least 5 characters.")));
        // Validate expiration dates
        if($_POST["m"]=="y"){
          $duration="+1 year";
        }else{
          $duration="+1 month";
        }
        $last_payment="";
        if(!empty($_POST["lp"]) && $_POST["membership"]=="pro") $last_payment=date("Y-m-d H:i:s",strtotime(str_replace("T", " ", $_POST["lp"])));
        
        $expire="";
        if($_POST["membership"]=="pro") $expire=date("Y-m-d H:i:s",strtotime($duration,strtotime($last_payment)));        
        // Generate unique auth key
        $auth_key=Main::encode($this->config["security"].Main::strrand());
        $unique=Main::strrand(20);
        $data=array(
          ":email" => Main::clean($_POST["email"],3),
          ":password" => Main::encode($_POST["password"]),
          ":banned" => (in_array($_POST["banned"], array("0","1"))?$_POST["banned"]:0),
          ":admin" => (in_array($_POST["admin"], array("0","1"))?$_POST["admin"]:0),
          ":membership" => (in_array($_POST["membership"], array("free","pro"))?$_POST["membership"]:"free"),
          ":expires"=> $expire,
          ":last_payment" => $last_payment,
          ":auth_key"=>$auth_key,
          ":unique_key"=>$unique,
          ":date"=>"NOW()"          
        );
        if($this->db->insert("user",$data)){
          return Main::redirect(Main::ahref("users","",FALSE),array("success",e("User has been added.")));
        }
        return Main::redirect(Main::ahref("users/add","",FALSE),array("danger",e("An unexpected error occured.")));
      }
      Main::set("title","Add User");
      $this->header();

      $header="Add User";
      $content="<form class='form-horizontal' role='form' action='".Main::ahref("users/add")."' method='post'>
                    <div class='form-group'>
                      <label for='email' class='col-sm-3 control-label'>Email</label>
                      <div class='col-sm-9'>
                        <input type='text' class='form-control' name='email' id='email' value=''>
                      </div>
                    </div>      
                    <div class='form-group'>
                      <label for='password' class='col-sm-3 control-label'>Password</label>
                      <div class='col-sm-9'>
                        <input type='password' class='form-control' name='password' id='password'>
                        <p class='help-block'>Make sure to add a strong password (min. 5 chars).</p>
                      </div>
                    </div>
                    <div class='form-group'>
                      <label for='banned' class='col-sm-3 control-label'>User Activity</label>
                      <div class='col-sm-9'>
                          <select name='banned' id='banned'>
                            <option value='0'>Active</option>                          
                            <option value='1'>Banned</option>
                          </select>
                      </div>
                    </div>                        
                    <div class='form-group'>
                      <label for='admin' class='col-sm-3 control-label'>User Type</label>
                      <div class='col-sm-9'>
                          <select name='admin' id='admin'>
                            <option value='0'>User</option>                          
                            <option value='1'>Admin</option>
                          </select>
                      </div>
                    </div>                                          
                    <div class='form-group'>
                      <label for='membership' class='col-sm-3 control-label'>Membership</label>
                      <div class='col-sm-9'>
                          <select name='membership' id='membership'>
                            <option value='free'>Free</option>
                            <option value='pro'>Pro</option>
                          </select>
                      </div>
                    </div>  
                    <div class='form-group'>
                      <label for='m' class='col-sm-3 control-label'>Membership Type</label>
                      <div class='col-sm-9'>
                          <select name='m' id='m'>
                            <option value='m'>Monthly</option>
                            <option value='y'>Yearly</option>
                          </select>
                      </div>
                    </div>                        
                    <div class='form-group'>
                      <label for='lp' class='col-sm-3 control-label'>Last Payment</label>
                      <div class='col-sm-9'>
                        <input type='datetime-local' class='form-control' name='lp' id='lp'>
                        <p class='help-block'>Pro users only: The last payment date must be in the following format: YYYY-MM-DD HH:II (e.g. 2014-02-01 12:00)</p>
                      </div>
                    </div>         
                    <br />       
                    <div class='form-group'>
                      <div class='col-sm-12'>
                        ".Main::csrf_token(TRUE)."
                        <button type='submit' class='btn btn-default'>Add User</button>                        
                      </div>
                    </div>                                                                                      
                  </form>
                </div>
            </div>";
      include($this->t("edit"));
      $this->footer();
    }    
    /**
     * Delete User
     * @since 1.0
     **/   
    private function user_delete(){
      // Disable this for demo
      if($this->config["demo"]) return Main::redirect("admin",array("danger","Feature disabled in demo."));                    
      // Multiple Delete
      if(isset($_POST["token"]) && isset($_POST["delete-id"]) && is_array($_POST["delete-id"])){        
        if(!Main::validate_csrf_token($_POST["token"])){
          return Main::redirect(Main::ahref("users","",FALSE),array("danger",e("Invalid token. Please try again.")));
        }     
        $query='(';
        $query2='(';
        $query3='(';
        $c=count($_POST["delete-id"]);
        $p="";
        $i=1;
        foreach ($_POST["delete-id"] as $id) {
          if($i>=$c){
            $query.="`id` = :id$i";
            $query2.="`polluserid` = :id$i";
            $query3.="`userid` = :id$i";
          }else{
            $query.="`id` = :id$i OR ";
            $query2.="`polluserid` = :id$i OR ";
            $query3.="`userid` = :id$i OR ";
          }
          $p[":id$i"]=$id;
          $i++;
        }    
        $query.=")";
        $query2.=")";  
        $query3.=")";  
        $this->db->delete("user",$query,$p);
        $this->db->delete("vote",$query2,$p);
        $this->db->delete("poll",$query3,$p);        
        return Main::redirect(Main::ahref("users","",FALSE),array("success",e("Users and their polls have been deleted.")));
      }

      if(!empty($this->id) && is_numeric($this->id)){
        // Validated Nonce
        if(!Main::validate_nonce()) return Main::redirect(Main::ahref("users","",FALSE),array("danger","Security token expired. Please try again."));        
        $id=$this->id;
        $this->db->delete("user",array("id"=>"?"),array($id)); // Delete user
        $this->db->delete("vote",array("pollid"=>"?"),array($id)); // Delete votes
        $this->db->delete("poll",array("userid"=>"?"),array($id)); // Delete polls
        return Main::redirect(Main::ahref("users","",FALSE),array("success",e("User has been deleted.")));
      } 
      return Main::redirect(Main::ahref("users","",FALSE),array("danger",e("An unexpected error occured.")));      
    }  
  /**
   * Settings
   * @since 1.0
   **/
  protected function settings(){
    if(isset($_POST["token"])){
      // Disable this for demo
      if($this->config["demo"]) return Main::redirect("admin",array("danger","Feature disabled in demo."));
      // Check Token
      if(!Main::validate_csrf_token($_POST["token"])){
        Main::redirect(Main::ahref("settings","",FALSE),array("danger","Something went wrong, please try again."));
        return;
      }         
      // Upload Logo
      if(isset($_FILES["logo_path"]) && !empty($_FILES["logo_path"]["tmp_name"])) {
        $ext=array("image/png"=>"png","image/jpeg"=>"jpg","image/jpg"=>"jpg");            
        if(!isset($ext[$_FILES["logo_path"]["type"]])) return Main::redirect(Main::ahref("settings","",FALSE),array("danger",e("Logo must be either a PNG or a JPEG.")));
        if($_FILES["logo_path"]["size"]>100*1024) return Main::redirect(Main::ahref("settings","",FALSE),array("danger",e("Logo must be either a PNG or a JPEG (Max 200KB).")));            
        $_POST["logo"]="auto_site_logo.".$ext[$_FILES["logo_path"]["type"]];
        move_uploaded_file($_FILES["logo_path"]['tmp_name'], ROOT."/static/auto_site_logo.".$ext[$_FILES["logo_path"]["type"]]);                
      }
      // Delete Logo
      if(isset($_POST["remove_logo"])){
        unlink(ROOT."/static/".$this->config["logo"]);
        $_POST["logo"]="";
      }       
      // Encode SMTP
      $_POST["smtp"]=json_encode($_POST["smtp"]);
      // Encode Fonts
      $_POST["fonts"]=Main::fontf($_POST["fonts"]);

      // Update Config
      foreach($_POST as $config => $var){
        $this->db->update("setting",array("var"=>$var),array("config"=>$config));
      }
      Main::redirect(Main::ahref("settings","",FALSE),array("success","Settings have been updated.")); 
      return; 
    }     
    $theme="";
    foreach (new RecursiveDirectoryIterator(ROOT."/themes/") as $path){
      if($path->isDir() && $path->getFilename()!=="." && $path->getFilename()!==".."){  
        $theme.="<option value='".$path->getFilename()."' ".($this->config["theme"]==$path->getFilename()?" selected":"").">".ucfirst($path->getFilename())."</option>";
      }
    }
    $lang="<option value='' ".($this->config["lang"]==""?" selected":"").">English</option>";
    foreach (new RecursiveDirectoryIterator(ROOT."/includes/languages/") as $path){
      if(!$path->isDir() && $path->getFilename()!=="." && $path->getFilename()!==".." && $path->getFilename()!=="sample_lang.php" && $path->getFilename()!=="index.php" && Main::extension($path->getFilename())==".php"){  
          $data=token_get_all(file_get_contents($path));
          $data=$data[1][1];
          if(preg_match("~Language:\s(.*)~", $data,$name)){
            $name="".strip_tags(trim($name[1]))."";
          }        
        $code=str_replace(".php", "" , $path->getFilename());
        $lang.="<option value='".$code."' ".($this->config["lang"]==$code?" selected":"").">$name</option>";
      }
    }

    Main::set("title","Settings"); 
    $this->header();
    include($this->t(__FUNCTION__));
    $this->footer();
  }
  /**
   * Tools
   * @since 1.0
   **/
  protected function help(){
    Main::set("title","Help &amp; Documentation");
    $this->header();
    include($this->t(__FUNCTION__));    
    $this->footer();
  }  
  /**
    * Search
    * @since 1.0 
    **/   
  protected function search(){
    $this->db->object=TRUE;
    $q=rtrim(Main::clean($_GET["q"],3)," ");

    if(strlen($q)<3) return Main::redirect("admin",array("danger","Keyword must be at leats 3 characters."));

    $polls=$this->db->search("poll",array("question"=>":q"),array("limit"=>$this->limit),array(":q"=>"%$q%"));
    $users=$this->db->search("user",array("email"=>":q"),array("limit"=>$this->limit),array(":q"=>"%$q%"));
    $payments=$this->db->search("payment",array("tid"=>":q"),array("limit"=>$this->limit),array(":q"=>"%$q%"));

    $this->header();
    $pagination="";
    // Polls
    if(!empty($polls)){
      $header="Polls <a href='".Main::href("create")."' class='btn btn-xs btn-primary pull-right'>Create</a>";
      $thead="<th><input type='checkbox' id='check-all'></th><th>Poll ID</th><th>User ID</th><th>Question</th><th>Number of Answers</th><th>Votes</th><th>Options</th>";
      $tbody="";
        foreach ($polls as $poll){
                $tbody.="<tr>
                  <td><input type='checkbox' class='data-delete-check' name='delete-id[]' value='{$poll->id}'></td>
                  <td>{$poll->id}</td>
                  <td>".(($poll->userid==0)?'Anonymous':$poll->userid)."</td>
                  <td>{$poll->question}</td>
                  <td>".count(json_decode($poll->options,TRUE))."</td>
                  <td>{$poll->votes}</td>
                  <td>
                    <a href='".Main::href($poll->uniqueid)."' class='btn btn-xs btn-success' target='_blank'>View</a>
                    <a href='".Main::ahref("polls/edit/{$poll->id}")."' class='btn btn-xs btn-primary'>Edit</a>
                    <a href='".Main::ahref("polls/delete/{$poll->id}")."' class='btn btn-xs btn-danger delete'>Delete</a>
                  </td>
                </tr>";             
        }   
      include($this->t("template"));  
    }   
    // Users
    if(!empty($users)){
      $header="Users <a href='".Main::ahref("users/add")."' class='btn btn-xs btn-primary pull-right'>Add User</a>";
      $thead="<th><input type='checkbox' id='check-all'></th><th>User ID</th><th>Email</th><th>Registration Date</th><th> Membership</th><th>Membership Expiration</th><th>Options</th>";
      $tbody="";
        foreach ($users as $user){
                $tbody.="<tr>
                  <td><input type='checkbox' class='data-delete-check' name='delete-id[]' value='{$user->id}'></td>
                  <td>{$user->id}</td>
                  <td>{$user->email}</td>
                  <td>".date("M d, Y H:i",strtotime($user->date))."</td>
                  <td>".ucfirst($user->membership)."</td>
                  <td>".($user->membership=="free"?"Never":date("M d, Y",strtotime($user->expires)))."</td>
                  <td>
                    <a href='".Main::ahref("polls/view/{$user->id}")."' class='btn btn-xs btn-default'>View Polls</a>
                    <a href='".Main::ahref("payments/view/{$user->id}")."' class='btn btn-xs btn-success'>View Payments</a>
                    <a href='".Main::ahref("users/edit/{$user->id}")."' class='btn btn-xs btn-primary'>Edit</a>
                    <a href='".Main::ahref("users/delete/{$user->id}")."' class='btn btn-xs btn-danger delete'>Delete</a>
                  </td>
                </tr>";             
        }
      include($this->t("template"));
    }
    // Payments
    if(!empty($payments)){
      $header="Payments";
      $thead="<th>Transaction ID</th><th>Paypal Transaction ID</th><th>Status</th><th>User ID</th><th>Date</th><th>Membership Expiration</th><th>Amount</th>";
      $tbody="";
        foreach ($payments as $payment){
          if($this->config["demo"]) $payment->tid="Hidden in demo to protect privacy";
                $tbody.="<tr>
                  <td>{$payment->id}</td>
                  <td>{$payment->tid}</td>
                  <td>{$payment->status}</td>
                  <td>{$payment->userid}</td>
                  <td>".date("d-M-Y, H:i",strtotime($payment->date))."</td>
                  <td>".date("d-M-Y, H:i",strtotime($payment->expires))."</td>
                  <td>{$payment->amount}</td>
                </tr>";             
        }
      include($this->t("template"));  
    }       
    if(empty($users) && empty($polls) && empty($payments)) echo "<h3>No results found</h3> <p>Your keyword did not match any results. Please try a different keyword.</p>";
    $this->footer();    
  }
  /**
   * Custom Pages
   * @since 1.0
   **/
  protected function pages(){
    // Add page
    if($this->do=="add"){
      $this->page_add();
      return;
    }    
    // Edit page
    if($this->do=="edit" && is_numeric($this->id)){
      $this->page_edit();
      return;
    }
    // Delete page
    if($this->do=="delete"){
      $this->page_delete();
      return;
    } 

    $this->db->object=TRUE;      
    $pages=$this->db->get("page","",array("count"=>1,"order"=>"date","limit"=>(($this->page-1)*$this->limit).", ".$this->limit.""));
    if (($this->db->rowCount%$this->limit)<>0) {
      $max=floor($this->db->rowCount/$this->limit)+1;
    } else {
      $max=floor($this->db->rowCount/$this->limit);
    }    
    $header="Pages ({$this->db->rowCount}) <a href='".Main::ahref("pages/add")."' class='btn btn-xs btn-primary pull-right'>Add Page</a>";
    $thead="<th><input type='checkbox' id='check-all'></th><th>Title</th><th>Slug</th><th>Date</th><th>Options</th>";
    $tbody="";
      foreach ($pages as $page){
              $tbody.="<tr>
                <td><input type='checkbox' class='data-delete-check' name='delete-id[]' value='{$page->id}'></td>
                <td>{$page->title}</td>
                <td>{$page->slug}</td>
                <td>".date("M d, Y H:i",strtotime($page->date))."</td>
                <td>
                  <a href='".Main::href("page/{$page->slug}")."' target='_blank' class='btn btn-xs btn-success'>View</a>
                  <a href='".Main::ahref("pages/edit/{$page->id}")."' class='btn btn-xs btn-primary'>Edit</a>
                  <a href='".Main::ahref("pages/delete/{$page->id}&".Main::nonce(),"pages/delete/{$page->id}?".Main::nonce())."' class='btn btn-xs btn-danger delete'>Delete</a>
                </td>
              </tr>";             
      }
    $pagination=Main::pagination($max,$this->page,Main::ahref("pages&page=%d","pages?page=%d"));
    Main::set("title","Users");
    $this->header();
    include($this->t("template"));
    $this->footer();
  }
    /**
     * Add Page
     * @since 1.0
     **/
    private function page_add(){
      if(isset($_POST["token"])){
        // Disable this for demo
        if($this->config["demo"]) return Main::redirect("admin",array("danger","Feature disabled in demo."));
        // Check Token
        if(!Main::validate_csrf_token($_POST["token"])){
          Main::redirect(Main::ahref("pages/add","",FALSE),array("danger","Something went wrong, please try again."));
          return;
        }     
        
        if(empty($_POST["title"])) return Main::redirect(Main::ahref("pages/add","",FALSE),array("danger","Title cannot be empty."));

        if(!empty($_POST["slug"])){
          $slug=Main::slug($_POST["slug"]);
        }else{
          $slug=Main::slug($_POST["title"]);
        }

        $data=array(
          ":title"=>Main::clean($_POST["title"],3,TRUE),
          ":slug"=>$slug,
          ":menu"=>Main::clean($_POST["menu"],3,TRUE),
          ":content"=>$_POST["content"]
          );
        if($this->db->insert("page",$data)){
          return Main::redirect(Main::ahref("pages","",FALSE),array("success","Page has been added."));
        }
        return Main::redirect(Main::ahref("pages/add","",FALSE),array("danger","An unexpected error occured. Please try again."));
      }
      // Add CDN
      Main::cdn("ckeditor","",1);
      Main::set("title","Add Page");
      $this->header();

      $header="Add Page";
      $content="
              <form class='form-horizontal' role='form' action='".Main::ahref("pages/add")."' method='post'>
                    <div class='form-group'>
                      <label for='title' class='col-sm-3 control-label'>Page Title</label>
                      <div class='col-sm-9'>
                        <input type='text' class='form-control' name='title' id='title' value=''>
                      </div>
                    </div>      
                    <div class='form-group'>
                      <label for='slug' class='col-sm-3 control-label'>Slug</label>
                      <div class='col-sm-9'>
                        <input type='text' class='form-control' name='slug' id='slug'>
                        <p class='help-block'>E.g. {$this->config["url"]}/page/<strong>Slug</strong>. Leave this empty to automatically generate it.</p>
                      </div>
                    </div>
                    <div class='form-group'>
                      <label for='content' class='col-sm-3 control-label'>Content</label>
                      <div class='col-sm-9'>
                        <textarea type='text' rows='20' class='form-control ckeditor' name='content' id='content'></textarea>
                      </div>
                    </div>                    
                    <div class='form-group'>
                      <label for='menu' class='col-sm-3 control-label'>Show in Menu</label>
                      <div class='col-sm-9'>
                          <select name='menu' id='menu'>
                            <option value='1'>Show</option>                          
                            <option value='0'>Don't Show</option>                          
                          </select>
                      </div>
                    </div>                             
                    <br />       
                    <div class='form-group'>
                      <div class='col-sm-12'>
                        ".Main::csrf_token(TRUE)."
                        <button type='submit' class='btn btn-default'>Add Page</button>
                      </div>
                    </div>                                                                                      
                  </form>
                </div>
            </div>";
      include($this->t("edit"));
      $this->footer();      
    }    
    /**
     * Edit User
     * @since 1.0
     **/  
    private function page_edit(){
      if(isset($_POST["token"])){
        // Disable this for demo
        if($this->config["demo"]) return Main::redirect("admin",array("danger","Feature disabled in demo."));
        // Check Token
        if(!Main::validate_csrf_token($_POST["token"])){
          Main::redirect(Main::ahref("pages/edit/{$this->id}","",FALSE),array("danger","Something went wrong, please try again."));
          return;
        }     
        
        if(empty($_POST["title"])) return Main::redirect(Main::ahref("pages/edit/{$this->id}","",FALSE),array("danger","Title cannot be empty."));

        if(!empty($_POST["slug"])){
          $slug=Main::slug($_POST["slug"]);
        }else{
          $slug=Main::slug($_POST["title"]);
        }

        $data=array(
          ":title"=>Main::clean($_POST["title"],3,TRUE),
          ":slug"=>$slug,
          ":menu"=>Main::clean($_POST["menu"],3,TRUE),
          ":content"=>$_POST["content"]
          );
        if($this->db->update("page","",array("id"=>$this->id),$data)){
          return Main::redirect(Main::ahref("pages/edit/{$this->id}","",FALSE),array("success","Page has been editted."));
        }
        return Main::redirect(Main::ahref("pages/edit/{$this->id}","",FALSE),array("danger","An unexpected error occured. Please try again."));
      }
      $this->db->object=TRUE;
      $page=$this->db->get("page",array("id"=>"?"),array("limit"=>1),array($this->id));
      // Add CDN
      Main::cdn("ckeditor","",1);
      Main::set("title","Edit Page");
      $this->header();

      $header="Edit Page";
      $content="
              <form class='form-horizontal' role='form' action='".Main::ahref("pages/edit/{$this->id}")."' method='post'>
                    <div class='form-group'>
                      <label for='title' class='col-sm-3 control-label'>Page Title</label>
                      <div class='col-sm-9'>
                        <input type='text' class='form-control' name='title' id='title' value='{$page->title}'>
                      </div>
                    </div>      
                    <div class='form-group'>
                      <label for='slug' class='col-sm-3 control-label'>Slug</label>
                      <div class='col-sm-9'>
                        <input type='text' class='form-control' name='slug' id='slug' value='{$page->slug}'>
                        <p class='help-block'>Slug should not contain any space or special characters. Replace space by a dash. Don't change this if your site has been indexed by bots.</p>
                      </div>
                    </div>
                    <div class='form-group'>
                      <label for='content' class='col-sm-3 control-label'>Content</label>
                      <div class='col-sm-9'>
                        <textarea type='text' rows='20' class='form-control ckeditor' name='content' id='content'>{$page->content}</textarea>
                      </div>
                    </div>                    
                    <div class='form-group'>
                      <label for='menu' class='col-sm-3 control-label'>Show in Menu</label>
                      <div class='col-sm-9'>
                          <select name='menu' id='menu'>
                            <option value='1' ".($page->menu?"selected":"").">Show</option>                          
                            <option value='0' ".(!$page->menu?"selected":"").">Don't Show</option>                          
                          </select>
                      </div>
                    </div>                             
                    <br />       
                    <div class='form-group'>
                      <div class='col-sm-12'>
                        ".Main::csrf_token(TRUE)."
                        <button type='submit' class='btn btn-default'>Edit Page</button>
                        <a href='".Main::href("page/{$page->slug}")."' class='btn btn-success pull-right' target='_blank'>View</a>
                      </div>
                    </div>                                                                                      
                  </form>
                </div>
            </div>";
      include($this->t("edit"));
      $this->footer();  
    }
    /**
     * Delete User
     * @since 1.0
     **/   
    private function page_delete(){
      // Disable this for demo
      if($this->config["demo"]) return Main::redirect("admin",array("danger","Feature disabled in demo."));                    
      // Multiple Delete
      if(isset($_POST["token"]) && isset($_POST["delete-id"]) && is_array($_POST["delete-id"])){        
        if(!Main::validate_csrf_token($_POST["token"])){
          return Main::redirect(Main::ahref("pages","",FALSE),array("danger",e("Invalid token. Please try again.")));
        }     
        $query='(';
        $c=count($_POST["delete-id"]);
        $p="";
        $i=1;
        foreach ($_POST["delete-id"] as $id) {
          if($i>=$c){
            $query.="`id` = :id$i";
          }else{
            $query.="`id` = :id$i OR ";
          }
          $p[":id$i"]=$id;
          $i++;
        }    
        $query.=")";
        $this->db->delete("page",$query,$p);    
        return Main::redirect(Main::ahref("pages","",FALSE),array("success",e("Pages have been deleted.")));
      }

      if(!empty($this->id) && is_numeric($this->id)){
        // Validated Nonce
        if(!Main::validate_nonce()) return Main::redirect(Main::ahref("pages","",FALSE),array("danger","Security token expired. Please try again."));        
        $id=$this->id;
        $this->db->delete("page",array("id"=>"?"),array($id)); // Delete page
        return Main::redirect(Main::ahref("pages","",FALSE),array("success",e("Page has been deleted.")));
      } 
      return Main::redirect(Main::ahref("pages","",FALSE),array("danger",e("An unexpected error occured.")));      
    }    
  /**
   * Language
   * @since 1.0 
   **/
    /**
     * Language Editor
     * @since v2.0
     */ 
    protected function lang($form=FALSE){
      if(isset($_GET["add"]) && isset($_POST["addlang"])){
        $this->lang_add();
        return;
      }
      if(isset($_POST["editlang"])){
        $this->lang_add("edited");
        return;
      }     
      if(isset($_GET["delete"]) && isset($_GET["file"])){
        $this->lang_delete();       
        return;
      }
      $path=ROOT."/includes/languages";
      $i=0;
      $header="Add a new Translation";
      foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path)) as $filename) { 
        if(Main::extension($filename)==".php" && !preg_match("~lang_sample.php~", $filename)){
          $d[$i]["lang"]="Unknown";
          $data=token_get_all(file_get_contents($filename));
          $data=$data[2][1];
          if(preg_match("~Language:\s(.*)~", $data,$name)){
            $d[$i]["lang"]="".strip_tags(trim($name[1]))."";
          }
          if(preg_match("~Author:\s(.*)~", $data,$author)){ 
            $d[$i]["author"]="".strip_tags(trim($author[1]))."";
          } 
          $d[$i]["code"]=str_replace("/","",stripslashes(str_replace(".php","",str_replace($path, "", $filename))));
        }
        $i++;
      } 
      $content="";
      $this->header();
      include($this->t("edit"));
      $this->footer();
      return;
    }
    /**
     * Add new Language
     * @since v2.0
     */     
    protected function lang_add($l="created"){
      if(!$this->update) return Main::redirect("admin",array("error","Feature disabled in demo."));
      if(!Main::validate_csrf_token($_POST["token"])){
        Main::redirect("admin/setting?do=lang",array("error","Something went wrong, please try again."));
        return;
      }     
      $path=ROOT."/includes/languages/";
      $file = substr(strtolower($_POST["language_name"]), 0, 2).".php";
      $handle = fopen($path.$file, 'w') or Main::redirect(Main::ahref("lang","",FALSE),array("error","Cannot create file. Make sure that the folder is writable."));
      $comment='<?php 
      /*
       * Language: '.ucfirst($_POST["language_name"]).'
       * ---------------------------------------------------------------
       * Important Notice: Make sure to only change the right-hand side
       * DO NOT CHANGE THE LEFT-HAND SIDE
       * Edit the text between double-quotes "DONT EDIT"=> "" on the right side
       * Make sure to not forget any quotes " and the comma , at the end
       * ---------------------------------------------------------------
       */
      $lang=array(';
      fwrite($handle, $comment);
      foreach ($_POST["text"] as $o => $t) {
        fwrite($handle, "\n\"".strip_tags($o,"<b><i><s><u><strong><a>")."\"".'=>'."\"".strip_tags($t,"<b><i><s><u><strong><a>")."\",");
      }
      fwrite($handle, "); ?>");
      fclose($handle);    
      Main::redirect(Main::ahref("lang","",FALSE),array("success","Language file has been successfully $l."));
      return;
    }
    /**
     * Delete Language
     * @since v2.0
     */   
    protected function lang_delete(){
      if(!$this->update) return Main::redirect("admin",array("error","Feature disabled in demo."));
      $path=ROOT."/includes/lang/";
      if(!preg_match("~[.]~",$_GET["file"]) && file_exists($path.Main::clean($_GET["file"]).".php")){
        unlink($path.Main::clean($_GET["file"]).".php");
        Main::redirect(Main::ahref("lang","",FALSE),array("success","Language file has been deleted."));
        return;
      }
      Main::redirect(Main::ahref("lang","",FALSE),array("error","For some reason, this language file cannot be deleted."));
      return;
    }   
  /**
   * Header
   * @since 1.0 
   **/
  protected function header(){
    include($this->t(__FUNCTION__));
  }
  /**
   * Footer
   * @since 1.0 
   **/
  protected function footer(){
    include($this->t(__FUNCTION__));
  }  
  /**
   * Template File
   * @since 1.0
   **/
  protected function t($file){
    if(file_exists(ROOT."/admin/system/$file.php")){
      return ROOT."/admin/system/$file.php";
    }else{
      return ROOT."/admin/system/index.php";
    }
  }  
}