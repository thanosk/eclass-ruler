<?php

require_once 'initEclass.php';
require_once 'Criterion.php';
require_once 'CriterionSet.php';

class BasicEvent implements Sabre\Event\EventEmitterInterface {
    use Sabre\Event\EventEmitterTrait;
    
    protected $context;
    protected $eventData;
    protected $certificateIds;
    protected $badgeIds;
    protected $criterionSet;
    
    public static function trigger($eventname, $eventdata) {
        $class = get_called_class();
        $event = new $class;
        $event->emit($eventname, [$eventdata]);
        return $event->getContext();
    }
    
    public function __construct() {
        $this->preDataListeners();
    }
    
    public function getContext() {
        return $this->context;
    }
    
    protected function setEventData($data) {
        // create context from standard event data
        $context = new Hoa\Ruler\Context();
        $context['activityType']  = $data->activityType;
        $context['module']  = $data->module;
        if (isset($data->resource)) {
            $context['resource'] = $data->resource;
        }
        $context['courseId'] = $data->courseId;
        $context['uid'] = $data->uid;
        
        $this->eventData = $data;
        $this->context = $context;
        
        // set post-data event listeners
        $this->on('prepare-rules', function() {
            $data = $this->eventData;
            $this->certificateIds = array();
            $this->badgeIds = array();
            $this->criterionSet = new CriterionSet();
            
            // select certificates not already conquered
            $certsQ = "select c.id from certificate c where c.course = ?d and c.id not in ("
                    . " select certificate from user_certificate where user = ?d )";
            Database::get()->queryFunc($certsQ, function($c) {
                $this->certificateIds[] = $c->id;
            }, $data->courseId, $data->uid);
            
            // select badges not already conquered
            $badgesQ = "select b.id from badge b where b.course = ?d and b.id not in ("
                    . " select badge from user_badge where user = ?d )";
            Database::get()->queryFunc($badgesQ, function($b) {
                $this->badgeIds[] = $b->id;
            }, $data->courseId, $data->uid);
            
            $iter = array();
            $iter['certificate'] = $this->certificateIds;
            $iter['badge'] = $this->badgeIds;
            
            foreach ($iter as $key => $ids) {
                // select criteria not already conquered
                if (count($ids) >0) {
                    $inIds = "(" . implode(",", $ids) . ")";
                    $args = array($data->uid, $data->activityType, $data->module);
                    $andResource = '';
                    if (isset($data->resource)) {
                        $andResource = " and c.resource = ?d ";
                        $args[] = $data->resource;
                    }
                    $critsQ = "select c.*, '$key' as type from {$key}_criterion c"
                        . " where c.$key in " . $inIds . " "
                        . " and c.id not in (select {$key}_criterion from user_{$key}_criterion where user = ?d) "
                        . " and c.activity_type = ?s "
                        . " and c.module = ?d "
                        . $andResource;
                    Database::get()->queryFunc($critsQ, function ($crit) {
                        $this->criterionSet->addCriterion(Criterion::initWithProperties($crit));
                    }, $args);
                }
            }
            
            // ready to fire the rule-engine
            $this->emit('fire-rules');
        });
    }
    
    protected function preDataListeners() {
        $this->on('fire-rules', function() {
            $this->criterionSet->evaluateCriteria($this->context);
        });
    }
    
}
