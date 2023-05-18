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

defined('MOODLE_INTERNAL') || die();

// Permite que se genere el archivo de Excel.
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=informe_" . date('Y:m:d:m:s').".xls");
header("Pragma: no-cache");
header("Expires: 0");

require_once('../../config.php');
require_once($CFG->dirroot. '/local/informe/lib.php');

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

echo $OUTPUT->header();

$allowgenerate = has_capability('local/informe:generarinforme', $context);

// Se procesan y visualizan los formularios.
if ($allowgenerate) {

    $cuerpoform = new \local_informe\form\cuerpo_form();
    $tabla = "";

    if ($data = $cuerpoform->get_data()) {

        require_capability('local/informe:generarinforme', $context);

        $sql = "SELECT * FROM {local_informes}";

        $userfields = \core_user\fields::for_name()->with_identity($context);
        $userfieldssql = $userfields->get_sql('u');

        $sql2 = "SELECT m.id, m.message, m.timecreated, m.userid {$userfieldssql->selects}
                FROM {local_greetings_messages} m
                LEFT JOIN {user} u ON u.id = m.userid
                  ORDER BY timecreated DESC";

        $informe = $DB->get_records_sql($sql);

            $tabla .= "
			<table>
				<thead>
					<tr>
						<th>Nombre</th>
						<th>Apellido</th>
						<th>Curso</th>
						<th>Grupo</th>
						<th>Duración</th>
					</tr>
				<tbody>
		";

        foreach ($informe as $i) {

            $tabla .= "
					<tr>
						<td>".$i->nombre."</td>
						<td>".$i->apellido."</td>
						<td>".$i->curso."</td>
						<td>".$i->grupo."</td>
						<td>".$i->duracion."</td>
					</tr>
		";

        }
        $tabla .= "
                </tbody>
            </table>";

    }

}

echo $OUTPUT->footer();
