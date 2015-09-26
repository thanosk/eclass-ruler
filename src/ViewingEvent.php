<?php

require_once 'BasicEvent.php';

class ViewingEvent extends BasicEvent {
    
    const VIDEO = 'video';
    const EBOOK = 'ebook';
    const DOCUMENT = 'document';
    const QUESTIONNAIRE = 'questionnaire';
    
    public function __construct() {
        parent::__construct();
        
        $this->on('resource-viewed', function($data) {
            $this->setEventData($data);
            $this->emit('prepare-rules');
        });
    }
    
}
