<?php
/*
Plugin Name: Zoecity Top 10 Widget
Description: Zoecity Daily Top 10. Find the hottest, most shared Christian articles and videos on the Internet.
Author: Zoecity
Version: 0.3
Author URI: http://www.zoecity.com
*/

// Initialize the widget!
function widget_zoecity_top_10_init() {
  
  // Check for the required API functions
  if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
    return;

  // This saves options and prints the widget's config form.
  function widget_zoecity_top_10_control() {
    $options = $newoptions = get_option('widget_zoecity_top_10');
    
    if ( $_POST['zoecity-submit'] ) {
      $newoptions['title'] = strip_tags(stripslashes($_POST['zoecity-title']));
      //$newoptions['domain'] = strip_tags(stripslashes($_POST['zoecity-domain']));
    }
    if ( $options != $newoptions ) {
      $options = $newoptions;
      update_option('widget_zoecity_top_10', $options);
    }
    
    // Set default title
    if ( $options['title'] == '' || !isset($options['title']) ) {
      $options['title'] = 'Zoecity Top 10';
    }    
  ?>
        <div style="text-align:right">
        <label for="zoecity-title" style="line-height:35px;display:block;"><?php _e('Title:', 'widgets'); ?> <input type="text" id="zoecity-title" name="zoecity-title" value="<?php echo wp_specialchars($options['title'], true); ?>" /></label>
        <input type="hidden" name="zoecity-submit" id="zoecity-submit" value="1" />
        </div>
  <?php
  }

  // This prints the widget
  function widget_zoecity_top_10($args) {
    extract($args);
    $defaults = array('domain' => '', 'title' => 'Zoecity Top 10');
    $options = (array) get_option('widget_zoecity_top_10');

    foreach ( $defaults as $key => $value )
      if ( !isset($options[$key]) )
        $options[$key] = $defaults[$key];
    ?>
    <?php echo $before_widget; ?>
      <?php echo $before_title . $options['title'] . $after_title; ?>
        <style type="text/css">
          @import url(http://www.zoecity.com/stylesheets/widget.css);
        </style>
        <script type="text/javascript" src="http://www.zoecity.com/widgets/top_10"></script>
      <?php echo $after_widget; ?>
<?php
  }

  // Tell Dynamic Sidebar about our new widget and its control
  register_sidebar_widget('Zoecity Top 10', 'widget_zoecity_top_10');
  register_widget_control('Zoecity Top 10', 'widget_zoecity_top_10_control');
  
}

// Delay plugin execution to ensure Dynamic Sidebar has a chance to load first
add_action('widgets_init', 'widget_zoecity_top_10_init');

?>
