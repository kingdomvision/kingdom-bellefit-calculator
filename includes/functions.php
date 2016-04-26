<?php

function cal_get_template_part($template_name) {
	$template = $template_name;
	include(Cal_URI . "/templates/{$template}.php");
}

function cal_plugin_url($file = '') {
	return Cal_URL . "/{$file}";
}

function cal_includes($file = '') {
	return Cal_URI . "/includes/{$file}";
}

function cal_images($file = '') {
	return Cal_URL . "/images/{$file}";
}

function cal_assets_css($interface = '', $file = '') {
	return Cal_URL . "/assets/css/{$interface}/{$file}";
}

function cal_assets_js($interface = '', $file = '') {
	return Cal_URL . "/assets/js/{$interface}/{$file}";
}

function cal_email_template($to, $subject, $body) {
	
	$site_name = get_option( 'blogname' );
	$admin_email = get_option( 'admin_email' );
	$site_url = get_site_url();
	$upload_dir = "";
	
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "From: {$site_name} <{$admin_email}>\r\n";
	$headers .= "Reply-To: {$site_name} <{$admin_email}>\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	
	$message = '<html><head>';
	$meesage .= "<title>{$subject} - {$site_name}</title>";
	$message .= '</head><body style="background:#ffffff;"><div class="page-wrapper">';
	$message .= '<div class="header" style="text-align:center;"><a href="'. $site_url .'"><img class="logo1" alt="'. $site_name .'" src="http://bellefitvip.com/wp-content/uploads/Bellefit-Logo-Header-400.png"></a></div>';
	$message .= '<hr style="border:2px solid #999; margin-bottom:30px" />';
	
	$message .= $body;
	
	$message .= "<div><p>If you have any difficulties, please Email us directly on <br />{$admin_email}</p></div>";
	$message .= "<div>Best wishes,</div>";
	$message .= "<div>{$site_url}</div>";
	$message .= '</div>';
	$message .= '</div></body></html>';
	
	return mail($to, $subject, $message, $headers);
}

add_filter( 'woocommerce_add_cart_item_data', 'add_cart_item_custom_data_vase', 10, 2 );
function add_cart_item_custom_data_vase( $cart_item_meta, $product_id ) {
  global $woocommerce;
  if (isset($_GET['calid'])) {
	  $cart_item_meta['bvip_cookie_id'] = $_GET['calid'];	  
  }
  return $cart_item_meta; 
}

function get_cart_items_from_session( $item, $values, $key ) {
	if ( array_key_exists( 'bvip_cookie_id', $values ) )
        $item['bvip_cookie_id'] = $values['bvip_cookie_id'];
    return $item;
}
add_filter( 'woocommerce_get_cart_item_from_session', 'get_cart_items_from_session', 1, 3 );


add_action('woocommerce_add_order_item_meta','wdm_add_values_to_order_item_meta', 1, 2);
function wdm_add_values_to_order_item_meta($item_id, $values) {
	global $woocommerce, $wpdb;
	$cal_id = $values['bvip_cookie_id'];
	if(!empty($cal_id)) {
		$cal_link = '<a href="'.admin_url().'?page=order-calculator-form&action=view&calkey='.$cal_id.'">View Form</a>';
	    wc_add_order_item_meta($item_id, 'Calculation Form Details', $cal_link);
		$cal_step_data = $wpdb->get_results("SELECT * from cal_step_save WHERE cal_key = '$cal_id' ", OBJECT);
		$data_count = $wpdb->num_rows;
		if ($data_count) {
			foreach($cal_step_data as $data) {
				$cal_object = unserialize($data->cal_value);
			}
			$date = date('Y-m-d');
			$cal_data = serialize($cal_object);
			$wpdb->insert(
				'cal_form_order_data', array(
					'order_id' => $item_id,
					'cal_id' => $cal_id,
					'cal_data' => $cal_data,
					'date' => $date
				)
			);
		}
    }
}

add_action( 'woocommerce_single_product_summary', 'check_our_form_link', 5 );
function check_our_form_link() {
	if (!isset($_GET['calid'])) {
		$form_page_id = get_option('_bellefit_form_page_id');
		$form_page_link = '';
		if ($form_page_id) {
			$form_page_link = get_permalink($form_page_id);
		}
	    echo '<p id="rtrn">Did you Check the our Calculator? <a href="'.$form_page_link.'">TRY NOW</a>.</p>';
	}
}
?>