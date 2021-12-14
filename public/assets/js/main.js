(function ($) {
  "use strict";

  
  $(".today-carousel").owlCarousel({
    loop:false,
    margin:0,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:2
        },
        1280:{
            items:3
        },
        1600:{
            items:3
        }
    }
})
  
  $('.owl-carousel').owlCarousel({
    loop:false,
    margin:15,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:2
        },
        1280:{
            items:3
        },
        1600:{
            items:3
        }
    }
})


$(document).ready(function() {
    $('.tbName').click(function() {
		var btn = $(this).data('btn');
        if($(this).val() != '') {
            $('#'+btn).prop('disabled', false);

        } else {
            $('#'+btn).prop('disabled', true);
        }
    });
});



})(jQuery);

