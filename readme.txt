=== WP-CMS Post Control ===Contributors: CMSBuilder
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=contact%40jonnya%2enet&item_name=WP%2dCMS%20Post%20Control%20Plugin%20donation&page_style=PayPal&no_shipping=1&cn=Your%20comments&tax=0&currency_code=GBP&lc=GB&bn=PP%2dDonationsBF&charset=UTF%2d8
Tags: post, page, postsRequires at least: 2.5Tested up to: 2.6Stable tag: 0.3Post Control hides unwanted items on the write page and write post pages within WordPress, eg custom fields, trackbacks etc.
== Description ==

**Post Control** from <a href="http://wp-cms.com/">WordPress CMS Modifications</a> hides unwanted items on the write page and write post pages within WordPress, eg custom fields, trackbacks etc. This helps you use WordPress more like a CMS, alowing you to totally customise what you want authors to see and use.

**v0.3 introduces the ability to control what Admin level users see** - either all standard post options or the selected Post Control options.

We love WordPress, and think it makes a fantastic CMS - this plugin goes one step further to making WordPress behave more like a CMS and a-little less like a blog! Some of the options are confusing for many people (or they simply don't use them!), so make their lives simple by using *Post Control*!

**This plugin builds upon some great work by** Brady J. Frey, Owen Winker, Mark Jaquith and Achim Staebler.

You can control the display of the following options:* Post - Preview Button* Post - Permalink* Post - Tags* Post - Categories* Post - Excerpt* Post - Trackbacks* Post - Custom Fields* Post - Comments & Pings* Post - Password Protect This Post* Post - Author* Page - Custom Fields* Page - Comments & Pings* Page - Password Protect This Page* Page - Parent* Page - Template* Page - Order* Page - Author* Post & Page - Media Upload* Post & Page - Footer== Installation ==

= First time install =

1. Decompress .zip file, retaining file structure.2. Upload directory `wp-cms-post-control` and all containing files to the `/wp-content/plugins/` directory3. Activate the plugin through the 'Plugins' menu in WordPress4. Configure options through `Settings > Post Control`

**NOTE** You can just upload the file `wp-cms-post-control.php` to your `/wp-content/plugins/` directory. Hoever, when using the WordPress plugin auto-update, I noticed that it installs it in a folder and deletes a single file install - so I guess it may be more compatible to upload the whole thing within different hosting environments to improve update compatibility.

= Update =

1. Deactivate Post Control plugin (clears preferences from database on de-activation)
2. Replace old version of `wp-cms-post-control` directory with new version on server
3. Re-activate it on your plugin management page
4. Configure options through `Settings > Post Control`

= WordPress automatic update =

The automatic plugin update feature of WordPress works fine with this plugin. If your server supports it you should certainly use this as it's the easiest way to keep your plugins up-to-date.

You should de-activate the plugin first, as this will ensure that the correct options are set/cleaned-up in the database (especially important as new featues are rolled out to the plugin).

If you have problems, de-activating, then re-activating after update should sort it out for you.== Frequently Asked Questions ==

= Wow, good work - I LOVE this plugin, and you did it all by yourself? =*The simple answer is no*, the code of this plugin started as <a href="http://txfx.net/code/wordpress/clutter-free/">Clutter-Free</a> by <a href="http://txfx.net/">Mark Jaquith</a>, modified and bought up-to-date by <a href="http://www.bradyjfrey.com/">Brady J. Frey</a>, who introduced some magic from Achim Staebler and the 'Kill Preview' functionality by Owen Winkler.

Brady kindly offered to pass over development of his version of the plugin called 'Cloak' to me, so I could maintain it and update it with new features and incorporate it into the WordPress plugin repository for the good of the whole WordPress community. I loved the name 'Cloak', but I intend to extend it to do more than just hide stuff, so thought I'd give it a more descriptive title!= Can you change the options for the admin user/different users? =**YES!** This was introduced in v0.3.

= If I hide things like comments, what options get set? =If you hide these options using this plugin, the options default to what you have got your main WordPress options to.

= It's not working! =Hit refresh in your browser to ensure the plugins CSS control is being used by your browser.
= What you got planned? =I've got quite a few things I'd like to do with this plugin, but don't hold your breath waiting for them to happen... you may burst!

* 'Insert notes' option
* Control revisions display
* Force upload type to default to non-Flash option
* Control over tinyMCE editor
* Insert new 'save/publish' buttons in admin, because I don't like the new placement in 2.5+== Screenshots ==

1. The admin interface, showing what you can control with this plugin.2. An example of a customised write panel - much simpler to use!

== Development Notes ==

*v0.2*
**First public release (26th July 2008)**

*v0.3*
**Second public release (26th July 2008)**
* Introduced Admin user control.