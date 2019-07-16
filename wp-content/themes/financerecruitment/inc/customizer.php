<?php
/**
 * financerecruitment Theme Customizer
 *
 * Please browse readme.txt for credits and forking information
 *
 * @package financerecruitment
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function financerecruitment_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_section('header_image')->title = __( 'Front Page Header', 'financerecruitment' );

	$wp_customize->add_setting( 'theme_color', array(
		'default'           => '#c69c53',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'theme_color', array(
		'label'       => __( 'Theme Color', 'financerecruitment' ),
		'description' => __( 'Applied to header background.', 'financerecruitment' ),
		'section'     => 'colors',
		'settings'    => 'theme_color',
		) ) );



	$wp_customize->add_section(
		'financerecruitment_help_and_support_today',
		array(
			'title' => __('FinanceRecruitment Premium', 'financerecruitment'),
			'priority' => 0,
			'description' => __(' ', 'financerecruitment') . '<a href="https://outstandingthemes.com/themes/finance-recruitment/" target="_blank"><img src="' . get_template_directory_uri() . '/images/theme-image-1.png"></a>',
			)
		); 

	$wp_customize->add_setting('financerecruitment_help_and_support_today_tabs_sec', array(
		'sanitize_callback' => 'unneeded',
		'type' => 'info_control',
		'capability' => 'edit_theme_options',
		)
	);
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'help_and_support_today_tab', array(
		'section' => 'financerecruitment_help_and_support_today',
		'settings' => 'financerecruitment_help_and_support_today_tabs_sec',
		'type' => 'none',
		'priority' => 0
		) )
	);   



	$wp_customize->add_setting('align_header_text', 
		array(
			'sanitize_callback' => 'sanitize_text_field', 
			'default' => 'left'
			));
	$wp_customize->add_control( 'align_header_text', array(
		'section'               => 'header_image',
		'label'                 => __( 'Header Text Alignment', 'financerecruitment' ),
		'type'                  => 'radio',
		'priority'              => 1,
		'choices'               => array(
			'left'              => __('Left', 'financerecruitment'),
			'center'              => __('Center', 'financerecruitment'),
			'right'            => __('Right', 'financerecruitment'),
			),
		));

	$wp_customize->add_setting( 'header_bg_color', array(
		'default'           => '#1b1b1b',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_bg_color', array(
		'label'       => __( 'Header Background Color', 'financerecruitment' ),
		'description' => __( 'Applied to header background.', 'financerecruitment' ),
		'section'     => 'header_image',
		'settings'    => 'header_bg_color',
		) ) );

	$wp_customize->add_section( 'site_identity' , array(
		'priority'   => 3,
		));

	$wp_customize->add_section( 'header_image' , array(
		'title'      => __('Front Page: Header', 'financerecruitment'),
		'priority'   => 4,
		));

	$wp_customize->add_setting( 'header_image_text_color', array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_image_text_color', array(
		'label'       => __( 'Header Image Headline Color', 'financerecruitment' ),
		'description' => __( 'Choose a color for the header image headline.', 'financerecruitment' ),
		'priority' 			=> 2,
		'section'     => 'header_image',
		'settings'    => 'header_image_text_color',
		) ) );

	$wp_customize->add_setting( 'header_image_tagline_color', array(
		'default'           => '#dcdcdc',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_image_tagline_color', array(
		'label'       => __( 'Header Image Tagline Color', 'financerecruitment' ),
		'description' => __( 'Choose a color for the header tagline headline.', 'financerecruitment' ),
		'section'     => 'header_image',
		'priority'   => 2,
		'settings'    => 'header_image_tagline_color',
		) ) );

	$wp_customize->add_setting( 'left_button_text', array(
		'type'              => 'theme_mod',
		'sanitize_callback' => 'sanitize_text_field',
		'capability'        => 'edit_theme_options',
		'default'  => '',
		) );

	$wp_customize->add_control( 'left_button_text', array(
		'label'    => __( "Left Button Text", 'financerecruitment' ),
		'section'  => 'header_image',
		'type'     => 'text',
		'default'  => '',
		'priority' => 1,
		) );

	$wp_customize->add_setting( 'left_button_link', array(
		'type'              => 'theme_mod',
		'sanitize_callback' => 'esc_url_raw',
		'capability'        => 'edit_theme_options',
		'default'  => '',
		) );

	$wp_customize->add_control( 'left_button_link', array(
		'label'    => __( "Left Button Link", 'financerecruitment' ),
		'section'  => 'header_image',
		'type'     => 'text',
		'default'  => '',
		'priority' => 1,
		) );

	$wp_customize->add_setting( 'right_button_text', array(
		'type'              => 'theme_mod',
		'sanitize_callback' => 'sanitize_text_field',
		'capability'        => 'edit_theme_options',
		'default'  => '',
		) );

	$wp_customize->add_control( 'right_button_text', array(
		'label'    => __( "Right Button Text", 'financerecruitment' ),
		'section'  => 'header_image',
		'type'     => 'text',
		'default'  => '',
		'priority' => 1,
		) );

		$wp_customize->add_setting( 'right_button_link', array(
		'type'              => 'theme_mod',
		'sanitize_callback' => 'esc_url_raw',
		'capability'        => 'edit_theme_options',
		'default'  => '',
		) );

	$wp_customize->add_control( 'right_button_link', array(
		'label'    => __( "Right Button Link", 'financerecruitment' ),
		'section'  => 'header_image',
		'type'     => 'text',
		'default'  => '',
		'priority' => 1,
		) );


	$wp_customize->add_setting( 'header_image_left_button_color', array(
		'default'           => '#c69c53',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_image_left_button_color', array(
		'label'       => __( 'Left Button Background Color', 'financerecruitment' ),
		'section'     => 'header_image',
		'priority'   => 2,
		'settings'    => 'header_image_left_button_color',
		) ) );
	$wp_customize->add_setting( 'header_image_left_text_color', array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_image_left_text_color', array(
		'label'       => __( 'Left Button Text Color', 'financerecruitment' ),
		'section'     => 'header_image',
		'priority'   => 2,
		'settings'    => 'header_image_left_text_color',
		) ) );

	$wp_customize->add_setting( 'header_image_right_button_color', array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_image_right_button_color', array(
		'label'       => __( 'Right Button Color', 'financerecruitment' ),
		'section'     => 'header_image',
		'priority'   => 2,
		'settings'    => 'header_image_right_button_color',
		) ) );


// Post and page Section
	$wp_customize->add_section(
		'post_page_options',
		array(
			'title'     => __('Post & Page','financerecruitment'),
			'priority'  => 6
			)
		);
	$wp_customize->add_setting( 'postpage_background', array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'postpage_background', array(
		'label'       => __( 'Post & Page Background', 'financerecruitment' ),
		'description' => __( 'Choose a color for the post & page background.', 'financerecruitment' ),
		'section'     => 'post_page_options',
		'settings'    => 'postpage_background',
		) ) );


	$wp_customize->add_setting( 'headline_color', array(
		'default'           => '#212121',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'headline_color', array(
		'label'       => __( 'Post & Page Headline Color', 'financerecruitment' ),
		'description' => __( 'Choose a color for the post & page headline.', 'financerecruitment' ),
		'section'     => 'post_page_options',
		'settings'    => 'headline_color',
		) ) );
	$wp_customize->add_setting( 'post_content_color', array(
		'default'           => '#949494',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'post_content_color', array(
		'label'       => __( 'Post & Page Paragraph Color', 'financerecruitment' ),
		'description' => __( 'Choose a color for the post & page paragraphs.', 'financerecruitment' ),
		'section'     => 'post_page_options',
		'settings'    => 'post_content_color',
		) ) );


	$wp_customize->add_setting( 'author_line_color', array(
		'default'           => '#afafaf',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'author_line_color', array(
		'label'       => __( 'Author Byline Color', 'financerecruitment' ),
		'description' => __( 'Choose a color for the author byline in the top of posts.', 'financerecruitment' ),
		'section'     => 'post_page_options',
		'settings'    => 'author_line_color',
		) ) );

// Post and page Section end

// Sidebar Section
	$wp_customize->add_section(
		'sidebar_options',
		array(
			'title'     => __('Sidebar','financerecruitment'),
			'priority'  => 7
			)
		);

	$wp_customize->add_setting( 'sidebar_headline_colors', array(
		'default'           => '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar_headline_colors', array(
		'label'       => __( 'Sidebar Headline Color', 'financerecruitment' ),
		'description' => __( 'Choose the color of the sidebar titles and headlines', 'financerecruitment' ),
		'section'     => 'sidebar_options',
		'settings'    => 'sidebar_headline_colors',
		) ) );


	$wp_customize->add_setting( 'sidebar_link_color', array(
		'default'           => '#6b6b6b',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar_link_color', array(
		'label'       => __( 'Sidebar Link Color', 'financerecruitment' ),
		'description' => __( 'Choose the color of the sidebar links', 'financerecruitment' ),
		'section'     => 'sidebar_options',
		'settings'    => 'sidebar_link_color',
		) ) );

	$wp_customize->add_setting( 'sidebar_text_color', array(
		'default'           => '#6b6b6b',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar_text_color', array(
		'label'       => __( 'Sidebar Text Color', 'financerecruitment' ),
		'description' => __( 'Choose the color of the sidebar text', 'financerecruitment' ),
		'section'     => 'sidebar_options',
		'settings'    => 'sidebar_text_color',
		) ) );


	$wp_customize->add_setting( 'footer_colors', array(
		'default'           => '#282C2F',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_colors', array(
		'label'       => __( 'Footer Widget Background', 'financerecruitment' ),
		'description' => __( 'Choose a background color for the footer widget section.', 'financerecruitment' ),
		'section'     => 'colors',
		'settings'    => 'footer_colors',
		) ) );

	$wp_customize->add_setting( 'footer_copyright_background_color', array(
		'default'           => '#282C2F',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_copyright_background_color', array(
		'label'       => __( 'Footer Copyright Background Color', 'financerecruitment' ),
		'description' => __( 'Choose a color for the footer copyright section background.', 'financerecruitment' ),
		'section'     => 'colors',
		'settings'    => 'footer_copyright_background_color',
		) ) );

	$wp_customize->add_setting( 'top_widget_background_color', array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'top_widget_background_color', array(
		'label'       => __( 'Top Widgets Background Color', 'financerecruitment' ),
		'description' => __( 'Choose a background color for the three top widgets.', 'financerecruitment' ),
		'section'     => 'colors',
		'settings'    => 'top_widget_background_color',
		) ) );


	$wp_customize->add_setting( 'postpage_background', array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
		) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'postpage_background', array(
		'label'       => __( 'Post & Page Background', 'financerecruitment' ),
		'description' => __( 'Choose a color for the post & page background.', 'financerecruitment' ),
		'section'     => 'colors',
		'settings'    => 'postpage_background',
		) ) );
	
}
add_action( 'customize_register', 'financerecruitment_customize_register' );



if ( ! function_exists( 'financerecruitment_sanitize_post_display_option' ) ) :
/**
 * Sanitization callback for post display option.
 *
 *
 * @param string $value post display style.
 * @return string post display style.
 */

function financerecruitment_sanitize_post_display_option( $value ) {
	if ( ! in_array( $value, array( 'post-excerpt', 'full-post' ) ) )
		$value = 'post-excerpt';

	return $value;
}
endif; // financerecruitment_sanitize_post_display_option

if(! function_exists('financerecruitment_website_color_customization_output' ) ):
	function financerecruitment_website_color_customization_output(){

		?>

		<style type="text/css">
		a:active, a:hover, a:focus {
			color: <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
		}
		.navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
			color: <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
		}
		.navbar-default .navbar-toggle:hover, .navbar-default .navbar-toggle:focus {
			background-color: <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
			background: <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
			border-color:<?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
		}
		.navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus {
			color: <?php echo esc_attr(get_theme_mod( 'theme_color')) ?> !important;
		}
		.dropdown-menu > .active > a, .dropdown-menu > .active > a:hover, .dropdown-menu > .active > a:focus {
			background-color: <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
		}
		.btn, .btn-default:visited, .btn-default:active:hover, .btn-default.active:hover, .btn-default:active:focus, .btn-default.active:focus, .btn-default:active.focus, .btn-default.active.focus {
			background: <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
		}
		.navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus {
			color: <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
		}
		.cat-links a, .tags-links a {
			color: <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
		}
		.navbar-default .navbar-nav > li > .dropdown-menu > li > a:hover, .navbar-default .navbar-nav > li > .dropdown-menu > li > a:focus {
			background-color: <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
		}
		h5.entry-date a:hover {
			color: <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
		}
		#respond input#submit {
			background-color: <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
			background: <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
		}
		button:hover, button, button:active, button:focus {
			border: 1px solid <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
			background-color:<?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
			background:<?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
		}
		.dropdown-menu .current-menu-item.current_page_item a, .dropdown-menu .current-menu-item.current_page_item a:hover, .dropdown-menu .current-menu-item.current_page_item a:active, .dropdown-menu .current-menu-item.current_page_item a:focus {
			background: <?php echo esc_attr(get_theme_mod( 'theme_color')) ?> !important;
		}
		@media (max-width: 767px) {
			.navbar-default .navbar-nav .open .dropdown-menu > li > a:hover {
				background-color: <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
			}
		}
		blockquote {
			border-left: 5px solid <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
		}
		.sticky-post{
			background: <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
		}
		.entry-header .entry-meta::after{
			background: <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
		}
		.readmore-btn, .readmore-btn:visited, .readmore-btn:active, .readmore-btn:hover, .readmore-btn:focus {
			background: <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
		}
		.post-password-form input[type="submit"], .post-password-form input[type="submit"]:hover, .post-password-form input[type="submit"]:focus, .post-password-form input[type="submit"]:active {
			background-color: <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
		}
		.fa {
			color: <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
		}
		.btn-default{
			border-bottom: 1px solid <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
		}
		.btn-default:hover, .btn-default:focus{
			border-bottom: 1px solid <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
			background-color: <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
		}
		.nav-previous:hover, .nav-next:hover{
			border: 1px solid <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
			background-color: <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
		}
		.next-post a:hover,.prev-post a:hover{
			color: <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
		}
		.posts-navigation .next-post a:hover .fa, .posts-navigation .prev-post a:hover .fa, .image-attachment .entry-meta a, a, a:visited, .next-post a:visited, .prev-post a:visited, .next-post a, .prev-post a {
			color: <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
		}
		button:active, button:focus, html input[type=button]:active, html input[type=button]:focus, input[type=reset]:active, input[type=reset]:focus, input[type=submit]:active, input[type=submit]:focus {
			background: <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
		}
		.cattegories a, .tags-links a {
			background: <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
		}
		#secondary .widget a:hover, #secondary .widget a:focus{
			color: <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
		}
		#secondary .widget_calendar tbody a {
			background-color: <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;
		}
		#secondary .widget_calendar tbody a:hover{background-color: <?php echo esc_attr(get_theme_mod( 'theme_color')) ?>;}
		.site-header { background: <?php echo esc_attr(get_theme_mod( 'header_bg_color')); ?>; }
		.footer-widgets h3 { color: <?php echo esc_attr(get_theme_mod( 'footer_widget_title_colors')); ?>; }
		.site-footer { background: <?php echo esc_attr(get_theme_mod( 'footer_copyright_background_color')); ?>; }
		.footer-widget-wrapper { background: <?php echo esc_attr(get_theme_mod( 'footer_colors')); ?>; }
		.row.site-info { color: <?php echo esc_attr(get_theme_mod( 'footer_copyright_text_color')); ?>; }
		#secondary h3.widget-title, #secondary h4.widget-title { color: <?php echo esc_attr(get_theme_mod( 'sidebar_headline_colors')); ?>; }
		#secondary .widget a, #secondary .widget #recentcomments a, #secondary .widget .rsswidget, #secondary .widget .widget-title .rsswidget, #secondary .widget a { color: <?php echo esc_attr(get_theme_mod( 'sidebar_link_color')); ?>; }
		.navbar-default,.navbar-default li>.dropdown-menu, .navbar-default .navbar-nav .open .dropdown-menu > .active > a, .navbar-default .navbar-nav .open .dr { background-color: <?php echo esc_attr(get_theme_mod( 'navigation_background_color')); ?>; }
		.navbar-default .navbar-nav>li>a, .navbar-default li>.dropdown-menu>li>a { color: <?php echo esc_attr(get_theme_mod( 'navigation_text_color')); ?>; }
		.navbar-default .navbar-brand, .navbar-default .navbar-brand:hover, .navbar-default .navbar-brand:focus { color: <?php echo esc_attr(get_theme_mod( 'navigation_logo_color')); ?>; }
		h1.entry-title, .entry-header .entry-title a, #main h1, #main h2, #main h3, #main h4, #main h5, #main h6, .comments-title, .comment-reply-title, .comment-content h1, .comment-content h2, .comment-content h3, .comment-content h4, .comment-content h5, .comment-author.vcard, .comment-content h6, .next-prev-text, #main th, .comment th, .entry-header .entry-title a, .entry-header .entry-title a:hover, .entry-header .entry-title a:focus, .page-numbers li a, .page-numbers li a:hover, .page-numbers li a:focus, .page-numbers li a:active, .page-numbers li * { color: <?php echo esc_attr(get_theme_mod( 'headline_color')); ?>; }
		.entry-content, .entry-summary, dd, .comment td, #main ul, #main ol, #main li, .comment li, .comment ul, .comment ol, .comment address, #main address, #main td, dt, .post-feed-wrapper p, .comment p, .comment-form-comment label, .search-no-results .page-content p, .error404 .page-content p { color: <?php echo esc_attr(get_theme_mod( 'post_content_color')); ?>; }
		h5.entry-date, h5.entry-date a, #main h5.entry-date, .comment-metadata time { color: <?php echo esc_attr(get_theme_mod( 'author_line_color')); ?>; }
		.top-widgets { background: <?php echo esc_attr(get_theme_mod( 'top_widget_background_color')); ?>; }
		.top-widgets h3 { color: <?php echo esc_attr(get_theme_mod( 'top_widget_title_color')); ?>; }
		.top-widgets, .top-widgets p { color: <?php echo esc_attr(get_theme_mod( 'top_widget_text_color')); ?>; }
		.bottom-widgets { background: <?php echo esc_attr(get_theme_mod( 'bottom_widget_background_color')); ?>; }
		.bottom-widgets h3 { color: <?php echo esc_attr(get_theme_mod( 'bottom_widget_title_color')); ?>; }
		.frontpage-site-title { color: <?php echo esc_attr(get_theme_mod( 'header_image_text_color')) ?>; }
		.frontpage-site-description { color: <?php echo esc_attr(get_theme_mod( 'header_image_tagline_color')) ?>; }
		.bottom-widgets, .bottom-widgets p { color: <?php echo esc_attr(get_theme_mod( 'bottom_widget_text_color')); ?>; }
		.footer-widgets, .footer-widgets p { color: <?php echo esc_attr(get_theme_mod( 'footer_widget_text_color')); ?>; }
		.home .lh-nav-bg-transform .navbar-nav>li>a { color: <?php echo esc_attr(get_theme_mod( 'navigation_frontpage_menu_color')); ?>; }
		.home .lh-nav-bg-transform.navbar-default .navbar-brand { color: <?php echo esc_attr(get_theme_mod( 'navigation_frontpage_logo_color')); ?>; }
		#secondary, #secondary p, #secondary ul, #secondary li, #secondary .widget table caption, #secondary td, #secondary th { color: <?php echo esc_attr(get_theme_mod( 'sidebar_text_color')); ?>; }
		#main .post-content, #main, .comments-area, .post-comments, .single-post-content, .post-comments .comments-area, .page .nav-links, .single-post .nav-links , .nav-next, .nav-previous, .next-post, .prev-post, .page-numbers li * { background: <?php echo esc_attr(get_theme_mod( 'postpage_background')); ?>; }
		.footer-widgets a, .footer-widget-wrapper a, .footer-widgets a:visited, .footer-widgets a:hover, .footer-widgets a:active, .footer-widgets a:focus{ color: <?php echo esc_attr(get_theme_mod( 'footer_widget_link_colors')); ?>; }
		span.frontpage-site-description:before{ background: <?php echo esc_attr(get_theme_mod( 'header_image_tagline_color')) ?>; }
		.header-social-media-link .fa{ color: <?php echo esc_attr(get_theme_mod( 'social_media_link_color')) ?>; }
		a.header-social-media-link{ border-color: <?php echo esc_attr(get_theme_mod( 'social_media_link_color')) ?>; }
		.site-header { padding-top: <?php echo esc_attr(get_theme_mod( 'header_top_padding')) ?>px; }
		.site-header { padding-bottom: <?php echo esc_attr(get_theme_mod( 'header_bottom_padding')) ?>px; }
		@media (min-width:767px){	
			.lh-nav-bg-transform.navbar-default .navbar-brand {color: <?php echo esc_attr(get_theme_mod( 'navigation_logo_color')); ?>; }
		}
		@media (max-width:767px){			
			.lh-nav-bg-transform button.navbar-toggle, .navbar-toggle, .navbar-default .navbar-toggle:hover, .navbar-default .navbar-toggle:focus { background-color: <?php echo esc_attr(get_theme_mod( 'navigation_text_color')); ?>; }
			.home .lh-nav-bg-transform, .navbar-default .navbar-toggle .icon-bar, .navbar-default .navbar-toggle:focus .icon-bar, .navbar-default .navbar-toggle:hover .icon-bar { background-color: <?php echo esc_attr(get_theme_mod( 'navigation_background_color')); ?> !important; }
			.navbar-default .navbar-nav .open .dropdown-menu>li>a, .home .lh-nav-bg-transform .navbar-nav>li>a {color: <?php echo esc_attr(get_theme_mod( 'navigation_text_color')); ?>; }
			.home .lh-nav-bg-transform.navbar-default .navbar-brand { color: <?php echo esc_attr(get_theme_mod( 'navigation_logo_color')); ?>; }
		}
		<?php if ( get_theme_mod( 'align_header_text' ) == 'left' ) : ?>
		.site-header, span.home-link a * { text-align: left; }
		<?php endif; ?>
		<?php if ( get_theme_mod( 'align_header_text' ) == 'center' ) : ?>
		.site-header, span.home-link a * { text-align: center; }
		<?php endif; ?>
		<?php if ( get_theme_mod( 'align_header_text' ) == 'right' ) : ?>
		.site-header, span.home-link a * { text-align: right; }
		<?php endif; ?>
		a.header-button-left{ color: <?php echo esc_attr(get_theme_mod( 'header_image_left_text_color')) ?>; }
		a.header-button-left{ background: <?php echo esc_attr(get_theme_mod( 'header_image_left_button_color')) ?>; }
		a.header-button-left{ border-color: <?php echo esc_attr(get_theme_mod( 'header_image_left_button_color')) ?>; }
		a.header-button-right{ border-color: <?php echo esc_attr(get_theme_mod( 'header_image_right_button_color')) ?>; }
		a.header-button-right{ color: <?php echo esc_attr(get_theme_mod( 'header_image_right_button_color')) ?>; }
		</style>
		<?php }
		add_action( 'wp_head', 'financerecruitment_website_color_customization_output' );
		endif;


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function financerecruitment_customize_preview_js() {
	wp_enqueue_script( 'financerecruitment_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'financerecruitment_customize_preview_js' );
