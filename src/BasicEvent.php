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
    
    public function __construct() {
        $this->preDataListeners();
    }
    
    public function getContext() {
        return $this->context;
    }
    
    protected function setEventData($data) {
        // create context from standard event data
        $context = new Hoa\Ruler\Context();
        $context['activity_type']  = $data->activityType;
        $context['module']  = $data->module;
        if (isset($data->resource)) {
            $context['resource'] = $data->resource;
        }
        
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
            
            // select certificate criteria not already conquered
            if (count($this->certificateIds) > 0) {
                $inCertIds = "(" . implode(",", $this->certificateIds) . ")";
                $certArgs = array($data->uid, $data->activityType, $data->module);
                $andResource = '';
                if (isset($data->resource)) {
                    $andResource = " and c.resource = ?d ";
                    $certArgs[] = $data->resource;
                }
                $critsQ = "select c.*, 'certificate' as type from certificate_criterion c"
                        . " where c.certificate in " . $inCertIds . " "
                        . " and c.id not in (select certificate_criterion from user_certificate_criterion where user = ?d) "
                        . " and c.activity_type = ?s "
                        . " and c.module = ?d "
                        . $andResource;
                Database::get()->queryFunc($critsQ, function ($crit) {
                    $this->criterionSet->addCriterion(Criterion::initWithProperties(
                        $crit->id, 
                        $crit->type, 
                        $crit->activity_type, 
                        $crit->module, 
                        $crit->resource, 
                        $crit->threshold, 
                        $crit->operator
                    ));
                }, $certArgs);
            }
            
            // select badge criteria not already conquered
            if (count($this->badgeIds) > 0) {
                $inBadgeIds = "(" . implode(",", $this->badgeIds) . ")";
                $badgeArgs = array($data->uid, $data->activityType, $data->module);
                $andResource = '';
                if (isset($data->resource)) {
                    $andResource = " and b.resource = ?d ";
                    $badgeArgs[] = $data->resource;
                }
                $badgesQ = "select b.*, 'badge' as type from badge_criterion b"
                        . " where b.badge in " . $inBadgeIds . " "
                        . " and b.id not in (select badge_criterion from user_badge_criterion where user = ?d) "
                        . " and b.activity_type = ?s "
                        . " and b.module = ?d "
                        . $andResource;
                Database::get()->queryFunc($critsQ, function ($crit) {
                    $this->criterionSet->addCriterion(Criterion::initWithProperties(
                        $crit->id, 
                        $crit->type, 
                        $crit->activity_type, 
                        $crit->module, 
                        $crit->resource, 
                        $crit->threshold, 
                        $crit->operator
                    ));
                }, $badgeArgs);
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
