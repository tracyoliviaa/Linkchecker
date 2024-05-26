<?php
namespace local_youtubechecker\task;

use core\task\scheduled_task;

class check_videos_task extends scheduled_task {
    public function get_name() {
        return get_string('checkvideostask', 'local_youtubechecker');
    }

    public function execute() {
        $youtube_checker = new \local_youtubechecker\youtube_checker();
        $videos = $youtube_checker->get_all_videos();

        foreach ($videos as $video) {
            $is_valid = $youtube_checker->check_video($video->videourl);
            $status = $is_valid ? 1 : 0;
            $youtube_checker->update_video_status($video->id, $status);
        }
    }
}
?>
