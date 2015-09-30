<?php

require_once 'src/CriterionSimple.php';

class CriterionSimpleTest extends PHPUnit_Framework_TestCase {
    
    private $criterion;
    
    public function setUp() {
        $props = new stdClass();
        $props->id = 1;
        $props->type = 'certificate';
        $props->activity_type = 'exercise';
        $props->module = 10;
        $props->resource = 1;
        $props->threshold = 8.6;
        $props->operator = 'get';
        $this->criterion = CriterionSimple::initWithProperties($props);
    }
    
    public function testOne() {
        $context = new Ruler\Context(array(
            'activityType' => 'exercise',
            'module' => 10,
            'resource' => 1,
            'threshold' => function() {
                return 8.6;
            }
        ));
        
        $this->assertTrue($this->criterion->evaluate($context));
    }
    
    public function testTwo() {
        $context = new Ruler\Context(array(
            'activityType' => 'forum',
            'module' => 9,
            'threshold' => function() {
                return 20.0;
            }
        ));
        
        $this->assertFalse($this->criterion->evaluate($context));
    }
}
