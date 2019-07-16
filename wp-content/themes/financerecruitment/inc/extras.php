<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package financerecruitment
 *
 * Please browse readme.txt for credits and forking information
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function financerecruitment_body_classes( $classes ) {
  // Adds a class of group-blog to blogs with more than 1 published author.
  if ( is_multi_author() ) {
    $classes[] = 'group-blog';
  }

  return $classes;
}
add_filter( 'body_class', 'financerecruitment_body_classes' );

if ( ! function_exists( 'financerecruitment_header_menu' ) ) :
    /**
     * Header menu (should you choose to use one)
     */
  function financerecruitment_header_menu() {
      // display the WordPress Custom Menu if available
    wp_nav_menu(array(
      'theme_location'    => 'primary',
      'depth'             => 2,
      'container'         => 'div',
      'container_class'   => 'collapse navbar-collapse navbar-ex1-collapse',
      'menu_class'        => 'nav navbar-nav',
      'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
      'walker'            => new wp_bootstrap_navwalker()
      ));
  } /* end header menu */
  endif;



/**
 * Adds the URL to the top level navigation menu item
 */
function  financerecruitment_add_top_level_menu_url( $atts, $item, $args ){
  if ( isset($args->has_children) && $args->has_children  ) {
    $atts['href'] = ! empty( $item->url ) ? $item->url : '';
  }
  return $atts;
}
add_filter( 'nav_menu_link_attributes', 'financerecruitment_add_top_level_menu_url', 99, 3 );


/**
 * Insert the styles.
 */
function financerecruitment_backendfunctions_styles( $hook ) {
  if ( 'appearance_page_financerecruitment-infopage' !== $hook ) {
    return;
  }
  wp_enqueue_style( 'financerecruitment-infopagecss', get_template_directory_uri() . '/css/admin.css', false, '3.0' );
}
add_action( 'admin_enqueue_scripts', 'financerecruitment_backendfunctions_styles' );



/**
 * Insert the theme page.
 */

add_action( 'admin_menu', 'financerecruitment_backendfunctions_wrapper' );
function financerecruitment_backendfunctions_wrapper() {
  add_theme_page( __('FinanceRecruitment Info', 'financerecruitment'), __('FinanceRecruitment', 'financerecruitment'), 'edit_theme_options', 'financerecruitment-infopage.php', 'financerecruitment_backendfunctions_text');
}

function financerecruitment_backendfunctions_text(){ ?>
<div class="text-centering">
  <div class="backend-css customize-financerecruitment">
    <h2><?php echo __( 'Welcome to FinanceRecruitment', 'financerecruitment' ); ?></p></h2>
    <p><?php echo __( 'If you have questions or need help with anything theme related please', 'financerecruitment' ); ?><br><?php echo __( 'send us an email through this', 'financerecruitment' ); ?> <a href="https://outstandingthemes.com/contact/" target="_blank"><?php echo __( 'contact form.', 'financerecruitment' ); ?></a> </p>
  </div>
</div>
<div class="text-centering">
  <div class="backend-css customize-financerecruitment">
    <h2><?php echo __( 'Do you like FinanceRecruitment?', 'financerecruitment' ); ?></p></h2>
    <p>
      <?php echo __( 'We work hard & do our best to give you an awesome theme.', 'financerecruitment' ); ?><br>
      <?php echo __( 'If you like financerecruitment then let the developer know, he gets so happy! ', 'financerecruitment' ); ?>
    </p> 
    <a href="https://wordpress.org/support/theme/financerecruitment/reviews/" class="review-button" target="_blank"><?php echo __( 'Rate FinanceRecruitment', 'financerecruitment' ); ?></a>
  </div>
</div>
<h2 class="headline-second"><?php echo __( 'Quick Links', 'financerecruitment' ); ?></h2>
<div class="text-centering">
 <div class="backend-css">
   <a class="wide-button-financerecruitment" href="<?php echo esc_url(admin_url('/customize.php')); ?>" target="_blank"><?php echo __( 'Customize Theme Design', 'financerecruitment' ); ?></a><br>
   <a class="wide-button-financerecruitment" href="https://outstandingthemes.com/themes/finance-recruitment/" target="_blank"><?php echo __( 'Read About FinanceRecruitment Pro', 'financerecruitment' ); ?></a><br>
   <a class="wide-button-financerecruitment" href="https://outstandingthemes.com/contact/" target="_blank"><?php echo __( 'Contact Us', 'financerecruitment' ); ?></a>
 </div>
</div>
<div class="text-centering"><br><br>
  <a href="https://outstandingthemes.com/themes/finance-recruitment/" target="_blank">
<?php echo '<a class="themeimage" href="https://outstandingthemes.com/themes/finance-recruitment/" target="_blank"><img src="' . get_template_directory_uri() . '/images/theme-image-2.png"></a>'; ?>
  </a>
</div>
<?php }

