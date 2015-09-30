<?php

require_once 'CriterionAbstract.php';
require_once 'OperatorSimple.php';

class CriterionSimple extends CriterionAbstract {
    
    public function __construct() {
        $this->ruler = new Ruler\RuleBuilder();
    }
    
    protected function buildRule() {
        $rb = $this->ruler;
        
        $op = new Ruler\Operator\LogicalAnd();
        $op->addOperand($rb['activityType']->equalTo($this->activityType));
        $op->addOperand($rb['module']->equalTo($this->module));
        $op->addOperand($rb['resource']->equalTo($this->resource));
        if (!is_null($this->threshold) && !is_null($this->operator)) {
            $functionName = constant("OperatorSimple::{$this->operator}");
            $op->addOperand($rb['threshold']->$functionName($this->threshold));
        }
        
        $this->rule = $rb->create($op);
    }
    
    public function evaluate($context) {
        if ($this->rule->evaluate($context)) {
            $this->assertedAction($context);
            return true;
        } else {
            $this->notAssertedAction($context);
            return false;
        }
    }
    
}

