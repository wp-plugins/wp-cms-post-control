=== WP-CMS Post Control ===
Contributors: Jonnyauk, CMSBuilder 
Tags: post, page, metabox, cms
Requires at least: 2.9
Tested up to: 3.0-beta
Stable tag: 2.01

Hide unwanted items from different user levels when they are writing and editing posts and pages.

== Description ==

**Post Control** from <a href="http://wp-cms.com/">WordPress CMS Modifications</a> builds upon the new controls in WordPress 2.9 to give you complete control over your write options **for every user level/role**. It not only allows you to hides unwanted items like custom fields, trackbacks, revisions etc. but also gives you a whole lot more control over how WordPress deals with creating content. This helps you use WordPress more like a CMS, alowing you to totally customise what your users see and use.

Simplify the and customise the write post and page areas of WordPress and just show the controls you need. Great for de-cluttering - do you really need those pingback and trackback options for instance - now you can decide what users can see and use.

**New to version 2** is the ability to hide different items for each user role - administrator, editor, author and even contributor. Now you can decide and control every aspect of your users experience when editing content - whatever their role. 

An example would be where you only wanted administrators and editors to be able to see and change the excerpt or commenting options! With this plugin you can control this and much more.

You can control the display of the following post options for each role level:

* Post Tags
* Post Categories
* Post Excerpt
* Post Trackbacks
* Post Custom fields
* Post Discussion
* Post Comment & ping options
* Post Author

You can control the display of the following page options:

* Page Custom fields
* Page Discussion
* Page Comment & ping options
* Page Attributes

You can control the display of the following global post/page options:

* Post/Page Media upload
* Many more to come - including text editor and core function controls!

== Installation ==

= First time install =

1. Get the latest version of this plugin at the <a href="http://wordpress.org/extend/plugins/wp-cms-post-control/">official WordPress plugin directory</a>.
2. Decompress .zip file, retaining file structure.
3. Upload directory `wp-cms-post-control` and all containing files to the `/wp-content/plugins/` directory
4. Activate the plugin through the 'Plugins' menu in WordPress
5. Configure options through `Settings > Post Control`

= Update existing install =

The automatic plugin update feature of WordPress works fine with this plugin. If your server supports it you should certainly use this as it's the easiest way to keep your plugins up-to-date.

You should go to the options page and re-save your Post Control options to refresh the settings after an update.

== Frequently Asked Questions ==

= I'm using v2.0 and I have some error messages appear at the top of the screen. =

**YES!** Version 2.01 (and above) fixes this glitch - thanks for the feedback!

= I used versions of this plugin prior to v2 and sometimes the controls wouldn't re-appear once deactivated. =

**YES!** Version 2 (and above) is a complete re-write, using a new method to remove the controls. Because of this, these issues are now completely resolved.

= Can you change the options for any user role? =

**YES!** Administrators, editors, authors and contributors can all have different settings.

= Can devious users still reveal the controls if they are hidden using tools like Firebug? =

**NO!** All of the core controls are removed in a completely different way now - not just hidden with CSS. They can't be revealed by hacking the browser rendered CSS, as they are not even rendered to the page anywhere!

= What options get used if I hide a control - like pingbacks and trackbacks? =

The global options you set in the main WordPress options are used.

= What happens if I activate/deactivate this plugin? =

This plugin currently uses only one entry in your options table (some plugins create many entries). In v2.0 the options are set to be persistent - so if you deactivate the plugin and re-enable it, the settings will remain.

= I installed v.2.0 and I dont have autosave and other options =

These controls are going to be reinstated in future versions.

= It's not working! =

**Make sure you are using the latest version!** V2.0 is designed for WordPress 2.9 and above. If you are using a version older than that, you really should think about upgrading!

Ensure you have the plugin installed in the correct directory - you should have a directory called WP-CMS-post-control in your plugins directory.

= What you got planned? =

I've got quite a few things I'd like to do with this plugin, but don't hold your breath waiting for them to happen... you may burst!

= Wow, good work - I LOVE this plugin, and you did it all by yourself? =

What began as inherited code has now been completely re-written in v2.0 to use new methods and best practices in WordPress plugin development. The first codebase began as a plugin build by Brady J. Frey. I maintained this version for some time, but version 2 is a complete re-write from the ground up.

== Screenshots ==

1. The admin interface, showing what you can control with this plugin.
2. An example of a customised write/edit post - much simpler to use for all your users and clients!
3. An example of a customised write/edit page - much simpler to use for all your users and clients!

== Changelog ==

= 2.01 = 
* Tenth public release (20th March 2010)
* Fixed bug when values empty
* Amended data sanitisation input

= 2.0 = 
* Ninth public release (19th March 2010)
* Complete re-write of codebase = major efficiency improvements
* New code eliminates all previous reported user issues
* WordPress 2.9.2 compatibility updates
* Introduced multi-user level controls
* New remove media upload control

= v1.2.1 =
* Eighth public release (31st March 2009)
* WordPress 2.7 author control

= v1.2 =
* Seventh public release (17th December 2008)
* WordPress 2.7 compatibility build, re-write plugin controls to support new 'Crazy Horse' interface
* Fix basic text formatting in custom message box, remove strip slashes to allow basic formatting like <b> and <i> 
* Changed option array function for more control
* Changed formatting of plugin options buttons

= v1.11 =
* Sixth public release (6th September 2008)
* Option to hide editor sidebar shortcuts and 'Press It' function
* Remove redundant preview code
* Improved formatting for message box text and title input

= v1.1 =
* Development version (5th September 2008)
* Found potential conflict with options variables declared within a theme functions file
* Conflicting PHP variables for reference - 'options' and 'newoptions'
* Should solve conflicts with wrongly coded variables from other plugins/themes

= v1.03 =
* Fifth public release (4th September 2008)
* Fix the bug introduced in v1.02 that broke the form fields
* After comments feedback, changed and documented admin control

= v1.02  =
* Forth public release (3rd September 2008)
* Bug catches, may help plugin compatibility on different servers

= v1.01 =
* Third public release (2nd August 2008)
* Option to insert message panel
* General tidying on admin page

= v1.0  =
* Development version (1st August 2008)
* Option to disable post and page revisions
* Option to disable autosaves

= v0.4  =
* Development version (1st August 2008)
* Option to select uploader (Flash or standard)
* Option to hide revisions control
* Option to hide word count
* Option to hide Advanced Options header
* Fixed page custom field control
* Redesigned admin page

= v0.3 =
* Second public release (28th July 2008)
* Introduced Admin user control.

= v0.2 =
* First public release (26th July 2008)
* Included clean-up of database on de-activation.

== Upgrade Notice ==

= 2.0 =
Please upgrade to the latest version with full WordPress 2.9 and above compatibility and to fix previous user issues reported.