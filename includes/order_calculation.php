<div class="wrap">
	<h1>Order Calculation Form Details</h1>
    <?php global $wpdb; ?>
    <?php if (isset($_GET['action']) && $_GET['action'] == 'view') { ?>
    
        <?php
		if (isset($_GET['calkey'])) {
			$calkey = $_GET['calkey'];
			$forms_data = $wpdb->get_results(" SELECT * FROM cal_form_order_data WHERE cal_id = '$calkey' LIMIT 0,1 ");
		} 
	    foreach($forms_data as $data) {
            ?>
            <div class="form_details">
                <div class="form_details_head">
                    ID : 
                </div>
                <div class="form_details_value">
                    <?php echo $data->cal_id; ?>
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
            <?php
            $cal_value = $data->cal_data;
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
						} ?>
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

    <?php } ?>
</div>