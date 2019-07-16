<?php
$posts_per_page = get_option('posts_per_page');
$sungit_lite_theme_options = sungit_lite_theme_options();
$tour_title = $sungit_lite_theme_options['tour_title'];
$tour_subtitle = $sungit_lite_theme_options['tour_subtitle']; ?>
<div class="sl-mid-sec section">
    <div class="container">
        <div class="row">
            <div class="section-title">
                <h2><?php echo esc_html( $tour_title ); ?></h2>
                <p><?php echo esc_html( $tour_subtitle ); ?></p>
            </div>
            <?php $args = array(
                'post_type' => 'post',
                'posts_per_page' => absint(get_option('posts_per_page')),
                'post_status' =>'publish',
                'order' => 'desc',
                'orderby' => 'menu_order date',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'post_format',
                        'field' => 'slug',
                        'terms' => array( 'post-format-audio' )
                        )
                    )
                );
            $query = new WP_query($args);
            if($query->have_posts()): ?>
                <!-- Start of upcoming concert section -->
                        <div class="col-md-4">
                            <div class="sl-playlist">
                                <div class="jAudio--player">
                                    <audio></audio>
                                    <div class="jAudio--thumb"></div>
                                  <div class="jAudio--ui">

                                    <div class="jAudio--status-bar">
                                      <div class="jAudio--volume-bar"></div>

                                      <div class="jAudio--progress-bar">
                                        <div class="jAudio--progress-bar-wrapper">
                                          <div class="jAudio--progress-bar-played">
                                            <span class="jAudio--progress-bar-pointer"></span>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="jAudio--time">
                                        <span class="jAudio--time-elapsed">00:00</span>
                                        <span class="jAudio--time-total">00:00</span>
                                      </div>
                                    <div class="jAudio--controls">
                                    <ul>
                                      <li><button class="btn" data-action="prev" id="btn-prev"><i class="fa fa-backward" aria-hidden="true"></i></button></li>
                                      <li><button class="btn" data-action="play" id="btn-play"><i class="fa fa-play" aria-hidden="true"></i></button></li>
                                      <li><button class="btn" data-action="next" id="btn-next"><i class="fa fa-forward" aria-hidden="true"></i></button></li>
                                    </ul>
                                  </div>
                                    </div>

                                  </div>


                                  <div class="jAudio--playlist">
                                  </div>
                                </div>

                            </div><!--slplaylist end-->
                        </div>


                        <?php while($query->have_posts()) : $query->the_post();


                                $blog_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
                                if(!empty($blog_image)){
                                    $blog_image_url = $blog_image[0];
                                }
                                else{
                                    $blog_image_url = '';
                                }
                                        global $shortcode_tags;

//                                        the_content();
                                        $post_id = get_the_ID();
                                        $html = "";
                                        $content = trim(get_post_field('post_content', $post_id));
                                        $ori_url = explode("\n", esc_html($content));
                                        $new_content = preg_match_all('/\[[^\]]*\]/', $content, $matches);
                                        if ($new_content) {
                                            global $post;
                                            $text = $matches[0][0];
                                            $post_content = $post->post_content;
                                            preg_match( '#\[audio\s*.*?\]#s', $post_content, $matches ) && preg_match('/"([^"]+)"/', $matches[0], $ids);
                                            $audio_id = explode(",", $ids[1]);
                                            if($audio_id){
                                                $mp3 = $audio_id[0];
                                                ?>
                                                <input type="hidden" name="audi-title[]" class="audio-data"  value="<?php echo esc_html($post->post_title); ?>">
                                                <input type="hidden" name="audi-guid[]" class="audio-data" value="<?php echo esc_url($mp3); ?>">
                                                <input type="hidden" name="audi-image[]" class="audio-data" value="<?php echo esc_url($blog_image_url); ?>">
                                            <?php }
                                        }


                                        ?>
                                        <?php
                        endwhile;
                        wp_reset_postdata(); ?>

                    <!-- End of blog section -->
            <?php endif; ?>

                                <!-- Start of mid section -->

                   <?php get_template_part( 'home-page/tours', 'section' );?>

                </div><!--row end-->
            </div>
        </div>
    </div>
    <!-- End of mid section -->