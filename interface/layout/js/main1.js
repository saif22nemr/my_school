/* hide & show ***/
$(document).ready(function(){
    $(".lecture_div").hide();
    $(".home_work_div").hide();
    $(".home_assignment_div").hide();
    $('.degree_table').hide();
    $('.absence_table').hide();
    
    $("#timetable").click(function(){
        $(".lecture_div").hide();
        $(".home_work_div").hide();
        $(".home_assignment_div").hide();
        $(".week_calender").show();
        $(".degree_table").hide();
        $(".absence_table").hide();
        $('.addDegree').hide();
        $('.showDegree').hide();
    });    
    $("#degreeTable").click(function(){
        $(".lecture_div").hide();
        $(".home_work_div").hide();
        $(".home_assignment_div").hide();
        $(".week_calender").hide();
        $(".degree_table").show();
        $(".absence_table").hide();
        $('.addDegree').hide();
        $('.showDegree').hide();
    });    
    $("#absenceTable").click(function(){
        $(".lecture_div").hide();
        $(".home_work_div").hide();
        $(".home_assignment_div").hide();
        $(".week_calender").hide();
        $(".degree_table").hide();
        $(".absence_table").show();
        $('.addDegree').hide();
        $('.showDegree').hide();
    });    
    $("#lectur").click(function(){
        $(".lecture_div").show();
        $(".home_work_div").hide();
        $(".week_calender").hide();
        $('.degree_table').hide();
        $('.absence_table').hide();
        $(".home_assignment_div").hide();
        $('.addDegree').hide();
        $('.showDegree').hide();
      });
 
    $("#homework").click(function(){
            $(".lecture_div").hide();
            $(".home_work_div").show();
            $(".week_calender").hide();
            $(".home_assignment_div").hide();
            $('.degree_table').hide();
            $('.absence_table').hide();
        $('.addDegree').hide();
        $('.showDegree').hide();
        });  
     $("#quize").click(function(){
            $(".lecture_div").hide();
            $(".home_work_div").hide();
            $(".week_calender").hide();
            $(".home_assignment_div").show();
            $('.degree_table').hide();
        $('.absence_table').hide();
         $('.addDegree').hide();
         $('.showDegree').hide();
        });
    $(".fff").click(function(){
            $(".lecture_div").hide();
            $(".home_work_div").hide();
            $(".week_calender").hide();
            $(".home_assignment_div").hide();
            $('.degree_table').hide();
        $('.absence_table').hide();
         $('.addDegree').show();
        $('.showDegree').hide();
        });
    $('.navsen a.nav-link').click(function(){
        $('.navsen li.nav-item').addClass('active').siblings.removeClass('active');
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