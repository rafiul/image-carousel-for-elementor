<?php

namespace TbCarousel\Widgets;

use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Css_Filter;
use Elementor\Plugin;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Modules\DynamicTags\Module as TagsModule;

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
		return __( 'Image Carousel (R)', 'tb-carousel' );
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
			'type_section',
			[
				'label' => esc_html__( 'Select Type', 'tb-carousel' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'carousel_type',
			[
				'label' => esc_html__( 'Carousel Type', 'tb-carousel' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'image',
				'options' => [
					'image' => esc_html__( 'Image', 'tb-carousel' ),
					'testimonial' => esc_html__( 'Testimonial', 'tb-carousel' ),
				],
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'image_section',
			[
				'label' => esc_html__( 'Image Content', 'tb-carousel' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'carousel_type' => 'image',
				],
			]
		);
		$this->add_control(
			'gallery',
			[
				'label' => esc_html__( 'Image', 'tb-carousel' ),
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
			],
			
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

		/** Testimonial Content */
		$this->start_controls_section(
			'repeater_section',
			[
				'label' => esc_html__( 'Testimonial Content', 'tb-carousel' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'carousel_type!' => 'image',
				],
			]
		);
		
	
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'testimonial_image',
			[
				'label' => esc_html__( 'Choose Image', 'tb-carousel' ),
				'type' =>\Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'exclude' => [],
				'include' => [],
				'default' => 'full',
				'condition' => [
					'carousel_type' => 'image',
				],
			],
			
		);

		$repeater->add_control(
			'testimonial_title',
			[
				'label' => esc_html__( 'Title', 'tb-carousel' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => 'Lorem Ipsum Title',
			]
		);
		$repeater->add_control(
			'testimonial_content',
			[
				'label' => esc_html__( 'Content', 'tb-carousel' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'rows' => '10',
				'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'tb-carousel' ),
			]
		);

		$repeater->add_control(
			'testimonial_name',
			[
				'label' => esc_html__( 'Name', 'tb-carousel' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'John Doe',
			]
		);

		$repeater->add_control(
			'testimonial_job',
			[
				'label' => esc_html__( 'Title', 'tb-carousel' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Designer',
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'tb-carousel' ),
				'type' => \Elementor\Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'https://your-link.com', 'tb-carousel' ),
			]
		);
		$this->add_control(
			'testimonial_list',
			[
				'label' => esc_html__( 'Testimonial List', 'tb-carousel' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'testimonial_title' => esc_html__( 'Title #1', 'tb-carousel' ),
						'testimonial_content' => esc_html__( 'Item content. Click the edit button to change this text.', 'tb-carousel' ),
					],
					[
						'testimonial_title' => esc_html__( 'Title #2', 'tb-carousel' ),
						'testimonial_content' => esc_html__( 'Item content. Click the edit button to change this text.', 'tb-carousel' ),
					],
					[
						'testimonial_title' => esc_html__( 'Title #3', 'tb-carousel' ),
						'testimonial_content' => esc_html__( 'Item content. Click the edit button to change this text.', 'tb-carousel' ),
					],
				],
				'title_field' => '{{{ testimonial_title }}}',
			]
		);

		/** End Repeater */
		
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
			'image_size',
			[
				'label' => esc_html__( 'Image Height', 'tb-carousel' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-slide img' => 'height: {{SIZE}}{{UNIT}};',
				],
				
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label' => esc_html__( 'Nav Color', 'tb-carousel' ),
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
				'label' => esc_html__( 'Nav Background Color', 'tb-carousel' ),
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
					'carousel_type' => 'image',
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
				'default' => 30,
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

		<?php if($settings['carousel_type']=='image'){?>
		<div class="tb-carousel">
			<div class="swiper featured-swiper-<?php echo $id;?>" id="swiper-<?php echo $id;?>">
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
			<?php
			if($settings['navigation']){?>
				<div class="swiper-button-next next-<?php echo $id;?> tb-next">
				<?php \Elementor\Icons_Manager::render_icon( $settings['navigation_next_icon'], [ 'aria-hidden' => 'true' ] ); ?>
				</div>
				<div class="swiper-button-prev prev-<?php echo $id;?> tb-prev">
				<?php \Elementor\Icons_Manager::render_icon( $settings['navigation_previous_icon'], [ 'aria-hidden' => 'true' ] ); ?>
				</div>
			<?php }?>
		</div>
		<?php }?>

		<!--Testimonial-->
		<?php if($settings['carousel_type']=='testimonial'){?>
		<div class="tb-carousel tb-testimonial">
			<div class="swiper featured-swiper-<?php echo $id;?>" id="swiper-<?php echo $id;?>">
				<div class="swiper-wrapper">

				<?php
				$count=0;
				//print_r($settings['testimonial_list']);
				 foreach($settings['testimonial_list'] as $testimonials){
				?>

				<div class="swiper-slide">
					<div class="tb-testimonial-image">
					<?php echo wp_get_attachment_image($testimonials['testimonial_image']['id'], $settings['thumbnail_size']);?>
					</div>
					<h3 class="tb-testimonial-title">
						<?php echo $testimonials['testimonial_title'];?>
					</h3>
					<div class="tb-testimonial-content">
						<?php echo $testimonials['testimonial_content'];?>
					</div>
					<div class="tb-testimonial-name">
						<?php echo $testimonials['testimonial_name'];?>
					</div>
					<div class="tb-testimonial-position">
						<?php echo $testimonials['testimonial_job'];?>
					</div>
				</div>
				<?php }?>
			</div>
			
		</div>
			<?php
				if($settings['navigation']){
			?>
				<div class="swiper-button-next tb-next next-<?php echo $id;?>">
				<?php \Elementor\Icons_Manager::render_icon( $settings['navigation_next_icon'], [ 'aria-hidden' => 'true' ] ); ?>
				</div>
				<div class="swiper-button-prev tb-prev prev-<?php echo $id;?>">
				<?php \Elementor\Icons_Manager::render_icon( $settings['navigation_previous_icon'], [ 'aria-hidden' => 'true' ] ); ?>
				</div>
			<?php }?>
	</div>
	<?php }?>
			
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

