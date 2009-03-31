<?php
/*
Plugin Name: WP-CMS Post Control
Version: 1.2.1
Plugin URI: http://wp-cms.com/our-wordpress-plugins/post-control/
Description: Post Control hides unwanted items on the write page and write post pages, and other post related controls. Updated to include WP2.7 and above.
Author: Jonnya
Author URI: http://wp-cms.com/
License: GPL
*/

/*

=== VERSION HISTORY ===

v0.1 Jul 2008	- First version, non-public beta testing version
v0.2 Jul 2008	- Public release 1
v0.3 Jul 2008	- Public release 2
v0.4 Aug 2008	- Development version
v1.00 Aug 2008	- Development version
V1.01 Aug 2008	- Public release 3
V1.02 Sept 2008	- Public release 4
V1.03 Sept 2008	- Public release 5
V1.1 Sept 2008	- Development version
V1.11 Sept 2008	- Public release 6
V1.2 Dec 2008	- Public release 7
V1.2.1 Mar 2009	- Public release 8

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
		
1.01	- Insert message panel

1.02	- Bug fixes, may improve compatibility with different server configs.

1.03	- Bug fix to options fields, introduced in 1.02 - sorry!
		- After comments feedback, changed and documented admin control
		
1.1		- Found conflict with options variables declaired within a theme functions file
		- Confilicting PHP variables for reference - 'options' and 'newoptions'
		- Should solve conflicts with wrongly coded variables from other plugins/themes
		
1.11	- Remove redundant preview code
		- Improved formatting for message box text and title input
		
1.2		- WordPress 2.7 compatibility build, re-write plugin controls to support new 'Crazy Horse' interface
		- Fix basic text formatting in custom message box, remove strip slashes to allow basic formatting like <b> and <i> 
		- Changed option array function for more control
		- Changed formatting of plugin options buttons
		
1.2.1	- WordPress 2.7 author control
		
		=== TO DO ===

		- Fix HTMLSpecChar so punctuation works instead of inserting slashes!!

*/

load_plugin_textdomain('wpcms_post_control','wp-content/plugins');
$wpcmspc_options = array();

if (get_option('wpcms_post_control_options')) {
	$wpcmspc_options = get_option('wpcms_post_control_options');
}

foreach ( array_keys(wpcms_post_control_ids()) as $css_id => $css_id_name ) {
	if (!isset($wpcmspc_options[$css_id_name]) ) {
		$wpcmspc_options[$css_id_name] = 1;
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

// !IMPORTANT! FILTER POTENTIAL MALICIOUS CODE BEFORE WRITTING TO DATABASE
add_filter('wpcmspc_msg1title_cleaner','wp_filter_kses');
add_filter('wpcmspc_msg1text_cleaner','wp_filter_kses');

function wpcms_post_control_options() {
	global $wpcmspc_options;
	$css_ids = (array) wpcms_post_control_ids();

	if (isset($_POST['wpcms_post_control_options_update'] ) ) {
		
		//For extra fields
		$admindisplayoption = $_POST["what_admin_sees"];
		$uploaderoption = $_POST["what_uploader"];
		$revisionsoption = $_POST["revisionscontrol"];
		$autosaveoption = $_POST["autosavecontrol"];
		//For message box		
		$msg1ctrloption = $_POST["msg1_ctrl"];
		$msg1titleoption = apply_filters('wpcmspc_msg1title_cleaner',$_POST["msg1title"]);	
		$msg1textoption = apply_filters('wpcmspc_msg1text_cleaner',$_POST["msg1text"]);		
		$msg1stateoption = $_POST["msg1_state"];	
		
		$wpcmspc_newoptions = array();

		foreach ( array_keys($css_ids) as $css_id )
			$wpcmspc_newoptions[$css_id] = ( $_POST['wpcms_post_control'][$css_id] ) ? '1' : '0';

		add_option('wpcms_post_control_options');
		update_option('wpcms_post_control_options', $wpcmspc_newoptions);
		
		//For extra fields
		update_option('wpcms_post_control_admindisplay', $admindisplayoption);
		update_option('wpcms_post_control_uploader', $uploaderoption);
		update_option('wpcms_post_control_revisions', $revisionsoption);
		update_option('wpcms_post_control_autosave', $autosaveoption);
		//For message box		
		update_option('wpcms_post_control_msg1ctrl', $msg1ctrloption);
		update_option('wpcms_post_control_msg1title', $msg1titleoption);
		update_option('wpcms_post_control_msg1text', $msg1textoption);
		update_option('wpcms_post_control_msg1state', $msg1stateoption);


		$wpcmspc_options = get_option('wpcms_post_control_options');
		echo '<div id="message" class="updated fade"><p>' . __('Post Control options updated.','wpcms_post_control') . '</p></div>';
	}
	?>

	<div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div>
		<h2><?php _e('WP-CMS Post Control Administration')?></h2>
	<h2><?php _e('General Options')?></h2>
	<p>These only disable the following post/page functions, they don't delete existing revisions or options from your database.<br />You can re-enable these functions anytime and they will continue to work just fine!</p>
	<form name="wpcms_post_control_options" method="post">
	<input type="hidden" name="wpcms_post_control_options_update" />

		
	<table class="form-table">
	
	
	<tr valign="middle">
	<th scope="row" style="width:150px; padding:15px;" >Uploader type</th>
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
	</td>
	</tr>
	
	
	<tr valign="middle">
	<th scope="row" style="width:150px; padding:15px;" >Post/Page Revisions</th>
	<td>

	<select name='revisionscontrol' id='revisionscontrol' tabindex='0' style="width:325px; margin-right:20px">

		<?php
		$revisionsoptions = get_option('wpcms_post_control_revisions');
		$revisionstringselected = "selected=\"selected\" ";
		$revisionsstring1 = "value='y'>Keep saving revisions (WordPress default)";
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
	</td>
	</tr>

	<tr valign="middle">
	<th scope="row" style="width:150px; padding:15px;" >Post/Page Autosave</th>
	<td>

	<select name='autosavecontrol' id='autosavecontrol' tabindex='0' style="width:325px; margin-right:20px">

		<?php
		$autosaveoptions = get_option('wpcms_post_control_autosave');
		$autosavestringselected = "selected=\"selected\" ";
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
<input type="submit" class="button" name="Submit" value="<?php _e('Save All Post Control Options','wpcms_post_control'); ?>" />
	</td>
	</tr>
	
		</table>
	
	<br /><h2><?php _e('Message Box Options')?></h2>
<p>Inserts a new, collapsable message box below the text editor on the write post/page pages.<br />Basic text markup is allowed like &#60;b&#62; &#60;i&#62;</p>
	
	<table class="form-table">
	
	
	<tr valign="middle">
	<th scope="row" style="width:150px; padding:15px;" >Display</th>
	<td>

	<select name='msg1_ctrl' id='msg1_ctrl' style="width:325px; margin-right:20px">

		<?php
		$msg1_ctrloptions = get_option('wpcms_post_control_msg1ctrl');
		$msg1_ctrlstringselected = "selected=\"selected\" ";
		$msg1_ctrlstring1 = "value='y'>Show message box";
		$msg1_ctrlstring2 = "value='n'>Don't show message box";
		if ($msg1_ctrloptions == "y") {
		$msg1_ctrlswitch1 = $msg1_ctrlstringselected . $msg1_ctrlstring1;
		$msg1_ctrlswitch2 = $msg1_ctrlstring2;
		} else {	
		$msg1_ctrlswitch1 = $msg1_ctrlstringselected . $msg1_ctrlstring2;
		$msg1_ctrlswitch2 = $msg1_ctrlstring1;
		}?>

	<option <?php echo $msg1_ctrlswitch1;?> </option>
	<option <?php echo $msg1_ctrlswitch2;?> </option>
	
	</select>
	
	
		<select name='msg1_state' id='msg1_state' style="width:325px; margin-right:20px">

		<?php
		$msg1_stateoptions = get_option('wpcms_post_control_msg1state');
		$msg1_statestringselected = "selected=\"selected\" ";
		$msg1_statestring1 = "value='open'>As expanded view (Click to collapse)";
		$msg1_statestring2 = "value='closed'>As collapsed view (Click to expand)";
		if ($msg1_stateoptions == "open") {
		$msg1_stateswitch1 = $msg1_statestringselected . $msg1_statestring1;
		$msg1_stateswitch2 = $msg1_statestring2;
		} else {	
		$msg1_stateswitch1 = $msg1_statestringselected . $msg1_statestring2;
		$msg1_stateswitch2 = $msg1_statestring1;
		}?>
		
	<option <?php echo $msg1_stateswitch1;?> </option>
	<option <?php echo $msg1_stateswitch2;?> </option>
	
	</select>
	
	</td>
	</tr>
	
	
		<tr valign="middle">
	<th scope="row" style="width:150px; padding:15px;" >Message Box Title</th>
	<td>

			<input name="msg1title" id="msg1title" type="text" style="width: 318px; margin-right:20px" value="<?php $formmsg1txt=get_option('wpcms_post_control_msg1title'); echo $formmsg1txt; ?>" size="50" />

	</td>
	</tr>

	
		<tr valign="middle">
	<th scope="row" style="width:150px; padding:15px;" >Message Box Text</th>
	<td>

			<input name="msg1text" id="msg1text" type="text" style="width: 318px; margin-right:20px" value="<?php $formmsg1txt=get_option('wpcms_post_control_msg1text'); echo $formmsg1txt; ?>" size="50" />

			<input type="submit" class="button" name="Submit" value="<?php _e('Save All Post Control Options','wpcms_post_control'); ?>" />	</td>
	</tr>


	</table>
	
	<br /><h2><?php _e('Display Options')?></h2>
		<p>Control what is visible and hidden on the write post/pages below.</p>
	
	<table class="form-table">	

	<tr valign="middle">
	<th scope="row" style="width:150px; padding:15px;" >Admin User Options</th>
	<td>
	
		<select name='what_admin_sees' id='what_admin_sees' style="width:325px; margin-right:20px">
	
		<?php
		$adminoptions = get_option('wpcms_post_control_admindisplay');
		$viewstringselected = "selected=\"selected\" ";
		$viewstring1 = "value='y'>Admin users see selected options";
		$viewstring2 = "value='n'>Admin users see all post options";
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
	
		<p>This controls if Admin level users get to see and control all the standard WordPress options when writing and editing posts and pages (choose 'Admin users see all post options') or just the options and controls you have selected below (choose 'Admin users see selected options'). If you choose 'Admin users see selected options', Admin level users will see what any user below admin level sees when using this plugin.</p>

	</td>
	</tr>	

	</table>
	<br />
	<ul>
	<?php foreach ( $css_ids as $css_id => $css_id_name ) { ?>
		<li><input name="wpcms_post_control[<?php echo $css_id; ?>]" id="wpcms_post_control_<?php echo $css_id; ?>" type="checkbox" value="1" <?php checked('1', $wpcmspc_options[$css_id]); ?> /><label for="wpcms_post_control_<?php echo $css_id; ?>">
			<?php echo $css_id_name; ?></label></li>
	<?php } ?>
	</ul>
	<br />
	<input type="submit" class="button-primary" name="Submit" value="<?php _e('Save All Post Control Options','wpcms_post_control'); ?>" />	
	</form>
<br />
	
<h2>
<?php _e('Harness the publishing power of WordPress')?>
</h2>
<p>This plugin is bought to you by <a href=http://wp-cms.com>WordPress CMS Modifications</a> - helping you make WordPress more like a CMS every day! Drop by the site to find out more about WordPress and support the best publishing platform on the Internet.</p>
	
	</div>
	
	<?php
}

function wpcms_post_control_ids() {
	global $wpcms_post_control_ids;
	if ( !isset($wpcms_post_control_ids) )
		$wpcms_post_control_ids = array(
		'#preview-action' => __('<strong style="color: #2583ad;">Post:</strong> Preview button', 'wpcms_post_control'),
		'#edit-slug-box' => __('<strong style="color: #2583ad;">Post:</strong> Permalink', 'wpcms_post_control'),
		'#tagsdiv' => __('<strong style="color: #2583ad;">Post:</strong> Tags', 'wpcms_post_control'),
		'#categorydiv' => __('<strong style="color: #2583ad;">Post:</strong> Categories', 'wpcms_post_control'),
		'#postexcerpt' => __('<strong style="color: #2583ad;">Post:</strong> Excerpt', 'wpcms_post_control'),
		'#trackbacksdiv' => __('<strong style="color: #2583ad;">Post:</strong> Trackbacks', 'wpcms_post_control'),
		'#postcustom' => __('<strong style="color: #2583ad;">Post:</strong> Custom fields', 'wpcms_post_control'),
		'#commentstatusdiv' => __('<strong style="color: #2583ad;">Post:</strong> Discussion', 'wpcms_post_control'),
		'p.meta-options' => __('<strong style="color: #2583ad;">Post:</strong> Comment & ping options', 'wpcms_post_control'),
		'#authordiv' => __('<strong style="color: #2583ad;">Post:</strong> Author', 'wpcms_post_control'),
		'#pagecustomdiv' => __('<strong style="color: #2583ad;">Page:</strong> Custom fields', 'wpcms_post_control'),
		'#pagecommentstatusdiv' => __('<strong style="color: #2583ad;">Page:</strong> Discussion', 'wpcms_post_control'),
		'#pagecommentstatusdiv div.inside p label.selectit' => __('<strong style="color: #2583ad;">Page:</strong> Comment & ping options', 'wpcms_post_control'),
		'#pageparentdiv' => __('<strong style="color: #2583ad;">Page:</strong> Attributes', 'wpcms_post_control'),
		'#visibility' => __('<strong style="color: #d54e21;">Post &amp; Page:</strong> Publish visibility', 'wpcms_post_control'),
		'.misc-pub-section-last' => __('<strong style="color: #d54e21;">Post &amp; Page:</strong> Publish date', 'wpcms_post_control'),
		'#media-buttons' => __('<strong style="color: #d54e21;">Post &amp; Page:</strong> Media upload', 'wpcms_post_control'),
		'#revisionsdiv' => __('<strong style="color: #d54e21;">Post &amp; Page:</strong> Revisions menu', 'wpcms_post_control'),
		'#wp-word-count' => __('<strong style="color: #d54e21;">Post &amp; Page:</strong> Word count', 'wpcms_post_control'),
		'#screen-meta' => __('<strong style="color: #66CC00;">WORDPRESS 2.7&#43; Interface:</strong> Screen options dropdown', 'wpcms_post_control'),
		'#favorite-actions' => __('<strong style="color: #66CC00;">WORDPRESS 2.7&#43; Interface:</strong> Header new post/page etc dropdown', 'wpcms_post_control'),
		'#dashboard_quick_press' => __('<strong style="color: #66CC00;">WORDPRESS 2.7&#43; Interface:</strong> Dashboard QuickPress', 'wpcms_post_control'),
		'#footer' => __('<strong style="color: #66CC00;">WORDPRESS 2.7&#43; Interface:</strong> Footer', 'wpcms_post_control'),
		);
		
		
	return (array) $wpcms_post_control_ids;
}

function wpcms_post_control_css() {
	global $wpcmspc_options;
	$css_hidden_ids = array();
	foreach ( (array) $wpcmspc_options as $id => $val ) {
		if ( 0 == $val && wpcms_post_control_validate($id) )
			//$css_hidden_ids[] = '#' . $id; HARDCODING HASH IN NOW FOR MORE CONTROL
			$css_hidden_ids[] = $id;
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

function wpcms_post_control_message1() {
	if (get_option('wpcms_post_control_msg1ctrl') == 'y') {
		$msg1title = get_option('wpcms_post_control_msg1title');	
		$msg1text = get_option('wpcms_post_control_msg1text');	
		$msg1state = get_option('wpcms_post_control_msg1state');	
		echo "<div id=\"wpcms_message1\" class=\"postbox if-js-" . $msg1state . "\"><h3>" . $msg1title . "</h3><div class=\"inside\"><p>" . $msg1text . "</p></div></div>";
	} else {
	}
}


// GO DO POST CONTROL

add_action('admin_head', 'wpcms_post_control_css');
add_action('init', create_function('$a=0','load_plugin_textdomain("wpcms_post_control");'), 10);
add_filter('flash_uploader', 'wpcms_post_control_flashloader', 5);
add_action('init', 'wpcms_post_control_postrevisions', 1);
add_action('wp_print_scripts', 'wpcms_post_control_autosave');
add_action( 'edit_form_advanced', 'wpcms_post_control_message1');
add_action( 'edit_page_form', 'wpcms_post_control_message1');


// INSTALL OR CLEANUP ON ACTIVATION/DEACTIVATION

register_activation_hook(__FILE__,'set_wpcms_post_control_options');
register_deactivation_hook(__FILE__,'unset_wpcms_post_control_options');

function set_wpcms_post_control_options() {
	add_option('wpcms_post_control_admindisplay','y','Control what admin users see');
	add_option('wpcms_post_control_uploader','flash','Control what uploader to use');
	add_option('wpcms_post_control_revisions','y','Control post revisions');
	add_option('wpcms_post_control_autosave','y','Control auto saves');

//MESSAGE BOX 1
	add_option('wpcms_post_control_msg1ctrl','n','Message 1 display');
	add_option('wpcms_post_control_msg1title','Type your message box title here','Message 1 title');
	add_option('wpcms_post_control_msg1text','<b>Bold</b> and <i>italic</i> can be used','Message 1 text');
	add_option('wpcms_post_control_msg1state','open','Message 1 box state');
}

function unset_wpcms_post_control_options() {
	delete_option('wpcms_post_control_options');
	delete_option('wpcms_post_control_admindisplay');
	delete_option('wpcms_post_control_uploader');
	delete_option('wpcms_post_control_revisions');
	delete_option('wpcms_post_control_autosave');

// MESSAGE BOX 1
	delete_option('wpcms_post_control_msg1ctrl');
	delete_option('wpcms_post_control_msg1title');
	delete_option('wpcms_post_control_msg1text');
	delete_option('wpcms_post_control_msg1state');	
}

?>