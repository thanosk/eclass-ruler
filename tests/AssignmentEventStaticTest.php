<?php

require_once 'src/AssignmentEvent.php';

class AssignmentEventStaticTest extends PHPUnit_Framework_TestCase {
    
    public function testAssignmentContext() {
        $data = new stdClass();
        $data->courseId = 1;
        $data->uid = 1000;
        $data->activityType = AssignmentEvent::ACTIVITY;
        $data->module = 5;
        $data->resource = 1;

        $context = AssignmentEvent::trigger(AssignmentEvent::NEWGRADE, $data);
        
        $this->assertNotNull($context);
    }
}
