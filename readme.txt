=== Bangla Date and Time ===
Contributors: mitcmt
Plugin Site: http://mithu.me
Tags: bangla, date, time, number, calendar, widget, bongabdo, hijri, gregorian
Requires at least: 2.8
Tested up to: 4.2.2
Stable tag: 2.5
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

A simple but useful plugin to display relevant Bangla date, time, calendar and numbers.


== Description ==
Bangla Date and Time is simple but effective to display relevant date, times on your website. It replaces all Latin number with Bangla number on every pages. It allows you to show current Bangla, Gregorian and Hijri date to the sidebar widget. Once you activate the plugin, automatically date and time will be changed to Bangla for all posts and comments and also you'll find dashboard numbers in Bangla.

= Why? (Features) =
* Bangla date.
* Bangla time.
* Bangla archive.
* Bangla calendar.
* Bangla month name.
* Bangla name of the days.
* Bangla number into dashboard.
* Bangla post view/hit count.
* Bangla page navigation number.
* Sidebar widget with Bongabdo and Hijri.

= How? (Usage) =
* For post hit count, use [WP-PostViews](http://wordpress.org/plugins/wp-postviews/) plugin (Recommend).
* For page navigation, use [WP-PageNavi](http://wordpress.org/plugins/wp-pagenavi/) plugin (Recommend).
* Please check [installation tab](http://wordpress.org/plugins/bangla-date-and-time/installation/) for more details.

= Who? (Developer) =
* Blog: [mithu.me](http://mithu.me)
* E-mail: mail@mithu.me


== Installation ==
1. Download the Plugin `bangla-date-and-time.zip`
2. Extract zip and upload the plugin in `wp-content/plugins/` directory.
3. Activate the plugin through the plugins menu.
4. Open any of your post and see bangla date and that's it.
5. To show local time into sidebar, please go to `Settings > General` and set `Timezone` value `Dhaka` or your preferred timezone value.


== Screenshots ==
1. Bangla date, comment count and hit count
2. Bangla number into page navigation
3. Bangla date and time widget
4. Bangla number into dashboard
5. Bangla calendar widget


== Changelog ==

= v2.5 (20.05.2015) =
* Renamed - class files.
* Updated - code to WP standards.
* Updated - methods to reduce redundancy.
* Tested - compatibility up to WP-4.2.2

= v2.4.5 (07.03.2015) =
* Modified - timestamp offset.
* Updated - copyright date.
* Tested - compatibility up to WP-4.1.1

= v2.4.4 (05.01.2015) =
* Modified - timestamp offset.
* Fixed - PHP warning.
* Tested - compatibility up to WP-4.1

= v2.4.3 (27.09.2014) =
* Modified - Hijri calendar date.
* Tested - compatibility.

= v2.4.2 (30.06.2014) =
* Modified - Hijri calendar date to current.

= v2.4.1 (25.05.2014) =
* Added - weekday name hiding feature into widget.
* Added - calendar year name hiding feature into widget.
* Modified - widget options and reordered them.
* Moved - screenshots.

= v2.4 (18.05.2014) =
* Added - season name hiding feature into widget.
* Added - current time hiding feature into widget.
* Added - default title placeholder.
* Added - new hooks.
* Renamed - widget title text.
* Renamed - file `general-funcs`.
* Modified - directory structure.
* Modified - including file paths.

= v2.3 (10.05.2014) =
* Added - widget title rename feature.
* Added - new widget class.
* Removed - method `bangla_date_widget` from `Bangla_date` class.
* Removed - method `register_widget` from `Bangla_date` class.
* Replaced - action hook with new hook for widget.
* Modified - included file on file.
* Updated - more funcionalities.
* Tested - compatibility up to WP-3.9.1

= v2.2 (05.05.2014) =
* Rewrite - code.
* Added - new class file.

= v2.1 (30.04.2014) =
* Added - bangla into calender.
* Added - bangla into archive.
* Added - content filtering.
* Added - new filter hook.
* Added - more new methods.
* Added - general functions file.
* Renamed - method `bangla_digit` on base class.
* Removed - `bangla_number` method from clild class.

= v2.0.2 (22.04.2014) =
* Updated - XML data file.
* Updated - XML related functionalities.
* Tested - compatibility up to WP-3.9

= v2.0.1 (16.04.2014) =
* Fixed - default timezone issue.
* Replaced - system timestamp with blog deafult.
* Extended - main class from lib class.

= v2.0 (12.04.2014) =
* Removed - remote data scrapper.
* Added - Bangla Date class.
* Added - XML data file.
* Fixed - data fetching failure issue.
* Rewrite - code with readable syntax.
* Updated - license to GPL-3.0
* Tested - compatibility up to WP-3.8.2

= v1.9.1 (27.03.2014) =
* Added - new feature Hijri date into widget.
* Tested - compatibility with WP-3.8.1

= v1.9 (25.02.2014) =
* Added - Bangla Season name into widget.

= v1.8.2 (12.02.2014) =
* Modified - data scraping from Bangla Date Json API.
* Tested - compatibility up to WP-3.8.1

= v1.8.1 (17.12.2013) =
* Changed - URL for remote date fetching issue.

= v1.8.0 (11.12.2013) =
* Rewrite - code to fully OOP way.
* Tested - compatibility up to WP-3.7.1

= v1.7.2 (28.11.2013) =
* Fixed - null data for remote contents.
* Added - cURL data scraping support for remote contents.
* Removed - header meta tag.

= v1.7.1 (08.04.2013) =
* Fixed - issue of remote contents for widget.
* Added - an error message for remote contents if getting failed.

= v1.7.0 (21.03.2013) =
* Added - bangla date and time widget support.
* Added - bangla calendar year (Bongabdo) for widget.

= v1.6.1 (22.12.2012) =
* Fixed - bug.

= v1.6 (16.12.2012) =
* Added - localization settings check.
* Tested - compatibility for WP-3.5

= v1.5 (20.10.2012) =
* Added - support for wp i18n.
* Display - bangla number into admin area.

= v1.4 (12.08.2012) =
* Enhance - functionality for newer version of wp.
* Remove - ordinal suffix from array for conflict with same strings.

= v1.3 (23.03.2012) =
* Added - `the_views` hook for popular view count plugin 'WP-PostViews' to count hit in Bangla.

= v1.2 (12.07.2011) =
* Added - `comments_number` hook for total comments number count

= v1.1 (24.06.2011) =
* Fixed - bug for month 'June' replacing 'Jun'.
* Added - blank character for 'st', 'nd', 'rd' & 'th'.

= v1.0.1 (11.05.2011) =
* Initial release.
