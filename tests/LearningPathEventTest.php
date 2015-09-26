<?php

require_once 'AbstractEventTest.php';
require_once 'src/LearningPathEvent.php';

class LearningPathEventTest extends AbstractEventTest {
    
    public static function setUpBeforeClass() {
        self::$hasResource = true;
    }
    
    public function setUp() {
        $this->event = new LearningPathEvent();
        $data = new stdClass();
        $data->courseId = 1;
        $data->uid = 1000;
        $data->activityType = LearningPathEvent::ACTIVITY;
        $data->module = 23;
        $data->resource = 1;
        $this->currentdata = $data;
    }
    
    public function testForumContext() {
        $this->event->emit('learning-path-accessed', [$this->currentdata]);
        $context = $this->event->getContext();
        
        $this->assertNotNull($context);
    }
}
