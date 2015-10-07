<?php

require_once 'src/Game.php';

class GameTest extends PHPUnit_Framework_TestCase {
    
    private $game;
    
    public function setUp() {
        $props = new stdClass();
        $props->id = 100;
        $props->type = 'certificate';
        $props->autoassign = 1;
        $props->active = 1;
        $props->criterionIds = array(1, 2, 3);
        
        $this->game = Game::initWithProperties($props);
    }
    
    public function testOne() {
        $context = new Hoa\Ruler\Context();
        $context['uid'] = 200;
        $context['userCriterionIds'] = array(3, 1, 2);
        
        $this->assertTrue($this->game->evaluate($context));
    }
    
    public function testTwo() {
        $context = new Hoa\Ruler\Context();
        $context['uid'] = 200;
        $context['userCriterionIds'] = array(1, 3);
        
        $this->assertFalse($this->game->evaluate($context));
    }
}
