<?php

abstract class AbstractEventTest extends PHPUnit_Framework_TestCase {
    
    protected $event;
    protected $currentdata;
    protected static $hasResource;
    
    public function assertPreConditions() {
        $this->assertNull($this->event->getContext());
    }
    
    public function assertPostConditions() {
        $data = $this->currentdata;
        $context = $this->event->getContext();
        
        if ($context !== NULL) {
            $this->assertInstanceOf('Hoa\\Ruler\\Context', $context);
            $this->assertEquals($data->activityType, $context['activity_type']);
            $this->assertEquals($data->module, $context['module']);
            if (self::$hasResource) {
                $this->assertEquals($data->resource, $context['resource']);
            } else {
                $this->assertObjectNotHasAttribute('resource', $data);
                $this->assertObjectNotHasAttribute('resource', $context);
            }
        }
    }
    
    public function testEmptyContext() {
        $ev = $this->event;
        $this->assertNull($ev->getContext());
        $ev->emit('hello');
        $this->assertNull($ev->getContext());
        $ev->emit('testevent');
        $this->assertNull($ev->getContext());
    }
}
