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
require_once($CFG->dirroot. '/local/informe/lib.php');

$context = context_system::instance();
$PAGE->set_context($context);

$PAGE->set_url(new moodle_url('/local/informe/index.php'));

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

    $cuerpoform->display();

    // Si está el botón cancelar, maneja la operación de cancelación.
    if ($cuerpoform->is_cancelled()) {

        redirect($PAGE->url);

        // Se procesan los datos validados. $mform->get_data() devuelve los datos introducidos.
    } else if ($data = $cuerpoform->get_data()) {

        // Select - devuelve la posición del array.
        $numcurso = $data->selec_curso;
        $numgrupo = $data->selec_grupo;

        // Recuperamos consulta cursos para obtener id.
        $cursos = get_cursos();
        $idcursos = array();
        foreach ($cursos as $c) {
            $idcursos[] = $c->id;
        }
        $idcurso = $idcursos[$numcurso];

        // Recuperamos consulta grupos para obtener id.
        $grupos = get_grupos();
        $idgrupos = array();
        foreach ($grupos as $g) {
            $idgrupos[] = $g->id;
        }
        $idgrupo = $idgrupos[$numgrupo];

        require_capability('local/informe:generarinforme', $context);

    } else {

        // Visualizar formulario.
        $this->content->text = $cuerpoform->render();
    }

}

echo $OUTPUT->footer();
