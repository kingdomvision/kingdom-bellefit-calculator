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

?>