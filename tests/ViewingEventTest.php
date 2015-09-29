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
        $videoData->activityType = ViewingEvent::VIDEO_ACTIVITY;
        $videoData->module = 5;
        $videoData->resource = 1;
        self::$videoData = $videoData;
        // ebook
        $ebookData = new stdClass();
        $ebookData->courseId = 1;
        $ebookData->uid = 1000;
        $ebookData->activityType = ViewingEvent::EBOOK_ACTIVITY;
        $ebookData->module = 18;
        $ebookData->resource = 1;
        self::$ebookData = $ebookData;
        // document
        $documentData = new stdClass();
        $documentData->courseId = 1;
        $documentData->uid = 1000;
        $documentData->activityType = ViewingEvent::DOCUMENT_ACTIVITY;
        $documentData->module = 3;
        $documentData->resource = 1;
        self::$documentData = $documentData;
        // questionnaire
        $questionnaireData = new stdClass();
        $questionnaireData->courseId = 1;
        $questionnaireData->uid = 1000;
        $questionnaireData->activityType = ViewingEvent::QUESTIONNAIRE_ACTIVITY;
        $questionnaireData->module = 21;
        $questionnaireData->resource = 1;
        self::$questionnaireData = $questionnaireData;
    }
    
    public function setUp() {
        $this->event = new ViewingEvent();
    }
    
    public function testVideoContext() {
        $this->currentdata = self::$videoData;
        $this->event->emit(ViewingEvent::NEWVIEW, [$this->currentdata]);
        $context = $this->event->getContext();
        
        $this->assertNotNull($context);
        $this->assertEquals(ViewingEvent::VIDEO_ACTIVITY, $context['activity_type']);
        $this->assertArrayNotHasKey('threshold', $context);
    }
    
    public function testEbookContext() {
        $this->currentdata = self::$ebookData;
        $this->event->emit(ViewingEvent::NEWVIEW, [$this->currentdata]);
        $context = $this->event->getContext();
        
        $this->assertNotNull($context);
        $this->assertEquals(ViewingEvent::EBOOK_ACTIVITY, $context['activity_type']);
        $this->assertArrayNotHasKey('threshold', $context);
    }
    
    public function testDocumentContext() {
        $this->currentdata = self::$documentData;
        $this->event->emit(ViewingEvent::NEWVIEW, [$this->currentdata]);
        $context = $this->event->getContext();
        
        $this->assertNotNull($context);
        $this->assertEquals(ViewingEvent::DOCUMENT_ACTIVITY, $context['activity_type']);
        $this->assertArrayNotHasKey('threshold', $context);
    }
    
    public function testQuestionnaireContext() {
        $this->currentdata = self::$questionnaireData;
        $this->event->emit(ViewingEvent::NEWVIEW, [$this->currentdata]);
        $context = $this->event->getContext();
        
        $this->assertNotNull($context);
        $this->assertEquals(ViewingEvent::QUESTIONNAIRE_ACTIVITY, $context['activity_type']);
        $this->assertArrayNotHasKey('threshold', $context);
    }
}
