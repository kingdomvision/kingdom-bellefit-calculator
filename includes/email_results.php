<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
global $wpdb;

$fields = json_decode(file_get_contents('php://input'));

$to = $fields->result_email;
$subject = "Calculation Form Result";
$status = "error";
$html = 'invalid request';

$body = '<div class="body"><div class="body-content">Dear User</div>';
$body .= '<div class="body-content"><p>Thank you very much for visting our site. Your Calculation Form details are below. </p></div>';
$body .= '<table><tbody>';
	foreach($fields as $key => $field) {
		$body .= '<tr><td>'.ucfirst(str_replace('_', ' ', $key)).'</td><td>'.$field.'</td></tr>';
	}
$body .= '</tbody></table>';
$body .= '</div>';

if( !empty($to) ) {
	if( cal_email_template($to, $subject, $body) ) {
		$status = 'success';
		$html = 'Email Sent Succesfully';
	}
	else {
		$html = 'Email Sent Error';
	}
}

$ngObject['status'] = $status;
$ngObject['html'] = $html;

echo json_encode( $ngObject );
exit;
?>