<?php

require_once 'AbstractEventTest.php';
require_once 'src/RatingEvent.php';

class RatingEventTest extends AbstractEventTest {
    
    private static $forumData;
    private static $socialBookmarkData;
    
    public static function setUpBeforeClass() {
        self::$hasResource = false;
        // forum
        $forumData = new stdClass();
        $forumData->courseId = 1;
        $forumData->uid = 1000;
        $forumData->activityType = RatingEvent::FORUM;
        $forumData->module = 39;
        self::$forumData = $forumData;
        // social bookmark
        $scData = new stdClass();
        $scData->courseId = 1;
        $scData->uid = 1000;
        $scData->activityType = RatingEvent::SOCIALBOOKMARK;
        $scData->module = 39;
        self::$socialBookmarkData = $scData;
    }
    
    public function setUp() {
        $this->event = new RatingEvent();
    }
    
    public function testForumContext() {
        $this->currentdata = self::$forumData;
        $this->event->emit('like-submitted', [$this->currentdata]);
        $context = $this->event->getContext();
        
        $this->assertNotNull($context);
        $this->assertEquals(RatingEvent::FORUM, $context['activity_type']);
    }
    
    public function testSocialBookmarkContext() {
        $this->currentdata = self::$socialBookmarkData;
        $this->event->emit('like-submitted', [$this->currentdata]);
        $context = $this->event->getContext();
        
        $this->assertNotNull($context);
        $this->assertEquals(RatingEvent::SOCIALBOOKMARK, $context['activity_type']);
    }
}
