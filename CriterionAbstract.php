<?php

abstract class CriterionAbstract {
    
    protected $id;
    protected $type;
    protected $activity_type;
    protected $module;
    protected $resource;
    protected $threshold;
    protected $operator;
    
    protected $rule;
    protected $ruler;
    
    public static function initWithId($id, $type) {
        $instance = new static();
        $instance->loadById($id, $type);
        return $instance;
    }
    
    protected function loadById($id, $type) {
        echo "running loadById(): select * from \$type_criterion WHERE id = \$id \n";
        // TODO: $crit = FROM DB
        $this->loadByProperties($id, $type, $crit->activity_type, $crit->module, $crit->resource, $crit->threshold, $crit->operator);
    }
    
    public static function initWithProperties($id, $type, $activity_type, $module, $resource, $threshold, $operator) {
        $instance = new static();
        $instance->loadByProperties($id, $type, $activity_type, $module, $resource, $threshold, $operator);
        return $instance;
    }
    
    protected function loadByProperties($id, $type, $activity_type, $module, $resource, $threshold, $operator) {
        $this->id = $id;
        $this->type = $type;
        $this->activity_type = $activity_type;
        $this->module = $module;
        $this->resource = $resource;
        $this->threshold = $threshold;
        $this->operator = $operator;
        
        $this->buildRule();
    }
    
    abstract protected function buildRule();
    
    abstract public function evaluate($context);
    
    protected function assertedAction() {
        echo "Rule evaluated as True\nrunning assertedAction(): insert into user_\$type_criterion(user, id) values (\$this->uid, \$this->id) \n";
        // TODO: insert into user_$type_criterion(user, id) values ($this->uid, $this->id)
    }
    
    protected function notAssertedAction() {
        echo "Rule evaluated as False\nrunning notAssertedAction(): delete from user_\$type_criterion where user = \$this->uid and id = \$this->id \n";
        // TODO: delete from user_$type_criterion where user = $this->uid and id = $this->id
    }
}

