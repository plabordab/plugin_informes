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
 * Este archivo contiene la biblioteca del complemento.
 *
 * @package     local_informe
 * @copyright   2023 Pilar Laborda <pilarlabordadaw@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Inserta un enlace y un icono a index.php en el menú de navegación de la página principal de sitios
 * que usan el tema Clásico o el tema Boost en sitios anteriores a Moodle 4.0.
 * @param global_navigation $root global_navigation extiende navigation_node por lo que todos los métodos
 * y propiedades del nodo de navegación que no se anulen a continuación estarán disponibles
 */

function local_informe_extend_navigation_frontpage(navigation_node $frontpage) {
    $frontpage->add(
            get_string('pluginname', 'local_informe'),
            new moodle_url('/local/informe/index.php'),
            navigation_node::TYPE_CUSTOM,
    );
}