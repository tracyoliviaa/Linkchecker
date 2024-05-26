<?php
defined('MOODLE_INTERNAL') || die();

$checkinterval = get_config('local_youtubechecker', 'checkinterval');
if (!$checkinterval) {
    $checkinterval = 24; // default to 24 hours if not set
}

$tasks = array(
    array(
        'classname' => 'local_youtubechecker\task\check_videos_task',
        'blocking' => 0,
        'minute' => '0',
        'hour' => '*/' . $checkinterval,
        'day' => '*',
        'month' => '*',
        'dayofweek' => '*',
        'disabled' => 0
    ),
);
?>
