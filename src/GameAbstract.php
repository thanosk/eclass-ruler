<?php

require_once 'initEclass.php';

abstract class GameAbstract {
    
    protected $id;
    protected $type;
    protected $autoassign;
    protected $active;
    protected $criterionIds;
    
    protected $table;
    protected $field;
    
    protected $rule;
    protected $ruler;
    
    public static function initWithProperties($properties) {
        $instance = new static();
        $instance->loadByProperties($properties);
        return $instance;
    }
    
    protected function loadByProperties($properties) {
        $this->id = $properties->id;
        $this->type = $properties->type;
        $this->autoassign = $properties->autoassign;
        $this->active = $properties->active;
        $this->criterionIds = $properties->criterionIds;
        
        $this->table = 'user_' . $properties->type;
        $this->field = $properties->type;
        
        $this->buildRule();
    }
    
    abstract protected function buildRule();
    
    abstract public function evaluate($context);
    
    protected function assertedAction($context) {
        $uid = (isset($context['uid'])) ? $context['uid'] : null;
        if ($uid) {
            $exists = Database::get()->querySingle("select count(id) as cnt from $this->table where user = ?d and $this->field = ?d", $uid, $this->id)->cnt;
            if (!$exists) {
                Database::get()->query("insert into $this->table (user, $this->field, assigned) values (?d, ?d, ?t)", $uid, $this->id, gmdate('Y-m-d H:i:s'));
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
