=== oik-presentation ===
Contributors: bobbingwide
Donate link: https://www.oik-plugins.com/oik/oik-donate/
Tags: shortcodes, smart, lazy, custom post type, CPT
Requires at least: 5.2
Tested up to: 6.4.1
Stable tag: 2.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: oik-presentation
Domain Path: /languages/

== Description ==
A custom post type for creating presentations using WordPress
Use in conjunction with the oobit theme.


== Installation ==
1. Upload the contents of the oik-presentation plugin to the `/wp-content/plugins/oik-presentation' directory
1. Activate the oik-presentation plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

== Screenshots ==
1. oik-presentation in action

== Upgrade Notice ==
= 2.0.1 =
Update for support for PHP 8.1 and PHP 8.2 

= 2.0.0 = 
Upgrade to support the WordPress block editor. 
You may also need to upgrade the theme to oobit v2.0.0.

= 1.1 = 
Depends on oik base plugin v2.1-alpha or higher and oik-fields v1.19.0905 or higher

= 1.0 =
Depends on oik and oik-fields

== Changelog == 
= 2.0.1 =
* Changed: Add PHPUnit tests for support PHP 8.1 and PHP 8.2,,[github bobbingwide oik-presentation issues 3]
* Tested: With WordPress 6.4.1 and WordPress Multisite
* Tested: With PHP 8.1 and PHP 8.2
* Tested: With PHPUnit 9.6

= 2.0.0 = 
* Changed: Support the WordPress block editor,[github bobbingwide oik-presentation issues 1]
* Changed: Eliminate most of the code in oik_presentation_footer,[github bobbingwide oik-presentation issues 2]
* Changed: Now depends on oik v3.3.7 and oik-fields v1.51.0
* Tested: With WordPress 5.2 and WordPress Multi Site
* Tested: With WordPres 5.3-RC2
* Tested: With PHP 7.3

= 1.1 =
* Added: Implements action hook "oik_presentation_footer"
* Added: Implements action hook "oik_presentation_navigation"
* Added: dependency checking logic
* Added: partially enabled i18n 

= 1.0 =
* Added: New plugin developed for WordCamp UK 2012

== Further reading ==
If you want to read more about the oik plugins then please visit the
[oik plugin](https://www.oik-plugins.com/oik) 
**"the oik plugin - for often included key-information"**

