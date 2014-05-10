<?php
/**
 * @package       Bangla Date and Time
 * @subpackage    Date Widget inherited class
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

// Including class
if (!class_exists('Bangla_Date'))
    require_once plugin_dir_path(__FILE__).'class.Bangla_Date.php';

// Instantiating the class
$date = new Bangla_Date;


class Date_Widget extends WP_Widget {

    /**
     * Class constructor
     * @access public
     * @return void
     */
    public function __construct() {
        parent::__construct(
            'bangla_date',
            'আজকের বাংলা তারিখ',
            array(
                'classname'   => 'bangla_date',
                'description' => 'A widget to display the relevant dates'
            )
        );
    }

    /**
     * Outputs the content of the widget
     * @access public
     * @param  array $args
     * @param  array $instance
     * @return string
     */
    public function widget($args, $instance) {
        global $date;
        extract($args);

        $title = apply_filters('widget_title', $instance['title']);
        $date  = $date->get_date();

        $widget  = $before_widget;
        $widget .= $before_title;
        $widget .= $title ? $title : 'আজকের বাংলা তারিখ';
        $widget .= $after_title;
        $widget .= '<ul>';
        $widget .= '<li>আজ ';
        $widget .= $date->ts['weekday'].', ';
        $widget .= $date->en['date'] . $date->en['suffix'].' ';
        $widget .= $date->en['month'].', ';
        $widget .= $date->en['year'];
        $widget .= '</li>';
        $widget .= '<li>';
        $widget .= $date->bn['date'] . $date->bn['suffix'].' ';
        $widget .= $date->bn['month'].', ';
        $widget .= $date->bn['year'];
        $widget .= ' বঙ্গাব্দ (' .$date->bn['season']. ')';
        $widget .= '</li>';
        $widget .= '<li>';
        $widget .= $date->ar['date'] . $date->ar['suffix'].' ';
        $widget .= $date->ar['month'].', ';
        $widget .= $date->ar['year'];
        $widget .= ' হিজরী';
        $widget .= '</li>';
        $widget .= '<li>এখন সময়, ';
        $widget .= $date->ts['prefix'].' '.$date->ts['time'];
        $widget .= '</li>';
        $widget .= '</ul>';
        $widget .= $after_widget;

        echo $widget;
    }

    /**
     * Processing widget options on save
     * @access public
     * @param  array $new_instance
     * @param  array $old_instance
     * @return array
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    /**
     * Outputs the options form on admin
     * @access public
     * @param  array $instance
     * @return void
     */
    public function form($instance) {
?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo 'Title:'; ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" type="text"  />
        </p>
<?php
    }

}

/**
 * Register the widget
 * @return void
 */
function register_date_widget() {
    register_widget('Date_Widget');
}
