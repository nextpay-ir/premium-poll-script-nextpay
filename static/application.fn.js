/**
 *  Premium Poll Script jQuery Custom Functions - Don't edit anything below!
 *  Copyright @KBRmedia - All rights Reserved 
 */
(function($){
  // Sticky
  $.fn.extend({
    sticky: function(a) {
      var b = {
        TopMargin: '0'
      }
      var e=$(this);
      if(!e.length)  return false;
      var s = $.extend(b, a);
      pos=e.position();
      $(window).scroll(function(){   
        if(window.pageYOffset>=pos.top){              
            e.css({
                position: 'fixed',
                top: s.TopMargin,
                left: pos.left,
                margin: 0
            });                                   
        }else{
            e.attr('style','');           
        }   
      });                   
    }       
  });
  // Tooltip
  $.fn.extend({
    tooltip: function(a){   
      $(this).hover(function(){
        var d=$(this).attr("data-content");              
        var pos=$(this).position();
        var x=pos.left + $(this).width() + 20;
        var y=pos.top;
        $("body").append("<span id='tooltip' style='position:absolute;top:"+y+"px;left:"+x+"px'>"+d+"</span>");
      },function(){
        $("#tooltip").remove();
      });
    }
  });
  // Modal
  $.fn.extend({
    modal: function(settings) {
      var defaults = {
          confimation: 0,
          title:$(this).attr("title"),
          content:$(this).attr("data-content"),
          link:$(this).attr("href")
      };
      var s = $.extend(defaults, settings);
      if(!s.content){
          s.content="توجه داشته باشید که این عمل دائمی است. هنگامی که شما بر روی ادامه کلیک کنید <strong>دیگر نمی‌توانید</strong> آن را بازیابی کنید. برای لغو می‌توانید هر جای صفحه کلیک کنید و یا بر روی کلید <a href='#close' class='close-modal'>بستن</a> کلیک کنید.";
      }
      if(!s.title){
        s.title="آیا مطمئن هستید که می‌خواهید ادامه دهید؟";
      }
      if(s.confimation){
          var proceed="";
      }else{
          var proceed="<a href='" + s.link + "' class='btn btn-success btn-xs'>ادامه</a> <a href='#' class='btn btn-danger btn-xs close-modal'>انصراف</a>";
      }
      $.fn.modal_destroy=function(){
        $("#modal-shadow").fadeOut('normal',function(){
          $(this).remove();
        });
        $("#modal-alert").fadeOut('normal',function(){
          $(this).remove();
        }); 
        return;       
      }
      if($("#modal-alert").length>0) $(document).modal_destroy();
      $("body").prepend('<div id="modal-alert"></div><div id="modal-shadow"></div>');
      $("#modal-shadow").css("height",$(document).height()).hide();
      $("#modal-shadow").show();
      var left=($(document).width() - $("#modal-alert").width())*0.5;
      var top=($(document).height() - $("#modal-alert").height()-100)*0.5;
      $("#modal-alert").css({"top":top,"left":left}).hide();
      $("#modal-alert").fadeIn();
      $("#modal-alert").html("<div class='title'>"+s.title+" <a href='#' class='btn btn-danger btn-xs pull-right close-modal'>بستن</a></div><p>"+ s.content +"</p>"+proceed);
      $(document).on('click',".close-modal,#modal-shadow",function(e) {
      	e.preventDefault();
        $(document).modal_destroy();
      });
      var pos=$('#modal-alert').position(); 
      $('body,html').animate({scrollTop: pos.top - 20});           
      $(document).keyup(function(e) {
        if (e.keyCode == 27) {       
        	e.preventDefault();
          $(document).modal_destroy();
        }   
      });                 
    }    
  }); 
  // Smooth Scroll
  $.fn.extend({ 
    smoothscroll: function() {
      $(this).click(function(e){
        e.preventDefault();
        var href=$(this).attr("href");
        var pos=$(href).position(); 
        var css=$(this).attr('class');
            $("."+css).removeClass("active");
            $('body,html').animate({ scrollTop: pos.top-30 });               
      });
    }        
  });   
})(jQuery);    
function is_mobile(){
    if($(document).width()<550) return true;
    return false;
}
function is_tablet(){
    if($(document).width()>=550 && $(document).width()<980) return true;
    return false;
}