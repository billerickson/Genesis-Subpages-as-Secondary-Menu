=== Genesis Subpages as Secondary Menu ===
Contributors: billerickson
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=2CT6DXD3NLGAS
Tags: menu, genesis, genesiswp, studiopress
Requires at least: 3.0
Tested up to: 3.2.1
Stable tag: 1.4

Replaces the manually managed Secondary Menu with one that automatically lists the current section's subpages. You must be using the Genesis Framework and have the Secondary Menu enabled (Genesis > Theme Settings > Navigation Settings).

== Description ==

Replaces the manually managed Secondary Menu with one that automatically lists the current section's subpages. You must be using the Genesis Framework and have the Secondary Menu enabled (Genesis > Theme Settings > Navigation Settings).

Simply activate the plugin, then go to a page with subpages. It should list all the subpages in the secondary menu. Navigating to a subpage will keep the same menu (it lists all subpages of top level page, not current page).

== Installation ==

1. Upload `genesis-subpages-as-secondary-menu` to the `/wp-content/plugins/` directory.
1. Activate the plugin through the *Plugins* menu in WordPress.
1. Go to Genesis > Theme Settings > Navigation Settings and ensure "Include Secondary Navigation Menu" is checked.


== Changelog ==

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