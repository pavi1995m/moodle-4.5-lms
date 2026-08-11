<?php
defined('MOODLE_INTERNAL') || die();

class block_featured_courses extends block_list {
    function init() {
        $this->title = get_string('pluginname', 'block_featured_courses');
    }

    function get_content() {
        global $CFG, $DB, $OUTPUT;

        if($this->content !== NULL) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->items = array();
        $this->content->icons = array();
        $this->content->footer = '';

        $sql = "SELECT c.id, c.fullname
                FROM {course} c
                JOIN {customfield_data} cfd ON cfd.instanceid = c.id
                JOIN {customfield_field} cff ON cff.id = cfd.fieldid
                JOIN {customfield_category} cfc ON cfc.id = cff.categoryid
                WHERE cfc.component = :component
                  AND cfc.area = :area
                  AND cff.shortname = :shortname
                  AND cfd.value = :value
                  AND c.visible = 1
                ORDER BY c.fullname ASC";
    
    $courses = $DB->get_records_sql($sql, array(
            'component' => 'core_course',
            'area' => 'course',
            'shortname' => 'featured_course',
            'value' => '1'
        ));
        
        if (empty($courses)) {
            $this->content->items[] = get_string('nofeaturedcourses', 'block_featured_courses');
            return $this->content;
        }

          foreach ($courses as $course) {
        $courseurl = new moodle_url('/course/view.php', array('id' => $course->id));
        $this->content->items[] = html_writer::link($courseurl, format_string($course->fullname));
        $this->content->icons[] = $OUTPUT->pix_icon('i/course', '', 'moodle');
    
    }

        // echo "<pre>";print_r($this->content);echo "</pre>";exit;
        return $this->content;
    }


    function applicable_formats() {
        return array('all' => true);
    }
}


