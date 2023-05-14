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

        $mform->addElement('select', 'message', get_string('selec_curso', 'local_informe'));
        $mform->setType('message', PARAM_TEXT);

        $mform->addElement('select', 'message', get_string('selec_grupo', 'local_informe'));
        $mform->setType('message', PARAM_TEXT);

        $submitlabel = get_string('generar', 'local_informe');

        $mform->addElement('submit', 'submitmessage', $submitlabel);

    }
}
