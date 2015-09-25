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
    
    protected function initContextFromEvent() {
        $data = $this->eventData;
        
        $context = new Hoa\Ruler\Context();
        // standard data from event
        $context['activity_type']  = $data->activity_type;
        $context['module']  = $data->module;
        $context['resource'] = $data->resource;
        
        $this->context = $context;
    }
    
    protected function preDataListeners() {
        $this->on('fire-rules', function() {
            echo "firing rules now\n";
        });
    }
    
    protected function postDataListeners() {
        $this->on('prepare-rules', function() {
            echo "preparing rules now\n";
            // TODO: implement business logic
            
            // if certificates/criterions are setup for this context, then emit
            $this->emit('fire-rules');
            // else do not emit nothing
        });
    }
    
}
