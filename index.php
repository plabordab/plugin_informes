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

        $urlprincipal = new moodle_url('/', ['redirect' => 0]);

        // Se procesan los datos validados. $mform->get_data() devuelve los datos introducidos.
    } else if ($data = $cuerpoform->get_data()) {

        require_capability('local/informe:generarinforme', $context);

        // Primero vaciamos la tabla.
        $DB->delete_records('local_informe');

        // Select - devuelve la posición del array.
        $numcurso = $data->selec_curso;
        $numgrupo = $data->selec_grupo;

        // Recuperamos consulta cursos para obtener id.
        $cursos = get_cursos();
        $nombrescursos = array();
        $idcursos = array();
        foreach ($cursos as $c) {
            $idcursos[] = $c->id;
            $nombrescursos[] = $c->fullname;
        }
        $idcurso = $idcursos[$numcurso];
        $nombrecurso = $nombrescursos[$numcurso];

        // Recuperamos consulta grupos para obtener id.
        $grupos = get_grupos();
        $nombregrupos = array();
        $idcursos = array();
        foreach ($grupos as $g) {
            $idgrupos[] = $g->id;
            $nombregrupos[] = $g->name;
        }
        $idgrupo = $idgrupos[$numgrupo];
        $nombregrupo = $nombregrupos[$numgrupo];

        // Recuperamos consulta informe.
        $informe = genera_informe($idcurso, $idgrupo);

        foreach ($informe as $i) {

            $registro = new stdClass;
            // Pte: $registro->nombre = $nombre;.
            $registro->nombre = '$nombre';
            // Pte: $registro->apellido = $apellido;.
            $registro->apellido = '$apellido';
            $registro->curso = $nombrecurso;
            $registro->grupo = $nombregrupo;
            // Pte: $registro->duracion = $duracion;.
            $registro->duracion = 1000000000;

            // Rellenamos la tabla con los datos del nuevo informe.
            $DB->insert_record('local_informe', $registro);

        }

        // Redirigimos a la página del informe para exportar a excel.
        $url = new moodle_url('/local/informe/informe.php');
        redirect($url);

    } else {

        // Visualizamos formulario.
        $cuerpoform->render();
    }

}

echo $OUTPUT->footer();
