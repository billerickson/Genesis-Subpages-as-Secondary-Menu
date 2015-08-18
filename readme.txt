=== Genesis Subpages as Secondary Menu ===
Contributors: billerickson
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=2CT6DXD3NLGAS
Tags: menu, genesis, genesiswp, studiopress
Requires at least: 3.0
Tested up to: 4.3
Stable tag: 2.0

Replaces the Genesis Secondary Menu with a dynamic listing of the current section's subpages. You must be using the Genesis Theme.

== Description ==

Replaces the Genesis Secondary Menu with a dynamic listing of the current section's subpages. You must be using the Genesis Theme Framework, and your child theme must support the Secondary Menu theme location.

Simply activate the plugin, then go to a page with subpages. It should list all the subpages in the secondary menu. Navigating to a subpage will keep the same menu (it lists all subpages of top level page, not current page).

If you go to Appearance > Menus, it will show the Secondary Menu location as currently set to "Genesis Subpages".

Want a similar listing in your sidebar? Use my [BE Subpages Widget](https://wordpress.org/plugins/be-subpages-widget/) plugin

[Support Forum](https://github.com/billerickson/Genesis-Subpages-as-Secondary-Menu/issues) | [View all plugins by Bill Erickson](http://www.billerickson.net/contributions/plugins/)

== Installation ==

1. Upload `genesis-subpages-as-secondary-menu` to the `/wp-content/plugins/` directory.
1. Activate the plugin through the *Plugins* menu in WordPress.


== Changelog ==

= Version 2.0 = 
* Completely rewritten from the ground up. Code is cleaner and improved performance
* In the Menus section, the secondary menu is now marked as active with "Genesis Subpages" to improve usability

= Version 1.8 = 
* Fixed typo that prevented secondary menu from appearing

= Version 1.7 =
* Improve HTML5 Support

= Version 1.6 =
* Add support for Genesis 2.0 menus

= Version 1.5 = 
* Display subnav when using Genesis 1.9 or later

= Version 1.4 =
* Wrap menu items in unordered list, and make the ul filterable ( be_genesis_subpages_wrapper )

= Version 1.3 =
* Prevents you from activating plugin if you're not using Genesis 
* Only display subnav if there are subpages, props dburns

= Version 1.2 =
* Fixed an error where the subnav could change the active page you're on. 

= Version 1.1 =
* Fixed an error when running in debug mode and on a non-page
* Added 'be_genesis_subpages_args' filter so that you can modify the page arguments.

= Version 1.0 =
* This is version 1.0.  Everything's new!

== Upgrade Notice ==

= 1.2 = 
Upgrade fixes an error that can cause the subnav to change the active page you're on. Please upgrade.