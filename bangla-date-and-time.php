<?php
/**
 * Plugin Name: Bangla Date and Time
 * Plugin URI: https://github.com/mhmithu/bangla-date-and-time
 * Description: Bangla Date and Time simply converts all date and time into Bangla.
 * Version: 2.3
 * Author: MH Mithu
 * Author URI: http://mithu.me/
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * ----------------------------------------------------------------------
 * Copyright (C) 2014  MH Mithu  (email: mail@mithu.me)
 * ----------------------------------------------------------------------
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * ----------------------------------------------------------------------
 */

// Including required file
require plugin_dir_path(__FILE__).'general-funcs.php';

// Hooking into core functions
add_filter('wp_list_categories', array($date, 'filter_content'));
add_filter('get_archives_link',  array($date, 'filter_content'));
add_filter('date_i18n',          array($date, 'set_month_day'), 10, 3);
add_filter('date_i18n',          array($date, 'bangla_number'), 10, 2);
add_filter('number_format_i18n', array($date, 'bangla_number'), 10, 1);
add_filter('get_calendar',       array($date, 'filter_calendar'));
add_action('widgets_init', 'register_date_widget');
