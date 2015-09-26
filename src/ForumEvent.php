<?php

require_once 'BasicEvent.php';

class ForumEvent extends BasicEvent {
    
    const ACTIVITY = 'forum';
    
    public function __construct() {
        parent::__construct();
        
        $this->on('post-submitted', function($data) {
            $this->setEventData($data);
            
            // TODO: fetch data from DB: SELECT COUNT POST FROM FORUM FOR USER $data->uid
            $this->context['threshold'] = 20;
            $this->emit('prepare-rules');
        });
    }
    
}
