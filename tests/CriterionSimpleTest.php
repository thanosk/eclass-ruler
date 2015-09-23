<?php

require_once 'src/CriterionSimple.php';

class CriterionSimpleTest extends PHPUnit_Framework_TestCase {
    
    private $criterion;
    
    public function setUp() {
        $this->criterion = CriterionSimple::initWithProperties(1, 'certificate', 'exercise', 10, 1, 8.6, 'get');
    }
    
    public function testOne() {
        $context = new Ruler\Context(array(
            'activity_type' => 'exercise',
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
            'activity_type' => 'forum',
            'module' => 9,
            'threshold' => function() {
                return 20.0;
            }
        ));
        
        $this->assertFalse($this->criterion->evaluate($context));
    }
}
