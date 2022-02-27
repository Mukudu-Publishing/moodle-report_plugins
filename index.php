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
 * Index file - show report graph.
 *
 * @package   report_plugins
 * @copyright 2019 - 2021 Mukudu Ltd - Bham UK
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . "/../../config.php");

require_login();

if (!is_siteadmin()) {   // Only site admins allowed.
    print_error('nopermissions', 'core');
}

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_pagelayout('admin');
$PAGE->set_heading($SITE->fullname);
$PAGE->set_title(get_string('pluginname', 'report_plugins'));
$PAGE->set_url('/report/plugins/index.php');

$pm = core_plugin_manager::instance();

$allplugintypes = $pm->get_plugin_types();

$chart = new core\chart_bar();
$chart->set_stacked(true);
$labels = array();
$series1data = array();
$series2data = array();

foreach ($allplugintypes as $type => $typefolder) {

    $installedplugins = $pm->get_installed_plugins($type);
    $enabledplugins = $pm->get_enabled_plugins($type);

    $installed = empty($installedplugins) ? 0 : count($installedplugins);
    $enabled = empty($enabledplugins) ? 0 : count($enabledplugins);

    $labels[] = $type;
    $series2data[] = $installed;
    $series1data[] = $enabled;

}

$chart->add_series(new core\chart_series(get_string('pluginenabled', 'report_plugins'), $series1data));
$chart->add_series(new core\chart_series(get_string('plugininstalled', 'report_plugins'), $series2data));

$chart->get_xaxis(0, true)->set_label(get_string('plugintypes', 'report_plugins'));
$chart->get_yaxis(0, true)->set_label(get_string('pluginnumbers', 'report_plugins'));

$chart->set_labels($labels);

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('pluginname', 'report_plugins'));

echo $OUTPUT->render_chart($chart);

// Trigger a logs viewed event.
$event = \report_plugins\event\report_viewed::create(array('context' => $context));
$event->trigger();

echo $OUTPUT->footer();
