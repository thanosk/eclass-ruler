<?php

require_once 'src/Criterion.php';

class CriterionTest extends PHPUnit_Framework_TestCase {
    
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
        $this->criterion = Criterion::initWithProperties($props);
    }
    
    public function testOne() {
        $context = new Hoa\Ruler\Context();
        // η πληροφορία του act_type, module, resource μπορεί να προέρχεται κατευθείαν
        // από ένα user-generated event (π.χ. submit τελευταίου βήματος άσκησης)
        $context['activityType']  = 'exercise';
        $context['module']  = 10;
        $context['resource'] = 1;
        // η πληροφορία του threshold μπορεί να προέρχεται από ένα ContextCreator Object
        // ειδικό για ασκήσεις που θα το καλεί το PHP backend βασιζόμενο και πάλι στην 
        // πληροφορία που κουβαλάει το Event
        $context['threshold'] = new Hoa\Ruler\DynamicCallable(function () {
            // select user's exercise grade from DB
            return 8.6;
        });
        
        $this->assertTrue($this->criterion->evaluate($context));
    }
    
    public function testTwo() {
        $context = new Hoa\Ruler\Context();
        $context['activityType']  = 'forum';
        $context['module']  = 9;
        $context['threshold'] = new Hoa\Ruler\DynamicCallable(function () {
            // count user's forum posts from DB
            return 20.0;
        });
        
        $this->assertFalse($this->criterion->evaluate($context));
    }
}
