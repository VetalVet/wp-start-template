(function ($) {
    $(window).on("elementor/frontend/init", function () {
  
      elementorFrontend.hooks.addAction("frontend/element_ready/ale_shop_products.default", function ($scope, $) {


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

        if($('.olins_shop_products_box').length){

            $(".olins_shop_products_box").tabs();
        }
  
      });
  
    });
  })(jQuery);
  