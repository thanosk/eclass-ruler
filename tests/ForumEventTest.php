<?php

require_once 'AbstractEventTest.php';
require_once 'src/ForumEvent.php';

class ForumEventTest extends AbstractEventTest {
    
    public static function setUpBeforeClass() {
        self::$hasResource = true;
        self::$hasThreshold = true;
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
    
    public function testNewPostContext() {
        $this->event->emit(ForumEvent::NEWPOST, [$this->currentdata]);
        $context = $this->event->getContext();
        
        $this->assertNotNull($context);
    }
    
    public function testDeletePostContext() {
        $this->event->emit(ForumEvent::DELPOST, [$this->currentdata]);
        $context = $this->event->getContext();
        
        $this->assertNotNull($context);
    }
}
