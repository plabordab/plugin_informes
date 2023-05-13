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
 * Este archivo contiene la pagina principal.
 *
 * @package     local_informe
 * @copyright   2023 Pilar Laborda <pilarlabordadaw@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');

$context = context_system::instance();
$PAGE->set_context($context);

$PAGE->set_url(new moodle_url('/local/informe/index.php'));

$PAGE->set_pagelayout('standard');
$PAGE->set_title($SITE->fullname);

$PAGE->set_heading(get_string('pluginname', 'local_informe'));

echo $OUTPUT->header();

if (isloggedin()) {

    echo get_string('subtitulo', 'local_informe');
    echo '<br/>';
    echo get_string('generadopor', 'local_informe', fullname($USER));
    echo '<br/>Fecha: ';
    echo userdate(time(), get_string('strftimedaydate', 'core_langconfig'));
}

echo $OUTPUT->footer();
