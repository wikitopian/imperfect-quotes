<?php
/* ------------------------------------ */
/* Shortcode Generator                  */
/* ------------------------------------ */

// Shortcode [perfect_quotes id="10"]
function perfect_quotes_func($atts) {
	global $perfect_quote_image_width;
	global $perfect_quote_image_height;
	$image_width = $perfect_quote_image_width;
	$image_height = $perfect_quote_image_height;
	extract(
		shortcode_atts(
			array(
				'id' => null,
				'image_width' => $perfect_quote_image_width,
				'image_height' => $perfect_quote_image_height
			),
			$atts
		)
	);
  
  // Load Perfect Quotes style.css
  wp_enqueue_style('perfect_quotes', plugins_url('style.css', __FILE__));

  ob_start();

  $quote = perfect_quotes_get_quote($id, $image_width, $image_height);
  echo perfect_quotes_quote($quote['author'], $quote['quote'], $quote['image']);

  wp_reset_postdata();
  $content = ob_get_clean();
  return $content;
}

function perfect_quotes_get_quote($id, $image_width, $image_height) {
	$args = null;
	if($id == null) {
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
	
	$query = new WP_Query($args);
	if($query->have_posts()) {
		$query->the_post();

		$quote = array();
		$quote['author'] = get_the_title(); 
		$quote['quote']  = get_the_content();
		$quote['image']  = get_the_post_thumbnail(null, array($image_width, $image_height));

		return($quote);
	}
}

function perfect_quotes_quote($quote, $author, $image) {
	$html  = '<div class="perfect-quotes">';
	$html .= $quote;
    $html .= '<span class="perfect-quotes-author">- '.$author.'</span>';
	$html .= $image;
	$html .= '</div>';
	return $html;
}

add_shortcode('perfect_quotes', 'perfect_quotes_func');
