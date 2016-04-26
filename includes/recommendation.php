<?php 
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
global $wpdb;

$fields = json_decode(file_get_contents('php://input'));

$model = $fields->model;
$cal_key = $fields->uniqid;
$cal_value = serialize($fields);

$ngObject = array();
$query = 0;
$date = date('Y-m-d h:i:s');
	
	if (is_user_logged_in()) {
		$user_id = get_current_user_id();
	} else {
		$user_id = 0;
	}
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	if ($model == 'step') {
		$status = '1';
	} else if ($model == 'save') {
		$status = '0';
	}
	
	
	if( ! empty($cal_key) ) {
		
		$result = $wpdb->get_row(" SELECT * FROM cal_step_save WHERE cal_key = '$cal_key' AND status = 0 ");
		$num_rows = $wpdb->num_rows;
		$res_key = $result->cal_key;
		
		if( $cal_key == $res_key && $num_rows == 1 )
			$query = 1;
			
		if( $query == 1 ) {
			$wpdb->update(
				'cal_step_save', 
				array(
					'cal_value' => $cal_value,
					'user_id' => $user_id,
					'ip' => $ip,
					'status' => $status,
					'date' => $date
				),
				array( 'cal_key' => $cal_key )
			);
		}
		else {
			$wpdb->insert(
				'cal_step_save', array(
					'cal_key' => $cal_key,
					'cal_value' => $cal_value,
					'user_id' => $user_id,
					'ip' => $ip,
					'status' => $status,
					'date' => $date
				)
			);
		}
	}

$status = "error";

/* Save Link Code Start */
	if ($model == 'save') {
		
		$to = $fields->save_email;
		//$to = "saad@kingdom-vision.co.uk";
		$subject = "Draft Form Link";
		
		$save_form_link = '<div><a href="'.get_permalink(1496) . '?action=retrive_form&token='.$cal_key.'">'.get_permalink(1496) . '?&action=retrive_form&uniqid='.$cal_key.'</a></div>';
		
		$body = '<div class="body"><div class="body-content">Dear User</div>';
		$body .= '<div class="body-content"><p>Thank you very much for visting our site. You draft form successfully saved and below the link for continue form in future. </p></div>';
		$body .= $save_form_link;
		$body .= '</div>';
		
		if( !empty($to) ) {
			if( cal_email_template($to, $subject, $body) ) {
				$status = 'success';
				$html = 'Email Sent Succesfully';
			}
			else {
				$html = 'Email Sent !Error';
			}
		}
		
		$ngObject['status'] = $status;
		$ngObject['html'] = $to;
		
		echo json_encode( $ngObject );
		exit;
	}
/* Save Link Code Ended */
	
	
/* Product Recommended Code Start */
	function getFileCsvArray($file_name){
		$csv_data = array();
		$handle = fopen( cal_includes($file_name), "r");
		while (($data = fgetcsv($handle)) !== FALSE) {
			$csv_data[] = $data;
		}
		return $csv_data;
	}
	
	//$give_birth = $fields->give_birth;
	$birth_by_csection = $fields->birth_by_csection;
	$plan_on_csection = $fields->plan_on_csection;
	$pre_pregnancy_jean_size = $fields->pregnancy_jean_size;
	$hip_size = $fields->measuring_inches;
	$weight_gained = $fields->pregnancy_gained;
	$how_taller = $fields->tall_are_you;
	$body_shape = strtolower($fields->body_shapes);
	
	
	if ($birth_by_csection == 'No' || $plan_on_csection == 'No') {	
		$birth_type = "Natural";
	} else { 
		$birth_type = "C-Section";
	}
	
	$pre_pregnancy_jean_size_column = '';

	$data_arr = getFileCsvArray("SIZE.csv");
	
	$pre_pregnancy_jean_size_column = '';
	for($column=0; $column < count($data_arr[0]); $column++) {
		if(trim($data_arr[0][$column]) == $pre_pregnancy_jean_size){
			$pre_pregnancy_jean_size_column = $column;
			$column = count($data_arr[0]);
		}
		
	}
	
	if($weight_gained >= 33)
		$pre_pregnancy_jean_size_column ++;
	elseif($weight_gained >= 50)
		$pre_pregnancy_jean_size_column ++;
	elseif($weight_gained >= 70)
		$pre_pregnancy_jean_size_column ++;
	
	// get heap_size line
	for($line=4; $line < count($data_arr); $line++) {
		
		if(trim($data_arr[$line][0]) == $hip_size){
			$heap_size_line = $line;
		}
	}
	$product_name = $data_arr[$heap_size_line][$pre_pregnancy_jean_size_column];
	$ngObject ['size']= $product_name;
	
	// FILTER BY BODY TYPE
    $data_arr = getFileCsvArray("STYLE.csv");
	
	
	if ($birth_type == 'Natural') {	
		$birth_type_styled = "natural-birth"; 
	} else { 
		$birth_type_styled = "c-section-uncertain"; 
	}
	
    $column_name = $birth_type_styled;
	
	
	// get the body type filter column
	$new_arr1 = array();
	$cnt = 0;
	foreach($data_arr[0] as $key => $arr1) {
		if ( trim($arr1) == $column_name ) { 
			$new_arr1[$cnt]['key'] = $key;
			$new_arr1[$cnt]['value'] = $arr1;
			$cnt++;
		}
	}
	
	$new_arr2 = array();
	foreach($new_arr1 as $new_arr) {
		if ($data_arr[2][$new_arr['key']] == $body_shape) {
			$new_arr2[] = $new_arr['key'];
		}
	}
	
	if($weight_gained <= 33)
		$real_column_no = 0;
	else if($weight_gained <= 50)
		$real_column_no = 1;
	else if($weight_gained <= 70)
		$real_column_no = 2;
	else $real_column_no = 3;
	
	
	$real_key = $new_arr2[$real_column_no];
	$prod_arr = array();
	$prod_style = array();
	$prod_bundle = array();
	
	for($newCnt = 3; $newCnt < count($data_arr); $newCnt++) {
		if ($data_arr[$newCnt][$real_key] == 'y') {
			$prod_sku = strtolower( $data_arr[$newCnt][1] );
			$prod_arr []= $prod_sku;
		}
	}
	
	$prod_args = array(
		'post_type'		=> 'product',
		'post_staus'	=> 'publish',
		'order'			=> 'ASC',
		'meta_query'	=> array(
								array(
									'key'		=> '_sku',
									'value'		=> $prod_arr,
									'compare'	=> 'IN'
								),
							)
	);
	$query = new WP_Query( $prod_args );
	
	$cnt = 0;
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) { $query->the_post();
			$product_id = get_the_ID();
			$_product = wc_get_product( $product_id );
			$getSku = $_product->get_sku();
			$regular_price = $_product->get_regular_price();
			$get_price = $_product->get_price();
			$sale_price = $_product->get_sale_price();
			
			if(! empty($regular_price) )
				$actual_price = $regular_price;
			else
				$actual_price = $get_price;
				
			if(! empty($sale_price) )
				$sale_price = wc_price($sale_price);
			
			
			if(stripos($getSku, "bundle") !== false)
				$_ObjKey = "bundle";
			else
				$_ObjKey = "style";
			
			
			$thumbnail_size = 'medium';
			$post_thumbnail_id = get_post_thumbnail_id( $product_id );
			$thumbnail = wp_get_attachment_image_src( $post_thumbnail_id, $thumbnail_size );
			$thumbnail_url = $thumbnail[0];
				
			$ngObject[$_ObjKey][$cnt]['sku'] = $getSku;
			$ngObject[$_ObjKey][$cnt]['title'] = get_the_title();
			$ngObject[$_ObjKey][$cnt]['link'] = get_permalink().'?calid='.$cal_key.'&size='.strtolower($product_name).'&how_taller='.$how_taller;
			$ngObject[$_ObjKey][$cnt]['img'] = $thumbnail_url;
			$ngObject[$_ObjKey][$cnt]['price'] = wc_price($actual_price);
			$ngObject[$_ObjKey][$cnt]['sale_price'] = $sale_price;
			
			$cnt++;
		}
	}
	wp_reset_postdata();
/* Product Recommended Code Ended */
	
echo json_encode( $ngObject );
exit;
?>