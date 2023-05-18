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

        $mform->addElement('advcheckbox', 'nombre', get_string('check_nombre', 'local_informe'),
                '', array('group' => 1), array(0, 1));
        $mform->addElement('advcheckbox', 'apellido', get_string('check_apellido', 'local_informe'),
                '', array('group' => 1), array(0, 1));
        $mform->addElement('advcheckbox', 'curso', get_string('check_curso', 'local_informe'),
                '', array('group' => 1), array(0, 1));
        $mform->addElement('advcheckbox', 'grupo', get_string('check_grupo', 'local_informe'),
                '', array('group' => 1), array(0, 1));
        $mform->addElement('advcheckbox', 'duracion', get_string('check_duracion', 'local_informe'),
                '', array('group' => 1), array(0, 1));

        // Añadir un controlador de checkbox para todos los checkboxes en `group => 1`.
        $this->add_checkbox_controller(
                1,
                get_string("checkbox", "local_informe")
        );

        $buttonarray = array();
        $buttonarray[] = $mform->createElement('submit', 'Submit', get_string('generar', 'local_informe'));
        $buttonarray[] = $mform->createElement('cancel');
        $mform->addgroup($buttonarray, 'buttonar', '', ' ', false);

    }
}
