<?php
namespace local_linkchecker\task;

use core\task\scheduled_task;

class check_videos_task extends scheduled_task {
    public function get_name() {
        return get_string('checkvideostask', 'local_linkchecker');
    }

    public function execute() {
        $link_checker = new \local_linkchecker\link_checker();
        $videos = $link_checker->get_all_videos();

        foreach ($videos as $video) {
            $is_valid = $link_checker->check_video($video->videourl);
            $status = $is_valid ? 1 : 0;
            $link_checker->update_video_status($video->id, $status);
        }
    }
}
?>

