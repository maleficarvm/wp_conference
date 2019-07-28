<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package The Conference
 */
/**
 * Doctype Hook
 *
 * @hooked the_conference_doctype
 */
do_action('the_conference_doctype');
?>
    <head itemscope itemtype="http://schema.org/WebSite">
        <?php
        /**
         * Before wp_head
         *
         * @hooked the_conference_head
         */
        do_action('the_conference_before_wp_head');

        wp_head(); ?>
    </head>

<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">

<?php
/**
 * Before Header
 *
 * @hooked the_conference_page_start - 20
 */
do_action('the_conference_before_header');

/**
 * Header
 *
 * @hooked the_conference_header - 20
 */
//do_action( 'the_conference_header' );
?>

    <header class="site-header" itemscope="" itemtype="http://schema.org/WPHeader">
        <div class="container">
            <div class="site-branding logo-with-site-identity" itemscope="" itemtype="http://schema.org/Organization">
                <div class="site-logo"><a href="http://wpfolder/" class="custom-logo-link" rel="home"><img width="80"
                                                                                                           height="80"
                                                                                                           src="http://wpfolder/wp-content/uploads/2019/06/лого-инст-12-e1561037572941.png"
                                                                                                           class="custom-logo"
                                                                                                           alt="МИНИСТЕРСТВО ПРИРОДНЫХ РЕСУРСОВ И ЭКОЛОГИИ РОССИЙСКОЙ ФЕДЕРАЦИИ<br>ФЕДЕРАЛЬНОЕ АГЕНСТВО ПО НЕДРОПОЛЬЗОВАНИЮ"></a>
                </div><!-- .site-logo -->
                <div class="site-title-wrap"><h1 class="site-title" itemprop="name"><a href="http://wpfolder/"
                                                                                       rel="home" itemprop="url">МИНИСТЕРСТВО
                            ПРИРОДНЫХ РЕСУРСОВ И ЭКОЛОГИИ РОССИЙСКОЙ ФЕДЕРАЦИИ<br>ФЕДЕРАЛЬНОЕ АГЕНСТВО ПО
                            НЕДРОПОЛЬЗОВАНИЮ</a></h1>
                    <p class="site-description" itemprop="description">Центральный научно-исследовательскийинститут
                        цветных и благородных металлов</p>
                </div><!-- .site-title-wrap -->
            </div>
            <div class="nav-wrap">
                <nav id="site-navigation" class="main-navigation" role="navigation" itemscope=""
                     itemtype="http://schema.org/SiteNavigationElement">

                </nav><!-- #site-navigation -->
            </div>
        </div>
    </header>

<?php
/**
 * Before Content
 *
 * @hooked the_conference_banner - 15
 */
do_action('the_conference_after_header');

/**
 * Content
 *
 * @hooked the_conference_content_start
 */
do_action('the_conference_content');