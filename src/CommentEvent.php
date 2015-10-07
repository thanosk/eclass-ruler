<?php

require_once 'BasicEvent.php';

class CommentEvent extends BasicEvent {
    
    const BLOG_ACTIVITY = 'blog';
    const NEWCOMMENT = 'comment-submitted';
    const DELCOMMENT = 'comment-deleted';
    
    public function __construct() {
        parent::__construct();
        
        $handle = function($data) {
            $this->setEventData($data);
            
            // TODO: fetch data from DB: SELECT COUNT COMMENTS FOR USER $data->uid FOR MODULE $data->module
            $this->context['threshold'] = 18;
            $this->emit(parent::PREPARERULES);
        };
        
        $this->on(self::NEWCOMMENT, $handle);
        $this->on(self::DELCOMMENT, $handle);
    }
    
}
