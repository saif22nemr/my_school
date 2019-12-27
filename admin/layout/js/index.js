/* hide & show ***/
$(document).ready(function(){
    $(".lecture_div").hide();
    $(".home_work_div").hide();

    $("#timetable").click(function(){
        $(".lecture_div").hide();
        $(".home_work_div").hide();
        $(".week_calender").show();
    
    });    
    
    $("#lectur").click(function(){
        $(".lecture_div").show();
        $(".home_work_div").hide();
        $(".week_calender").hide();
      });
 
    $("#homework").click(function(){
            $(".lecture_div").hide();
            $(".home_work_div").show();
            $(".week_calender").hide();  
        });
    $("#timetable").click(function(){
        $(".lectur").hide();
          $(".timeline").show();
      });       
    $('.filter-selection').on('change',function(){
       this.form.submit(); 
    });
    $('.sidebar .list-group-item').on('click',function(){
        this.addClass('active').siblings.removeClass('active');
    });
});

$(function() {
   'use strict' 
    
    /*navbar*/
    $(window).scroll(function(){
        var scroll = $(window).scrollTop();
          if (scroll > 50) {
            $("#navbar").addClass("backgroundnav");
            $(".navbar-light .navbar-nav .nav-link").addClass("color-li");
          }
          else{
              $("#navbar").removeClass("backgroundnav");
              $(".navbar-light .navbar-nav .nav-link").removeClass("color-li");
          }
      });
    // Header up Full Window
    $('header').height($(window).height());
    
    /* Smoth scroll */
    $(document).on('click', 'a[href^="#"]', function (event) {
    event.preventDefault();

    $('html, body').animate({
        scrollTop: $($.attr(this, 'href')).offset().top
    }, 800);
    });
    
});

  $("#lectur").click(function(){
    $(".timeline").hide();
      $(".lectur").show();
  });
 $("#timetable").click(function(){
    $(".lectur").hide();
      $(".timeline").show();
  });
function addCourseTeacher(){
    $('.studentCourse .displayNone').removeClass('displayNone').addClass('fixedSection');
}
function closeFixed(){
    $('.studentCourse .fixedSection').removeClass('fixedSection').addClass('displayNone');
}

	/*function dispalydate()
	{
		var d = new Date(),
        seconds = d.getSeconds().toString().length == 1 ? '0'+d.getSeconds() : d.getSeconds(),
	    minutes = d.getMinutes().toString().length == 1 ? '0'+d.getMinutes() : d.getMinutes(),
    	hours = d.getHours().toString().length == 1 ? '0'+d.getHours() : d.getHours(),
        ampm = d.getHours() >= 12 ? 'pm' : 'am',
    	months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
    	days = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
		return days[d.getDay()]+', '+months[d.getMonth()]+', '+d.getDate()+' ,'+d.getFullYear()+' '+hours+':'+minutes+':'+seconds+ampm;
	
	}
	
	document.getElementById("demo").innerHTML = dispalydate();*/



