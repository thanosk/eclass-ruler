<?php

require_once 'BasicEvent.php';

class ForumEvent extends BasicEvent {
    
    const ACTIVITY = 'forum';
    const NEWPOST = 'forumpost-submitted';
    const DELPOST = 'forumpost-deleted';
    
    public function __construct() {
        parent::__construct();
        
        $handle = function($data) {
            $this->setEventData($data);
            
            // TODO: fetch data from DB: SELECT COUNT POST FROM FORUM FOR USER $data->uid
            $this->context['threshold'] = 20;
            $this->emit(parent::PREPARERULES);
        };
        
        $this->on(self::NEWPOST, $handle);
        $this->on(self::DELPOST, $handle);
    }
    
}
