<?php

require_once 'CriterionAbstract.php';
require_once 'Operator.php';

class Criterion extends CriterionAbstract {
    
    public function __construct() {
        $this->ruler = new Hoa\Ruler\Ruler();
    }
    
    protected function buildRule() {
        $act_type = (!is_null($this->activity_type)) ? 'activity_type = "' . $this->activity_type . '"': null;
        $module = (!is_null($this->module)) ? 'module = ' . $this->module : null;
        $resource = (!is_null($this->resource)) ? 'resource = ' . $this->resource : null;
        
        $threshold = null;
        if (!is_null($this->threshold) && !is_null($this->operator)) {
            $threshold = 'threshold ' . constant("Operator::{$this->operator}") . ' ' . $this->threshold;
        }
        
        $ar = array($act_type, $module, $resource, $threshold);
        $this->rule = implode(' and ', array_filter($ar, function ($v) {
            return $v !== null;
        }));
        
        echo "buildRule() result: " . $this->rule . "\n";
    }
    
    public function evaluate($context) {
        if ($this->ruler->assert($this->rule, $context)) {
            $this->assertedAction();
            return true;
        } else {
            $this->notAssertedAction();
            return false;
        }
    }
    
}