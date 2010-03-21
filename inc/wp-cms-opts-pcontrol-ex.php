<?php
/**
* Core functions options page include
*
* @since 2.1
* @lastupdate 2.12
* 
*
*/
?>

<div class="wrap">

	<div id="icon-options-general" class="icon32"><br /></div>
	<h2>WP-CMS Post Control Core Functions</h2>

	<h3><a href="<?php echo admin_url('options-general.php?page=wpcms_pcontrol'); ?>" title="Main post control options">Post Control</a> | <a href="<?php echo admin_url('options-general.php?page=wpcms_pcontrol_ex'); ?>" title="Core WordPress publishing functions">Core Functions</a></h3>

	<p>Use these controls to configure the core publishing behaviour of WordPress.</p>
	<p><strong>Disable autosave</strong> - Stops this interpution when you are writing content.</p>
	<p><strong>Disable revisions</strong> - Stops more post revisions being saved - existing revisions will be kept.</p>
	<p><strong>Disable Flash uploader</strong> - Removes Flash upload as option and forces back to browser upload type.</p>

	<form method="post" action="options.php">
		<?php
		
		$options = get_option('wpcms_pcontrolopts_ex');			
		//Output nonce, action, and option_page fields for a settings page
		// @param string $option_group A settings group name. IMPORTANT - This should match the group name used in register_setting()
		settings_fields('wpcms_pcontrol_options_ex');
		?>		
		
		<table class="form-table">
		
			<?php
			$mypagecontrols = array(
			'Disable Autosave' => 'autosave', 
			'Disable Revisions' => 'revisions', 
			'Disable Flash uploader' => 'flashupload'
			);		

			//Generate form from array
			foreach($mypagecontrols as $key => $value) { ?>		
		
			<tr>
				<th scope="row"><?php echo $key; ?></th>
				<td>
				<fieldset>
				<legend class="screen-reader-text"><span><?php echo $key; ?></span></legend>

					<label for="wpcms_pcontrolopts_ex_autosave">
					
					<input name="wpcms_pcontrolopts_ex[<?php echo $value; ?>]" type="checkbox" value="off" 
					<?php 
					if (isset($options[''.$value.''])) {
						checked('off', $options[''.$value.'']);
					}
					?> 
					/>	

					</label>
					
				</fieldset>
				</td>
			</tr>
			
			<?php 
			}
			?>
		
		</table>	

		<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Save Post Control options') ?>" />
		</p>
		
	</form>

<?php include("wp-cms-opts-pcontrol-common.php"); ?>

</div>