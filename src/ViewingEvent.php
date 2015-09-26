<?php

require_once 'BasicEvent.php';

class ViewingEvent extends BasicEvent {
    
    const VIDEO_ACTIVITY = 'video';
    const EBOOK_ACTIVITY = 'ebook';
    const DOCUMENT_ACTIVITY = 'document';
    const QUESTIONNAIRE_ACTIVITY = 'questionnaire';
    const NEWVIEW = 'resource-viewed';
    
    public function __construct() {
        parent::__construct();
        
        $this->on(self::NEWVIEW, function($data) {
            $this->setEventData($data);
            $this->emit('prepare-rules');
        });
    }
    
}
