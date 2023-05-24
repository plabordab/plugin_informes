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

namespace local_informe\form;
defined('MOODLE_INTERNAL') || die();
require_once($CFG->libdir . '/formslib.php');

/**
 * Clase que extiende de moodleform para añadir un formulario
 *
 * @package     local_informe
 */
class cuerpo_form extends \moodleform {

    /**
     * Definición del formulario.
     */
    public function definition() {

        $mform = $this->_form;

        // Recuperamos consulta cursos.
        $cursos = get_cursos();

        $opcursos = array();

        foreach ($cursos as $c) {
            $opcursos[] = $c->fullname;
        }

        $mform->addElement('select', 'selec_curso', get_string('selec_curso', 'local_informe'), $opcursos);
        $mform->setType('selec_curso', PARAM_INT);

        // Recuperamos consulta grupos.
        $grupos = get_grupos();

        $opgrupos = array();

        foreach ($grupos as $g) {
            $opgrupos[] = $g->name;
        }

        $mform->addElement('select', 'selec_grupo', get_string('selec_grupo', 'local_informe'), $opgrupos);
        $mform->setType('selec_grupo', PARAM_INT);

        $radioarray = array();
        $radioarray[] = $mform->createElement('radio', 'radio_info', get_string('informe1', 'local_informe'), 0);
        $radioarray[] = $mform->createElement('radio', 'radio_info', get_string('informe2', 'local_informe'), 0);
        $radioarray[] = $mform->createElement('radio', 'radio_info', get_string('informe3', 'local_informe'), 0);
        $radioarray[] = $mform->createElement('radio', 'radio_info', get_string('informe4', 'local_informe'), 0);
        $radioarray[] = $mform->createElement('radio', 'radio_info', get_string('informe5', 'local_informe'), 0);
        $radioarray[] = $mform->createElement('radio', 'radio_info', get_string('informe6', 'local_informe'), 0);

        $mform->addGroup($radioarray, 'radio', get_string('radio', 'local_informe'), '<br>');

        $buttonarray = array();
        $buttonarray[] = $mform->createElement('submit', 'Submit', get_string('generar', 'local_informe'));
        $buttonarray[] = $mform->createElement('cancel');
        $mform->addgroup($buttonarray, 'buttonar', '', ' ', false);

    }
}
