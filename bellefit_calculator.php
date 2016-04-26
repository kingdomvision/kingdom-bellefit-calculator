<?php
/*
Plugin Name: Bellefit Calculator
Description: Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
Version: 1.0
Author: Kingdom Vision
Author URI: http://www.kingdom-vision.com/
Plugin URI: http://www.kingdom-vision.com/
License: KV License
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly


define('Cal_NAME', 'Bellefit Calculator' );
define('Cal_VERSION', '1.0' );
define('Cal_URL', untrailingslashit( plugins_url( '/', __FILE__ ) ) );
define('Cal_URI', plugin_dir_path( __FILE__ ) );


/*if ( ! function_exists( 'is_plugin_active' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

if ( !function_exists( 'WC' ) ) {

	function cal_install_woocommerce_admin_notice() {
		?>
		<div class="error">
			<p><?php _e( Cal_NAME .' is enabled but not effective. It requires Woocommerce in order to work.', 'calculator' ); ?></p>
		</div>
	<?php
    }

	add_action( 'admin_notices', 'cal_install_woocommerce_admin_notice' );
    return;
}*/

include( Cal_URI . '/includes/functions.php');

//code for add pages on admin site
add_action('admin_menu', 'bellefit_menu_pages');
function bellefit_menu_pages(){
    
	add_menu_page(Cal_NAME, Cal_NAME, 'manage_options', 'bellefit-calculator', 'choosing_sizing_codex', 'dashicons-list-view', 10 );
    
	add_submenu_page('bellefit-calculator', Cal_NAME.' - Choosing & Sizing', 'Choosing & Sizing', 'manage_options', 'bellefit-calculator', 'choosing_sizing_codex' );
	
	add_submenu_page('bellefit-calculator', Cal_NAME.' - Choosing & Sizing', 'Settings', 'manage_options', 'bellefit-settings', 'cal_settings_codex' );
	
	add_submenu_page('', Cal_NAME.' - Order Calculation Form', 'Order Calculation Form', 'manage_options', 'order-calculator-form', 'order_calculator_codex' );
	
    add_submenu_page('bellefit-calculator', 'About '.Cal_NAME, 'About', 'manage_options', 'bellefit-about', 'cal_about_codex' );
}

//function for output of setting page
function cal_settings_codex() {
	include( cal_includes( 'bellefit-settings.php' ) );
}

//function for output of about page
function cal_about_codex() {
	echo '<h1>About</h1>';
}

function order_calculator_codex() {
	global $wpdb;
	include( cal_includes('order_calculation.php') );
}

function choosing_sizing_codex() {
	global $wpdb;
	include( cal_includes('choosing-sizing.php') );
}

// code for add script and css on admin site
add_action( 'admin_enqueue_scripts', 'admin_calculator_enque_script' );
function admin_calculator_enque_script() {
	
	wp_register_script('admin_calculator_script', cal_assets_js('admin', 'admin-calculator.js'), array('jquery'), '1.1', true);
	wp_enqueue_script('admin_calculator_script');
	
	wp_enqueue_style( 'admin_calculator_style', cal_assets_css('admin', 'admin-calculator-style.css') );
}


// code for add script and css on front end site
add_action( 'wp_enqueue_scripts', 'calculator_enque_script' );
function calculator_enque_script() {
	
	wp_register_style( 'bootstrap',  cal_assets_css('front', 'bootstrap.min.css', __FILE__), false, '3.2.0' );
	wp_enqueue_style( 'bootstrap' );
	
	wp_register_style( 'classic',  cal_assets_css('front', 'classic.css', __FILE__), false, '3.4.0' );
	wp_enqueue_style( 'classic' );
	
	wp_register_style( 'classic-date',  cal_assets_css('front', 'classic.date.css', __FILE__), false, '3.4.0' );
	wp_enqueue_style( 'classic-date' );
	
	wp_register_style( 'calculator_style', cal_assets_css('front', 'calculator.css', __FILE__) );
	wp_enqueue_style( 'calculator_style');
	
	// Javascript
	wp_register_script( 'bootstrap', cal_assets_js('front', 'bootstrap.min.js', __FILE__), false, '3.2.0', true );
	wp_enqueue_script( 'bootstrap' );
	
	wp_register_script( 'angular-js', cal_assets_js('front', 'angular.min.js', __FILE__), false, '1.2.29', true );
	wp_enqueue_script( 'angular-js' );
	
	wp_register_script( 'angular-sanitize', cal_assets_js('front', 'angular-sanitize.min.js', __FILE__), false, '1.2.29', true );
	wp_enqueue_script( 'angular-sanitize' );
	
	wp_register_script( 'angular-cookies', cal_assets_js('front', 'angular-cookies.min.js', __FILE__), false, '1.2.29', true );
	wp_enqueue_script( 'angular-cookies' );
	
	/*wp_register_script( 'angular-datepicker', cal_assets_js('front', 'angular-datepicker.js', __FILE__), false, '3.4.0', true );
	wp_enqueue_script( 'angular-datepicker' );*/
	
	wp_register_script( 'angular-scrollbar', cal_assets_js('front', 'mb-scrollbar.js', __FILE__), false, '2.2.0', true );
	wp_enqueue_script( 'angular-scrollbar' );
	
	wp_register_script( 'app-ctrl', cal_plugin_url('app.js'), false, false, true );
	wp_enqueue_script( 'app-ctrl' );
		
}

add_action('admin_head', 'choosing_sizing_script');
function choosing_sizing_script() {
	?>
    <script type="text/javascript">
    	jQuery(document).ready(function(e) {
            jQuery("#select_all_forms").click(function() {
				var checked = jQuery(this).is(":checked");
				jQuery(".select_form").each(function(index, element) {
                    jQuery(element).attr("checked", checked);
                });
			});
        });
    </script>
    <?php
}

add_action('wp_head', 'define_cal_url');
function define_cal_url() {
	?>
    <script type="text/javascript">
    	var calUrl = '<?php echo Cal_URL; ?>';
    </script>
    <?php
}

//shortcode for output frontend form
add_shortcode('bl-calculator', 'codex_bl_calculator');
function codex_bl_calculator() {
	ob_start();
	
	cal_get_template_part( 'content-calculator' );
	
	return ''.ob_get_clean();
}
