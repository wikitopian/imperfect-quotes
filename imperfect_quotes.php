<?php
/*
Plugin Name: Imperfect Quotes
Plugin URI: http://www.swarmstrategies.com/imperfect-quotes
Description: An even easier to use plugin for misquotes and testimonials!
Version: 0.9.0
Author: Brandon Ferens, Perfect Space, Inc., Matt Parrott
Author URI: http://www.swarmstrategies.com
License: GPL2
 */

$imperfect_quote_image_width  = 100;
$imperfect_quote_image_height = 100;

require 'includes/widget.php';
require 'includes/shortcodes.php';

// Custom Post Type: Imperfect Quotes
add_action('init', 'imperfect_quotes_init');
add_action('admin_head', 'imperfect_quotes_admin_css');

function imperfect_quotes_init() {
	$labels = array(
		'name' => _x('Imperfect Quotes', 'post type general name'),
		'singular_name' => _x('Imperfect Quote', 'post type singular name'),
		'add_new' => _x('Add new', 'member'),
		'add_new_item' => __('Add new Imperfect Quote'),
		'edit_item' => __('Edit Imperfect Quote'),
		'new_item' => __('New Imperfect Quote'),
		'view_item' => __('View Imperfect Quote'),
		'search_items' => __('Search Imperfect Quotes'),
		'not_found' =>  __('No Imperfect Quotes found!'),
		'not_found_in_trash' => __('No Imperfect Quotes in the trash!'),
		'parent_item_colon' => ''
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 100,
		'menu_icon' => plugin_dir_url(__FILE__) . 'images/imperfect-space-icon.png',
		'supports' => array('title', 'editor', 'thumbnail')
	);
	register_post_type('imperfect-quotes',$args);
	add_action( 'save_post', 'imperfect_quotes_save_postdata' );
}

// Custom Columns
add_action("manage_posts_custom_column",  "imperfect_quotes_columns");
add_filter("manage_edit-imperfect-quotes_columns", "imperfect_quotes_edit_columns");

function imperfect_quotes_edit_columns($columns){
	$columns = array(
		'cb' => "<input type=\"checkbox\" />",
		'title' => 'Author',
		'imperfect-quote' => 'Quote',
		'shortcode' => 'Shortcode',
		'author' => 'Posted by',
		'date' => 'Date'
	);

	return $columns;
}

function imperfect_quotes_columns($column){
	global $post;

	switch ($column) {
	case 'imperfect-quote':
		echo get_the_excerpt();
		break;
	case 'shortcode':
		echo '[imperfect_quotes id="' . $post->ID . '"]';
		break;
	}
}

// Change the defaULT "eNter title here" text
function imperfect_quotes_post_author($author) {
	$screen = get_current_screen();
	if ('imperfect-quotes' == $screen->post_type) {
		$author = 'Enter author name here';
	}
	return $author;
}
add_filter('enter_title_here', 'imperfect_quotes_post_author');

// Add filter for Imperfect Quotes
add_filter( 'post_updated_messages', 'imperfect_quote_updated_messages' );
function imperfect_quote_updated_messages( $messages ) {
	global $post, $post_ID;

	$messages['imperfect-quotes'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Imperfect Quote updated. <a href="%s">View quote</a>'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.'),
		3 => __('Custom field deleted.'),
		4 => __('Imperfect Quote updated.'),
		5 => isset($_GET['revision']) ? sprintf( __('Imperfect Quote restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Imperfect Quote published. <a href="%s">View quote</a>'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Imperfect Quote saved.'),
		8 => sprintf( __('Imperfect Quote submitted. <a target="_blank" href="%s">Preview quote</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Imperfect Quote scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview quote</a>'),
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Imperfect Quote draft updated. <a target="_blank" href="%s">Preview quote</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);

	return $messages;
}

// Display contextual help for Imperfect Quotes
add_action( 'contextual_help', 'imperfect_quote_add_help_text', 10, 3 );

function imperfect_quote_add_help_text( $contextual_help, $screen_id, $screen ) {
	if ( 'imperfect-quotes' == $screen->id ) {
		$contextual_help =
			'<p><strong>' . __('Things to remember when adding or editing a <em>Imperfect Quote</em>:') . '</strong></p>' .
			'<ul>' .
			'<li>' . __('Just type in the <em>Imperfect Quote</em> you want! It\'s that easy!') . '</li>' .
			'</ul>' .
			'<p><strong>' . __('If you want to schedule the <em>Imperfect Quote</em> to be published in the future:') . '</strong></p>' .
			'<ul>' .
			'<li>' . __('Under the Publish module, click on the Edit link next to Publish.') . '</li>' .
			'<li>' . __('Change the date to when you actually publish the quote, then click on OK.') . '</li>' .
			'</ul>' .
			'<p><strong>' . __('For more information:') . '</strong></p>' .
			'<p>' . __('<a href="http://imperfectspace.com/" target="_blank">Visit ImperfectSpace.com</a>') . '</p>';
	}
	return $contextual_help;
}

function imperfect_quotes_save_postdata($post_id) {
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	} // end if

	// Check user permissions
	if ($_POST['post_type'] == 'page') {
		if (!current_user_can('edit_page', $post_id)) return $post_id;
	} else {
		if (!current_user_can('edit_post', $post_id)) return $post_id;
	}

	return $post_id;
}

function imperfect_quotes_clean(&$arr) {
	if (is_array($arr)) {
		foreach ($arr as $i => $v) {
			if (is_array($arr[$i])) {
				my_meta_clean($arr[$i]);
				if (!count($arr[$i])) {
					unset($arr[$i]);
				}
			} else {
				if (trim($arr[$i]) == '') {
					unset($arr[$i]);
				}
			}
		}
		if (!count($arr)) {
			$arr = NULL;
		}
	}
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

function imperfect_quotes_admin_css() {
	echo '<link rel="stylesheet" type="text/css" href="'.plugin_dir_url(__FILE__) . 'includes/admin.css" />';
}
