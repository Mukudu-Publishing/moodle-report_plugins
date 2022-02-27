<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Viewed Event class file.
 *
 * @package   report_plugins
 * @copyright 2019 - 2021 Mukudu Ltd - Bham UK
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace report_plugins\event;

defined('MOODLE_INTERNAL') || die();

/**
 * Viewed Event class.
 *
 * @package   report_plugins
 * @copyright 2019 - 2021 Mukudu Ltd - Bham UK
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class report_viewed extends \core\event\base {

    /**
     * Override in this class.
     *
     * Set all required data properties:
     *  1/ crud - letter [crud]
     *  2/ edulevel - using a constant self::LEVEL_*.
     *  3/ objecttable - name of database table if objectid specified
     *
     * Optionally it can set:
     * a/ fixed system context
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Returns localised general event name.
     *
     * Override in subclass, we can not make it static and abstract at the same time.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventreportviewed', 'report_plugins');
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        return get_string('eventreportdesc', 'report_plugins', $this->userid);
    }

    /**
     * Returns relevant URL, override in subclasses.
     * @return \moodle_url
     */
    public function get_url() {
        return new \moodle_url('/report/plugins/index.php');
    }
}