<?php

require_once 'BasicEvent.php';

class AssignmentEvent extends BasicEvent {
    
    const ACTIVITY = 'assignment';
    const NEWGRADE = 'assignment-graded';
    
    public function __construct() {
        parent::__construct();
        
        $this->on(self::NEWGRADE, function($data) {
            $this->setEventData($data);
            
            // TODO: fetch data from DB: SELECT ASSIGNMENT GRADE FOR USER $data->uid
            $this->context['threshold'] = 8.6;
            $this->emit('prepare-rules');
        });
    }
    
}
