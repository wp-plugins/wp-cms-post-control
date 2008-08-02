<?php
/*
Plugin Name: WP-CMS Post Control
Version: 1.00
Plugin URI: http://wp-cms.com/our-wordpress-plugins/post-control/
Description: Post Control hides unwanted items on the write page and write post pages within WordPress, eg custom fields, trackbacks etc. Requires WP 2.5.0 or above.
Author: Jonnya
Author URI: http://wp-cms.com/
License: GPL
*/

/*

=== VERSION HISTORY ===

v0.1 Jul 2008 - First version, non-public beta testing version
v0.2 Jul 2008 - First public release
v0.3 Jul 2008 - Second public release
v0.4 Aug 2008 - Development version
v1.00 Aug 2008 - Development version

=== CHANGE LOG ===

0.2		- Changed text
		- New clean-up of options table on plugin de-activation
	
0.3		- New admin control functionality
		- General tidying
	
0.4		- Option to select uploader
		- Option to hide revisions control
		- Option to hide word count
		- Option to hide Advanced Options header
		- Fixed page custom field control
		- Redesigned admin page
	
1.00	- Control WordPress Revisions
		- Control WordPress Autosave

*/

load_plugin_textdomain('wpcms_post_control','wp-content/plugins');
$options = array();

if (get_option('wpcms_post_control_options')) {
	$options = get_option('wpcms_post_control_options');
}

foreach ( array_keys(wpcms_post_control_ids()) as $css_id => $css_id_name ) {
	if (!isset($options[$css_id_name]) ) {
		$options[$css_id_name] = 1;
	}
}

function wpcms_post_control_admin_menu() {
  if(function_exists('add_options_page'))
  {//($page_title, $menu_title, $access_level, $file, $function = '')
    add_options_page('WPCMS Post Control','Post Control', 'manage_options', basename(__FILE__),'wpcms_post_control_options' );
  }
}
add_action('admin_menu', 'wpcms_post_control_admin_menu');

function wpcms_post_control_validate($id) {
	$css_ids = array_keys(wpcms_post_control_ids());
	if ( in_array($id, $css_ids) )
		return true;
	return false;
}

function wpcms_post_control_options() {
	global $options;
	$css_ids = (array) wpcms_post_control_ids();

	if (isset($_POST['wpcms_post_control_options_update'] ) ) {
		
		//For extra fields
		$admindisplayoption = $_POST["what_admin_sees"];
		$uploaderoption = $_POST["what_uploader"];
		$revisionsoption = $_POST["revisionscontrol"];
		$autosaveoption = $_POST["autosavecontrol"];
		
		$newoptions = array();

		foreach ( array_keys($css_ids) as $css_id )
			$newoptions[$css_id] = ( $_POST['wpcms_post_control'][$css_id] ) ? '1' : '0';

		add_option('wpcms_post_control_options');
		update_option('wpcms_post_control_options', $newoptions);
		
		//For extra fields
		update_option('wpcms_post_control_admindisplay', $admindisplayoption);
		update_option('wpcms_post_control_uploader', $uploaderoption);
		update_option('wpcms_post_control_revisions', $revisionsoption);
		update_option('wpcms_post_control_autosave', $autosaveoption);


		$options = get_option('wpcms_post_control_options');
		echo '<div id="message" class="updated fade"><p>' . __('Post Control options updated.','wpcms_post_control') . '</p></div>';
	}
	?>

	<div class="wrap">
	<h2><?php _e('WP-CMS Post Control Administration')?></h2>
	<form name="wpcms_post_control_options" method="post">
	<input type="hidden" name="wpcms_post_control_options_update" />

		
	<table class="form-table">	
	
	<tr valign="middle">	<th scope="row" style="width:150px; padding:15px;" >Uploader type:</th>
	<td>
	
	<select name='what_uploader' id='what_uploader' tabindex='0' style="width:325px; margin-right:20px">
	
		<?php
		$uploadoptions = get_option('wpcms_post_control_uploader');
		$uploadstringselected = "selected=\"selected\" ";
		$uploadstring1 = "value='flash'>Flash uploader (WordPress default)";
		$uploadstring2 = "value='html'>Standard uploader (if Flash doesn't work)";
		if ($uploadoptions == "flash") {
		$uploadswitch1 = $uploadstringselected . $uploadstring1;
		$uploadswitch2 = $uploadstring2;
		} else {	
		$uploadswitch1 = $uploadstringselected . $uploadstring2;
		$uploadswitch2 = $uploadstring1;
		}?>

	<option <?php echo $uploadswitch1; ?> </option>
	<option <?php echo $uploadswitch2; ?> </option>

	</select>
	<input type="submit" name="Submit" value="<?php _e('Save Post Control Options','wpcms_post_control'); ?>" />
	</td>
	</tr>
	
	
	<tr valign="middle">	<th scope="row" style="width:150px; padding:15px;" >Post/Page Revisions:</th>
	<td>

	<select name='revisionscontrol' id='revisionscontrol' tabindex='0' style="width:325px; margin-right:20px">

		<?php
		$revisionsoptions = get_option('wpcms_post_control_revisions');
		$revisionstringselected = "selected=\"selected\" ";
		$revisionsstring1 = "value='y'>Keep storing revisions (WordPress default)";
		$revisionsstring2 = "value='n'>Don't save further revisions (keeps previous)";
		if ($revisionsoptions == "y") {
		$revisionsswitch1 = $revisionsstringselected . $revisionsstring1;
		$revisionsswitch2 = $revisionsstring2;
		} else {	
		$revisionsswitch1 = $revisionsstringselected . $revisionsstring2;
		$revisionsswitch2 = $revisionsstring1;
		}?>

	<option <?php echo $revisionsswitch1;?> </option>
	<option <?php echo $revisionsswitch2;?> </option>
	
	</select>
	<input type="submit" name="Submit" value="<?php _e('Save Post Control Options','wpcms_post_control'); ?>" />
	</td>
	</tr>	


	<tr valign="middle">	<th scope="row" style="width:150px; padding:15px;" >Post/Page Autosave:</th>
	<td>

	<select name='autosavecontrol' id='autosavecontrol' tabindex='0' style="width:325px; margin-right:20px">

		<?php
		$autosaveoptions = get_option('wpcms_post_control_autosave');
		$autosavetringselected = "selected=\"selected\" ";
		$autosavestring1 = "value='y'>Keep autosave active (WordPress default)";
		$autosavestring2 = "value='n'>Disable autosave";
		if ($autosaveoptions == "y") {
		$autosaveswitch1 = $autosavestringselected . $autosavestring1;
		$autosaveswitch2 = $autosavestring2;
		} else {	
		$autosaveswitch1 = $autosavestringselected . $autosavestring2;
		$autosaveswitch2 = $autosavestring1;
		}?>

	<option <?php echo $autosaveswitch1;?> </option>
	<option <?php echo $autosaveswitch2;?> </option>
	
	</select>
	<input type="submit" name="Submit" value="<?php _e('Save Post Control Options','wpcms_post_control'); ?>" />
	</td>
	</tr>
		

	<tr valign="middle">	<th scope="row" style="width:150px; padding:15px;" >Admin user options:</th>
	<td>
	
		<select name='what_admin_sees' id='what_admin_sees' style="width:325px; margin-right:20px">
	
		<?php
		$adminoptions = get_option('wpcms_post_control_admindisplay');
		$viewstringselected = "selected=\"selected\" ";
		$viewstring1 = "value='y'>Admin users only get options selected below";
		$viewstring2 = "value='n'>Admin users see all normal post options";
		if ($adminoptions == "y") {
		$viewswitch1 = $viewstringselected . $viewstring1;
		$viewswitch2 = $viewstring2;
		} else {	
		$viewswitch1 = $viewstringselected . $viewstring2;
		$viewswitch2 = $viewstring1;
		}?>

	<option <?php echo $viewswitch1; ?> </option>
	<option <?php echo $viewswitch2; ?> </option>

	</select>

	<input type="submit" name="Submit" value="<?php _e('Save Post Control Options','wpcms_post_control'); ?>" />
	</td>
	</tr>	
	
	</table>
	
	
	<h3><?php _e('Display the following elements on the Post or Page write and edit screens:', 'wpcms_post_control'); ?></h3>
	<ul>
	<?php foreach ( $css_ids as $css_id => $css_id_name ) { ?>
		<li><input name="wpcms_post_control[<?php echo $css_id; ?>]" id="wpcms_post_control_<?php echo $css_id; ?>" type="checkbox" value="1" <?php checked('1', $options[$css_id]); ?> /><label for="wpcms_post_control_<?php echo $css_id; ?>">
			<?php echo $css_id_name; ?></label></li>
	<?php } ?>
	</ul>
	
	<p class="submit"><input type="submit" name="Submit" value="<?php _e('Save All Post Control Options','wpcms_post_control'); ?>" /></p>
	
	</form>
	
	<p>This plugin is bought to you by <a href=http://wp-cms.com>WordPress CMS Mods</a> - making WordPress more like a CMS every day!</p>
	
	</div>
	<?php
}

function wpcms_post_control_ids() {
	global $wpcms_post_control_ids;
	if ( !isset($wpcms_post_control_ids) )
		$wpcms_post_control_ids = array(
		'previewview' => __('<strong style="color: #2583ad;">Post:</strong> Preview Button', 'wpcms_post_control'),
		'edit-slug-box' => __('<strong style="color: #2583ad;">Post:</strong> Permalink', 'wpcms_post_control'),
		'tagsdiv' => __('<strong style="color: #2583ad;">Post:</strong> Tags', 'wpcms_post_control'),
		'categorydiv' => __('<strong style="color: #2583ad;">Post:</strong> Categories', 'wpcms_post_control'),
		'postexcerpt' => __('<strong style="color: #2583ad;">Post:</strong> Excerpt', 'wpcms_post_control'),
		'trackbacksdiv' => __('<strong style="color: #2583ad;">Post:</strong> Trackbacks', 'wpcms_post_control'),
		'postcustom' => __('<strong style="color: #2583ad;">Post:</strong> Custom Fields', 'wpcms_post_control'),
		'commentstatusdiv' => __('<strong style="color: #2583ad;">Post:</strong> Comments & Pings', 'wpcms_post_control'),
		'passworddiv' => __('<strong style="color: #2583ad;">Post:</strong> Password Protect This Post', 'wpcms_post_control'),
		'authordiv' => __('<strong style="color: #2583ad;">Post:</strong> Author', 'wpcms_post_control'),
		'pagecustomdiv' => __('<strong style="color: #2583ad;">Page:</strong> Custom Fields', 'wpcms_post_control'),
		'pagecommentstatusdiv' => __('<strong style="color: #2583ad;">Page:</strong> Comments &amp; Pings', 'wpcms_post_control'),
		'pagepassworddiv' => __('<strong style="color: #2583ad;">Page:</strong> Password Protect This Page', 'wpcms_post_control'),
		'pageparentdiv' => __('<strong style="color: #2583ad;">Page:</strong> Parent', 'wpcms_post_control'),
		'pagetemplatediv' => __('<strong style="color: #2583ad;">Page:</strong> Template', 'wpcms_post_control'),
		'pageorderdiv' => __('<strong style="color: #2583ad;">Page:</strong> Order', 'wpcms_post_control'),
		'pageauthordiv' => __('<strong style="color: #2583ad;">Page:</strong> Author', 'wpcms_post_control'),
		'media-buttons' => __('<strong style="color: #d54e21;">Post &amp; Page:</strong> Media Upload', 'wpcms_post_control'),
		'revisionsdiv' => __('<strong style="color: #d54e21;">Post &amp; Page:</strong> Revisions Menu <b>NOTE:</b> Doesn\'t disable feature, just hides menu', 'wpcms_post_control'),
		'wp-word-count' => __('<strong style="color: #d54e21;">Post &amp; Page:</strong> Word Count', 'wpcms_post_control'),
		'post-body h2' => __('<strong style="color: #d54e21;">Post &amp; Page:</strong> Advanced Options Title', 'wpcms_post_control'),
		'footer' => __('<strong style="color: #d54e21;">Post &amp; Page:</strong> Footer', 'wpcms_post_control')
		);
	return (array) $wpcms_post_control_ids;
}

function wpcms_post_control_css() {
	global $options;
	$css_hidden_ids = array();
	foreach ( (array) $options as $id => $val ) {
		if ( 0 == $val && wpcms_post_control_validate($id) )
			$css_hidden_ids[] = '#' . $id;
	}
	if ( !$css_hidden_ids ) {
		echo '<!-- ' . __('Post Control plugin: no GUI elements are being hidden', 'wpcms_post_control') . ' -->';
		return;
	}
	$css_id_string = implode(', ', $css_hidden_ids);
	$post_control_admin = get_option('wpcms_post_control_admindisplay');
	
	if ($post_control_admin == "y") {
		
	echo "\n<!-- " . __('WP-CMS Post Control plugin CSS:', 'wpcms_post_control') . " -->\n<style type='text/css'>\n<!--\n$css_id_string { display: none !important; }\n-->\n</style>\n";
	}
	
	elseif ($post_control_admin == "n") {
		if (current_user_can('manage_options') ) {
		echo '<!-- ' . __('Post Control plugin: no GUI elements are being hidden', 'wpcms_post_control') . ' -->';}
		else {echo "\n<!-- " . __('WP-CMS Post Control plugin CSS:', 'wpcms_post_control') . " -->\n<style type='text/css'>\n<!--\n$css_id_string { display: none !important; }\n-->\n</style>\n";}
	}
}


function wpcms_post_control_kill_iframes_init() {
	if ( strpos($_SERVER['REQUEST_URI'], 'wp-admin/post.php') === false )
		return;
	global $options;
	if ( isset($options['preview']) && $options['preview'] == '0' )
		ob_start('wpcms_post_control_kill_preview');
	if ( isset($options['uploading']) && $options['uploading'] == '0' )
		ob_start('wpcms_post_control_kill_uploading');
}


function wpcms_post_control_kill_preview($content) {
	global $post;
	
	$content = preg_replace("/<div[^>]*?id=['\"]preview['\"].*?<\/div>/mis", '', $content);
	$content = preg_replace('/<a href="#preview-post">/mis', '<a href="' . add_query_arg('preview', 'true', get_permalink($post->ID)) . '" onclick="this.target=\'_blank\';">', $content);
	return $content;
}


function wpcms_post_control_kill_uploading($content) {
	return preg_replace("/<iframe[^>]*?id=['\"]uploading['\"].*?<\/iframe>/mis", '', $content);
}


function wpcms_post_control_flashloader(){
if (get_option('wpcms_post_control_uploader') == 'flash') {
		return true;
	} else {
		return false;
	}
}


function wpcms_post_control_postrevisions(){
	if (get_option('wpcms_post_control_revisions') == 'n') {
		@remove_action ( 'pre_post_update', 'wp_save_post_revision' );
		} else {
	}
}


function wpcms_post_control_autosave() {
	if (get_option('wpcms_post_control_autosave') == 'n') {
		wp_deregister_script('autosave');
		} else {
	}
}


// GO DO POST CONTROL

add_action('admin_head', 'wpcms_post_control_css');
add_action('init', create_function('$a=0','load_plugin_textdomain("wpcms_post_control");'), 10);
add_action('init', 'wpcms_post_control_kill_iframes_init', 11);
add_filter('flash_uploader', 'wpcms_post_control_flashloader', 5);
add_action('init', 'wpcms_post_control_postrevisions', 1);
add_action('wp_print_scripts', 'wpcms_post_control_autosave');

// INSTALL OR CLEANUP ON ACTIVATION/DEACTIVATION

register_activation_hook(__FILE__,'set_wpcms_post_control_options');
register_deactivation_hook(__FILE__,'unset_wpcms_post_control_options');

function set_wpcms_post_control_options() {
	add_option('wpcms_post_control_admindisplay','y','Control what admin users see');
	add_option('wpcms_post_control_uploader','flash','Control what uploader to use');
	add_option('wpcms_post_control_revisions','y','Control post revisions');
	add_option('wpcms_post_control_autosave','y','Control auto saves');
}

function unset_wpcms_post_control_options() {
	delete_option('wpcms_post_control_options');
	delete_option('wpcms_post_control_admindisplay');
	delete_option('wpcms_post_control_uploader');
	delete_option('wpcms_post_control_revisions');
	delete_option('wpcms_post_control_autosave');

}

?>
