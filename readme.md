=== Bangla Date and Time ===
Contributors: mitcmt
Plugin Site: http://mithu.me/
Tags: bangla, date, time, comments, post, widget, bongabdo
Requires at least: 2.8
Tested up to: 3.8.1
Stable tag: 1.9
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A very useful plugin to convert all Latin number to Bangla number throughout your blog.


== Description ==

Bangla Date and Time simply replace all Latin number with Bangla number to your Bangla blog. For that, once you activate the plugin, all the number will be shown in Bangla. Automatically date and time will be changed to Bangla for all posts and comments and also you'll find dashboard numbers in Bangla.


= Why? (Features) =

* Bangla date.
* Bangla time.
* Bangla month name.
* Bangla name of the days.
* Bangla number into dashboard.
* Bangla post view/hit count.
* Bangla page navigation number.
* Sidebar widget ready with Bongabdo.

= How? (Usage) =

* For post hit count, use [WP-PostViews](http://wordpress.org/extend/plugins/wp-postviews/) plugin.
* For page navigation, use [WP-PageNavi](http://wordpress.org/extend/plugins/wp-pagenavi/) plugin.

= Who? (Developer) =

* Blog: [mithu.me](http://mithu.me/)
* E-mail: mail@mithu.me


== Installation ==

1. Download the Plugin `bangla-date-and-time.zip`

2. Extract zip and upload the plugin in `wp-content/plugins/` directory.

3. Activate the plugin through the plugins menu.

4. Open any of your post and see bangla date and that's it.


== Screenshots ==

1. Bangla date, comment count and hit count

2. Bangla number into page navigation

3. Bangla date and time widget

4. Bangla number into dashboard


== Changelog ==

= v1.9 (25.02.2014) =
* Added Bangla Season name into widget.

= v1.8.2 (12.02.2014) =
* Modified data scraping from Bangla Date Json API.
* Tested compatibility up to WP 3.8.1

= v1.8.1 (17.12.2013) =
* Changed URL for remote date fetching issue.

= v1.8.0 (11.12.2013) =
* Rewrite code to fully OOP way.
* Tested compatibility up to WP 3.7.1

= v1.7.2 (28.11.2013) =
* Fixed null data for remote contents.
* Added cURL data scraping support for remote contents.
* Removed header meta tag.

= v1.7.1 (08.04.2013) =
* Fixed issue of remote contents for widget.
* Added an error message for remote contents if getting failed.

= v1.7.0 (21.03.2013) =
* Added bangla date and time widget support.
* Added bangla calendar year (Bongabdo) for widget.

= v1.6.1 (22.12.2012) =
* Bug fixed.

= v1.6 (16.12.2012) =
* Added localization settings check.
* Tested compatibility for WP 3.5

= v1.5 (20.10.2012) =
* Added support for wp i18n.
* Display bangla number into admin area.

= v1.4 (12.08.2012) =
* Enhance functionality for newer version of wp.
* Remove ordinal suffix from array for confliction with same strings.

= v1.3 (23.03.2012) =
* Added `the_views` hook for popular view count plugin 'WP-PostViews' to count hit in Bangla.

= v1.2 (12.07.2011) =
* Added `comments_number` hook for total comments number count

= v1.1 (24.06.2011) =
* Bug fixed for month 'June' replacing 'Jun'.
* Added blank character for 'st', 'nd', 'rd' & 'th'.

= v1.0.1 (11.05.2011) =
* First release.
