<?php
/**
 * Plugin Name: Multi Carousel for Elementor
 * Description: This plugin uses Elementors slider script and adds the posibility for a slider. 
 * Plugin URI:  https://github.com/rafiul
 * Version:     1.0.0
 * Author:      B M Rafiul Alam
 * Author URI:  https://github.com/rafiul
 * Text Domain: tb-carousel
 */

define( 'ELEMENTOR_SWIPER_SLIDER', __FILE__ );

/**
 * Include the Elementor_Swiper_Slider class.
 */
require plugin_dir_path( ELEMENTOR_SWIPER_SLIDER ) . 'activate-widget.php';
