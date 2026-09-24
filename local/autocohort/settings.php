<?php

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {

    $settings = new admin_settingpage(
        'local_autocohort',
        get_string('pluginname', 'local_autocohort')
    );

    $ADMIN->add('localplugins', $settings);

    $cohorts = $DB->get_records_menu(
        'cohort',
        null,
        'name ASC',
        'id, name'
    );

    $settings->add(new admin_setting_configselect(
        'local_autocohort/cohortid',
        get_string('cohort', 'local_autocohort'),
        get_string('cohort_desc', 'local_autocohort'),
        5,
        [0 => get_string('choose')] + $cohorts
    ));
}