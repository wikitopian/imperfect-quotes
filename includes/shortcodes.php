<?php
/* ------------------------------------ */
/* Shortcode Generator                  */
/* ------------------------------------ */

// Shortcode [imperfect_quotes id="10"]
function imperfect_quotes_func($atts) {
	global $imperfect_quote_image_width;
	global $imperfect_quote_image_height;
	$image_width = $imperfect_quote_image_width;
	$image_height = $imperfect_quote_image_height;
	extract(
		shortcode_atts(
			array(
				'id' => null,
				'image_width' => $imperfect_quote_image_width,
				'image_height' => $imperfect_quote_image_height
			),
			$atts
		)
	);

  // Load Imperfect Quotes style.css
  wp_enqueue_style('imperfect_quotes', plugins_url('style.css', __FILE__));

  ob_start();

  echo imperfect_quotes_get_quote($id, $image_width, $image_height);

  wp_reset_postdata();
  $content = ob_get_clean();
  return $content;
}

function imperfect_quotes_get_quote($id, $image_width, $image_height) {
	$args = null;
	if($id == null) {
		$args = array(
		  'posts_per_page' => 1,
		  'orderby'   => 'rand',
		  'post_type' => 'imperfect-quotes'
		);
	} else {
		$args = array(
		  'p'         => $id,
		  'post_type' => 'imperfect-quotes'
		);
	}

	$query = new WP_Query($args);
	if($query->have_posts()) {
		$query->the_post();

		$quote = array();
		$quote['author'] = get_the_title();
		$quote['quote']  = get_the_content();
		$quote['image']  = get_the_post_thumbnail(null, array($image_width, $image_height));

		$html = imperfect_quotes_html($quote['author'], $quote['quote'], $quote['image']);

		return($html);
	}
}

function imperfect_quotes_html($author, $quote, $image) {
	$html  = '<div class="imperfect-quotes">';
	$html .= $quote;
    $html .= '<span class="imperfect-quotes-author">- '.$author.'</span>';
	$html .= $image;
	$html .= '</div>';
	return $html;
}

add_shortcode('imperfect_quotes', 'imperfect_quotes_func');
