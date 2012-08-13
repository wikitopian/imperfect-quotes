<?php
/* ------------------------------------ */
/* Shortcode Generator                  */
/* ------------------------------------ */

// Shortcode [perfect_quotes id="10"]
function perfect_quotes_func($atts) {
  extract(shortcode_atts(array('id' => null), $atts));
  if ($id){
    $args = array(
      'p'         => $id,
      'post_type' => 'perfect-quotes'
    );
  } else {
    $args = array(
      'posts_per_page' => 1,
      'orderby'   => 'rand',
      'post_type' => 'perfect-quotes'
    );
  }

  // Load Perfect Quotes style.css
  wp_enqueue_style('perfect_quotes', plugins_url('style.css', __FILE__));

  ob_start();

  $query = new WP_Query($args);

  while ($query->have_posts()) {
    $query->the_post();
    echo '<div class="perfect-quotes">';
	echo get_the_content();
    echo '<span>- '.get_the_title().'</span>';
    echo '</div>';
  }

  wp_reset_postdata();
  $content = ob_get_clean();
  return $content;
}
add_shortcode('perfect_quotes', 'perfect_quotes_func');
