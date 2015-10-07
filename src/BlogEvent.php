<?php

require_once 'BasicEvent.php';

class BlogEvent extends BasicEvent {
    
    const ACTIVITY = 'blog';
    const NEWPOST = 'blogpost-submitted';
    const DELPOST = 'blogpost-deleted';
    
    public function __construct() {
        parent::__construct();
        
        $handle = function($data) {
            $this->setEventData($data);
            
            // TODO: fetch data from DB: SELECT COUNT BLOG POSTS FOR USER $data->uid
            $this->context['threshold'] = 12;
            $this->emit(parent::PREPARERULES);
        };
        
        $this->on(self::NEWPOST, $handle);
        $this->on(self::DELPOST, $handle);
    }
    
}
