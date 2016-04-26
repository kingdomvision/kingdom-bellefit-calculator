<?php 
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
global $wpdb;

$fields = json_decode(file_get_contents('php://input'));

$uniqid = $fields->id;
$ngObject = array();
$status = "error";
$obj = 'invalid request';

$result = $wpdb->get_row(" SELECT * FROM cal_step_save WHERE cal_key = '$uniqid' ");
$num_rows = $wpdb->num_rows;
$cal_value = $result->cal_value;

if( $num_rows == 1 ) {
	
	$obj = maybe_unserialize($cal_value);
	$status = "success";
}

$ngObject['status'] = $status;
$ngObject['cookie'] = $obj;

echo json_encode( $ngObject );
exit;
?>