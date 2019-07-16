<?php
/**
 * financerecruitment functions and definitions
 * Please browse readme.txt for credits and forking information
 *
 * @package financerecruitment
 */


if ( ! function_exists( 'financerecruitment_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */


function financerecruitment_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on financerecruitment, use a find and replace
	 * to change 'financerecruitment' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'financerecruitment', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 604, 270);
	add_image_size( 'financerecruitment-full-width', 1038, 576, true );
	
	

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'financerecruitment_custom_background_args', array(
		'default-color' => 'eee',
		'default-image' => '',
		) ) );
	
	function financerecruitment_register_financerecruitment_menus() {
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Top Primary Menu', 'financerecruitment' ),
			) );
	}

	add_action( 'init', 'financerecruitment_register_financerecruitment_menus' );
	
	
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		) );



}


endif; // financerecruitment_setup
add_action( 'after_setup_theme', 'financerecruitment_setup' );

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 */
function financerecruitment_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'financerecruitment_content_width', 640 );
}
add_action( 'after_setup_theme', 'financerecruitment_content_width', 0 );


/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */

function financerecruitment_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'financerecruitment' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Widgets here will appear in your sidebar', 'financerecruitment' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
		) );
}
add_action( 'widgets_init', 'financerecruitment_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function financerecruitment_scripts ( $in_footer ) {
	wp_enqueue_style( 'bootstrap', get_template_directory_uri().'/css/bootstrap.css',true );  

	wp_enqueue_style( 'financerecruitment-style', get_stylesheet_uri() );

	if ( get_theme_mod( 'toggle_header_allpages' ) == '1' ) : 
		wp_enqueue_style( 'financerecruitment-extra-styling', get_template_directory_uri().'/css/extra-header.css',true );   	
	endif;

	wp_enqueue_style( 'font-awesome', get_template_directory_uri().'/font-awesome/css/font-awesome.min.css',true );   
	
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.js',array('jquery'),'',true);  

	wp_enqueue_script( 'financerecruitment-skip-link-focus-fix-jquery', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array('jquery'), '20130115', true );

	wp_enqueue_script( 'html5shiv', get_template_directory_uri().'/js/html5shiv.js', array(),'3.7.3',false );
	wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( get_theme_mod( 'toggle_header_allpages' ) == '1' ) : 
		wp_enqueue_style( 'financerecruitment-extra-styling', get_template_directory_uri().'/css/financerecruitment-header.css',true );   	
	endif;


}
add_action( 'wp_enqueue_scripts', 'financerecruitment_scripts' );


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';


/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';


/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';


/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Load custom nav walker
 */
if(!class_exists('wp_bootstrap_navwalker')){
require get_template_directory() . '/inc/navwalker.php';
}


function financerecruitment_google_fonts() {
	$query_args = array(

		'family' => 'Lato:400,400italic,600,600italic,700,700i,900'
		);
	wp_register_style( 'financerecruitmentgooglefonts', add_query_arg( $query_args, "//fonts.googleapis.com/css" ), array(), null );
	wp_enqueue_style( 'financerecruitmentgooglefonts');
}

add_action('wp_enqueue_scripts', 'financerecruitment_google_fonts');


function financerecruitment_new_excerpt_more( $more ) {
	if ( is_admin() ) {
		return $more;
	}

		$link = sprintf( '<p class="read-more"><a class="readmore-btn" href="'. esc_url(get_permalink( get_the_ID() )) . '' . '">' . __('Read More', 'financerecruitment') . '<span class="screen-reader-text"> '. __(' Read More', 'financerecruitment').'</span></a></p>',
		esc_url( get_permalink( get_the_ID() ) )
	);
	return '&hellip;' . $link;

}
add_filter( 'excerpt_more', 'financerecruitment_new_excerpt_more' );




/**
*
* Custom Logo in the top menu
*
**/

function financerecruitment_logo() {
	add_theme_support('custom-logo', array(
		'size' => 'financerecruitment-logo',
		'flex-width'            => true,
		'flex-height'            => true,
		));
}

add_action('after_setup_theme', 'financerecruitment_logo');


function financerecruitment_footer_widget_left_init() {

	register_sidebar( array(
		'name' => esc_html__('Footer Widget left', 'financerecruitment'),
		'id' => 'footer_widget_left',
		'description'   => esc_html__( 'Widgets here will appear in your footer', 'financerecruitment' ),
		'before_widget' => '<div class="footer-widgets">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
		) );
}
add_action( 'widgets_init', 'financerecruitment_footer_widget_left_init' );

function financerecruitment_footer_widget_middle_init() {

	register_sidebar( array(
		'name' => esc_html__('Footer Widget middle', 'financerecruitment'),
		'id' => 'footer_widget_middle',
		'description'   => esc_html__( 'Widgets here will appear in your footer', 'financerecruitment' ),
		'before_widget' => '<div class="footer-widgets">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
		) );
}
add_action( 'widgets_init', 'financerecruitment_footer_widget_middle_init' );

function financerecruitment_footer_widget_right_init() {

	register_sidebar( array(
		'name' => esc_html__('Footer Widget right', 'financerecruitment'),
		'id' => 'footer_widget_right',
		'before_widget' => '<div class="footer-widgets">',
		'description'   => esc_html__( 'Widgets here will appear in your footer', 'financerecruitment' ),
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
		) );
}
add_action( 'widgets_init', 'financerecruitment_footer_widget_right_init' );




function financerecruitment_top_widget_left_init() {

	register_sidebar( array(
		'name' => esc_html__('Top Widget left', 'financerecruitment'),
		'id' => 'top_widget_left',
		'before_widget' => '<div class="top-widgets">',
		'description'   => esc_html__( 'Widgets here will appear under the header image', 'financerecruitment' ),
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
		) );
}
add_action( 'widgets_init', 'financerecruitment_top_widget_left_init' );


function financerecruitment_top_widget_middle_init() {

	register_sidebar( array(
		'name' => esc_html__('Top Widget middle', 'financerecruitment'),
		'id' => 'top_widget_middle',
		'description'   => esc_html__( 'Widgets here will appear under the header image', 'financerecruitment' ),
		'before_widget' => '<div class="top-widgets">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
		) );
}
add_action( 'widgets_init', 'financerecruitment_top_widget_middle_init' );

function financerecruitment_top_widget_right_init() {

	register_sidebar( array(
		'name' => esc_html__('Top Widget right', 'financerecruitment'),
		'id' => 'top_widget_right',
		'before_widget' => '<div class="top-widgets">',
		'after_widget' => '</div>',
		'description'   => esc_html__( 'Widgets here will appear under the header image', 'financerecruitment' ),
		'before_title' => '<h3>',
		'after_title' => '</h3>',
		) );
}
add_action( 'widgets_init', 'financerecruitment_top_widget_right_init' );



