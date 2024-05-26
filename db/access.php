<?php
defined('MOODLE_INTERNAL') || die();

$capabilities = array(
    'local/linkchecker:view' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'manager' => CAP_ALLOW,
        ),
    ),
);
?>
