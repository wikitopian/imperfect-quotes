<?php
/* ------------------------------------ */
/* Shortcode Generator                  */
/* ------------------------------------ */


// Shortcode [perfect_quotes id="10"]
function perfect_quotes_func($atts) {
  extract(shortcode_atts(array('id' => null, 'num' => null, 'random' => null), $atts));
  if ($id == null && $num == null & $random == null) {
    return false;
  } else if ($id){
    $args = array(
      'p'         => $id,
      'post_type' => 'perfect-quotes'
    );
  } else if ($num) {
    $num = ($num == 'all') ? -1 : $num;
    $args = array(
      'posts_per_page' => $num,
      'post_type'      => 'perfect-quotes'
    );
    if ($random) {
      $args['orderby'] = 'rand';
    }
  } else if ($random) {
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
    if (get_the_title()) the_title();
    $quote_author = get_post_meta(get_the_ID(), 'perfect_quote_author', true);
    $quote_where  = get_post_meta(get_the_ID(), 'perfect_quote_where', true);
    if (!empty($quote_author) || !empty($quote_where)) {
      echo '<span>- ';
      if (!empty($quote_author)) echo $quote_author;
      if (!empty($quote_author) && !empty($quote_where)) echo ', ';
      if (!empty($quote_where)) echo $quote_where;
      echo '</span>';
    }
    echo '</div>';
  }

  wp_reset_postdata();
  $content = ob_get_clean();
  return $content;
}
add_shortcode('perfect_quotes', 'perfect_quotes_func');
