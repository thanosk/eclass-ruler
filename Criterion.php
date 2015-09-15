<?php

require_once 'Operator.php';

class Criterion {
    
    private $id;
    private $type;
    private $activity_type;
    private $module;
    private $resource;
    private $threshold;
    private $operator;
    
    private $rule;
    private $ruler;
    
    public function __construct() {
        $this->ruler = new Hoa\Ruler\Ruler();
    }
    
    public static function initWithId($id, $type) {
        $instance = new self();
        $instance->loadById($id, $type);
        return $instance;
    }
    
    private function loadById($id, $type) {
        echo "running loadById(): select * from \$type_criterion WHERE id = \$id \n";
        // TODO: $crit = FROM DB
        $this->loadByProperties($id, $type, $crit->activity_type, $crit->module, $crit->resource, $crit->threshold, $crit->operator);
    }
    
    public static function initWithProperties($id, $type, $activity_type, $module, $resource, $threshold, $operator) {
        $instance = new self();
        $instance->loadByProperties($id, $type, $activity_type, $module, $resource, $threshold, $operator);
        return $instance;
    }
    
    private function loadByProperties($id, $type, $activity_type, $module, $resource, $threshold, $operator) {
        $this->id = $id;
        $this->type = $type;
        $this->activity_type = $activity_type;
        $this->module = $module;
        $this->resource = $resource;
        $this->threshold = $threshold;
        $this->operator = $operator;
        
        $this->buildRule();
    }
    
    private function buildRule() {
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
    
    private function assertedAction() {
        echo "Rule evaluated as True\nrunning assertedAction(): insert into user_\$type_criterion(user, id) values (\$this->uid, \$this->id) \n";
        // TODO: insert into user_$type_criterion(user, id) values ($this->uid, $this->id)
    }
    
    private function notAssertedAction() {
        echo "Rule evaluated as False\nrunning notAssertedAction(): delete from user_\$type_criterion where user = \$this->uid and id = \$this->id \n";
        // TODO: delete from user_$type_criterion where user = $this->uid and id = $this->id
    }
}

