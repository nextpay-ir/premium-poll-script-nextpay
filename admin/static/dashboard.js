/**
 * 
 **/
 $(document).ready(function(){
  /**
   * Easy Tabs
   **/
    $(".tabbed").hide();
    $(".tabbed").filter(":first").fadeIn();
    $(".tabs a").click(function(e){
      e.preventDefault();
      var id=$(this).attr("href");
      $(".tabs li").removeClass("active");
      $(this).parent("li").addClass("active");
      $(".tabbed").hide();
      $(id).fadeIn();
      if(!is_mobile()){
        $(".sub-sidebar").height($(id).height()+100);
      }
    });  
	  // Sidebar Height
		if(!is_mobile() && !is_tablet()){
			if($(document).height() >= $(window).height()){
				var h1=$(document).height();
			}else{
				var h1=$(".main").height();
				$(".nav-sidebar").sticky({TopMargin: 30});
			}			
			$(".sidebar").height(h1);			
		}
		if(!is_mobile()){
			$(".sub-sidebar").height($('.tabbed').height()+100);
		}
  /**
   * Active Menu
   **/
  var path = location.pathname.substring(1)+location.search;  
  if (path) {
    $('.nav-sidebar li').removeClass("active");
    $('.nav-sidebar li a[href$="' + path + '"]').parent("li").addClass('active'); 
  }    		
 $("select").chosen();

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
    }).disableSelection();
  /**
   * Add Fields
   **/
    var ul_li_html=$("#sortable li:first").html();
    var add_field_count=$("#sortable li").length+1;
    $(document).on("click","#add-field",function(e){
      e.preventDefault();
      $("#sortable").append("<li id='poll_sort_"+add_field_count+"'>"+ul_li_html+"</li>");
      $("#poll_sort_"+add_field_count+" input").val('');
      $("#poll_sort_"+add_field_count+" input").attr('name','option['+add_field_count+'][answer]');
      $("#poll_sort_"+add_field_count+" .col-md-3").remove();
      $("#poll_sort_"+add_field_count+" .col-md-9").addClass('col-md-12').removeClass('col-md-9');
      $("#poll_answers").append("<li id='poll-"+add_field_count+"'><label><input type='radio' name='answer' value=''> <span>Answer "+add_field_count+"</span></label></li>");  
      add_field_count++;
      if(add_field_count>20) {
        $(this).addClass("disabled");
        return false;
      }        
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
   * Reset Data
   **/
   $("#reset-votes").click(function(e){
    e.preventDefault();
    $(".counts").val('0');
    $(".hidden").removeClass('hidden');
   });
  /**
   * Delete Alert
   **/
  $(".delete").click(function(e){
    e.preventDefault();
    $(this).modal();
    return false;
  });   
  // Remove logo
  $("#remove_logo").click(function(e){
    e.preventDefault();
    $("#setting-form").append("<input type='hidden' name='remove_logo' value='1'>");
    $(this).text("Logo will be removed upon submission");
  });  
  // Remove Alert
 $("div.alert").click(function(){
    $(this).fadeOut();
 });  
 // Check All
  $('#check-all').on('click', function () {
    $(".data-delete-check").prop('checked', this.checked);
  });    
  $('#check-all,.data-delete-check').on('click', function () {
    $("#deleteall").fadeIn();
  }); 
});