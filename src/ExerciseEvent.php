<?php

require 'BasicEvent.php';

class ExerciseEvent extends BasicEvent {
    
    const ACTIVITY = 'exercise';
    
    public function __construct() {
        parent::__construct();
        
        $this->on('exercise-submitted', function($data) {
            echo "exercise-submitted event received!\n";
            $this->setEventData($data);
            
            // TODO: fetch data from DB: SELECT EXERCISE GRADE FOR USER $data->uid
            $this->context['threshold'] = 8.6;
            $this->emit('prepare-rules');
        });
    }
    
}
