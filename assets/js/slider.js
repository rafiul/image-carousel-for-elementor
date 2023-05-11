 

;(function ($, w) {
    'use strict';
    
var $window = $(w);

$window.on( 'elementor/frontend/init', function() {
    
    var EF = elementorFrontend,
        EM = elementorModules;
    
    var ModuleBase = elementorModules.frontend.handlers.Base;

    var Hero_Slider = EM.frontend.handlers.Base.extend({
        onInit: function(){
            this.run();
        },
        onChange: function(){
            this.run();
        },
        run: function(){

            var $scope = this.$element;
             var $id        = $scope[0].dataset.id;
			
            /**
             * get data on editor mode
             */
            var $settings = this.getElementSettings();
            var swiper = new Swiper('#swiper-'+ $id, {
                slidesPerView: $settings.slidesPerView,
                //spaceBetween: $settings.spaceBetween,
                speed: $settings.speed,
				centeredSlides: $settings.centeredSlides=='yes' ? true : false,
                loop:$settings.loop=='yes' ? true : false,
                //disableOnInteraction: true,

                autoplay: {
                    enabled: true,
                    delay: $settings.delay,
                },
             breakpoints: {
					960: {
					  slidesPerView: 2,
					  spaceBetween: 30
					},
					720: {
					  slidesPerView: 2,
					  spaceBetween: 15
					},
					540: {
					  slidesPerView: 1,
					  spaceBetween: 0
					},
					320: {
					  slidesPerView: 1,
					  spaceBetween: 0
					},
				  },

                navigation: {
                    nextEl: '.next-'+$id,
                    prevEl: '.prev-'+$id,
                },
              });
        }
    });

    /**
     * Hero Slider Finalized Here
     *
     * @author B M Rafiul Alam <bmrafiul.alam@gmail.com>
     * @since 1.1.0.8
     */

    // Moving_Letters Hooked Here
    EF.hooks.addAction(
        'frontend/element_ready/Tb_Image_Carousel.default',
        function ($scope) {
                EF.elementsHandler.addHandler(Hero_Slider, {
                        $element: $scope,
                });
        }
    );
});
} (jQuery, window));
