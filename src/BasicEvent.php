<?php

class BasicEvent implements Sabre\Event\EventEmitterInterface {
    use Sabre\Event\EventEmitterTrait;
    
    protected $context;
    protected $eventData;
    
    public function __construct() {
        $this->preDataListeners();
    }
    
    public function getContext() {
        return $this->context;
    }
    
    protected function setEventData($data) {
        // create context from standard event data
        $context = new Hoa\Ruler\Context();
        $context['activity_type']  = $data->activityType;
        $context['module']  = $data->module;
        if (isset($data->resource)) {
            $context['resource'] = $data->resource;
        }
        
        $this->eventData = $data;
        $this->context = $context;
        
        // set post-data event listeners
        $this->on('prepare-rules', function() {
            // TODO: implement business logic
            
            // if certificates/criterions are setup for this context, then emit
            $this->emit('fire-rules');
            // else do not emit nothing
        });
    }
    
    protected function preDataListeners() {
        $this->on('fire-rules', function() {
            // TODO: evaluate rule-engine criteria
        });
    }
    
}
