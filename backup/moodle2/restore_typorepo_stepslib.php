<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Restore steps.
 *
 * @package   mod_typorepo
 * @copyright 2020 bdecent gmbh <https://bdecent.de>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

/**
 * Define all the restore steps that will be used by the restore_url_activity_task
 */

/**
 * Restore steps.
 *
 * Structure step to restore one typorepo activity
 */
class restore_typorepo_activity_structure_step extends restore_activity_structure_step {

    /**
     * Define activity structure.
     *
     * @return array
     */
    protected function define_structure() {

        $paths = [];
        $paths[] = new restore_path_element('typorepo', '/activity/typorepo');

        // Return the paths wrapped into standard activity structure.
        return $this->prepare_activity_structure($paths);
    }

    /**
     * Process typorepo instance.
     *
     * @param array $data
     * @throws base_step_exception
     * @throws dml_exception
     */
    protected function process_typorepo($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;
        $data->course = $this->get_courseid();

        // Insert the typorepo record.
        $newitemid = $DB->insert_record('typorepo', $data);
        // Immediately after inserting "activity" record, call this.
        $this->apply_activity_instance($newitemid);
    }

}
