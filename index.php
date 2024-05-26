<?php
require_once('../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->libdir.'/tablelib.php');
require_once($CFG->dirroot.'/local/linkchecker/classes/link_checker.php');

require_login();
admin_externalpage_setup('local_linkchecker');

$link_checker = new \local_linkchecker\link_checker();
$status = optional_param('status', null, PARAM_INT);
$search = optional_param('search', '', PARAM_TEXT);
$videos = $link_checker->get_all_videos($status, $search);

if (optional_param('delete', false, PARAM_INT)) {
    $DB->delete_records('local_linkchecker_videos', array('id' => required_param('delete', PARAM_INT)));
    redirect(new moodle_url('/local/linkchecker/index.php'));
}

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('checkvideos', 'local_linkchecker'));

// Filteroptionen und Suchleiste
echo '<form method="get" action="index.php">';
echo '<input type="text" name="search" placeholder="Suche nach Video oder Kurs" value="' . s($search) . '">';
echo '<select name="status">';
echo '<option value="">' . get_string('allvideos', 'local_linkchecker') . '</option>';
echo '<option value="1"' . ($status === '1' ? ' selected' : '') . '>' . get_string('validvideos', 'local_linkchecker') . '</option>';
echo '<option value="0"' . ($status === '0' ? ' selected' : '') . '>' . get_string('invalidvideos', 'local_linkchecker') . '</option>';
echo '</select>';
echo '<button type="submit">' . get_string('filter', 'local_linkchecker') . '</button>';
echo '</form>';

// Tabelle zur Anzeige der YouTube-Videos
$table = new flexible_table('youtube-videos');
$table->define_columns(array('courseid', 'videotitle', 'videourl', 'status', 'actions'));
$table->define_headers(array('Kurs', 'Video-Titel', 'Video-URL', 'Status', 'Aktionen'));
$table->setup();

foreach ($videos as $video) {
    $status = $video->status ? 'Gültig' : 'Ungültig';
    $actions = html_writer::link(new moodle_url('/local/linkchecker/edit.php', array('id' => $video->id)), get_string('edit', 'local_linkchecker'))
        . ' ' . html_writer::link(new moodle_url('/local/linkchecker/index.php', array('delete' => $video->id)), get_string('delete', 'local_linkchecker'));

    $table->add_data(array($video->courseid, $video->videotitle, $video->videourl, $status, $actions));
}

$table->finish_output();
echo $OUTPUT->footer();
?>

