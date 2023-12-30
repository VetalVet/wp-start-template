(function ($) {
    $(window).on("elementor/frontend/init", function () {
  
      elementorFrontend.hooks.addAction("frontend/element_ready/ale_recent_blog_posts.default", function ($scope, $) {
 
        if($('.grid').length){
            initMasonry( $('.grid') );
        }
        function initMasonry( $grid ) {
            var $grid = $grid.masonry({
                columnWidth: '.grid-sizer',
                gutter: '.gutter-sizer',
                itemSelector: '.grid-item',
                percentPosition: true
            });
    
            // layout images after they are loaded
            $grid.imagesLoaded( function() {
                $grid.masonry('layout');
            });
        }
  
      });
  
    });
  })(jQuery);
  