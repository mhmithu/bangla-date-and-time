<?php
/**
 * @package       Bangla Date and Time
 * @subpackage    Child Date class
 * @author        MH Mithu <mail@mithu.me>
 * @link          https://github.com/mhmithu
 * @license       http://www.gnu.org/licenses/gpl-3.0.html
 *
 * ----------------------------------------------------------------------
 * Bangla Date and Time - WordPress Plugin
 * Copyright (C) 2014  MH Mithu
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

if (!class_exists('Date'))
    require_once plugin_dir_path(__FILE__).'class.Date.php';


class Bangla_Date extends Date {

    private $merged;

    /**
     * Class constructor method
     * @access public
     * @return void
     */
    public function __construct() {
        parent::__construct(current_time('timestamp'));
    }

    /**
     * Replacing default month, weekday and time strings with Bangla
     * @access public
     * @param  string $args
     * @return string
     */
    public function set_month_day($args) {
        $ml = (array) $this->data->months->en->long;
        $ms = (array) $this->data->months->en->short;
        $dl = (array) $this->data->weekday->long;
        $ds = (array) $this->data->weekday->short;

        $this->merged = array_merge($ml, $ms, $dl, $ds);
        $this->merged['am'] = $this->data->timespan->am;
        $this->merged['pm'] = $this->data->timespan->pm;

        return str_ireplace(array_keys($this->merged), array_values($this->merged), $args);
    }

    /**
     * Refiltering contents for valid markup and URI
     * @access public
     * @param  string $content
     * @return string
     */
    public function filter_content($content) {
        $num  = explode(',', $this->data->number);
        $str  = $this->merged;
        $data = array_merge($num, $str);
        unset($data['am'], $data['pm']);

        $filtered = str_replace(array_keys($data), array_values($data), $content);

        preg_match_all('/(https?):\/\/[a-z\d.-]+(\/[^\'"]*)?/i', $filtered, $uris);
        preg_match_all('/[\'"]([\dp]{1,})[\'"]/u', $filtered, $qots);

        $uri = str_ireplace(array_values($data), array_keys($data), $uris[0]);
        $qot = str_ireplace(array_values($data), array_keys($data), $qots[0]);

        return str_ireplace(array_merge($uris[0], $qots[0]), array_merge($uri, $qot), $filtered);
    }

    /**
     * Filtering calendars
     * @access public
     * @return string
     */
    public function filter_calendar() {
        return $this->filter_content(filter_get_calendar());
    }


}
