(function ($) {
    $(window).on("elementor/frontend/init", function () {
  
      elementorFrontend.hooks.addAction("frontend/element_ready/ale_simple_team.default", function ($scope, $) {
 
        if($('.olins_simple_team').length){
            $('.olins_simple_team').flexslider({
                animation: "slide",
                animationLoop: true,
                //smoothHeight: true,
                directionNav: false
            });
        }
  
      });
  
    });
  })(jQuery);
  