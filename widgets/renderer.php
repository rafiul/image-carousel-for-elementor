<?php

namespace TbCarousel\Widgets;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Group_Control_Text_Shadow;

// Security Note: Blocks direct access to the plugin PHP files.
defined( 'ABSPATH' ) || die();

class SliderControls extends \Elementor\Widget_Base {

	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );
	}

	// Widget name
	public function get_name() {
		return 'Tb_Image_Carousel';
	}

	// Widget title
	public function get_title() {
		return __( 'Image Carousel', 'tb-carousel' );
	}

	// Widget icon
	public function get_icon() {
		return 'eicon-thumbnails-down';
	}

	// Category the widget belongs to
	public function get_categories() {
		return array( 'custom widget' );
	}
	
	// Enqueue styles
	public function get_style_depends() {
		return array( 'slider-upgrade-style' );
	}

	// Enqueue scripts
	public function get_script_depends() {
		return array( 'slider-upgrade-script', 'slider-swiper-script' );
	}

	// Widget Controls
	protected function register_controls() {

		/**
		 * Image Section Start
		 */
		$this->start_controls_section(
			'image_section',
			[
				'label' => esc_html__( 'Images', 'tb-carousel' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'gallery',
			[
				'label' => esc_html__( 'Add Images', 'tb-carousel' ),
				'type' => \Elementor\Controls_Manager::GALLERY,
				'default' => [],
				'description' => esc_html__( 'Adding more than 1 image, will active the slider functionality', 'tb-carousel' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'exclude' => [],
				'include' => [],
				'default' => 'full',
			]
		);
		$this->add_control(
			'navigation_previous_icon',
			[
				'label' => esc_html__( 'Previous Arrow Icon', 'tb-carousel' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'skin' => 'inline',
				'label_block' => false,
				'skin_settings' => [
					'inline' => [
						'none' => [
							'label' => 'Default',
							'icon' => 'eicon-chevron-left',
						],
						'icon' => [
							'icon' => 'eicon-star',
						],
					],
				],
				'recommended' => [
					'fa-regular' => [
						'arrow-alt-circle-left',
						'caret-square-left',
					],
					'fa-solid' => [
						'angle-double-left',
						'angle-left',
						'arrow-alt-circle-left',
						'arrow-circle-left',
						'arrow-left',
						'caret-left',
						'caret-square-left',
						'chevron-circle-left',
						'chevron-left',
						'long-arrow-alt-left',
					],
				],
			]
		);

		$this->add_control(
			'navigation_next_icon',
			[
				'label' => esc_html__( 'Next Arrow Icon', 'tb-carousel' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'skin' => 'inline',
				'label_block' => false,
				'skin_settings' => [
					'inline' => [
						'none' => [
							'label' => 'Default',
							'icon' => 'eicon-chevron-right',
						],
						'icon' => [
							'icon' => 'eicon-star',
						],
					],
				],
				'recommended' => [
					'fa-regular' => [
						'arrow-alt-circle-right',
						'caret-square-right',
					],
					'fa-solid' => [
						'angle-double-right',
						'angle-right',
						'arrow-alt-circle-right',
						'arrow-circle-right',
						'arrow-right',
						'caret-right',
						'caret-square-right',
						'chevron-circle-right',
						'chevron-right',
						'long-arrow-alt-right',
					],
				],
				
			]
		);
		$this->add_control(
			'caption_type',
			[
				'label' => esc_html__( 'Caption', 'tb-carousel' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => esc_html__( 'None', 'tb-carousel' ),
					'title' => esc_html__( 'Title', 'tb-carousel' ),
					'caption' => esc_html__( 'Caption', 'tb-carousel' ),
					'description' => esc_html__( 'Description', 'tb-carousel' ),
				],
			]
		);
		$this->end_controls_section();
		/**
		 * Image Section End
		 */

		/**
		 * Style Section Start
		 */
		$this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Style', 'tb-carousel' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'item_border_radius',
			[
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'label'      => esc_html__( 'Image Border Radius', 'tb-carousel' ),
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .swiper-slide img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
	

		

		$this->add_control(
			'arrows_size',
			[
				'label' => esc_html__( 'Size', 'tb-carousel' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 60,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-button-prev.tb-prev, 
					{{WRAPPER}} .swiper-button-next.tb-next' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label' => esc_html__( 'Color', 'tb-carousel' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-button-next.tb-next, 
					{{WRAPPER}} .swiper-button-prev.tb-prev' => 'color: {{VALUE}};',
					'{{WRAPPER}} .swiper-button-next.tb-next svg, 
					{{WRAPPER}} .swiper-button-prev.tb-prev svg' => 'fill: {{VALUE}};',
				],
				
			]
		);
		$this->add_control(
			'arrows_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'tb-carousel' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-button-next.tb-next, 
					{{WRAPPER}} .swiper-button-prev.tb-prev' => 'background-color: {{VALUE}};',
				],
				
			]
		);
		

		$this->end_controls_section();
		$this->start_controls_section(
			'section_caption',
			[
				'label' => esc_html__( 'Caption', 'tb-carousel' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'caption_type!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'caption_align',
			[
				'label' => esc_html__( 'Alignment', 'tb-carousel' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'tb-carousel' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'tb-carousel' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'tb-carousel' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .tb-image-carousel-caption' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'caption_text_color',
			[
				'label' => esc_html__( 'Text Color', 'tb-carousel' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tb-image-carousel-caption' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'caption_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'tb-carousel' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tb-image-carousel-caption' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'caption_typography',
				'global' => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selector' => '{{WRAPPER}} .tb-image-carousel-caption',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'caption_shadow',
				'selector' => '{{WRAPPER}} .tb-image-carousel-caption',
			]
		);

		$this->end_controls_section();
		
		/**
		 * Style Section End
		 */
		$this->slider_settings_controls();
		

	}
	protected function slider_settings_controls(){
        $this->start_controls_section(
            'slider_settings',
            [
                'label'     => esc_html__( 'Slider Settings . ', 'tb-carousel' ),
            ]
        );

		$this->add_control(
			'loop',
			[
				'label' => __( 'Loop', 'tb-carousel' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'tb-carousel' ),
				'label_off' => __( 'No', 'tb-carousel' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'frontend_available' => true,
			]
		);	
		
		$this->add_control(
			'speed',
			[
				'label' => __( 'Speed', 'tb-carousel' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 500,
				'max' => 3000,
				'step' => 500,
				'default' => 1000,
				'frontend_available' => true,
			]
		);
        $this->add_control(
			'delay',
			[
				'label' => __( 'Delay', 'tb-carousel' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1000,
				'max' => 7000,
				'step' => 1000,
				'default' => 5000,
				'frontend_available' => true,
			]
		);
	

        $this->add_control(
			'stopOnHover',
			[
				'label' => __( 'Stop On Hover', 'tb-carousel' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'tb-carousel' ),
				'label_off' => __( 'No', 'tb-carousel' ),
				'return_value' => 'yes',
				'default' => 'yes',
                'frontend_available' => true,
			]
		);
		
       $this->add_control(
			'slidesPerView',
			[
				'label' => __( 'Slides Per View', 'tb-carousel' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '1',
				'frontend_available' => true,
				'options' => [
                    'auto'  => __( 'Auto', 'tb-carousel' ),
					'1'  => __( 'One', 'tb-carousel' ),
					'2' => __( 'Two', 'tb-carousel' ),
					'3' => __( 'Three', 'tb-carousel' ),
					'4' => __( 'Four', 'tb-carousel' ),
				],
			]
		);
       $this->add_control(
			'spaceBetween',
			[
				'label' => __( 'Space Between', 'tb-carousel' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 100,
				'step' => 2,
				'default' => 50,
				'frontend_available' => true,
                'condition' => [
                    'slidesPerView!' => 'default',
                ],
			]
		);
        $this->add_control(
			'navigation',
			[
				'label' => __( 'Navigation', 'tb-carousel' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'tb-carousel' ),
				'label_off' => __( 'No', 'tb-carousel' ),
				'return_value' => 'yes',
				'default' => 'yes',
                'frontend_available' => true,
			]
		);
        $this->add_control(
			'centeredSlides',
			[
				'label' => __( 'Centered Slides', 'tb-carousel' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'tb-carousel' ),
				'label_off' => __( 'No', 'tb-carousel' ),
				'return_value' => 'yes',
				'default' => 'yes',
                'frontend_available' => true,
			]
		);
       

        $this->end_controls_section();
    }

	// Frontend output
	protected function render() {
		$settings = $this->get_settings_for_display();
		
		$id= $this->get_id();
		?>
		<div class="tb-carousel">
			<div class="swiper featured-swiper">
				<div class="swiper-wrapper">
				<?php
				foreach ( $settings['gallery'] as $index => $attachment ) { 
					$image_caption = $this->get_image_caption( $attachment );
					?>
				<div class="swiper-slide">
					<?php echo wp_get_attachment_image($attachment['id'], $settings['thumbnail_size']);?>
					<?php if ( ! empty( $image_caption ) ) {
					echo '<div class="tb-image-carousel-caption">' . wp_kses_post( $image_caption ) . '</div>';
				}?>
				</div>
				
				<?php }?>
				</div>
				
			</div>
			<div class="swiper-button-next tb-next">
			<?php \Elementor\Icons_Manager::render_icon( $settings['navigation_next_icon'], [ 'aria-hidden' => 'true' ] ); ?>
			</div>
			<div class="swiper-button-prev tb-prev">
			<?php \Elementor\Icons_Manager::render_icon( $settings['navigation_previous_icon'], [ 'aria-hidden' => 'true' ] ); ?>
			</div>
		</div>
			
<?php }


private function get_image_caption( $attachment ) {
	$caption_type = $this->get_settings_for_display( 'caption_type' );

	if ( empty( $caption_type ) ) {
		return '';
	}

	$attachment_post = get_post( $attachment['id'] );

	if ( 'caption' === $caption_type ) {
		return $attachment_post->post_excerpt;
	}

	if ( 'title' === $caption_type ) {
		return $attachment_post->post_title;
	}

	return $attachment_post->post_content;
}

}

