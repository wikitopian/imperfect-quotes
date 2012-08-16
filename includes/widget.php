<?php
add_action('widgets_init', 'imperfect_quotes_register_widgets');

function imperfect_quotes_register_widgets() {
	register_widget('Imperfect_Quotes_Widget');
}

class Imperfect_Quotes_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array(
			'classname' => 'widget_imperfect_quote',
			'description' => __('A quotes widget imperfectly done'),
		);
		parent::__construct('imperfect-quotes', __('Imperfect Quotes'), $widget_ops);
		$this->alt_option_name = 'widget_imperfect_quote';

		add_action( 'save_post', array(&$this, 'flush_widget_cache') );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		// Retrieve cached data
		$cache = wp_cache_get('widget_imperfect_quotes', 'widget');

		// Load Imperfect Quotes style.css
		wp_enqueue_style('imperfect_quotes', plugins_url('style.css', __FILE__));

		if (!is_array($cache)) {
			$cache = array();
		}

		if (isset($cache[$args['widget_id']])) {
			echo $cache[$args['widget_id']];
			return;
		}

		// We don't have cached data : we create it!
		ob_start();
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Imperfect Quotes') : $instance['title'], $instance, $this->id_base);

		if (isset($instance['random']) && $instance['random'] == 1) {
			$instance['id'] = null;
		}

		echo $before_widget;
		if ($title) {
			echo $before_title . $title . $after_title;
		}

		global $imperfect_quote_image_width;
		global $imperfect_quote_image_height;
			echo imperfect_quotes_get_quote(
				$instance['id'],
				$imperfect_quote_image_width,
				$imperfect_quote_image_height
			);

		echo $after_widget;

		// Echo the result get it for caching
		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_imperfect_quotes', $cache, 'widget');
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['random'] = strip_tags($new_instance['random']);
		$instance['id'] = (int) $new_instance['id'];

		// Keep the data fresh
		$this->flush_widget_cache();

		$alloptions = wp_cache_get('alloptions', 'options');
		if (isset($alloptions['widget_imperfect_quote'])) {
			delete_option('widget_imperfect_quote');
		}

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_imperfect_quotes', 'widget');
	}

	function form($instance) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$random = esc_attr( $instance['random']);
		$id = isset($instance['id']) ? absint($instance['id']) : 1;
?>
	<p>
	  <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo __('Title:'); ?></label>
	  <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>
	<p>
	  <input type="checkbox" class="checkbox" name="<?php echo $this->get_field_name('random')?>" value="1" <?php checked( $random, 1 ); ?> />
	  <label for="<?php echo $this->get_field_id('random'); ?>"><?php _e('Display random quote'); ?></label>
	</p>
	<p>
	  <label for="<?php echo $this->get_field_id('id'); ?>"><?php echo __('Quote ID:'); ?></label>
	  <input id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" type="text" value="<?php echo $id; ?>" size="5" />
	</p>
<?php
	}
}
