<?php

namespace local_autocohort;

defined('MOODLE_INTERNAL') || die();

class observer {

    public static function user_created(\core\event\user_created $event) {
        global $CFG;

        require_once($CFG->dirroot . '/cohort/lib.php');

        $userid = $event->objectid;

        $cohortid = get_config('local_autocohort', 'cohortid');

        if (empty($cohortid)) {
            return;
        }


        cohort_add_member($cohortid, $userid);
    }
}