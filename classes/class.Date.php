<?php
/**
 * @package       Bangla Date and Time
 * @subpackage    Base Date class
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

class Date {

    protected $data;                     # XML data object
    protected $stamp;                    # System Unix timestamp
    protected $date_time;                # PHP DateTime object
    protected $is_leapyear;              # Whether leap year or not
    protected $jd_lunation;              # Julian day lunation
    protected $get_year;                 # Year format YYYY
    protected $get_month;                # Month [1 to 12]
    protected $get_date;                 # Date [1 to 31]
    protected $get_hour;                 # Hour [0 to 23]
    protected $get_weekday;              # Weekday [1 to 7]
    protected $set_month;                # Store months
    protected $set_suffix  = array();    # Store ordinal suffix
    protected $set_prefix  = array();    # Store time prefix
    protected $set_weekday = array();    # Store weekdays
    protected $set_season  = array();    # Store seasons

    /**
     * Populating system Timestamp and parsing XML data
     * @access public
     * @param  integer $stamp     Unix Timestamp
     * @param  object  $timezone  Default Timezone
     * @return void
     */
    public function __construct($stamp) {
        $this->date_time = new DateTime;
        $this->date_time->setTimestamp($stamp);
        $this->_timestamp();
        $this->_xml_data();
    }

    /**
     * Getting various date info based on Unix Timestamp
     * @desc   Passed over constructor method
     * @access private
     * @return void
     */
    private function _timestamp() {
        // Setting property values
        $this->stamp       = $this->date_time->getTimestamp();
        $this->is_leapyear = $this->date_time->format('L');
        $this->get_year    = $this->date_time->format('Y');
        $this->get_month   = $this->date_time->format('n');
        $this->get_date    = $this->date_time->format('j');
        $this->get_hour    = $this->date_time->format('G');
        $this->get_weekday = $this->date_time->format('N');
    }

    /**
     * Parsing data from XML file
     * @desc   Passed over constructor method
     * @access private
     * @return void
     */
    private function _xml_data() {
        // Loading simplexml data
        $xml = simplexml_load_file(plugin_dir_path(__DIR__).'assets/data.xml');

        // Parsing data from xml
        foreach($xml->xpath('//suffix/name') as $suffix) array_push($this->set_suffix, (string) $suffix);
        foreach($xml->xpath('//prefix/name') as $prefix) array_push($this->set_prefix, (string) $prefix);
        foreach($xml->xpath('//season/name') as $season) array_push($this->set_season, (string) $season);

        // Parsing simplexml object as array
        $ar = (array) $xml->months->ar;
        $bn = (array) $xml->months->bn;

        // Changing keys
        $ar['ar'] = $ar['month'];
        $bn['bn'] = $bn['month'];
        $en['en'] = array_values((array) $xml->months->en->long);

        // Unsetting old keys
        unset($ar['month'], $bn['month']);

        // Exploring properties
        $this->data        = $xml;
        $this->set_month   = array_merge($ar, $bn, $en);
        $this->set_weekday = array_values((array) $xml->weekday->long);
        $this->jd_lunation = explode(',', (string) $xml->jd_lunation);
    }

    /**
     * Calculating Gregorian date
     * @access private
     * @return array
     */
    private function gregorian() {
        // Converting Gregorian months to Bangla
        switch ($this->get_month) {
            case 1:  $month = $this->set_month['en'][0];  break;
            case 2:  $month = $this->set_month['en'][1];  break;
            case 3:  $month = $this->set_month['en'][2];  break;
            case 4:  $month = $this->set_month['en'][3];  break;
            case 5:  $month = $this->set_month['en'][4];  break;
            case 6:  $month = $this->set_month['en'][5];  break;
            case 7:  $month = $this->set_month['en'][6];  break;
            case 8:  $month = $this->set_month['en'][7];  break;
            case 9:  $month = $this->set_month['en'][8];  break;
            case 10: $month = $this->set_month['en'][9];  break;
            case 11: $month = $this->set_month['en'][10]; break;
            case 12: $month = $this->set_month['en'][11]; break;
        }

        // Converting Latin digit to Bangla
        $date = $this->bangla_number($this->get_date);
        $year = $this->bangla_number($this->get_year);

        // Converting ordinal suffix to Bangla
        $suffix = $this->suffix($this->get_date);

        // Returning results as array
        return array(
            'date'   => $date,
            'suffix' => $suffix,
            'month'  => $month,
            'year'   => $year
        );
    }

    /**
     * Calculating Bongabdo (Bangla Calender Year)
     * @access private
     * @return array
     */
    private function bongabdo() {
        // Calculating Bongabdo month, date and suffix
        switch ($this->get_month) {
            // Months are ordered by sequentially
            case 1:
                if ($this->get_date >= 1 && $this->get_date <= 13) {
                    if ($this->get_hour < 6) $date = $this->get_date + 16;
                    else $date = $this->get_date + 17;
                    $month = $this->set_month['bn'][8];
                } else {
                    if ($this->get_date == 14 && $this->get_hour < 6) {
                        $date  = $this->get_date + 16;
                        $month = $this->set_month['bn'][8];
                    } else {
                        if ($this->get_hour < 6) $date = $this->get_date - 14;
                        else $date = $this->get_date - 13;
                        $month = $this->set_month['bn'][9];
                    }
                }
                break;

            case 2:
                if ($this->get_date >= 1 && $this->get_date <= 12) {
                    if ($this->get_hour < 6) $date = $this->get_date + 17;
                    else $date = $this->get_date + 18;
                    $month = $this->set_month['bn'][9];
                } else {
                    if ($this->get_date == 13 && $this->get_hour < 6) {
                        $date  = $this->get_date + 17;
                        $month = $this->set_month['bn'][9];
                    } else {
                        if ($this->get_hour < 6) $date = $this->get_date - 13;
                        else $date = $this->get_date - 12;
                        $month = $this->set_month['bn'][10];
                    }
                }
                break;

            case 3:
                if ($this->get_date >= 1 && $this->get_date <= 14) {
                    if ($this->get_hour < 6) {
                        if (!$this->is_leapyear) $date = $this->get_date + 15;
                        else $date = $this->get_date + 16;
                        $month = $this->set_month['bn'][10];
                    } else {
                        if (!$this->is_leapyear) $date = $this->get_date + 16;
                        else $date = $this->get_date + 17;
                        $month = $this->set_month['bn'][10];
                    }
                } else {
                    if ($this->get_date == 15 && $this->get_hour < 6) {
                        if (!$this->is_leapyear) $date = $this->get_date + 15;
                        else $date = $this->get_date + 16;
                        $month = $this->set_month['bn'][10];
                    } else {
                        if ($this->get_hour < 6) $date = $this->get_date - 15;
                        else $date = $this->get_date - 14;
                        $month = $this->set_month['bn'][11];
                    }
                }
                break;

            case 4:
                if ($this->get_date >= 1 && $this->get_date <= 13) {
                    if ($this->get_hour < 6) $date = $this->get_date + 16;
                    else $date = $this->get_date + 17;
                    $month = $this->set_month['bn'][11];
                } else {
                    if ($this->get_date == 14 && $this->get_hour < 6) {
                        $date  = $this->get_date + 16;
                        $month = $this->set_month['bn'][11];
                    } else {
                        if ($this->get_hour < 6) $date = $this->get_date - 14;
                        else $date = $this->get_date - 13;
                        $month = $this->set_month['bn'][0];
                    }
                }
                break;

            case 5:
                if ($this->get_date >= 1 && $this->get_date <= 14) {
                    if ($this->get_hour < 6) $date = $this->get_date + 16;
                    else $date = $this->get_date + 17;
                    $month = $this->set_month['bn'][0];
                } else {
                    if ($this->get_date == 15 && $this->get_hour < 6) {
                        $date  = $this->get_date + 16;
                        $month = $this->set_month['bn'][0];
                    } else {
                        if ($this->get_hour < 6) $date = $this->get_date - 15;
                        else $date = $this->get_date - 14;
                        $month = $this->set_month['bn'][1];
                    }
                }
                break;

            case 6:
                if ($this->get_date >= 1 && $this->get_date <= 14) {
                    if ($this->get_hour < 6) $date = $this->get_date + 16;
                    else $date = $this->get_date + 17;
                    $month = $this->set_month['bn'][1];
                } else {
                    if ($this->get_date == 15 && $this->get_hour < 6) {
                        $date  = $this->get_date + 16;
                        $month = $this->set_month['bn'][1];
                    } else {
                        if ($this->get_hour < 6) $date = $this->get_date - 15;
                        else $date = $this->get_date - 14;
                        $month = $this->set_month['bn'][2];
                    }
                }
                break;

            case 7:
                if ($this->get_date >= 1 && $this->get_date <= 15) {
                    if ($this->get_hour < 6) $date = $this->get_date + 15;
                    else $date = $this->get_date + 16;
                    $month = $this->set_month['bn'][2];
                } else {
                    if ($this->get_date == 16 && $this->get_hour < 6) {
                        $date  = $this->get_date + 15;
                        $month = $this->set_month['bn'][2];
                    } else {
                        if ($this->get_hour < 6) $date = $this->get_date - 16;
                        else $date = $this->get_date - 15;
                        $month = $this->set_month['bn'][3];
                    }
                }
                break;

            case 8:
                if ($this->get_date >= 1 && $this->get_date <= 15) {
                    if ($this->get_hour < 6) $date = $this->get_date + 15;
                    else $date = $this->get_date + 16;
                    $month = $this->set_month['bn'][3];
                } else {
                    if ($this->get_date == 16 && $this->get_hour < 6) {
                        $date  = $this->get_date + 15;
                        $month = $this->set_month['bn'][3];
                    } else {
                        if ($this->get_hour < 6) $date = $this->get_date - 16;
                        else $date = $this->get_date - 15;
                        $month = $this->set_month['bn'][4];
                    }
                }
                break;

            case 9:
                if ($this->get_date >= 1 && $this->get_date <= 15) {
                    if ($this->get_hour < 6) $date = $this->get_date + 15;
                    else $date = $this->get_date + 16;
                    $month = $this->set_month['bn'][4];
                } else {
                    if ($this->get_date == 16 && $this->get_hour < 6) {
                        $date  = $this->get_date + 15;
                        $month = $this->set_month['bn'][4];
                    } else {
                        if ($this->get_hour < 6) $date = $this->get_date - 16;
                        else $date = $this->get_date - 15;
                        $month = $this->set_month['bn'][5];
                    }
                }
                break;

            case 10:
                if ($this->get_date >= 1 && $this->get_date <= 15) {
                    if ($this->get_hour < 6) $date = $this->get_date + 14;
                    else $date = $this->get_date + 15;
                    $month = $this->set_month['bn'][5];
                } else {
                    if ($this->get_date == 16 && $this->get_hour < 6) {
                        $date  = $this->get_date + 14;
                        $month = $this->set_month['bn'][5];
                    } else {
                        if ($this->get_hour < 6) $date = $this->get_date - 16;
                        else $date = $this->get_date - 15;
                        $month = $this->set_month['bn'][6];
                    }
                }
                break;

            case 11:
                if ($this->get_date >= 1 && $this->get_date <= 14) {
                    if ($this->get_hour < 6) $date = $this->get_date + 15;
                    else $date = $this->get_date + 16;
                    $month = $this->set_month['bn'][6];
                } else {
                    if ($this->get_date == 15 && $this->get_hour < 6) {
                        $date  = $this->get_date + 15;
                        $month = $this->set_month['bn'][6];
                    } else {
                        if ($this->get_hour < 6) $date = $this->get_date - 15;
                        else $date = $this->get_date - 14;
                        $month = $this->set_month['bn'][7];
                    }
                }
                break;

            case 12:
                if ($this->get_date >= 1 && $this->get_date <= 14) {
                    if ($this->get_hour < 6) $date = $this->get_date + 15;
                    else $date = $this->get_date + 16;
                    $month = $this->set_month['bn'][7];
                } else {
                    if ($this->get_date == 15 && $this->get_hour < 6) {
                        $date  = $this->get_date + 15;
                        $month = $this->set_month['bn'][7];
                    } else {
                        if ($this->get_hour < 6) $date = $this->get_date - 15;
                        else $date = $this->get_date - 14;
                        $month = $this->set_month['bn'][8];
                    }
                }
                break;
        }

        // Calculating season
        if ($month == $this->set_month['bn'][0] || $month == $this->set_month['bn'][1])
            $season = $this->set_season[0];
        elseif ($month == $this->set_month['bn'][2] || $month == $this->set_month['bn'][3])
            $season = $this->set_season[1];
        elseif ($month == $this->set_month['bn'][4] || $month == $this->set_month['bn'][5])
            $season = $this->set_season[2];
        elseif ($month == $this->set_month['bn'][6] || $month == $this->set_month['bn'][7])
            $season = $this->set_season[3];
        elseif ($month == $this->set_month['bn'][8] || $month == $this->set_month['bn'][9])
            $season = $this->set_season[4];
        else
            $season = $this->set_season[5];

        // Calculating year
        if ($this->get_month < 4) {
            $year = $this->get_year - 594;
        } else {
            if ($this->get_month == 4) {
                if (($this->get_date < 14) || ($this->get_date == 14 && $this->get_hour < 6))
                    $year = $this->get_year - 594;
                else
                    $year = $this->get_year - 593;
            }
            else $year = $this->get_year - 593;
        }

        // Getting ordinal suffix of date
        $suffix = $this->suffix($date);

        // Converting Latin digit to Bangla
        $date = $this->bangla_number($date);
        $year = $this->bangla_number($year);

        // Returning results as array
        return array(
            'date'   => $date,
            'suffix' => $suffix,
            'month'  => $month,
            'year'   => $year,
            'season' => $season
        );
    }

    /**
    * Calculating Hijri date
    * @access private
    * @return array
    */
    private function hijri(){
        $date = new DateTime;
        $date->setTimestamp($this->stamp + (6*60*60));
        // Year, Month, Day
        $y = $date->format('Y');
        $m = $date->format('m');
        $d = $date->format('d');
        // If month before March
        if ($m < 3) {
            $y -= 1;
            $m += 12;
        }
        // Calculating Julian days
        $gyc = floor($y/100.0);
        $jgc = $gyc - floor($gyc/4.0) - 2;
        $cjd = floor(365.25*($y+4716)) + floor(30.6001*($m+1)) + $d-$jgc-1524;
        $mjd = $cjd - 2400000;
        // Iterating lunation numbers
        foreach ($this->jd_lunation as $k => $v) {
            if ($v > $mjd) {
                error_reporting(0); // Debug
                break;
            }
        }
        // Calculating Hijri date
        $il = $k + 16260;
        $ii = floor(($il-1)/12);
        $iy = $ii + 1;
        $im = $il - 12*$ii;
        $id = $mjd - $this->jd_lunation[$k-1];
        $id = $id <= 0 ? 1 : $id;
        // Preparing results
        $date   = $this->bangla_number($id);
        $suffix = $this->suffix($id);
        $month  = $this->set_month['ar'][$im-1];
        $year   = $this->bangla_number($iy);

        // Returning results as array
        return array(
            'date'   => $date,
            'suffix' => $suffix,
            'month'  => $month,
            'year'   => $year
        );
    }

    /**
     * Calculating weekdays
     * @access private
     * @return array
     */
    private function weekday() {
        switch ($this->get_weekday) {
            case 1: $weekday = $this->set_weekday[0]; break;
            case 2: $weekday = $this->set_weekday[1]; break;
            case 3: $weekday = $this->set_weekday[2]; break;
            case 4: $weekday = $this->set_weekday[3]; break;
            case 5: $weekday = $this->set_weekday[4]; break;
            case 6: $weekday = $this->set_weekday[5]; break;
            case 7: $weekday = $this->set_weekday[6]; break;
        }
        // Returning result as array
        return array('weekday' => $weekday);
    }

    /**
     * Calculating time
     * @access private
     * @return array
     */
    private function hour() {
        // Calculating time prefix between hours
        if ($this->get_hour < 6 && $this->get_hour > 3)
            $prefix = $this->set_prefix[0];
        elseif ($this->get_hour < 12 && $this->get_hour > 5)
            $prefix = $this->set_prefix[1];
        elseif ($this->get_hour < 15 && $this->get_hour > 11)
            $prefix = $this->set_prefix[2];
        elseif ($this->get_hour < 18 && $this->get_hour > 14)
            $prefix = $this->set_prefix[3];
        elseif ($this->get_hour < 20 && $this->get_hour > 17)
            $prefix = $this->set_prefix[4];
        else
            $prefix = $this->set_prefix[5];

        // Converting hour/minute to Bangla according to Timestamp
        $time = $this->bangla_number($this->date_time->format('g:i'));

        // Returning results as array
        return array(
            'prefix' => $prefix,
            'time'   => $time
        );
    }

    /**
     * Calculating ordinal suffix of date
     * @access private
     * @param  integer $date
     * @return string
     */
    private function suffix($date) {
        // Calculating on input date
        if ($date == 1)
            $suffix = $this->set_suffix[0];
        elseif ($date == 2 || $date == 3)
            $suffix = $this->set_suffix[1];
        elseif ($date == 4)
            $suffix = $this->set_suffix[2];
        elseif ($date < 19 && $date > 4)
            $suffix = $this->set_suffix[3];
        else
            $suffix = $this->set_suffix[4];

        // Returning result
        return $suffix;
    }

    /**
     * Converting numbers from Latin to Bangla
     * @access public
     * @param  integer $int
     * @return string
     */
    public function bangla_number($int) {
        return str_replace(range(0, 9), explode(',', $this->data->number), $int);
    }

    /**
     * Getting the results
     * @access public
     * @return object
     */
    public function get_date() {
        $dates = array(
            'ar' => $this->hijri(),
            'bn' => $this->bongabdo(),
            'en' => $this->gregorian(),
            'ts' => $this->weekday() + $this->hour()
        );
        return (object) $dates;
    }


}
