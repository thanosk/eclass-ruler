<?php

require_once 'src/ExerciseEvent.php';

class ExerciseEventTest extends PHPUnit_Framework_TestCase {
    
    private $exEv;
    private $eventData;
    
    public function setUp() {
        $this->exEv = new ExerciseEvent();
        $data = new stdClass();
        $data->activityType = ExerciseEvent::ACTIVITY;
        $data->module = 10;
        $data->resource = 1;
        $data->uid = 1000;
        $this->eventData = $data;
    }
    
    public function testEmptyContext() {
        $ev = $this->exEv;
        $this->assertNull($ev->getContext());
        $ev->emit('hello');
        $this->assertNull($ev->getContext());
        $ev->emit('testevent');
        $this->assertNull($ev->getContext());
    }
    
    public function testExerciseContext() {
        $this->exEv->emit('exercise-submitted', [$this->eventData]);
        $context = $this->exEv->getContext();
        $data = $this->eventData;
        $this->assertNotNull($context);
        $this->assertInstanceOf('Hoa\\Ruler\\Context', $context);
        $this->assertEquals($data->activityType, $context['activity_type']);
        $this->assertEquals($data->module, $context['module']);
        $this->assertEquals($data->resource, $context['resource']);
    }
}
