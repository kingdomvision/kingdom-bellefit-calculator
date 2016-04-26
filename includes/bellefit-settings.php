<?php
$message = '';
$error = 0;
if (isset($_POST['bellefit_video_link_submit'])) {
	$form_page_id = $_POST['bellefit_form_page_id'];
	$video_link = $_POST['bellefit_form_video_link'];
	if ($video_link != '') {
		if (filter_var($video_link, FILTER_VALIDATE_URL) === false) {
			$error = 1;
			$message = '<p class="error"><strong>Error! </strong>Invalid Video URL</p>';
		}
	}
	if (!$error) {
		$message = '<p class="success"><strong>Success! </strong>Settings Updated.</p>';
		update_option('_bellefit_form_video_link', $video_link);
		update_option('_bellefit_form_page_id', $form_page_id);
	}
	
}
?>

<div class="wrap">
	<h1>Settings</h1>
    <?php
	if ($message) echo $message;
	?>
    <form method="post" action="" >
    	<div class="form-group">
        	<label>Select Form Page</label>
            <?php 
			$args = array(
				'post_type'			=> 'page',
				'post_status'		=> 'publish',
				'posts_per_page'	=> '-1',
			);
			$pages = get_posts($args);
			?>
            <select name="bellefit_form_page_id" id="bellefit-form-page-id">
            	<option value="">--Select Page--</option>
            <?php
			$pre_page_link = get_option('_bellefit_form_page_id');
			foreach($pages as $page) {
				$selected = '';
				if ($page->ID == $pre_page_link) {
					$selected = 'selected="selected"';
				}
				echo '<option value="'.$page->ID.'" '.$selected.'>'.$page->post_title.'</option>';
			}
			?>
            </select>
        </div>
        <div class="form-group">
        	<label>Sizing Form Video Link</label>
            <input type="url" name="bellefit_form_video_link" id="bellefit-video-link" value="<?php echo get_option('_bellefit_form_video_link'); ?>" />
        </div>
        <div class="form-group">
            <input type="submit" name="bellefit_video_link_submit" value="Submit" id="bellefit-video-link-submit" />
        </div>
    </form>
</div>