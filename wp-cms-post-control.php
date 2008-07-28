<?php
/*
Plugin Name: WP-CMS Post Control
Version: 0.3
Plugin URI: http://wp-cms.com/our-wordpress-plugins/post-control/
Description: Post Control hides unwanted items on the write page and write post pages within WordPress, eg custom fields, trackbacks etc. Requires WP 2.5.0 or above.
Author: Jonnya
Author URI: http://wp-cms.com/
License: GPL
*/

/*

=== VERSION HISTORY ===

WPCMS Post Options v0.1 Jul 2008 - First version, non-public beta testing version

WPCMS Post Options v0.2 Jul 2008 - First public release

WPCMS Post Options v0.3 Jul 2008 - Codename 'Crazy Tortoise' NOT READY FOR PUBLIC USE JUST YET - STABLE TAG IS v0.2

=== CHANGE LOG ===

0.2	- First public release
	- Changed text
	- Implemented clean-up of options table on plugin de-activation
	
0.3	- Codename 'Crazy Tortoise'
	- Implemented admin control functionality
	- General tidying

=== CREDITS ===

Inspired by the Clutter Free plugin by Mark Jaquith

The iframe preview removal feature comes courtesy of Owen Winkler's "Kill Preview" plugin http://redalt.com/wiki/Kill+Preview+Plugin

Further work by Brady J. Frey, who called the plugin 'Cloak' - he has now moved onto bigger and brighter things and kindly offered to allow me to continue the development of his good work!

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
		$admindisplayoption = $_POST["what_admin_sees"];
		$newoptions = array();

		foreach ( array_keys($css_ids) as $css_id )
			$newoptions[$css_id] = ( $_POST['wpcms_post_control'][$css_id] ) ? '1' : '0';

		add_option('wpcms_post_control_options');
		update_option('wpcms_post_control_options', $newoptions);
		update_option('wpcms_post_control_admindisplay', $admindisplayoption);

		$options = get_option('wpcms_post_control_options');
		echo '<div id="message" class="updated fade"><p>' . __('Post Control options updated.','wpcms_post_control') . '</p></div>';
	}
	?>

	<div class="wrap">
	<h2><?php _e('WP-CMS Post Control Administration')?></h2>
	<form name="wpcms_post_control_options" method="post">
	<input type="hidden" name="wpcms_post_control_options_update" />
	
		<h3>Admin user control</h3>
		<?php
		$adminoptionsforform = get_option('wpcms_post_control_admindisplay');
		if ($adminoptionsforform == "n") { ?>
<select name='what_admin_sees' id='post_status' tabindex='0'>
<option selected="selected" value='n'>Admin users see all normal post options</option><option value='y'>Admin users only get options selected below</option></select>
<?php }
else {?>
<select name='what_admin_sees' id='post_status' tabindex='0'>
<option selected="selected" value='y'>Admin users only get options selected below</option><option value='n'>Admin users see all normal post options</option></select>	
<?php }?>
	
	<h3><?php _e('Display the following elements on the Post or Page write and edit screens:', 'wpcms_post_control'); ?></h3>
	<ul>
	<?php foreach ( $css_ids as $css_id => $css_id_name ) { ?>
		<li><input name="wpcms_post_control[<?php echo $css_id; ?>]" id="wpcms_post_control_<?php echo $css_id; ?>" type="checkbox" value="1" <?php checked('1', $options[$css_id]); ?> /><label for="wpcms_post_control_<?php echo $css_id; ?>">
			<?php echo $css_id_name; ?></label></li>
	<?php } ?>
	</ul>
	
	<p class="submit"><input type="submit" name="Submit" value="<?php _e('Save Post Control Options','wpcms_post_control'); ?>" /></p>
	
	</form>
	</div>
	<?php
}

function wpcms_post_control_ids() {
	global $wpcms_post_control_ids;
	if ( !isset($wpcms_post_control_ids) )
		$wpcms_post_control_ids = array(
		'previewview' => __('<strong style="color: red;">Post:</strong> Preview Button', 'wpcms_post_control'),
		'edit-slug-box' => __('<strong style="color: red;">Post:</strong> Permalink', 'wpcms_post_control'),
		'tagsdiv' => __('<strong style="color: red;">Post:</strong> Tags', 'wpcms_post_control'),
		'categorydiv' => __('<strong style="color: red;">Post:</strong> Categories', 'wpcms_post_control'),
		'postexcerpt' => __('<strong style="color: red;">Post:</strong> Excerpt', 'wpcms_post_control'),
		'trackbacksdiv' => __('<strong style="color: red;">Post:</strong> Trackbacks', 'wpcms_post_control'),
		'postcustom' => __('<strong style="color: red;">Post:</strong> Custom Fields', 'wpcms_post_control'),
		'commentstatusdiv' => __('<strong style="color: red;">Post:</strong> Comments & Pings', 'wpcms_post_control'),
		'passworddiv' => __('<strong style="color: red;">Post:</strong> Password Protect This Post', 'wpcms_post_control'),
		'authordiv' => __('<strong style="color: red;">Post:</strong> Author', 'wpcms_post_control'),
		'pagepostcustom' => __('<strong style="color: red;">Page:</strong> Custom Fields', 'wpcms_post_control'),
		'pagecommentstatusdiv' => __('<strong style="color: red;">Page:</strong> Comments &amp; Pings', 'wpcms_post_control'),
		'pagepassworddiv' => __('<strong style="color: red;">Page:</strong> Password Protect This Page', 'wpcms_post_control'),
		'pageparentdiv' => __('<strong style="color: red;">Page:</strong> Parent', 'wpcms_post_control'),
		'pagetemplatediv' => __('<strong style="color: red;">Page:</strong> Template', 'wpcms_post_control'),
		'pageorderdiv' => __('<strong style="color: red;">Page:</strong> Order', 'wpcms_post_control'),
		'pageauthordiv' => __('<strong style="color: red;">Page:</strong> Author', 'wpcms_post_control'),
		'media-buttons' => __('<strong style="color: red;">Post &amp; Page:</strong> Media Upload', 'wpcms_post_control'),
		'footer' => __('<strong style="color: red;">Post &amp; Page:</strong> Footer', 'wpcms_post_control'),
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


add_action('admin_head', 'wpcms_post_control_css');
add_action('init', create_function('$a=0','load_plugin_textdomain("wpcms_post_control");'), 10);
add_action('init', 'wpcms_post_control_kill_iframes_init', 11);


// INSTALL OR CLEANUP ON ACTIVATION/DEACTIVATION

register_activation_hook(__FILE__,'set_wpcms_post_control_options');
register_deactivation_hook(__FILE__,'unset_wpcms_post_control_options');

function set_wpcms_post_control_options() {
	add_option('wpcms_post_control_admindisplay','y','Control what admin users see');
}

function unset_wpcms_post_control_options() {
	delete_option('wpcms_post_control_options');
	delete_option('wpcms_post_control_admindisplay');
}

?>
