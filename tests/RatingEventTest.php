<?php

require_once 'AbstractEventTest.php';
require_once 'src/RatingEvent.php';

class RatingEventTest extends AbstractEventTest {
    
    private static $forumData;
    private static $socialBookmarkData;
    
    public static function setUpBeforeClass() {
        self::$hasResource = false;
        self::$hasThreshold = true;
        // forum
        $forumData = new stdClass();
        $forumData->courseId = 1;
        $forumData->uid = 1000;
        $forumData->activityType = RatingEvent::FORUM_ACTIVITY;
        $forumData->module = 39;
        self::$forumData = $forumData;
        // social bookmark
        $scData = new stdClass();
        $scData->courseId = 1;
        $scData->uid = 1000;
        $scData->activityType = RatingEvent::SOCIALBOOKMARK_ACTIVITY;
        $scData->module = 39;
        self::$socialBookmarkData = $scData;
    }
    
    public function setUp() {
        $this->event = new RatingEvent();
    }
    
    public function testNewForumLikeContext() {
        $this->currentdata = self::$forumData;
        $this->event->emit(RatingEVENT::NEWLIKE, [$this->currentdata]);
        $context = $this->event->getContext();
        
        $this->assertNotNull($context);
        $this->assertEquals(RatingEvent::FORUM_ACTIVITY, $context['activityType']);
    }
    
    public function testDelForumLikeContext() {
        $this->currentdata = self::$forumData;
        $this->event->emit(RatingEVENT::DELLIKE, [$this->currentdata]);
        $context = $this->event->getContext();
        
        $this->assertNotNull($context);
        $this->assertEquals(RatingEvent::FORUM_ACTIVITY, $context['activityType']);
    }
    
    public function testNewSocialBookmarkLikeContext() {
        $this->currentdata = self::$socialBookmarkData;
        $this->event->emit(RatingEVENT::NEWLIKE, [$this->currentdata]);
        $context = $this->event->getContext();
        
        $this->assertNotNull($context);
        $this->assertEquals(RatingEvent::SOCIALBOOKMARK_ACTIVITY, $context['activityType']);
    }
    
    public function testDelSocialBookmarkLikeContext() {
        $this->currentdata = self::$socialBookmarkData;
        $this->event->emit(RatingEVENT::DELLIKE, [$this->currentdata]);
        $context = $this->event->getContext();
        
        $this->assertNotNull($context);
        $this->assertEquals(RatingEvent::SOCIALBOOKMARK_ACTIVITY, $context['activityType']);
    }
}
