/* hide & show ***/
$(document).ready(function(){
    $(".lecture_div").hide();
    $(".home_work_div").hide();
    $(".home_assignment_div").hide();
    $(".degree").hide();
    $(".absence_days").show();
    
    $("#timetable").click(function(){
        $(".lecture_div").hide();
        $(".home_work_div").hide();
        $(".home_assignment_div").hide();
        $(".degree").hide();
        $(".absence").hide();
        $(".absence_days").hide();
        $(".week_calender").show();
        
    });    
    
    $("#lectur").click(function(){
        $(".lecture_div").show();
        $(".home_work_div").hide();
        $(".week_calender").hide();
        $(".home_assignment_div").hide();
        $(".degree").hide();
        $(".absence").hide();
        $(".absence_days").hide();
      });
 
    $("#homework").click(function(){
        $(".lecture_div").hide();
        $(".home_work_div").show();
        $(".week_calender").hide();
        $(".home_assignment_div").hide();
        $(".degree").hide();
        $(".absence").hide();
        $(".absence_days").hide();
        });  
     $("#quize").click(function(){
        $(".lecture_div").hide();
        $(".home_work_div").hide();
        $(".week_calender").hide();
         $(".degree").hide();
        $(".absence").hide();
        $(".absence_days").hide();
        $(".home_assignment_div").show();
            
        });
    $("#absences").click(function(){
            $(".absence").show();
            $(".absence_days").show();
            $(".degree").hide();
            $(".home_work_div").hide();
            $(".week_calender").hide();
            $(".home_assignment_div").hide();
            
        });
    $("#degrees").click(function(){
          $(".absence").hide();
            $(".absence_days").hide();
            $(".degree").show();
            $(".home_work_div").hide();
            $(".week_calender").hide();
            $(".home_assignment_div").hide();
            
            
        });
});
$(document).ready(function() {
    $('#Carousel').carousel({
        interval: 5000
    })
});
// Start Sidebar Events Page
    $('.sidebar ul li span').click(function(){
       $(this).next().slideToggle(1000); 
    });
     $('.sidebar ul').height(window.innerHeight);

/**************sticky navbar***************/
window.onscroll = function() {myFunction()};

var navbar = document.getElementById("pro-menu");
var sticky = navbar.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}


/*  Isotope Fillter js
    /*----------------------------------------------------*/
	function gallery_isotope(){
        if ( $('.gallery_f_inner').length ){
            // Activate isotope in container
			$(".gallery_f_inner").imagesLoaded( function() {
                $(".gallery_f_inner").isotope({
                    layoutMode: 'fitRows',
                    animationOptions: {
                        duration: 750,
                        easing: 'linear'
                    }
                }); 
            });
			
            // Add isotope click function
            $(".gallery_filter li").on('click',function(){
                $(".gallery_filter li").removeClass("active");
                $(this).addClass("active");

                var selector = $(this).attr("data-filter");
                $(".gallery_f_inner").isotope({
                    filter: selector,
                    animationOptions: {
                        duration: 450,
                        easing: "linear",
                        queue: false,
                    }
                });
                return false;
            });
        }
    }
gallery_isotope();

/******start testmonial************/
$(document).ready(function(){
    $("#testimonial-slider").owlCarousel({
        items:2,
        itemsDesktop:[1000,2],
        itemsDesktopSmall:[979,2],
        itemsTablet:[768,1],
        pagination:false,
        navigation:true,
        navigationText:["",""],
        autoPlay:true
    });
});