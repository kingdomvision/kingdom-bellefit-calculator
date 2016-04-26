<h1>Choosing & Sizing Forms</h1>
<div class="wrap">
    <?php if (isset($_GET['action']) && $_GET['action'] == 'delete_all') {
        $bulk_action = $_POST['bulk_action'];
        $cal_step_ids = $_POST['cal_step_ids'];
        $total_record = count($cal_step_ids);
        if ($bulk_action == 'delete' && $total_record) {
            foreach($cal_step_ids as $cal_step_id) {
                $wpdb->query('DELETE FROM cal_step_save WHERE cal_step_id = '.$cal_step_id.'');
            } ?>
            <div class="updated notice is-dismissible" id="message"><p><?php echo $total_record; ?> Record's Deleted.</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
            <?php
        }

    } ?>
    <?php if (isset($_GET['action']) && $_GET['action'] == 'delete') {
        $cal_step_id = $_GET['id'];
        $wpdb->query('DELETE FROM cal_step_save WHERE cal_step_id = '.$cal_step_id.'');
        ?> <div class="updated notice is-dismissible" id="message"><p>1 Record Deleted.</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div> <?php
    } ?>
    
    <?php if (isset($_GET['action']) && $_GET['action'] == 'view') { ?>
    
        <?php
		if (isset($_GET['id'])) {
			$cal_step_id = $_GET['id'];
			$forms_data = $wpdb->get_results('SELECT * FROM cal_step_save WHERE cal_step_id = '.$cal_step_id.' ', OBJECT);
		} 
	    foreach($forms_data as $data) {
            ?>
            <div class="form_details">
                <div class="form_details_head">
                    ID : 
                </div>
                <div class="form_details_value">
                    <?php echo $data->cal_key; ?>
                </div>
            </div>
            <?php
            $user_id = $data->user_id;
            if ($user_id) {
                $user_data = get_user_by('ID', $user_id);
                $user_info = $user_data->data;
                $user_name = $user_info->display_name;
            } else {
                $user_name = 'Guest User';
            }
            ?>
            <div class="form_details">
                <div class="form_details_head">
                    User Name : 
                </div>
                <div class="form_details_value">
                    <?php echo $user_name; ?>
                </div>
            </div>
            <?php
            $status = $data->status;
            if ($status) {
                $status_name = 'Fill Form';
            } else {
                $status_name = 'Save Form';
            }
            ?>
            <div class="form_details">
                <div class="form_details_head">
                    Status : 
                </div>
                <div class="form_details_value">
                    <?php echo $status_name; ?>
                </div>
            </div>
            <div class="form_details">
                <div class="form_details_head">
                    Date : 
                </div>
                <div class="form_details_value">
                    <?php $date = 'date'; echo date("F, d Y h:i:s", strtotime($data->$date)); ?>
                </div>
            </div>
            <div class="form_details">
                <div class="form_details_head">
                    User IP : 
                </div>
                <div class="form_details_value">
                    <?php echo $data->ip; ?>
                </div>
            </div>
            <?php
            $cal_value = $data->cal_value;
            $cal_value = unserialize($cal_value);
            foreach ($cal_value as $key => $value) {
				if ($key != 'model' && $key != 'uniqid') {
					?>
					<div class="form_details">
						<div class="form_details_head">
							<?php 
							if ($key == '_2_pregnancy_weight') {
								echo 'Pregnancy weight';
							} else if ($key == '_2_heaviest_weight') {
								echo 'Heaviest weight';
							} else if ($key == '_2_weight_now') {
								echo 'Weight now';
							} else  {
								echo ucfirst(str_replace('_', ' ', $key)) . ' :'; 
							}
							?> 
						</div>
						<div class="form_details_value">
							<?php echo $value; ?>
						</div>
					</div>
					<?php
				}
            }
        }
        ?>

    <?php } else { ?>
        <?php
            $per_page = 25;
            if (isset($_GET['pageno'])) {
                $current_page = $_GET['pageno'];
            } else {
                $current_page = 1;
            }
            if ($current_page == 1) {
                $start_record = 0;
            } else {
                $start_record = ($current_page * $per_page) - $per_page;
            }
			
			if (isset($_GET['status']) && $_GET['status'] != '') {
				if ($_GET['status'] == 'fill_form') { $where = ' WHERE status = 1'; }
				if ($_GET['status'] == 'save_form') { $where = ' WHERE status = 0'; }
			} else {
				$where = '';
			}
			
            $forms_count = $wpdb->get_results('SELECT count(*) FROM cal_step_save'. $where .' ORDER BY cal_step_id DESC', OBJECT); ?>
        <?php foreach($forms_count as $count) {
            $cnt = 'count(*)';
            $total_rec = $count->$cnt;
        } ?>
        <?php 
		
		$forms_data = $wpdb->get_results('SELECT * FROM cal_step_save'. $where . ' ORDER BY cal_step_id DESC LIMIT '.$start_record.', '.$per_page.' ', OBJECT);
        //$forms_data = $wpdb->get_results('SELECT * FROM cal_step_save'. $where . ' ORDER BY cal_step_id DESC', OBJECT);
		
		$pagination_link = '';
		if (isset($_GET['pageno']) && $_GET['pageno'] != '') {
			$pagination_link = '&pageno='.$_GET['pageno'];
		}
		$status_link = '';
		if (isset($_GET['status']) && $_GET['status'] != '') {
			$status = $_GET['status'];
			$status_link = '&status='.$status;
		}
        ?>
        
        <form method="post" action="<?php echo admin_url(); ?>admin.php?page=bellefit-calculator&action=delete_all<?php echo $pagination_link . $status_link; ?>" >
            <div class="tablenav top">
                <div class="alignleft actions bulkactions">
                    <label class="screen-reader-text" for="bulk-action-selector-top">Select bulk action</label>
                    <select id="bulk-action-selector-top" name="bulk_action">
                        <option value="">Bulk Actions</option>
                        <option value="delete">Delete</option>
                    </select>
                    <input type="submit" value="Apply" class="button action" id="doaction">
                </div>
                
                <div class="filter_status" style="float:right; margin-right:5px;">
                    <label>Select Status</label>
                    <?php
					?>
                    <select id="filter-status" name="filter_status">
                        <option value="">All</option>
                        <option value="fill_form" <?php if (isset($_GET['status']) && $_GET['status'] == 'fill_form') echo 'selected="selected"'; ?>>Fill Form</option>
                        <option value="save_form" <?php if (isset($_GET['status']) && $_GET['status'] == 'save_form') echo 'selected="selected"'; ?>>Save Form</option>
                    </select>
                </div>
            </div>
            <table class="wp-list-table widefat fixed striped posts">
                <thead>
                    <tr>
                        <td class="manage-column column-cb check-column" id="cb">
                            <label for="cb-select-all-1" class="screen-reader-text">Select All</label>
                            <input type="checkbox" id="select_all_forms">
                        </td>
                        <th class="manage-column"scope="col"><span>ID</span></th>
                        <th class="manage-column" scope="col">User Name</th>
                        <th class="manage-column" scope="col">Status</th>
                        <th class="manage-column" scope="col">Date</th>
                        <th class="manage-column" scope="col">User IP</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach($forms_data as $data) {
                    ?>
                    <tr>
                        <td>
                            <input type="checkbox" value="<?php echo $data->cal_step_id; ?>" name="cal_step_ids[]" class="select_form" />
                        </td>
                        <td>
                            <a href="<?php echo admin_url(); ?>admin.php?page=bellefit-calculator&action=view&id=<?php echo $data->cal_step_id; ?>"><?php echo $data->cal_key; ?></a>
                            <div class="row-actions">
                                <span class="view">
                                    <a href="<?php echo admin_url(); ?>admin.php?page=bellefit-calculator&action=view&id=<?php echo $data->cal_step_id; ?>">View</a>
                                </span>&nbsp;|&nbsp;
                                <span class="trash">
                                    <a href="<?php echo admin_url(); ?>admin.php?page=bellefit-calculator&action=delete&id=<?php echo $data->cal_step_id . $pagination_link . $status_link; ?>">Delete</a>
                                </span>
                            </div>
                        </td>
                        <?php
                        $user_id = $data->user_id;
                        if ($user_id) {
                            $user_data = get_user_by('ID', $user_id);
                            $user_info = $user_data->data;
                            $user_name = $user_info->display_name;
                        } else {
                            $user_name = 'Guest User';
                        }
                        ?>
                        <td><?php echo $user_name; ?></td>
                        <?php
                        $status = $data->status;
                        if ($status) {
                            $status_name = 'Fill Form';
                        } else {
                            $status_name = 'Save Form';
                        }
                        ?>
                        <td><?php echo $status_name; ?></td>
                        <td><?php $date = 'date'; echo date("F, d Y h:i:s", strtotime($data->$date)); ?></td>
                        <td><?php echo $data->ip; ?></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </form>
        <div class="pagination">
        	<?php
			$end_rec = $start_record + $per_page;
			if ( $end_rec > $total_rec) {
				$end_rec = $total_rec;
			} 
			?>
        	<div class="page_stat">Showing <?php echo $start_record + 1; ?> - <?php echo $end_rec; ?> of <?php echo $total_rec; ?> Records</div>
            <?php
			$total_pages = $total_rec / $per_page;
			$total_pages = ceil($total_pages);
			if ($total_pages > 1) {
			?>
            <div class="paging">
            	<?php for ($pg = 1; $pg <= $total_pages; $pg++) { ?>
                	<?php 
					$page_link = admin_url() . 'admin.php?page=bellefit-calculator&pageno='.$pg; 
					?>
					<span class="paged <?php if ($current_page == $pg) echo 'active'; ?>"><a href="<?php echo $page_link.$status_link; ?>"><?php echo $pg; ?></a></span>
				<?php } ?>
            </div>
            <?php } ?>
        </div>
        <script>
        	jQuery(document).ready(function(e) {
                jQuery("#filter-status").on("change", function() {
					var $filter = jQuery(this).val();
					if ($filter != '') {
						window.location.assign('<?php echo admin_url(); ?>admin.php?page=bellefit-calculator&status='+$filter);
					} else {
						window.location.assign('<?php echo admin_url(); ?>admin.php?page=bellefit-calculator');
					}
				});
            });
        </script>
    <?php } ?>
</div>