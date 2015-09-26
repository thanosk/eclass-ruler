<?php

require_once 'AbstractEventTest.php';
require_once 'src/AssignmentEvent.php';

class AssignmentEventTest extends AbstractEventTest {
    
    public static function setUpBeforeClass() {
        self::$hasResource = true;
    }
    
    public function setUp() {
        $this->event = new AssignmentEvent();
        $data = new stdClass();
        $data->courseId = 1;
        $data->uid = 1000;
        $data->activityType = AssignmentEvent::ACTIVITY;
        $data->module = 5;
        $data->resource = 1;
        $this->currentdata = $data;
    }
    
    public function testAssignmentContext() {
        $this->event->emit('assignment-graded', [$this->currentdata]);
        $context = $this->event->getContext();
        
        $this->assertNotNull($context);
    }
}
