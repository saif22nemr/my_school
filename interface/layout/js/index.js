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


});

