<?php

require_once 'AbstractEventTest.php';
require_once 'src/WikiEvent.php';

class WikiEventTest extends AbstractEventTest {
    
    public static function setUpBeforeClass() {
        self::$hasResource = true;
    }
    
    public function setUp() {
        $this->event = new WikiEvent();
        $data = new stdClass();
        $data->courseId = 1;
        $data->uid = 1000;
        $data->activityType = WikiEvent::ACTIVITY;
        $data->module = 26;
        $data->resource = 1;
        $this->currentdata = $data;
    }
    
    public function testNewPageContext() {
        $this->event->emit(WikiEvent::NEWPAGE, [$this->currentdata]);
        $context = $this->event->getContext();
        
        $this->assertNotNull($context);
    }
    
    public function testDeletePageContext() {
        $this->event->emit(WikiEvent::DELPAGE, [$this->currentdata]);
        $context = $this->event->getContext();
        
        $this->assertNotNull($context);
    }
}
