<?php
defined('MOODLE_INTERNAL') || die();
global $CFG;
require_once($CFG->dirroot . '/local/youtubechecker/classes/youtube_checker.php');

class local_youtubechecker_testcase extends advanced_testcase {

    // Test setup
    protected function setUp(): void {
        $this->resetAfterTest(true);
    }

    // Test für die Funktion, die alle Videos abruft
    public function test_get_all_videos() {
        $youtube_checker = new \local_youtubechecker\youtube_checker();

        // Einfügen eines Dummy-Videos in die Datenbank
        $video = new stdClass();
        $video->courseid = 1;
        $video->videourl = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';
        $video->videotitle = 'Test Video';
        $video->status = 1;
        $video->id = $this->getDataGenerator()->get_plugin_generator('core')->create_data('local_youtubechecker_videos', $video);

        // Abrufen aller Videos und Testen, ob das eingefügte Video zurückgegeben wird
        $videos = $youtube_checker->get_all_videos();
        $this->assertCount(1, $videos);
        $this->assertEquals($video->videourl, reset($videos)->videourl);
    }

    // Test für die Video-Überprüfungsfunktion
    public function test_check_video() {
        $youtube_checker = new \local_youtubechecker\youtube_checker();

        // Gültige URL testen
        set_config('apikey', 'YOUR_VALID_API_KEY', 'local_youtubechecker');
        set_config('validstatuscodes', '200,301,302', 'local_youtubechecker');
        $valid_url = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';
        $this->assertTrue($youtube_checker->check_video($valid_url));

        // Ungültige URL testen
        $invalid_url = 'https://www.youtube.com/watch?v=invalidvideoid';
        $this->assertFalse($youtube_checker->check_video($invalid_url));
    }

    // Test für die Funktion, die den Videostatus aktualisiert
    public function test_update_video_status() {
        global $DB;
        $youtube_checker = new \local_youtubechecker\youtube_checker();

        // Einfügen eines Dummy-Videos in die Datenbank
        $video = new stdClass();
        $video->courseid = 1;
        $video->videourl = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';
        $video->videotitle = 'Test Video';
        $video->status = 1;
        $video->id = $this->getDataGenerator()->get_plugin_generator('core')->create_data('local_youtubechecker_videos', $video);

        // Aktualisieren des Status des Videos
        $youtube_checker->update_video_status($video->id, 0);

        // Testen, ob der Status korrekt aktualisiert wurde
        $updated_video = $DB->get_record('local_youtubechecker_videos', array('id' => $video->id));
        $this->assertEquals(0, $updated_video->status);
    }

    // Test für die Bearbeitungsfunktion
    public function test_edit_video() {
        global $DB;
        $youtube_checker = new \local_youtubechecker\youtube_checker();

        // Einfügen eines Dummy-Videos in die Datenbank
        $video = new stdClass();
        $video->courseid = 1;
        $video->videourl = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';
        $video->videotitle = 'Test Video';
        $video->status = 1;
        $video->id = $this->getDataGenerator()->get_plugin_generator('core')->create_data('local_youtubechecker_videos', $video);

        // Bearbeiten der Video-URL
        $new_url = 'https://www.youtube.com/watch?v=anothervalidurl';
        $video->videourl = $new_url;
        $DB->update_record('local_youtubechecker_videos', $video);

        // Testen, ob die Video-URL korrekt aktualisiert wurde
        $updated_video = $DB->get_record('local_youtubechecker_videos', array('id' => $video->id));
        $this->assertEquals($new_url, $updated_video->videourl);
    }

    // Test für die Löschfunktion
    public function test_delete_video() {
        global $DB;
        $youtube_checker = new \local_youtubechecker\youtube_checker();

        // Einfügen eines Dummy-Videos in die Datenbank
        $video = new stdClass();
        $video->courseid = 1;
        $video->videourl = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';
        $video->videotitle = 'Test Video';
        $video->status = 1;
        $video->id = $this->getDataGenerator()->get_plugin_generator('core')->create_data('local_youtubechecker_videos', $video);

        // Löschen des Videos
        $DB->delete_records('local_youtubechecker_videos', array('id' => $video->id));

        // Testen, ob das Video korrekt gelöscht wurde
        $deleted_video = $DB->get_record('local_youtubechecker_videos', array('id' => $video->id));
        $this->assertFalse($deleted_video);
    }
}
?>
