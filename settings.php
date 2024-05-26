<?php
defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_linkchecker', get_string('pluginname', 'local_linkchecker'));

    // Einstellung für den Überprüfungsintervall
    $settings->add(new admin_setting_configtext(
        'local_linkchecker/checkinterval',
        get_string('checkinterval', 'local_linkchecker'),
        get_string('checkinterval_desc', 'local_linkchecker'),
        '24', // Standardwert in Stunden
        PARAM_INT
    ));

    // Einstellung für die gültigen HTTP-Statuscodes
    $settings->add(new admin_setting_configtext(
        'local_linkchecker/validstatuscodes',
        get_string('validstatuscodes', 'local_linkchecker'),
        get_string('validstatuscodes_desc', 'local_linkchecker'),
        '200,301,302', // Standardwerte
        PARAM_TEXT
    ));

    // Einstellung für den API-Schlüssel
    $settings->add(new admin_setting_configtext(
        'local_linkchecker/apikey',
        get_string('apikey', 'local_linkchecker'),
        get_string('apikey_desc', 'local_linkchecker'),
        '', // Standardwert
        PARAM_TEXT
    ));

    $ADMIN->add('localplugins', $settings);
}
?>
