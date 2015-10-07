<?php

require_once 'BasicEvent.php';

class LearningPathEvent extends BasicEvent {
    
    const ACTIVITY = 'learning path';
    
    public function __construct() {
        parent::__construct();
        
        $this->on('learning-path-accessed', function($data) {
            $this->setEventData($data);
            
            // TODO: fetch data from DB: SELECT LP USER GRADE FOR USER $data->uid
            $this->context['threshold'] = 80;
            $this->emit(parent::PREPARERULES);
        });
    }
    
}
