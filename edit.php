<?php
require_once('../../config.php');
require_once($CFG->dirroot.'/local/linkchecker/classes/form/edit_video_form.php');

$id = required_param('id', PARAM_INT);
$video = $DB->get_record('local_linkchecker_videos', array('id' => $id), '*', MUST_EXIST);

$mform = new \local_linkchecker\form\edit_video_form(null, array('id' => $id));
if ($mform->is_cancelled()) {
    redirect(new moodle_url('/local/linkchecker/index.php'));
} else if ($data = $mform->get_data()) {
    $video->videourl = $data->videourl;
    $DB->update_record('local_linkchecker_videos', $video);
    redirect(new moodle_url('/local/linkchecker/index.php'));
}

$mform->set_data($video);
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('edit', 'local_linkchecker'));
$mform->display();
echo $OUTPUT->footer();
?>

