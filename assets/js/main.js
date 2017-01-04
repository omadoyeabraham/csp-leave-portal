$(function() {
     var pageurl = window.location.href;//.substr(window.location.href
//.lastIndexOf("/")+1);

     $(".sidebar a").each(function(){
          if($(this).attr("href") == pageurl || $(this).attr("href") == '' )
          $(this).addClass("active-tab");
     })
});
