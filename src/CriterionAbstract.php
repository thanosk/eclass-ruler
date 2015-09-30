<?php

require_once 'initEclass.php';

abstract class CriterionAbstract {
    
    protected $id;
    protected $type;
    protected $activityType;
    protected $module;
    protected $resource;
    protected $threshold;
    protected $operator;
    
    protected $table;
    protected $field;
    
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
        $this->loadByProperties($crit);
    }
    
    public static function initWithProperties($properties) {
        $instance = new static();
        $instance->loadByProperties($properties);
        return $instance;
    }
    
    protected function loadByProperties($properties) {
        $this->id = $properties->id;
        $this->type = $properties->type;
        $this->activityType = $properties->activity_type;
        $this->module = $properties->module;
        $this->resource = $properties->resource;
        $this->threshold = $properties->threshold;
        $this->operator = $properties->operator;
        
        $this->table = 'user_' . $properties->type . '_criterion';
        $this->field = $properties->type . '_criterion';
        
        $this->buildRule();
    }
    
    abstract protected function buildRule();
    
    abstract public function evaluate($context);
    
    protected function assertedAction($context) {
        $uid = (isset($context['uid'])) ? $context['uid'] : null;
        if ($uid) {
            $exists = Database::get()->querySingle("select count(id) as cnt from $this->table where user = ?d and $this->field = ?d", $uid, $this->id)->cnt;
            if (!$exists) {
                Database::get()->query("insert into $this->table (user, $this->field) values (?d, ?d)", $uid, $this->id);
            }
        }
    }
    
    protected function notAssertedAction($context) {
        $uid = (isset($context['uid'])) ? $context['uid'] : null;
        if ($uid) {
            Database::get()->query("delete from $this->table where user = ?d and $this->field = ?d", $uid, $this->id);
        }
    }
}

