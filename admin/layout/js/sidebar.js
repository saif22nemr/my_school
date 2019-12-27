$(function() {
   'use strict' 
    
    // Sidebare Full Height
    $('.sidebar ul').height($(window).height());
    
    // Sidebare Lists
    $('.sidebar ul li').click(function() {
       $(this).find(".dropdown-sidebar").slideToggle(300) 
    });
    
});
