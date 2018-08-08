/**
 *  Premium Poll Script jQuery Application
 *  Copyright @KBRmedia - All rights Reserved 
 */
$(function() {
    // Sidebar Height
    if(!is_mobile() && !is_tablet()){
      if($(document).height() >= $(window).height()){
        var h1=$(document).height();
      }else{
        var h1=$(".content").height();
      }     
      $(".sidebar").height(h1);     
    }
  /**
   * Sort Widgets
   **/
    $("#sortable").sortable({
      placeholder: "input_placeholder",
      axis: 'y',
       start: function(event, ui){
          before = ui.item.index();
        },
        update: function(event, ui) {
          after = ui.item.index();
          lafter = $('#poll_answers li:eq('+after+')');
          lebefore = $('#poll_answers li:eq('+before+')');

          lafter.replaceWith(lebefore);
          if(before > after)
            lebefore.after(lafter);
          else
            lebefore.before(lafter);
        }
    });
    /**
     * Update Font
     **/
    $('select.choose_font').chosen().change(function(e,v){
        var font=$('select.choose_font option:selected').html();
        $("#poll_widget").css("font-family",font+", sans-serif");
      
    });  
    /**
     * Update Language
     **/
    $('select#lang').chosen().change(function(e,v){
        var href=document.URL.split("?")[0].split("#")[0];
        window.location=href+"?lang="+v.selected;
    });     
  /**
   * Update Background
   **/
    $("#background").keyup(function(e){
      if($(this).val().length<5) return false;
      $("#poll_widget").css("background-image","url("+$(this).val()+")");
    });
  /**
   * Update Themes
   **/
    $(".themes li a").click(function(e){
      e.preventDefault();
      var c=$(this).attr("data-class");
      $(".themes li a").removeClass("current");
      $(this).addClass("current");
      $("#poll_widget").removeClass();
      $("#poll_widget").addClass(c);    
      $("#poll_theme_value").val(c);
    });
  /**
   * Embed Poll
   **/
    $("#poll_embed").click(function(e){
      e.preventDefault();
      $("#poll_embed_holder").fadeToggle();
    });
  /**
   * Add Fields
   **/
    var ul_li_html=$("#sortable li:first").html();
    var add_field_count=$("#sortable li").length+1;
    $(document).on("click","#add-field",function(e){
      e.preventDefault();
      $("#sortable").append("<li id='poll_sort_"+add_field_count+"'>"+ul_li_html+"</li>");
      $("#poll_sort_"+add_field_count+" input").val('');
      $("#poll_sort_"+add_field_count+" input").attr('name','option['+add_field_count+']');
      $("#poll_sort_"+add_field_count+" .col-md-3").remove();
      $("#poll_sort_"+add_field_count+" .col-md-9").addClass('col-md-12').removeClass('col-md-9');
      $("#poll_answers").append("<li id='poll-"+add_field_count+"'><label><input type='radio' name='answer' value=''> <span>جواب "+add_field_count+"</span></label></li>");  
      icheck_reload();
      add_field_count++;
      if(add_field_count > max_count) {
        $(this).addClass("disabled");
        return false;
      }        
    });
  /**
   * Easy Tabs
   **/
    $(".tabbed").hide();
    $(".tabbed").filter(":first").fadeIn();
    $(".tabs").click(function(e){
      e.preventDefault();
      var id=$(this).attr("data-id");
      $(".tabs").parent("li").removeClass("active");
      $(this).parent("li").addClass("active");
      $(".tabbed").hide();
      $("#"+id).fadeIn();
    });
  /**
   * Load iCheck
   **/
    icheck_reload();
  /**
   * Load Selectize
   **/
    $('select').chosen();   
  /**
   * Custom Radio Box
   **/
    $(document).on('click','.form_opt li a',function(e) {
      
      var href=$(this).attr('href');
      var name = $(this).parent("li").parent("ul").attr("data-id");
      var to = $(this).attr("data-value");
      var callback=$(this).parent("li").parent("ul").attr("data-callback");
      if(href=="#" || href=="") e.preventDefault();

      $("input#" + name).val(to);
      $(this).parent("li").parent("ul").find("a").removeClass("current");
      $(this).addClass("current");
      if(callback !==undefined){
        window[callback](to);
      }      
    }); 
  /**
   * Generate Preview
   **/
    $(document).on('keyup focusout','#questions',function(){
      var v=$(this).val().replace(/(<([^>]+)>)/ig,"");
      if(v=="") return false;
      $("#poll_widget #poll_question h3").text(v);
    });
  /**
   * Create Answers
   **/
    $("#widget_answers input").each(function(e){
      var index=$("#widget_answers input").index(this)+1;
      $("#poll_answers").append("<li id='poll-"+index+"'><label><input type='radio' name='answer' value=''> <span>جواب "+index+"</span></label></li>");
      icheck_reload();    
    });
  /**
   * Add Answers
   **/
    $(document).on("keyup focusout","#widget_answers input",function(){
      var v=$(this).val().replace(/(<([^>]+)>)/ig,"");
      var index=$("#widget_answers input").index(this)+1;
      if(v.length < 1) return false;
      if($("#poll_answers #poll-"+index).length >0){
        $("#poll_answers #poll-"+index).find("span").text(v);
      }else{
        $("#poll_answers").append("<li id='poll-"+index+"'><label><input type='radio' name='answer' value='"+v+"'> <span>"+v+"</span></label></li>");
      }
      icheck_reload();
    }); 
  /**
   * Show forgot password form
   **/
   $(document).on('click','#forgot-password',function(){
      show_forgot_password();
   });
   if(location.hash=="#forgot"){
      show_forgot_password();
   }   
   $(".alert").click(function(){
    $(this).fadeOut();
   });
/**
 * Display Results
 **/
  $("#view-results").click(function(e){
    e.preventDefault();
    $(".form_poll").hide();
    $(".poll_results").show();
  });  
 /**
  * Vote Poll
  **/
  animate_progress();
  $("#poll_form").submit(function(e){
    e.preventDefault();
    var f=$(this);
    var action=f.attr("action");
    var r=document.referrer;
    $.ajax({
      type: "POST",
      url: action,
      data: f.serialize()+"&ref="+r,          
      success: function (r) {                              
        f.parent("div").html(r);
        animate_progress();
      }
    });      
  });
 /**
  * Search for Polls
  **/
  $("#poll_search_q").keyup(function(e){
    e.preventDefault();
    var val=$(this).val();
    var action=$("#poll_search_form").attr("action");
    if(val.length > 3){
      $.ajax({
          type: "POST",
          url: action,
          data: "q="+val+"&token="+token,
          beforeSend: function() {
            $(".content").html("<img class='loader' src='"+appurl+"/static/loader.gif' style='margin:0 45%;border:0;' />");
          },
          complete: function() {      
            $('img.loader').fadeOut("fast",function(){$(this).remove()});
          },          
          success: function (r) { 
            $(".content").html(r);
            $(".list-group-item").removeClass("active");
            icheck_reload();
          }
      }); 
    }
  }); 
 /**
  * Get Stats
  **/
  $(document).on('click',".get_stats",function(e){
    e.preventDefault();
    var r=$(this).attr("data-request");
    var id=$(this).attr("data-id");
    var target=$(this).attr("data-target");
    var val=$(this).attr("data-value");
    var action=$(this).attr("href");
    if(target=="this"){
      var holder=$(this);
    }else{
      var holder="#"+target;
    }
    $.ajax({
        type: "POST",
        url: action,
        data: "request="+r+"&token="+token+"&id="+id+"&value="+val,
        beforeSend: function() {
          if(target!="this"){
            $(holder).hide();
            $(holder).parents(".panel").find(".panel-heading").append("<img class='loader' src='"+appurl+"/static/loader.gif' style='float:right' />");
          }
        },
        complete: function() {      
          $('img.loader').fadeOut("fast",function(){$(this).remove()});
        },          
        success: function (r) { 
         if(r!==""){
            if(r==="notpro"){
              window.location=appurl;
              return;
            }
            if(target=="this"){
              $(holder).replaceWith(r);
            }else{
              $(holder).parent("div").append("<div id='ajax'>"+r+"<a href='#back' class='return btn btn-xs btn-primary'>&larr;</a></div>");
              $(".return").click(function(e){
                e.preventDefault();
                $("#ajax").remove();
                $(holder).fadeIn();
              });              
            }
         }
        }
    }); 
  });   
  if($(".poll_results").length!==0){    
    //update_results();
  }
  // Select All
  $(document).on('click','#select_all',function(e) {
    e.preventDefault();   
    $('input').iCheck('toggle');            
  }); 
  /**
   * Delete All
   */
  $(document).on('click','#delete_all',function(e) {
    e.preventDefault();
    $('form#delete_all_form').submit();
  });  
  /**
   * Active Menu
   **/
  var path = location.pathname.substring(1)+location.search;  
  if (path) {
    $('.nav-sidebar a').removeClass("active");
    $('.nav-sidebar a[href$="' + path + '"]').addClass('active'); 
  }   
  // Alert Modal
  $(".delete").click(function(e){
    e.preventDefault();
    $(this).modal();    
  });
  /**
   * OnClick Select
   **/
   $(".onclick-select").on('click',function(){
    $(this).select();
   })
   /**
    * Data Picker
    **/
  $("#expires").datepicker({ minDate: +1,dateFormat: 'yy-mm-dd'});
  /**
   * Show Languages
   **/
  $("#show-language").click(function(e){
    e.preventDefault();
    $(".langs").fadeToggle();
  });
}); // End jQuery Ready
/**
 * iCheck Load Function
 **/
function icheck_reload(){
  if(typeof icheck !== "undefined"){
    var c=icheck;
  }else{
    if($("input[type=checkbox],input[type=radio]").attr("data-class")){
      var c="-"+$("input[type=checkbox],input[type=radio]").attr("data-class");
    }else{
      var c="";
    }    
  }
  $('input').iCheck({
    checkboxClass: 'icheckbox_flat'+c,
    radioClass: 'iradio_flat'+c
  }); 
}

/**
 * Show Password Field Function
 **/
function show_forgot_password(){
  $("#login_form").slideUp("slow");
  $("#forgot_form").slideDown("slow");  
  return false  
}
/**
 * Progress Bar Animate
 **/
function animate_progress(){
  $(".progress-bar").each(function(){
    var p=$(this).attr("aria-valuenow");  
    $(this).animate({width:p+"%"},1000,function(){
      $(".slidedown").slideDown("slow");
    });    
  });    
}
/**
 * Get Results
 **/
function update_results(action,id){
  if(action.length==0 || typeof action==undefined) action=$(".poll_results").attr("data-action");
  if(id.length==0 || typeof id==undefined) id=$(".poll_results").attr("data-id");
    $.ajax({
      type: "POST",
      data: "poll_id="+id,
      url: action,        
      success: function (r) {                              
       $("#poll_widget").html(r);
       animate_progress();
      }
    }); 
}
/**
 * Custom Radio Box Callback
 **/
window.update_choice_type=function(v){
    if(v==="0"){
      $("#poll_answers input[type=checkbox]").attr("type","radio");
      icheck_reload();
      return;
    }else if(v=="1"){
      $("#poll_answers input[type=radio]").attr("type","checkbox");
      icheck_reload();
      return;
    }
}
window.update_share=function(v){
  if(v==="0"){
    $("#poll_embed").fadeOut();
    return;
  }else if(v=="1"){
    $("#poll_embed").fadeIn();
    return;
  }  
}
window.update_results_button=function(v){
  if(v==="0"){
    $("#view_results_button").fadeOut();
    return;
  }else if(v=="1"){
    $("#view_results_button").fadeIn();
    return;
  }  
}
