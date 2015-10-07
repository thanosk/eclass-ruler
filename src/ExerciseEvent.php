<?php

require_once 'BasicEvent.php';

class ExerciseEvent extends BasicEvent {
    
    const ACTIVITY = 'exercise';
    const NEWRESULT = 'exercise-submitted';
    
    public function __construct() {
        parent::__construct();
        
        $this->on(self::NEWRESULT, function($data) {
            $this->setEventData($data);
            
            // TODO: fetch data from DB: SELECT EXERCISE GRADE FOR USER $data->uid
            $this->context['threshold'] = 8.6;
            $this->emit(parent::PREPARERULES);
        });
    }
    
}
