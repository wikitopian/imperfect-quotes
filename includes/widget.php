<?php
add_action('widgets_init', 'perfect_quotes_register_widgets');

function perfect_quotes_register_widgets() {
  register_widget('Perfect_Quotes_Widget');
}

class Perfect_Quotes_Widget extends WP_Widget {

  function __construct() {
    $widget_ops = array(
      'classname' => 'widget_perfect_quote',
      'description' => __('A quotes widget perfectly done'),
    );
    parent::__construct('perfect-quotes', __('Perfect Quotes'), $widget_ops);
    $this->alt_option_name = 'widget_perfect_quote';

    add_action( 'save_post', array(&$this, 'flush_widget_cache') );
    add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
    add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
  }

  function widget($args, $instance) {
    // Retrieve cached data
    $cache = wp_cache_get('widget_perfect_quotes', 'widget');

    // Load Perfect Quotes style.css
    wp_enqueue_style('perfect_quotes', plugins_url('style.css', __FILE__));

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
    $title = apply_filters('widget_title', empty($instance['title']) ? __('Perfect Quotes') : $instance['title'], $instance, $this->id_base);

    if (!$number = absint($instance['number'])) {
      $number = 1;
    }

    $query = array(
      'showposts' => $number,
      'no_found_rows' => TRUE,
      'post_status' => 'publish',
      'ignore_sticky_posts' => TRUE,
      'post_type' => 'perfect-quotes',
    );
    
    if ($instance['random'] == true) {
      $query['orderby'] = 'rand';
    }
    
    $r = new WP_Query($query);

    if ($r->have_posts()) {
      echo $before_widget;
      if ($title) {
        echo $before_title . $title . $after_title;
      }
      echo '<ul class="perfect-quotes">';
      while ($r->have_posts()) {
        $r->the_post();
        ?>
        <li>
          <?php
          if (get_the_title()) the_title();
          $quote_author = get_post_meta(get_the_ID(), 'perfect_quote_author', true);
          $quote_where  = get_post_meta(get_the_ID(), 'perfect_quote_where', true);
          ?>
          <span>
            <?php
            if (!empty($quote_author)) echo $quote_author;
            if (!empty($quote_author) && !empty($quote_where)) echo '<br />'; 
            if (!empty($quote_where)) echo $quote_where;
            ?>
          </span>
        </li>
        <?php
      }
      echo '</ul>';
      echo $after_widget;

      // Reset the global $the_post as this query will have stomped on it
      wp_reset_postdata();
    }

    // Echo the result get it for caching
    $cache[$args['widget_id']] = ob_get_flush();
    wp_cache_set('widget_perfect_quotes', $cache, 'widget');
  }

  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['number'] = (int) $new_instance['number'];
    $instance['random'] = strip_tags($new_instance['random']);
    // Keep the data fresh
    $this->flush_widget_cache();

    $alloptions = wp_cache_get('alloptions', 'options');
    if (isset($alloptions['widget_perfect_quote'])) {
      delete_option('widget_perfect_quote');
    }

    return $instance;
  }

  function flush_widget_cache() {
    wp_cache_delete('widget_perfect_quotes', 'widget');
  }

  function form($instance) {
    $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
    $number = isset($instance['number']) ? absint($instance['number']) : 1;
    $random = esc_attr( $instance['random']);
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo __('Title:'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('number'); ?>"><?php echo __('Number of quotes to show:'); ?></label>
      <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
    </p>
    <p>
      <input type="checkbox" class="checkbox" name="<?php echo $this->get_field_name('random')?>" value="1" <?php checked( $random, 1 ); ?> />
      <label for="<?php echo $this->get_field_id('random'); ?>"><?php _e('Display random quote'); ?></label>
    </p>
    <?php
  }
}