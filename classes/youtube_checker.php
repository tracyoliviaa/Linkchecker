<?php
namespace local_linkchecker;

class link_checker {
    public function get_all_videos($status = null, $search = '') {
        global $DB;
        $conditions = array();
        $params = array();

        if ($status !== null) {
            $conditions[] = 'status = ?';
            $params[] = $status;
        }

        if (!empty($search)) {
            $conditions[] = '(videourl LIKE ? OR videotitle LIKE ?)';
            $params[] = "%$search%";
            $params[] = "%$search%";
        }

        $sql = 'SELECT * FROM {local_linkchecker_videos}';
        if (!empty($conditions)) {
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }

        return $DB->get_records_sql($sql, $params);
    }

    public function check_video($url) {
        // Retrieve valid HTTP status codes from settings
        $validstatuscodes = explode(',', get_config('local_linkchecker', 'validstatuscodes'));

        // Retrieve API key from settings
        $apikey = get_config('local_linkchecker', 'apikey');

        // Extract video ID from URL
        preg_match('/v=([^&]+)/', $url, $matches);
        if (empty($matches[1])) {
            return false;
        }
        $videoid = $matches[1];

        // YouTube API-URL
        $apiurl = "https://www.googleapis.com/youtube/v3/videos?id={$videoid}&key={$apikey}&part=status";

        // API-Anfrage senden
        $response = file_get_contents($apiurl);
        $data = json_decode($response, true);

        // Überprüfen, ob das Video existiert
        if (!empty($data['items'])) {
            $statuscode = 200;
        } else {
            $statuscode = 404;
        }

        return in_array($statuscode, $validstatuscodes);
    }

    public function update_video_status($id, $status) {
        global $DB;
        $DB->update_record('local_linkchecker_videos', array('id' => $id, 'status' => $status));
    }
}
?>
