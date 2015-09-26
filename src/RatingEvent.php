<?php

require_once 'BasicEvent.php';

class RatingEvent extends BasicEvent {
    
    const FORUM = 'forum likes';
    const SOCIALBOOKMARK = 'social bookmark likes';
    
    public function __construct() {
        parent::__construct();
        
        $this->on('like-submitted', function($data) {
            $this->setEventData($data);
            
            // TODO: fetch data from DB: SELECT COUNT LIKES FROM RATING FOR USER $data->uid FOR MODULE $data->module
            $this->context['threshold'] = 80;
            $this->emit('prepare-rules');
        });
    }
    
}
