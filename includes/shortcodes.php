<?php

// Shortcode [imperfect_quotes id="10" image_width="100" image_height="100"]
function imperfect_quotes_shortcodes($atts) {
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

	wp_enqueue_style('imperfect_quotes', plugins_url('style.css', __FILE__));

	ob_start();

	echo imperfect_quotes_get_quote($id, $image_width, $image_height);

	wp_reset_postdata();
	$content = ob_get_clean();
	return $content;
}

add_shortcode('imperfect_quotes', 'imperfect_quotes_shortcodes');
