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
require_once($CFG->dirroot . '/local/informe/lib.php');

// Permite que se genere el archivo de Excel.
$filename = "informe_" . date('Y:m:d:m:s') . ".xls";

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Expires: 0");

$context = context_system::instance();
$PAGE->set_context($context);

$PAGE->set_url(new moodle_url('/local/informe/informe.php'));

$PAGE->set_pagelayout('standard');
$PAGE->set_title($SITE->fullname);

$PAGE->set_heading(get_string('pluginname', 'local_informe'));

require_login();

if (isguestuser()) {
    throw new moodle_exception('noguest');
}

// Obtenemos los registros.
$informe = $DB->get_records('local_informe');

echo html_writer::start_tag('table');
echo html_writer::start_tag('tr');
echo html_writer::tag('th', 'Nombre');
echo html_writer::end_tag('th');
echo html_writer::tag('th', 'Apellido');
echo html_writer::end_tag('th');
echo html_writer::tag('th', 'Curso');
echo html_writer::end_tag('th');
echo html_writer::tag('th', 'Grupo');
echo html_writer::end_tag('th');
echo html_writer::end_tag('tr');

foreach ($informe as $i) {

    echo html_writer::start_tag('tr');
    echo html_writer::tag('td', $i->nombre);
    echo html_writer::end_tag('td');
    echo html_writer::tag('td', $i->apellido);
    echo html_writer::end_tag('td');
    echo html_writer::tag('td', $i->curso);
    echo html_writer::end_tag('td');
    echo html_writer::tag('td', $i->grupo);
    echo html_writer::end_tag('td');
    echo html_writer::end_tag('tr');

}

echo html_writer::end_tag('table');
