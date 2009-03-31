=== WP-CMS Post Control ===
Contributors: CMSBuilder Jonnya PeteInnes

Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=contact%40jonnya%2enet&item_name=WP%2dCMS%20Post%20Control%20Plugin%20donation&page_style=PayPal&no_shipping=1&cn=Your%20comments&tax=0&currency_code=GBP&lc=GB&bn=PP%2dDonationsBF&charset=UTF%2d8
Tags: cms, post, page, revisions, autosave, disable revision, disable autosave
Requires at least: 2.7
Tested up to: 2.7.1
Stable tag: 1.21

Complete control over write post/pages admin - hide all unwanted items, disable flash upload, post revisions, autosave & add a personal message.

== Description ==

**Post Control** from <a href="http://wp-cms.com/">WordPress CMS Modifications</a> builds upon the new controls in WordPress 2.7 to give you complete control over your write options. It not only allows you to hides unwanted items like custom fields, trackbacks, revisions etc. but also gives you a whole lot more control over how WordPress deals with creating content! This helps you use WordPress more like a CMS, alowing you to totally customise what your authors see and use.

The latest version of Post Control covers all features of WordPress 2.7 and is a substantial upgrade over the previous version - including full admin over-ride of hidden panels from users of lower levels.

**IMPORTANT - If you are still using WordPress 2.6.x you can use the <a href="http://downloads.wordpress.org/plugin/wp-cms-post-control.1.11.zip">previous stable release</a> of this plugin that was designed for full compatibility with WordPress v2.5-2.6.3**

With this plugin you can control the following advanced options:

* Force standard browser upload instead of Flash upload - great if you are having trouble with the Flash uploader, this stops you needing to select 'browser uploader' every time if the Flash uploader doesn't work for you!

* Turn off the revisions feature completely, some people don't want to use this. This is great when you are developing a site - why clutter up your database with loads of revisions when you don't need them! Just turn them off whilst you are developing the site, then turn back on if you want the functionality back on site launch!

* Turn off the auto save feature, some people have problems with this or don't wish to be interrupted as they type.

* Create a collapsable message panel that appears below the write panel, allowing you to show messages to authors.

* Hide the Screen Options and Help dropdown introduced in WordPress 2.7

* Hide the favorites dropdown in the admin header introduced in WordPress 2.7

* Hide the Dashboard QuickPress panel introduced in WordPress 2.7

You can control the display of the following post options:

* Post: Preview button
* Post: Permalink
* Post: Tags
* Post: Categories
* Post: Excerpt
* Post: Trackbacks
* Post: Custom fields
* Post: Discussion
* Post: Comment & ping options

You can control the display of the following page options:

* Page: Custom fields
* Page: Discussion
* Page: Comment & ping options
* Page: Attributes

You can control the display of the following global post/page options:

* Post & Page: Publish visibility
* Post & Page: Publish date
* Post & Page: Media upload
* Post & Page: Revisions menu
* Post & Page: Word count

We love WordPress, and think it makes a fantastic CMS - this plugin goes one step further to making WordPress behave more like a CMS and a-little less like a blog! Some of the options are confusing for many people (or they simply don't use them!), so make their lives simple by using *Post Control*!


**This plugin builds upon some great work by** Brady J. Frey, Mark Jaquith. Many thanks to Pete Innes for bug swatting, testing and fresh eyes on the code!


== Installation ==

= First time install =

1. Get the right version of this plugin! The latest version is designed for WordPress 2.7 and above - use V1.11 for older versions of WordPress down to 2.5
2. Decompress .zip file, retaining file structure.
3. Upload directory `wp-cms-post-control` and all containing files to the `/wp-content/plugins/` directory
4. Activate the plugin through the 'Plugins' menu in WordPress
5. Configure options through `Settings > Post Control`

**NOTE** You can just upload the file `wp-cms-post-control.php` to your `/wp-content/plugins/` directory. Hoever, when using the WordPress plugin auto-update, I noticed that it installs it in a folder and deletes a single file install - so I guess it may be more compatible to upload the whole thing within different hosting environments to improve update compatibility.

= Update existing install =

1. Deactivate Post Control plugin (clears preferences from database on de-activation)
2. Replace old version of `wp-cms-post-control` directory with new version on server
3. Re-activate it on your plugin management page
4. Configure options through `Settings > Post Control`

= WordPress automatic update =

The automatic plugin update feature of WordPress works fine with this plugin. If your server supports it you should certainly use this as it's the easiest way to keep your plugins up-to-date.

You should de-activate the plugin first, as this will ensure that the correct options are set/cleaned-up in the database (especially important as new featues are rolled out to the plugin).

If you have problems, de-activating, then re-activating after update should sort it out for you.

== Frequently Asked Questions ==

= What happens to the options I set under 'screen options' in WordPress 2.7 and above? =

This plugin over-rides these settings, so it's probably best to hide this menu using the plugin options page.

= There's a bunch of funny code in the form fields in the options page - that's not right is it? =

**NO!** There was a bug in v1.02 of this plugin, this has now been fixed in v1.03 and above. Please download the latest version from the link on the right.

= Can you change the options for the admin user/different users? =

**YES!** This was introduced in v0.3.

= If I hide things like comments, what options get set? =

If you hide these options using this plugin, the options default to what you have got your main WordPress options to under 'Settings'.

= What happens if I activate/deactivate this plugin? =

The Post Control plugin doesn't modify any core settings or files and it's options are stored in the database options table, which are deleted when you de-activate the plugin. I like well behaved plugins that don't leave loads of junk in your database!

= Can I put code in the message panel =

No, you can only put simple text in the message panel for security reasons. However, you can format your text using simple tagging like bold and italic.

= It's not working! =

**Make sure you are using the latest version!** V1.2 is designed for WordPress 2.7 and above, V1.11 is designed to run on WordPress 2.5 to Wordpress 2.6.3

If it still doesn't work for you, try de-activating, then re-activate the plugin. It behaves well and cleans-up after itself, so this will delete all database options entries created by the plugin and create you a new set. Also you might try hitting refresh in your browser to ensure the plugins CSS control is being used by your browser.

= What you got planned? =

I've got quite a few things I'd like to do with this plugin, but don't hold your breath waiting for them to happen... you may burst!

= Wow, good work - I LOVE this plugin, and you did it all by yourself? =

*The simple answer is no*, the code of this plugin started as <a href="http://txfx.net/code/wordpress/clutter-free/">Clutter-Free</a> by <a href="http://txfx.net/">Mark Jaquith</a>, modified and bought up-to-date by <a href="http://www.bradyjfrey.com/">Brady J. Frey</a>.

Brady kindly offered to pass over development of his version of the plugin called 'Cloak' to me, so I could maintain it and update it with new features and incorporate it into the WordPress plugin repository for the good of the whole WordPress community. I loved the name 'Cloak', but I intend to extend it to do more than just hide stuff, so thought I'd give it a more descriptive title!

It has since expanded to include more options and cover the latest version of WordPress. I have also added a range of new controls that go way above and beyond what Cloak did, and have more planned for the future!

== Screenshots ==

1. The admin interface, showing what you can control with this plugin.
2. An example of a customised write panel - much simpler to use for all your authors and clients!

== Development Notes ==

= v0.2 - First public release (26th July 2008) =

- Included clean-up of database on de-activation.

= v0.3 - Second public release (28th July 2008) =

- Introduced Admin user control.

= v0.4 - Development version (1st August 2008) =

- Option to select uploader (Flash or standard)
- Option to hide revisions control
- Option to hide word count
- Option to hide Advanced Options header
- Fixed page custom field control
- Redesigned admin page

= v1.0 - Development version (1st August 2008) =

- Option to disable post and page revisions
- Option to disable autosaves

= v1.01 - Third public release (2nd August 2008) =

- Option to insert message panel
- General tidying on admin page

= v1.02 - Forth public release (3rd September 2008) =

- Bug catches, may help plugin compatibility on different servers

= v1.03 - Fifth public release (4th September 2008) =

- Fix the bug introduced in v1.02 that broke the form fields
- After comments feedback, changed and documented admin control

= v1.1 - Development version (5th September 2008) =
- Found potential conflict with options variables declaired within a theme functions file
- Confilicting PHP variables for reference - 'options' and 'newoptions'
- Should solve conflicts with wrongly coded variables from other plugins/themes
		
= v1.11 - Sixth public release (6th September 2008) =
- Option to hide editor sidebar shortcuts and 'Press It' function
- Remove redundant preview code
- Improved formatting for message box text and title input

= v1.2 - Seventh public release (17th December 2008) =
- WordPress 2.7 compatibility build, re-write plugin controls to support new 'Crazy Horse' interface
- Fix basic text formatting in custom message box, remove strip slashes to allow basic formatting like <b> and <i> 
- Changed option array function for more control
- Changed formatting of plugin options buttons

= v1.21 - Eighth public release (31st March 2009) =
- WordPress 2.7 author control