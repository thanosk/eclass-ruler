<?php

require_once 'BasicEvent.php';

class WikiEvent extends BasicEvent {
    
    const ACTIVITY = 'wiki';
    const NEWPAGE = 'page-submitted';
    const DELPAGE = 'page-deleted';
    
    public function __construct() {
        parent::__construct();
        
        $handle = function($data) {
            $this->setEventData($data);
            
            // TODO: fetch data from DB: SELECT COUNT WIKI PAGES FOR USER $data->uid
            $this->context['threshold'] = 7;
            $this->emit(parent::PREPARERULES);
        };
        
        $this->on(self::NEWPAGE, $handle);
        $this->on(self::DELPAGE, $handle);
    }
    
}
