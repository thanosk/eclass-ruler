<?php

require_once 'BasicEvent.php';

class RatingEvent extends BasicEvent {
    
    const FORUM_ACTIVITY = 'forum likes';
    const SOCIALBOOKMARK_ACTIVITY = 'social bookmark likes';
    const NEWLIKE = 'like-submitted';
    const DELLIKE = 'like-deleted';
    
    public function __construct() {
        parent::__construct();
        
        $handle = function($data) {
            $this->setEventData($data);
            
            // TODO: fetch data from DB: SELECT COUNT LIKES FROM RATING FOR USER $data->uid FOR MODULE $data->module
            $this->context['threshold'] = 80;
            $this->emit('prepare-rules');
        };
        
        $this->on(self::NEWLIKE, $handle);
        $this->on(self::DELLIKE, $handle);
    }
    
}
