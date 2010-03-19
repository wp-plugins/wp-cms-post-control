<?php
/*
Plugin Name: WP-CMS Post Control
Version: 2.0
Plugin URI: http://wp-cms.com/our-wordpress-plugins/post-control/
Description: Hides unwanted items within the write/edit page and post admin area, including individual controls for different user levels.
Author: Jonny Allbut - Jonnya Creative WordPress Consultant
Author URI: http://jonnya.net
License: GPL
*/

/*

=== VERSION HISTORY ===

0.1 Jul 2008	- First version, non-public beta testing version
0.2 Jul 2008	- Public release 1
0.3 Jul 2008	- Public release 2
0.4 Aug 2008	- Development version
1.00 Aug 2008	- Development version
1.01 Aug 2008	- Public release 3
1.02 Sept 2008	- Public release 4
1.03 Sept 2008	- Public release 5
1.1 Sept 2008	- Development version
1.11 Sept 2008	- Public release 6
1.2 Dec 2008	- Public release 7
1.2.1 Mar 2009	- Public release 8
2.0 Mar 2010	- Public release 9

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

2.0		- Complete re-write of codebase = major efficiency improvements
		- New code eliminates all previous reported user issues
		- WordPress 2.9.2 compatibility updates
		- Introduced multi-user level controls
		- New remove media upload control

*/


/**
* Setup Post Control
*
* @since 2.001
* @lastupdate 2.001
* 
*/
function wpcms_pcontrol_init(){
	register_setting( 'wpcms_pcontrol_options', 'wpcms_pcontrolopts', 'wpcms_pcontrol_validate' );
}


/**
* Run Post Control
*
* @since 2.001
* @lastupdate 2.003
* 
*/
function wpcms_pcontrol_run() {

	include("inc/wp-cms-class-pcontrol.php");
	$wpcms_pcontrol_doit = new wpcms_pcontrol;

	// Just load what we need when we need it
	
	add_action('load-page.php', array($wpcms_pcontrol_doit, 'pccore_page'));
	add_action('load-page-new.php', array($wpcms_pcontrol_doit, 'pccore_page'));
	add_action('load-post.php', array($wpcms_pcontrol_doit, 'pccore_post'));
	add_action('load-post-new.php', array($wpcms_pcontrol_doit, 'pccore_post'));
}


/**
* Adds options page
*
* @since 2.001
* @lastupdate 2.003
* 
*/
function wpcms_pcontrol_add_page() {
	// Access level is set here - level 10 = admin only, could change if required!
	add_options_page('WP-CMS Post Control Options', 'Post Control', 10, 'wpcms_pcontrol', 'wpcms_pcontrol_do_page');
}


/**
* Add link to plugins listing to jump to admin
*
* @since 2.005
* @lastupdate 2.007
* 
*/
function wpcms_pcontrol_meta($links, $file) {
 
	$plugin = plugin_basename(__FILE__);
 
	// create link
	if ($file == $plugin) {
		return array_merge(
			$links,
			array( sprintf( '<a href="options-general.php?page=wpcms_pcontrol">Post Control settings</a>', $plugin, __('Post Control Settings') ) )
		);
	}
	return $links;
}


/**
* Options page content
*
* @since 2.005
* @lastupdate 2.015
* 
*/
function wpcms_pcontrol_do_page() { ?>
	
	<div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div>
		<h2>WP-CMS Post Control</h2>
					
		<form method="post" action="options.php">
			<?php
			//Output nonce, action, and option_page fields for a settings page
			// @param string $option_group A settings group name. IMPORTANT - This should match the group name used in register_setting()
			settings_fields('wpcms_pcontrol_options');
			?>

			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Post Control options') ?>" />
			</p>
			
			<?php $options = get_option('wpcms_pcontrolopts'); ?>
				
			<div id="icon-themes" class="icon32"><br /></div>
			<h2>Page Controls</h2>
			<p>Check option <strong>to hide create/edit page controls </strong> available to different <a href="http://codex.wordpress.org/Roles_and_Capabilities" title="WordPress roles and capabilities">user roles</a>.</p>
			<p>Page creation and editing is only available to administrator and editor level users.</p>

	
			<table class="form-table">
			
				<?php
				$mypagecontrols = array(
				'Attributes' => 'pageparentdiv', 
				'Author' => 'pageauthordiv', 
				'Custom Fields' => 'postcustom',
				'Discussion' => 'commentstatusdiv', 
				'Revisions' => 'revisionsdiv'
				);		
	
				//Generate form from array
				foreach($mypagecontrols as $key => $value) { ?>		
				
				<tr>
					<th scope="row"><?php echo $key; ?></th>
					<td>
					<fieldset>
					<legend class="screen-reader-text"><span><?php echo $key; ?></span></legend>
	
						<label for="wpcms_pcontrolopts[<?php echo $value; ?>_page_administrator]">
						<input name="wpcms_pcontrolopts[<?php echo $value; ?>_page_administrator]" type="checkbox" id="<?php echo $value; ?>" value="<?php echo $value; ?>" <?php checked(''.$value.'', $options[''.$value.'_page_administrator']); ?> />
						Administrator
						</label>
	
						<label for="wpcms_pcontrolopts[<?php echo $value; ?>_page_editor]">
						<input name="wpcms_pcontrolopts[<?php echo $value; ?>_page_editor]" type="checkbox" id="<?php echo $value; ?>" value="<?php echo $value; ?>" <?php checked(''.$value.'', $options[''.$value.'_page_editor']); ?> />
						Editor
						</label>
						
					</fieldset></td>
				</tr>
				
				<?php 
				}
				?>
			
			</table>

			
			<div id="icon-themes" class="icon32"><br /></div>
			<h2>Post Controls</h2>
			<p>Check option <strong>to hide create/edit post controls </strong> available to different <a href="http://codex.wordpress.org/Roles_and_Capabilities" title="WordPress roles and capabilities">user roles</a>.</p>
	
			<table class="form-table">
			
				<?php
				$mypostcontrols = array( 
				'Author' => 'authordiv',
				'Category' => 'categorydiv', 
				'Comments' => 'commentsdiv', 
				'Custom fields' => 'postcustom', 
				'Discussion' => 'commentstatusdiv', 
				'Excerpt' => 'postexcerpt', 
				'Revisions' => 'revisionsdiv', 
				'Tags' => 'tagsdiv-post_tag', 
				'Trackbacks' => 'trackbacksdiv'
				);		
				
				//Generate form from array
				foreach($mypostcontrols as $key => $value) { ?>
				
				<tr>
					<th scope="row"><?php echo $key; ?></th>
					<td>
					<fieldset>
					<legend class="screen-reader-text"><span><?php echo $key; ?></span></legend>
	
						<label for="wpcms_pcontrolopts[<?php echo $value; ?>_post_administrator]">
						<input name="wpcms_pcontrolopts[<?php echo $value; ?>_post_administrator]" type="checkbox" id="<?php echo $value; ?>" value="<?php echo $value; ?>" <?php checked(''.$value.'', $options[''.$value.'_post_administrator']); ?> />
						Administrator
						</label>
	
						<label for="wpcms_pcontrolopts[<?php echo $value; ?>_post_editor]">
						<input name="wpcms_pcontrolopts[<?php echo $value; ?>_post_editor]" type="checkbox" id="<?php echo $value; ?>" value="<?php echo $value; ?>" <?php checked(''.$value.'', $options[''.$value.'_post_editor']); ?> />
						Editor
						</label>
						
						<label for="wpcms_pcontrolopts[<?php echo $value; ?>_post_author]">
						<input name="wpcms_pcontrolopts[<?php echo $value; ?>_post_author]" type="checkbox" id="<?php echo $value; ?>" value="<?php echo $value; ?>" <?php checked(''.$value.'', $options[''.$value.'_post_author']); ?> />
						Author
						</label>
						
						<label for="wpcms_pcontrolopts[<?php echo $value; ?>_post_contributor]">
						<input name="wpcms_pcontrolopts[<?php echo $value; ?>_post_contributor]" type="checkbox" id="<?php echo $value; ?>" value="<?php echo $value; ?>" <?php checked(''.$value.'', $options[''.$value.'_post_contributor']); ?> />
						Contributor
						</label>
						
					</fieldset></td>
				</tr>
				
				<?php 
				}
				?>
			
			</table>


			<div id="icon-tools" class="icon32"><br /></div>
			<h2>Advanced Controls</h2>
			<p>These options apply <strong>to all edit screens</strong> available to different <a href="http://codex.wordpress.org/Roles_and_Capabilities" title="WordPress roles and capabilities">user roles</a>.</p>
	
			<table class="form-table">
			
				<?php
				$mywpcorecontrols = array(
				'Remove media upload' => 'media_buttons'
				);		
	
				//Generate form from array
				foreach($mywpcorecontrols as $key => $value) { ?>		
				
				<tr>
					<th scope="row"><?php echo $key; ?></th>
					<td>
					<fieldset>
					<legend class="screen-reader-text"><span><?php echo $key; ?></span></legend>
	
						<label for="wpcms_pcontrolopts[<?php echo $value; ?>_wpcore_administrator]">
						<input name="wpcms_pcontrolopts[<?php echo $value; ?>_wpcore_administrator]" type="checkbox" id="<?php echo $value; ?>" value="<?php echo $value; ?>" <?php checked(''.$value.'', $options[''.$value.'_wpcore_administrator']); ?> />
						Administrator
						</label>
	
						<label for="wpcms_pcontrolopts[<?php echo $value; ?>_wpcore_editor]">
						<input name="wpcms_pcontrolopts[<?php echo $value; ?>_wpcore_editor]" type="checkbox" id="<?php echo $value; ?>" value="<?php echo $value; ?>" <?php checked(''.$value.'', $options[''.$value.'_wpcore_editor']); ?> />
						Editor
						</label>
						
						<label for="wpcms_pcontrolopts[<?php echo $value; ?>_wpcore_author]">
						<input name="wpcms_pcontrolopts[<?php echo $value; ?>_wpcore_author]" type="checkbox" id="<?php echo $value; ?>" value="<?php echo $value; ?>" <?php checked(''.$value.'', $options[''.$value.'_wpcore_author']); ?> />
						Author
						</label>
						
						<label for="wpcms_pcontrolopts[<?php echo $value; ?>_wpcore_contributor]">
						<input name="wpcms_pcontrolopts[<?php echo $value; ?>_wpcore_contributor]" type="checkbox" id="<?php echo $value; ?>" value="<?php echo $value; ?>" <?php checked(''.$value.'', $options[''.$value.'_wpcore_contributor']); ?> />
						Contributor
						</label>
						
					</fieldset></td>
				</tr>
				
				<?php 
				}
				?>
			
			</table>

	
			<?php /*		
			DONT NEED THIS ANY MORE WITH WPCORE settings_fields()
			<input type="hidden" name="wpcms_pcontrol_nonce" value="<?php echo wp_create_nonce('wpcms_pcontrol_nonce'); ?>" />
			*/
			?>
			
			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Post Control options') ?>" />
			</p>
	
		</form>
		
			<div id="icon-edit-comments" class="icon32"><br /></div>
			<h2>Get new features and updates quicker!</h2>
			<p>I have built and maintained this plugin for nearly two years, and share it with you at no cost. You can use it on as many websites as you like, even commercial ones without any credit or payment required.</p>
			<p>I have loads of very cool new features planned too for the future of this plugin, but sadly I can only give so much of my time away for free!</p>
			<p><strong>However, you may consider making a small donation through PayPal or your credit/debit card</strong> - treats and goodies make me code faster!</p> 		
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="2XJCF5U6KUNTC">
			<table>
			<tr><td><input type="hidden" name="on0" value="Fuel Jonny and get new features quicker - this plugin is free!"></td></tr><tr><td><select name="os0">
				<option value="Dontate sweets">Dontate sweets &pound;1.00</option>
				<option value="Donate cake">Donate cake &pound;5.00</option>
				<option value="Donate steak">Donate steak &pound;10.00</option>
				<option value="Donate goodies">Donate goodies &pound;25.00</option>
				<option value="Ultimate karma">Ultimate karma &pound;50.00</option>
			</select> </td></tr>
			</table>
			<input type="hidden" name="currency_code" value="GBP">
			<input type="image" src="https://www.paypal.com/en_US/GB/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
			<img alt="" border="0" src="https://www.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1">
			</form>
			<p><strong>Money dontated since last Plugin update:</strong> Not even enough for <a href="http://twitpic.com/ydoj1" title="Kimmy">Kimmy&rsquo;s</a> treats!</p>

			<div id="icon-edit-comments" class="icon32"><br /></div>
			<h2>More Information</h2>
			<p><strong>Having problems?</strong> <a href="http://wp-cms.com/our-wordpress-plugins/post-control/" title="Visit the Post Control homepage">Drop by the plugin homepage</a> and leave a comment at <a href="http://wp-cms.com" title="WP-CMS website">http://wp-cms.com</a></p>
			<p><strong>Developed and maintained by:</strong> <a href="http://jonnya.net" title="I make WordPress ZOOM!">Jonnya Creative WordPress Consultant</a>, see a few of the <a href="http://jonnya.net/tools/wordpress/" title="Some of the custom WordPress sites I've built">WordPresss sites I've built</a>.</p>
			<p><strong>Coming June 2010, my new FREE WordPress theme framework:</strong> <a href="http://wonderflux.com" title="Wonderflux Framework">Wonderflux</a></p>		
			
	</div>

<?php }


/**
* Saves data from form
*
* @since 2.005
* @lastupdate 2.016
* 
*/
function wpcms_pcontrol_validate($input) {	

	// PAGE OPERATIONS 
	$pc_administrator_pageopsall = array();
	$pc_editor_pageopsall = array();
	
	foreach($input as $key => $value) {

		$adminmatch = "/_page_administrator/";
		$editormatch = "/_page_editor/";
		
		if (preg_match($adminmatch, $key)) {
		    $pc_administrator_pageopsall[] = $value;
	
		} elseif (preg_match($editormatch, $key)) {
			$pc_editor_pageopsall[] = $value;
	
		}
		
	}
	
	$input['pc_administrator_pageops'] = $pc_administrator_pageopsall;
	$input['pc_editor_pageops'] = $pc_editor_pageopsall;
	
	// POST OPERATIONS 
	$pc_administrator_postopsall = array();
	$pc_editor_postopsall = array();
	$pc_author_postopsall = array();
	$pc_contributor_postopsall = array();
	
	foreach($input as $key => $value) {

		$adminmatch = "/_post_administrator/";
		$editormatch = "/_post_editor/";
		$authormatch = "/_post_author/";
		$contributormatch = "/_post_contributor/";	
		
		if (preg_match($adminmatch, $key)) {
		    $pc_administrator_postopsall[] = $value;
		    //print_r($pc_administrator_postopsall);
	
		} elseif (preg_match($editormatch, $key)) {
			$pc_editor_postopsall[] = $value;
	
		} elseif (preg_match($authormatch, $key)) {
			$pc_author_postopsall[] = $value;
	
		} elseif (preg_match($contributormatch, $key)) {
			$pc_contributor_postopsall[] = $value;
	
		}
	
	}
	
	$input['pc_administrator_postops'] = $pc_administrator_postopsall;
	$input['pc_editor_postops'] = $pc_editor_postopsall;
	$input['pc_author_postops'] = $pc_author_postopsall;
	$input['pc_contributor_postops'] = $pc_contributor_postopsall;
	
	// CORE FUNCTION OPERATIONS 
	$pc_administrator_wpcoreopsall = array();
	$pc_editor_wpcoreopsall = array();
	$pc_author_wpcoreopsall = array();
	$pc_contributor_wpcoreopsall = array();
	
	foreach($input as $key => $value) {

		$adminmatch = "/_wpcore_administrator/";
		$editormatch = "/_wpcore_editor/";
		$authormatch = "/_wpcore_author/";
		$contributormatch = "/_wpcore_contributor/";	
		
		if (preg_match($adminmatch, $key)) {
		    $pc_administrator_wpcoreopsall[] = $value;
	
		} elseif (preg_match($editormatch, $key)) {
			$pc_editor_wpcoreopsall[] = $value;
	
		} elseif (preg_match($authormatch, $key)) {
			$pc_author_wpcoreopsall[] = $value;
	
		} elseif (preg_match($contributormatch, $key)) {
			$pc_contributor_wpcoreopsall[] = $value;

		}
	
	}
	
	$input['pc_administrator_wpcoreops'] = $pc_administrator_wpcoreopsall;
	$input['pc_editor_wpcoreops'] = $pc_editor_wpcoreopsall;
	$input['pc_author_wpcoreops'] = $pc_author_wpcoreopsall;
	$input['pc_contributor_wpcoreops'] = $pc_contributor_wpcoreopsall;
	
	return $input;
}


add_action('admin_init', 'wpcms_pcontrol_run');
add_action('admin_init', 'wpcms_pcontrol_init' );
add_action('admin_menu', 'wpcms_pcontrol_add_page');
add_filter( 'plugin_row_meta', 'wpcms_pcontrol_meta', 10, 2 );


?>
