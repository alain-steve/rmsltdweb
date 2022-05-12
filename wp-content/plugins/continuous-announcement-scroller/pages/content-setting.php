<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
  <div class="form-wrap">
    <div id="icon-edit" class="icon32 icon32-posts-post"><br>
    </div>
    <h2><?php _e('Continuous announcement scroller', 'continuous-announcement-scroller'); ?></h2>	
    <?php
	$cas_title = get_option('cas_title');
	$cas_total_rec = get_option('cas_total_rec');
	$cas_dis_count = get_option('cas_dis_count');
	$cas_rec_height = get_option('cas_rec_height');
	$cas_randomorder = get_option('cas_randomorder');
	
	$cas_speed = get_option('cas_speed');
	$cas_waitseconds = get_option('cas_waitseconds');
	
	if (isset($_POST['cas_form_submit']) && $_POST['cas_form_submit'] == 'yes')
	{
		//	Just security thingy that wordpress offers us
		check_admin_referer('cas_form_setting');
			
		$cas_title = stripslashes(sanitize_text_field($_POST['cas_title']));
		$cas_total_rec = stripslashes(intval($_POST['cas_total_rec']));
		$cas_dis_count = stripslashes(intval($_POST['cas_dis_count']));
		$cas_rec_height = stripslashes(intval($_POST['cas_rec_height']));
		$cas_randomorder = stripslashes(sanitize_text_field($_POST['cas_randomorder']));
		
		$cas_speed = stripslashes(intval($_POST['cas_speed']));
		$cas_waitseconds = stripslashes(intval($_POST['cas_waitseconds']));
		
		if(!is_numeric($cas_total_rec) || $cas_total_rec == 0) { $cas_total_rec = 10; }
		if(!is_numeric($cas_dis_count) || $cas_dis_count == 0) { $cas_dis_count = 5; }
		if(!is_numeric($cas_rec_height) || $cas_rec_height == 0) { $cas_rec_height = 60; }
		if(!is_numeric($cas_speed) || $cas_speed == 0) { $cas_speed = 2; }
		if(!is_numeric($cas_waitseconds) || $cas_waitseconds == 0) { $cas_waitseconds = 2; }
		
		update_option('cas_title', $cas_title );
		update_option('cas_total_rec', $cas_total_rec );
		update_option('cas_dis_count', $cas_dis_count );
		update_option('cas_rec_height', $cas_rec_height );
		update_option('cas_randomorder', $cas_randomorder );
		
		update_option('cas_speed', $cas_speed );
		update_option('cas_waitseconds', $cas_waitseconds );
		?>
		<div class="updated fade">
			<p><strong><?php _e('Details successfully updated.', 'continuous-announcement-scroller'); ?></strong></p>
		</div>
		<?php
	}
	?>
    <form name="cas_form" method="post" action="">
        <h3><?php _e('Setting', 'continuous-announcement-scroller'); ?></h3>
		
		<label for="tag-width"><?php _e('Widget title', 'continuous-announcement-scroller'); ?></label>
		<input name="cas_title" type="text" value="<?php echo $cas_title; ?>"  id="cas_title" size="50" maxlength="100">
		<p><?php _e('Please enter your widget title.', 'continuous-announcement-scroller'); ?></p>
		
		<label for="tag-width"><?php _e('Scroll height', 'continuous-announcement-scroller'); ?></label>
		<input name="cas_rec_height" type="text" value="<?php echo $cas_rec_height; ?>"  id="cas_rec_height" maxlength="3">
		<p><?php _e('If any overlap in the announcement text at front end, <br>you should arrange(increase/decrease) the height.', 'continuous-announcement-scroller'); ?> (Example: 40)</p>
		
		<label for="tag-width"><?php _e('Display record', 'continuous-announcement-scroller'); ?></label>
		<input name="cas_dis_count" type="text" value="<?php echo $cas_dis_count; ?>"  id="cas_dis_count" maxlength="3">
		<p><?php _e('Please enter number of records you want to display at the same time in scroll.', 'continuous-announcement-scroller'); ?> (Example: 5)</p>

		<label for="tag-width"><?php _e('Record to scroll', 'continuous-announcement-scroller'); ?></label>
		<input name="cas_total_rec" type="text" value="<?php echo $cas_total_rec; ?>"  id="cas_total_rec" maxlength="3">
		<p><?php _e('Please enter maximum number of records to scroll.', 'continuous-announcement-scroller'); ?> (Example: 10)</p>
		
		<label for="tag-title"><?php _e('Random', 'continuous-announcement-scroller'); ?></label>
		<select name="cas_randomorder" id="cas_randomorder">
			<option value='YES' <?php if($cas_randomorder == 'YES') { echo "selected='selected'" ; } ?>>Yes</option>
			<option value='NO' <?php if($cas_randomorder == 'NO') { echo "selected='selected'" ; } ?>>No</option>
		</select>
		<p><?php _e('Please select random display option.', 'continuous-announcement-scroller'); ?></p>
		
		<label for="cas_speed"><?php _e( 'Scrolling speed', 'continuous-announcement-scroller' ); ?></label>
		<?php _e( 'Slow', 'vertical-scroll-recent-post' ); ?> 
		<input name="cas_speed" type="range" value="<?php echo $cas_speed; ?>"  id="cas_speed" min="1" max="10" /> 
		<?php _e( 'Fast', 'vertical-scroll-recent-post' ); ?> 
		<p><?php _e( 'Set how fast you want to scroll.', 'continuous-announcement-scroller' ); ?></p>
		
		<label for="cas_waitseconds"><?php _e( 'Seconds to wait', 'vertical-scroll-recent-post' ); ?></label>
		<input name="cas_waitseconds" type="text" value="<?php echo $cas_waitseconds; ?>" id="cas_waitseconds" maxlength="4" />
		<p><?php _e( 'How many seconds you want the wait to scroll', 'continuous-announcement-scroller' ); ?> (<?php _e( 'Example', 'continuous-announcement-scroller' ); ?>: 5)</p>
		
		<input type="hidden" name="cas_form_submit" value="yes"/>
		<p class="submit">
		<input name="cas_submit" id="cas_submit" class="button" value="<?php _e('Submit', 'continuous-announcement-scroller'); ?>" type="submit" />
		<input name="publish" lang="publish" class="button" onclick="_cas_redirect()" value="<?php _e('Cancel', 'continuous-announcement-scroller'); ?>" type="button" />
		<input name="Help" lang="publish" class="button" onclick="_cas_help()" value="<?php _e('Help', 'continuous-announcement-scroller'); ?>" type="button" />
		</p>
		<?php wp_nonce_field('cas_form_setting'); ?>
    </form>
  </div>
</div>