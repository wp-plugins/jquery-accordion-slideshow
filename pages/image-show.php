<?php
// Form submitted, check the data
if (isset($_POST['frm_JaS_display']) && $_POST['frm_JaS_display'] == 'yes')
{
	$did = isset($_GET['did']) ? $_GET['did'] : '0';
	
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
		?><div class="error fade"><p><strong>Oops, selected details doesn't exist (1).</strong></p></div><?php
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
			$JaS_success = __('Selected record was successfully deleted.', TinyCarousel_UNIQUE_NAME);
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
    <h2><?php echo Wp_JaS_TITLE; ?><a class="add-new-h2" href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=jquery-accordion-slideshow&amp;ac=add">Add New</a></h2>
    <div class="tool-box">
	<?php
		$sSql = "SELECT * FROM `".WpJqueryAccordionSlidshowTbl."` order by JaS_id desc";
		$myData = array();
		$myData = $wpdb->get_results($sSql, ARRAY_A);
		?>
		<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/jquery-accordion-slideshow/pages/setting.js"></script>
		<form name="frm_JaS_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th class="check-column" scope="col"><input type="checkbox" name="JaS_group_item[]" /></th>
			<th scope="col">Image folder location</th>
			<th scope="col">Gallery name</th>
            <th scope="col">Container width</th>
			<th scope="col">Container height</th>
			<th scope="col">Slide width</th>
			<th scope="col">Slide height</th>
          </tr>
        </thead>
		<tfoot>
          <tr>
            <th class="check-column" scope="col"><input type="checkbox" name="JaS_group_item[]" /></th>
			<th scope="col">Image folder location</th>
			<th scope="col">Gallery name</th>
            <th scope="col">Container width</th>
			<th scope="col">Container height</th>
			<th scope="col">Slide width</th>
			<th scope="col">Slide height</th>
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
						<td align="left"><input type="checkbox" value="<?php echo $data['JaS_id']; ?>" name="JaS_group_item[]"></td>
						<td><?php echo $data['JaS_Location']; ?>
						<div class="row-actions">
							<span class="edit"><a title="Edit" href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=jquery-accordion-slideshow&amp;ac=edit&amp;did=<?php echo $data['JaS_id']; ?>">Edit</a> | </span>
							<span class="trash"><a onClick="javascript:JaS_delete('<?php echo $data['JaS_id']; ?>')" href="javascript:void(0);">Delete</a></span> 
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
				?><tr><td colspan="7" align="center">No records available.</td></tr><?php 
			}
			?>
		</tbody>
        </table>
		<p class="description">Note: Don't upload your original images into plug-in folder. if you upload the images into plug-in folder, you may lose the images when you update the plug-in to next version.</p>
		<?php wp_nonce_field('JaS_form_show'); ?>
		<input type="hidden" name="frm_JaS_display" value="yes"/>
      </form>	
	  <div class="tablenav">
	  <h2>
	  <a class="button add-new-h2" href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=jquery-accordion-slideshow&amp;ac=add">Add New</a>
	  <a class="button add-new-h2" target="_blank" href="<?php echo Wp_JaS_FAV; ?>">Help</a>
	  </h2>
	  </div>
	  <div style="height:5px"></div>
	<h3>Plugin configuration option</h3>
	<ol>
		<li>Drag and drop the widget to your sidebar.</li>
		<li>Add the plugin in the posts or pages using short code.</li>
		<li>Add directly in to the theme using PHP code.</li>
	</ol>
	<p class="description"><?php echo Wp_JaS_LINK; ?></p>
	</div>
</div>