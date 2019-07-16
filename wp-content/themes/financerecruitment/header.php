<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
* Please browse readme.txt for credits and forking information
 * @package financerecruitment
 */

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="page" class="hfeed site">
		<header id="masthead"  role="banner">
			<nav class="navbar lh-nav-bg-transform navbar-default navbar-fixed-top navbar-left" role="navigation"> 
				<!-- Brand and toggle get grouped for better mobile display --> 
				<div class="container" id="navigation_menu">
					<div class="navbar-header"> 
						<?php if ( has_nav_menu( 'primary' ) ) { ?>
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"> 
							<span class="sr-only"><?php echo esc_html('Toggle Navigation', 'financerecruitment') ?></span> 
							<span class="icon-bar"></span> 
							<span class="icon-bar"></span> 
							<span class="icon-bar"></span> 
						</button> 
						<?php } ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<?php 
							if (!has_custom_logo()) { 
								echo '<div class="navbar-brand">'; bloginfo('name'); echo '</div>';
							} else {
								the_custom_logo();
							} ?>
						</a>
					</div> 
					<?php if ( has_nav_menu( 'primary' ) ) {
              financerecruitment_header_menu(); // main navigation 
            }
            ?>

          </div><!--#container-->
        </nav>

        <?php if ( is_front_page() ) { ?>
        <div class="site-header">
          <div class="container">
           <div class="site-branding">   
            <span class="home-link">
             <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
               <span class="frontpage-site-title"> <?php bloginfo( 'name' ); ?></span>
               <span class="frontpage-site-description"><?php bloginfo( 'description' ); ?></span>
           </a>

           <?php if (get_theme_mod('left_button_text') ) : ?>
             <a href="<?php echo esc_url(get_theme_mod('left_button_link')) ?>" class="header-button-left"><?php echo esc_html(get_theme_mod('left_button_text')) ?></a>
           <?php endif; ?>
           <?php if (get_theme_mod('right_button_text') ) : ?>
             <a href="<?php echo esc_url(get_theme_mod('right_button_link')) ?>" class="header-button-right"><?php echo esc_html(get_theme_mod('right_button_text')) ?></a>
           <?php endif; ?>
         </span>
       </div><!--.site-branding-->
     </div>
   </div><!--.site-header--> 
 </header>    
 <div id="content" class="site-content top-header-img">
   <?php } else {  ?>
 </header>    
 <div id="content" class="site-content">
   <?php } ?>   

   <div id="content" class="site-content top-header-img">
     <div class="container"> 
      <div class="row">
       <div class="col-md-4">
        <?php dynamic_sidebar( 'top_widget_left' ); ?>
      </div>
      <div class="col-md-4">
        <?php dynamic_sidebar( 'top_widget_middle' ); ?>
      </div>
      <div class="col-md-4">
        <?php dynamic_sidebar( 'top_widget_right' ); ?>
      </div>
    </div>
  </div>



