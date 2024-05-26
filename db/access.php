<?php
defined('MOODLE_INTERNAL') || die();

$capabilities = array(
    'local/youtubechecker:view' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'manager' => CAP_ALLOW,
        ),
    ),
);
?>
