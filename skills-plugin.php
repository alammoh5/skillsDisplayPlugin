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


function fantastic_shortcode( $atts , $content=null ) {
	extract( shortcode_atts(
		   array(
		   'color'=>'green',
		   'size'=>'5px'
		   ), $atts )
		   );
		   ?>
		<style>
		.color_me{
			border: solid <?php echo $color ." ". $size ?>;
		}
		</style><?php
	   return'<div class="color_me">'. get_the_post_thumbnail($content). '</div>';
	   }
	   
	   add_shortcode( 'color_my_border', 'fantastic_shortcode' );




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
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<header class="entry-header">
							<?php
							if ( is_single() ) :
								the_title( '<h1 class="entry-title">', '</h1>' );
							else :
								the_title( '<h2 class="entry-title">', '</h2>' );
							endif; ?>
						<?php echo do_shortcode('[color_my_border size="5px" color="gold"][/color_my_border]'); ?>
						</header><!-- .entry-header -->
						<div class="entry-content">
							<?php
								the_content( sprintf(
									/* translators: %s: Name of current post. */
									wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'chictonic' ), array( 'span' => array( 'class' => array() ) ) ),
									the_title( '<span class="screen-reader-text">"', '"</span>', false )
								) );
								wp_link_pages( array(
									'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'chictonic' ),
									'after'  => '</div>',
								) ); ?>
						</div><!-- .entry-content -->
					</article><!-- #post-## -->
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