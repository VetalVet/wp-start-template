(function ($) {
    $(window).on("elementor/frontend/init", function () {
  
      elementorFrontend.hooks.addAction("frontend/element_ready/ale_works_masonry_grid.default", function ($scope, $) {
 
        if($('.olins_works_masonry_grid').length){

            $('.olins_works_masonry_grid').imagesLoaded( function() {
                $('.olins_works_masonry_grid').masonry({
                    columnWidth: '.grid-sizer',
                    gutter: '.gutter-sizer',
                    itemSelector: '.grid_item_work',
                    isAnimated: true,
                    percentPosition: true,
                });
                $('.olins_works_masonry_grid').masonry('layout');
            });
        }

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
  