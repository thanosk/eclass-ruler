<?php

require_once 'AbstractEventTest.php';
require_once 'src/ForumEvent.php';

class ForumEventTest extends AbstractEventTest {
    
    public static function setUpBeforeClass() {
        self::$hasResource = true;
    }
    
    public function setUp() {
        $this->event = new ForumEvent();
        $data = new stdClass();
        $data->courseId = 1;
        $data->uid = 1000;
        $data->activityType = ForumEvent::ACTIVITY;
        $data->module = 9;
        $data->resource = 1;
        $this->currentdata = $data;
    }
    
    public function testForumContext() {
        $this->event->emit('post-submitted', [$this->currentdata]);
        $context = $this->event->getContext();
        
        $this->assertNotNull($context);
    }
}
