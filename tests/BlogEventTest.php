<?php

require_once 'AbstractEventTest.php';
require_once 'src/BlogEvent.php';

class BlogEventTest extends AbstractEventTest {
    
    public static function setUpBeforeClass() {
        self::$hasResource = true;
    }
    
    public function setUp() {
        $this->event = new BlogEvent();
        $data = new stdClass();
        $data->courseId = 1;
        $data->uid = 1000;
        $data->activityType = BlogEvent::ACTIVITY;
        $data->module = 37;
        $data->resource = 1;
        $this->currentdata = $data;
    }
    
    public function testNewPageContext() {
        $this->event->emit(BlogEvent::NEWPOST, [$this->currentdata]);
        $context = $this->event->getContext();
        
        $this->assertNotNull($context);
    }
    
    public function testDeletePageContext() {
        $this->event->emit(BlogEvent::DELPOST, [$this->currentdata]);
        $context = $this->event->getContext();
        
        $this->assertNotNull($context);
    }
}
