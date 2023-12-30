(function ($) {
    $(window).on("elementor/frontend/init", function () {
  
      elementorFrontend.hooks.addAction("frontend/element_ready/ale_testimonials_slider.default", function ($scope, $) {

        if($('.olins_testimonials_slider').length){
            $('.olins_testimonials_slider').flexslider({
                animation: "slide",
                animationLoop: true,
                smoothHeight: true,
                directionNav: false
            });
        }
  
      });
  
    });
  })(jQuery);