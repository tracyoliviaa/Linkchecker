<?php
namespace local_youtubechecker\privacy;

defined('MOODLE_INTERNAL') || die();

/**
 * Privacy Subsystem for local_youtubechecker implementing null_provider.
 */
class provider implements \core_privacy\local\metadata\null_provider {

    /**
     * Get the language string identifier with the component's language file
     * @return  string
     */
    public static function get_reason() : string {
        return 'privacy:metadata';
    }
}
?>
