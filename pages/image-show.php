<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
// Form submitted, check the data
if (isset($_POST['frm_JaS_display']) && $_POST['frm_JaS_display'] == 'yes')
{
	$did = isset($_GET['did']) ? $_GET['did'] : '0';
	if(!is_numeric($did)) { die('<p>Are you sure you want to do this?</p>'); }
	
	$JaS_success = '';
	$JaS_success_msg = FALSE;
	
	// First check if ID exist with requested ID
	$sSql = $wpdb->prepare(
		"SELECT COUNT(*) AS `count` FROM ".WpJqueryAccordionSlidshowTbl."
		WHERE `JaS_id` = %d",
		array($did)
	);
	$result = '0';
	$result = $wpdb->get_var($sSql);
	
	if ($result != '1')
	{
		?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist', 'jquery-accordion'); ?></strong></p></div><?php
	}
	else
	{
		// Form submitted, check the action
		if (isset($_GET['ac']) && $_GET['ac'] == 'del' && isset($_GET['did']) && $_GET['did'] != '')
		{
			//	Just security thingy that wordpress offers us
			check_admin_referer('JaS_form_show');
			
			//	Delete selected record from the table
			$sSql = $wpdb->prepare("DELETE FROM `".WpJqueryAccordionSlidshowTbl."`
					WHERE `JaS_id` = %d
					LIMIT 1", $did);
			$wpdb->query($sSql);
			
			//	Set success message
			$JaS_success_msg = TRUE;
			$JaS_success = __('Selected record was successfully deleted.', 'jquery-accordion');
		}
	}
	
	if ($JaS_success_msg == TRUE)
	{
		?><div class="updated fade"><p><strong><?php echo $JaS_success; ?></strong></p></div><?php
	}
}
?>
<div class="wrap">
  <div id="icon-edit" class="icon32 icon32-posts-post"></div>
    <h2><?php _e('Jquery accordion slideshow', 'jquery-accordion'); ?>
	<a class="add-new-h2" href="<?php echo WP_JaS_ADMIN_URL; ?>&amp;ac=add"><?php _e('Add New', 'jquery-accordion'); ?></a></h2>
    <div class="tool-box">
	<?php
		$sSql = "SELECT * FROM `".WpJqueryAccordionSlidshowTbl."` order by JaS_id desc";
		$myData = array();
		$myData = $wpdb->get_results($sSql, ARRAY_A);
		?>
		<script language="JavaScript" src="<?php echo WP_JaS_PLUGIN_URL; ?>/pages/setting.js"></script>
		<form name="frm_JaS_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
			<th scope="col"><?php _e('Image folder location', 'jquery-accordion'); ?></th>
			<th scope="col"><?php _e('Gallery name', 'jquery-accordion'); ?></th>
            <th scope="col"><?php _e('Container width', 'jquery-accordion'); ?></th>
			<th scope="col"><?php _e('Container height', 'jquery-accordion'); ?></th>
			<th scope="col"><?php _e('Slide width', 'jquery-accordion'); ?></th>
			<th scope="col"><?php _e('Slide height', 'jquery-accordion'); ?></th>
          </tr>
        </thead>
		<tfoot>
          <tr>
			<th scope="col"><?php _e('Image folder location', 'jquery-accordion'); ?></th>
			<th scope="col"><?php _e('Gallery name', 'jquery-accordion'); ?></th>
            <th scope="col"><?php _e('Container width', 'jquery-accordion'); ?></th>
			<th scope="col"><?php _e('Container height', 'jquery-accordion'); ?></th>
			<th scope="col"><?php _e('Slide width', 'jquery-accordion'); ?></th>
			<th scope="col"><?php _e('Slide height', 'jquery-accordion'); ?></th>
          </tr>
        </tfoot>
		<tbody>
			<?php 
			$i = 0;
			if(count($myData) > 0 )
			{
				foreach ($myData as $data)
				{
					?>
					<tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
						<td><?php echo $data['JaS_Location']; ?>
						<div class="row-actions">
						<span class="edit"><a title="Edit" href="<?php echo WP_JaS_ADMIN_URL; ?>&amp;ac=edit&amp;did=<?php echo $data['JaS_id']; ?>"><?php _e('Edit', 'jquery-accordion'); ?></a> | </span>
						<span class="trash"><a onClick="javascript:JaS_delete('<?php echo $data['JaS_id']; ?>')" href="javascript:void(0);"><?php _e('Delete', 'jquery-accordion'); ?></a></span> 
						</div>
						</td>
						<td><?php echo $data['JaS_Gallery']; ?></td>
						<td><?php echo $data['JaS_width']; ?> px</td>
						<td><?php echo $data['JaS_height']; ?> px</td>
						<td><?php echo $data['JaS_slideWidth']; ?> px</td>
						<td><?php echo $data['JaS_slideHeight']; ?> px</td>
					</tr>
					<?php 
					$i = $i+1; 
				} 	
			}
			else
			{
				?><tr><td colspan="6" align="center"><?php _e('No records available.', 'jquery-accordion'); ?></td></tr><?php 
			}
			?>
		</tbody>
        </table>
		<p class="description"><?php _e('Note: Dont upload your original images into plug-in folder. if you upload the images into plug-in folder, you may lose the images when you update the plug-in to next version.', 'jquery-accordion'); ?></p>
		<?php wp_nonce_field('JaS_form_show'); ?>
		<input type="hidden" name="frm_JaS_display" value="yes"/>
      </form>	
	  <div class="tablenav">
	  <h2>
	  <a class="button add-new-h2" href="<?php echo WP_JaS_ADMIN_URL; ?>&amp;ac=add"><?php _e('Add New', 'jquery-accordion'); ?></a>
	  <a class="button add-new-h2" target="_blank" href="<?php echo Wp_JaS_FAV; ?>"><?php _e('Help', 'jquery-accordion'); ?></a>
	  </h2>
	  </div>
	  <div style="height:5px"></div>
	<h3><?php _e('Plugin configuration option', 'jquery-accordion'); ?></h3>
	<ol>
		<li><?php _e('Drag and drop the widget to your sidebar.', 'jquery-accordion'); ?></li>
		<li><?php _e('Add the plugin in the posts or pages using short code.', 'jquery-accordion'); ?></li>
		<li><?php _e('Add directly in to the theme using PHP code.', 'jquery-accordion'); ?></li>
	</ol>
	<p class="description">
		<?php _e('Check official website for more information', 'onclick-show-popup'); ?>
		<a target="_blank" href="<?php echo Wp_JaS_FAV; ?>"><?php _e('click here', 'onclick-show-popup'); ?></a>
	</p>
	</div>
</div>