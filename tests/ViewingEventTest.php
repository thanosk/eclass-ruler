<?php

require_once 'AbstractEventTest.php';
require_once 'src/ViewingEvent.php';

class ViewingEventTest extends AbstractEventTest {
    
    private static $videoData;
    private static $ebookData;
    private static $documentData;
    private static $questionnaireData;
    
    public static function setUpBeforeClass() {
        self::$hasResource = true;
        // video
        $videoData = new stdClass();
        $videoData->courseId = 1;
        $videoData->uid = 1000;
        $videoData->activityType = ViewingEvent::VIDEO;
        $videoData->module = 5;
        $videoData->resource = 1;
        self::$videoData = $videoData;
        // ebook
        $ebookData = new stdClass();
        $ebookData->courseId = 1;
        $ebookData->uid = 1000;
        $ebookData->activityType = ViewingEvent::EBOOK;
        $ebookData->module = 18;
        $ebookData->resource = 1;
        self::$ebookData = $ebookData;
        // document
        $documentData = new stdClass();
        $documentData->courseId = 1;
        $documentData->uid = 1000;
        $documentData->activityType = ViewingEvent::DOCUMENT;
        $documentData->module = 3;
        $documentData->resource = 1;
        self::$documentData = $documentData;
        // questionnaire
        $questionnaireData = new stdClass();
        $questionnaireData->courseId = 1;
        $questionnaireData->uid = 1000;
        $questionnaireData->activityType = ViewingEvent::QUESTIONNAIRE;
        $questionnaireData->module = 21;
        $questionnaireData->resource = 1;
        self::$questionnaireData = $questionnaireData;
    }
    
    public function setUp() {
        $this->event = new ViewingEvent();
    }
    
    public function testVideoContext() {
        $this->currentdata = self::$videoData;
        $this->event->emit('resource-viewed', [$this->currentdata]);
        $context = $this->event->getContext();
        
        $this->assertNotNull($context);
        $this->assertEquals(ViewingEvent::VIDEO, $context['activity_type']);
    }
    
    public function testEbookContext() {
        $this->currentdata = self::$ebookData;
        $this->event->emit('resource-viewed', [$this->currentdata]);
        $context = $this->event->getContext();
        
        $this->assertNotNull($context);
        $this->assertEquals(ViewingEvent::EBOOK, $context['activity_type']);
    }
    
    public function testDocumentContext() {
        $this->currentdata = self::$documentData;
        $this->event->emit('resource-viewed', [$this->currentdata]);
        $context = $this->event->getContext();
        
        $this->assertNotNull($context);
        $this->assertEquals(ViewingEvent::DOCUMENT, $context['activity_type']);
    }
    
    public function testQuestionnaireContext() {
        $this->currentdata = self::$questionnaireData;
        $this->event->emit('resource-viewed', [$this->currentdata]);
        $context = $this->event->getContext();
        
        $this->assertNotNull($context);
        $this->assertEquals(ViewingEvent::QUESTIONNAIRE, $context['activity_type']);
    }
}
