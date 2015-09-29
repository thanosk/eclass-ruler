<?php

require_once 'AbstractEventTest.php';
require_once 'src/CommentEvent.php';

class CommentEventTest extends AbstractEventTest {
    
    public static function setUpBeforeClass() {
        self::$hasResource = true;
        self::$hasThreshold = true;
    }
    
    public function setUp() {
        $this->event = new CommentEvent();
        $data = new stdClass();
        $data->courseId = 1;
        $data->uid = 1000;
        $data->activityType = CommentEvent::BLOG_ACTIVITY;
        $data->module = 37;
        $data->resource = 1;
        $this->currentdata = $data;
    }
    
    public function testNewPageContext() {
        $this->event->emit(CommentEvent::NEWCOMMENT, [$this->currentdata]);
        $context = $this->event->getContext();
        
        $this->assertNotNull($context);
    }
    
    public function testDeletePageContext() {
        $this->event->emit(CommentEvent::DELCOMMENT, [$this->currentdata]);
        $context = $this->event->getContext();
        
        $this->assertNotNull($context);
    }
}
