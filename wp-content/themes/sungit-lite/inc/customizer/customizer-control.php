<?php
if( ! class_exists('WP_Customize_Control') ){
  return NULL;
}

class Sungit_Lite_Support_Control extends WP_Customize_Control {

      /**
       * Render the content on the theme customizer page
       */
       public $type = "sungit-lite-support";

         public function enqueue() {
         wp_enqueue_style( 'sungit-lite-support-style', trailingslashit( get_template_directory_uri() ) . '/inc/customizer/css/customizer-control.css' );
        /* js */
      }

      public function render_content() {
         //Add Theme instruction, Support Forum, Demo Link, Rating Link

         ?><p>
              <a class="sungit-lite-support" target="_blank" href="<?php echo esc_url("http://yudleethemes.com/sungit-lite-documentation/");?>"><span class="dashicons dashicons-book-alt"></span><?php echo  esc_html__('Documentation', 'sungit-lite') ?></a>
            <a class="sungit-lite-support" target="_blank" href="<?php echo  esc_url('http://yudleethemes.com/my-tickets/') ?>"><span class="dashicons dashicons-edit"></span><?php echo esc_html__('Create a Ticket', 'sungit-lite') ?></a>

                <a class="sungit-lite-support" target="_blank" href="<?php echo esc_url("https://yudleethemes.com/product/sungit-premium-theme/?add-to-cart=1732");?>"><span class="dashicons dashicons-star-filled"></span><?php echo  esc_html__('Buy Premium', 'sungit-lite') ?></a>
          <a class="support-image sungit-lite-support" target="_blank" href="<?php echo  esc_url('http://yudleethemes.com/support/#customization_support') ?>"><img src = "<?php echo esc_url(get_template_directory_uri() . '/assets/img/wparmy.png') ?>" /> <?php echo esc_html__('Request Customization', 'sungit-lite'); ?></a>
          </p>
         <?php
      }
}