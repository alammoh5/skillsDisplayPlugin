<?php
	
/*
	Plugin Name: Skills Display
	Description: A widget to display your wonderful skills
	Author: Osama Alam
	Author URI: https://phoenix.sheridanc.on.ca/~ccit3661/
	Version: 1.0
*/

//Enqueue scripts
function skillsdp_scripts() {
	
	wp_register_style('googleFonts', 'https://fonts.googleapis.com/css?family=Lato');
    wp_enqueue_style( 'googleFonts');
	wp_register_style('googleFontss', 'https://fonts.googleapis.com/css?family=Orbitron:400,900)');
    wp_enqueue_style( 'googleFontss');
	wp_enqueue_style( 'skillsdp-plugin-style', plugin_dir_url( __FILE__ ) . "/css/style.css");
	
	/* Simple Grid
	Project Page - http://thisisdallas.github.com/Simple-Grid/
	Author - Dallas Bass
	Site - http://dallasbass.com
	Licensed under Creative Commons Attribution-NonCommercial 3.0 license 
	*/
	wp_enqueue_style( 'simplegrid.css',  plugin_dir_url( __FILE__ ) . '/css/simplegrid.css' );
	
	/* flexSlider 
	Licensed under Creative Commons Attribution-NonCommercial 3.0 license https://woocommerce.com/flexslider/ 
	*/
	wp_enqueue_script('flexslider', plugin_dir_url( __FILE__ ) . '/js/flex-slider/jquery.flexslider.js', array('jquery'), '2.6.1', true);
	wp_enqueue_script('flexslider-min', plugin_dir_url( __FILE__ ) . '/js/flex-slider/jquery.flexslider-min.js', array('jquery'), '2.6.1', true);
	wp_enqueue_style( 'flexslider-css', plugin_dir_url( __FILE__ ) . '/js/flex-slider/flexslider.css');

	
	wp_enqueue_script('my-scripts', plugin_dir_url( __FILE__ ) . 'js/scripts.js', array('jquery'), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'skillsdp_scripts' );


// Create the Widget
class chictonicSkillsDisplay extends WP_Widget {
	
	// Initialize the Widget
	public function __construct() {
		$skills_ops = array(
			'classname' => 'widget_skills_display', 
			'description' => __( 'Your wonderful skills.') 
	);
		// Adds a class to the widget and provides a description on the Widget page to describe what the widget does.
		parent::__construct('widget_skills_display', __('Skills Display'), $skills_ops);
	}
	
	// Determines what will appear on the site
	public function widget( $args, $instance ) { ?>
		
		<div id = "skills">
		<main id="skills-main" >
		<h1 class ="entry-title"> Skills </h1>
		<div class="slider">
			<div class="flexslider">
			  <ul class="slides">
				<?php $my_query = new WP_Query( array( 'post_type' => 'tech_skill' ) ); ?>
				<?php while ($my_query->have_posts()) : $my_query->the_post(); ?>
				<li>
				<?php get_template_part( 'template-parts/content-test', get_post_format() );?>
				</li>	
				<?php endwhile; ?>
				<?php wp_reset_query(); ?>
				</ul>
			</div>
		</div>
		</main><!-- #main -->
	</div><!-- #testimonial -->
		
	<?php }
	
	
	
	
}

// Tells WordPress that this widget has been created and that it should display in the list of available widgets.

add_action( 'widgets_init', function(){
     register_widget( 'chictonicSkillsDisplay' );
});