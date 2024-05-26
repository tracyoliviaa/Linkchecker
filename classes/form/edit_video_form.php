<?php
namespace local_youtubechecker\form;

use moodleform;

require_once("$CFG->libdir/formslib.php");

class edit_video_form extends moodleform {
    public function definition() {
        $mform = $this->_form;

        // Video URL field
        $mform->addElement('text', 'videourl', get_string('videourl', 'local_youtubechecker'));
        $mform->setType('videourl', PARAM_URL);
        $mform->addRule('videourl', null, 'required', null, 'client');

        // Hidden ID field
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        // Action buttons
        $this->add_action_buttons(true, get_string('savechanges', 'local_youtubechecker'));
    }
}
?>
