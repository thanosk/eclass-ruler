<?php

require_once 'AbstractEventTest.php';
require_once 'src/ExerciseEvent.php';

class ExerciseEventTest extends AbstractEventTest {
    
    public static function setUpBeforeClass() {
        self::$hasResource = true;
        self::$hasThreshold = true;
    }
    
    public function setUp() {
        $this->event = new ExerciseEvent();
        $data = new stdClass();
        $data->courseId = 1;
        $data->uid = 1000;
        $data->activityType = ExerciseEvent::ACTIVITY;
        $data->module = 10;
        $data->resource = 1;
        $this->currentdata = $data;
    }
    
    public function testExerciseContext() {
        $this->event->emit(ExerciseEvent::NEWRESULT, [$this->currentdata]);
        $context = $this->event->getContext();
        
        $this->assertNotNull($context);
    }
}
