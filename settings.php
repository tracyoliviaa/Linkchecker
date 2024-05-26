<?php
defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_youtubechecker', get_string('pluginname', 'local_youtubechecker'));

    // Einstellung für den Überprüfungsintervall
    $settings->add(new admin_setting_configtext(
        'local_youtubechecker/checkinterval',
        get_string('checkinterval', 'local_youtubechecker'),
        get_string('checkinterval_desc', 'local_youtubechecker'),
        '24', // Standardwert in Stunden
        PARAM_INT
    ));

    // Einstellung für die gültigen HTTP-Statuscodes
    $settings->add(new admin_setting_configtext(
        'local_youtubechecker/validstatuscodes',
        get_string('validstatuscodes', 'local_youtubechecker'),
        get_string('validstatuscodes_desc', 'local_youtubechecker'),
        '200,301,302', // Standardwerte
        PARAM_TEXT
    ));

    // Einstellung für den API-Schlüssel
    $settings->add(new admin_setting_configtext(
        'local_youtubechecker/apikey',
        get_string('apikey', 'local_youtubechecker'),
        get_string('apikey_desc', 'local_youtubechecker'),
        '', // Standardwert
        PARAM_TEXT
    ));

    $ADMIN->add('localplugins', $settings);
}
?>
